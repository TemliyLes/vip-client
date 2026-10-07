<?php
/**
 * Plugin Name: VIP Polylang REST
 * Description: Language filtering and safe translation links for the headless VIP Client REST API.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: polylang
 * License: GPL-2.0-or-later
 * Text Domain: vip-polylang-rest
 */

defined( 'ABSPATH' ) || exit;

final class VIP_Client_Polylang_REST {

    public static function init() {
        if ( ! function_exists( 'pll_languages_list' ) ) {
            return;
        }

        $languages = pll_languages_list( array( 'hide_empty' => false, 'fields' => 'slug' ) );
        if ( empty( $languages ) ) {
            return;
        }

        $parameter = array(
            'description' => 'Filter by an existing Polylang language slug.',
            'type'        => 'string',
            'enum'        => array_values( $languages ),
        );

        foreach ( get_post_types( array( 'show_in_rest' => true ), 'names' ) as $post_type ) {
            if ( ! pll_is_translated_post_type( $post_type ) ) {
                continue;
            }

            add_filter( "rest_{$post_type}_collection_params", function ( $params ) use ( $parameter ) {
                $params['lang'] = $parameter;
                return $params;
            } );
            add_filter( "rest_{$post_type}_query", array( __CLASS__, 'filter_posts' ), 20, 2 );
            self::register_fields( $post_type, 'post' );
        }

        foreach ( get_taxonomies( array( 'show_in_rest' => true ), 'names' ) as $taxonomy ) {
            if ( ! pll_is_translated_taxonomy( $taxonomy ) ) {
                continue;
            }

            add_filter( "rest_{$taxonomy}_collection_params", function ( $params ) use ( $parameter ) {
                $params['lang'] = $parameter;
                return $params;
            } );
            add_filter( "rest_{$taxonomy}_query", array( __CLASS__, 'filter_terms' ), 20, 2 );
            self::register_fields( $taxonomy, 'term' );
        }
    }

    public static function filter_posts( $args, $request ) {
        $language = $request->get_param( 'lang' );
        if ( ! is_string( $language ) || '' === $language ) {
            return $args;
        }

        $args['lang'] = $language;
        // Filter in SQL before pagination, including when taxonomy filters use OR.
        $language_query = array(
            'taxonomy'         => 'language',
            'field'            => 'slug',
            'terms'            => array( $language ),
            'include_children' => false,
        );
        $existing = $args['tax_query'] ?? array();
        $args['tax_query'] = array( 'relation' => 'AND', $language_query );
        if ( ! empty( $existing ) ) {
            $args['tax_query'][] = $existing;
        }

        return $args;
    }

    public static function filter_terms( $args, $request ) {
        $language = $request->get_param( 'lang' );
        if ( is_string( $language ) && '' !== $language ) {
            // Polylang's term query filter also handles the REST total count.
            $args['lang'] = $language;
        }
        return $args;
    }

    private static function register_fields( $object_type, $kind ) {
        global $wp_rest_additional_fields;

        $schemas = array(
            'lang' => array(
                'description' => 'Polylang language slug, or null when unassigned.',
                'type'        => array( 'string', 'null' ),
                'context'     => array( 'view', 'embed', 'edit' ),
                'readonly'    => false,
            ),
            'translations' => array(
                'description'          => 'Available translation IDs indexed by language slug.',
                'type'                 => 'object',
                'additionalProperties' => array( 'type' => 'integer', 'minimum' => 1 ),
                'context'              => array( 'view', 'embed', 'edit' ),
                'readonly'             => false,
            ),
        );

        foreach ( $schemas as $field => $schema ) {
            // Do not replace fields supplied by another integration or Polylang Pro.
            if ( isset( $wp_rest_additional_fields[ $object_type ][ $field ] ) ) {
                continue;
            }

            register_rest_field( $object_type, $field, array(
                'update_callback' => function ( $value, $object ) use ( $kind, $field, $object_type ) {
                    return self::update_field( $value, $object, $kind, $field, $object_type );
                },
                'get_callback' => function ( $object ) use ( $kind, $field ) {
                    $id = (int) $object['id'];
                    if ( 'lang' === $field ) {
                        $language = 'post' === $kind
                            ? pll_get_post_language( $id, 'slug' )
                            : pll_get_term_language( $id, 'slug' );
                        return $language ? $language : null;
                    }

                    $translations = 'post' === $kind
                        ? pll_get_post_translations( $id )
                        : pll_get_term_translations( $id );
                    $available = array();

                    foreach ( $translations as $language => $translated_id ) {
                        $translated_id = (int) $translated_id;
                        if ( 'post' === $kind ) {
                            $post = get_post( $translated_id );
                            // Public responses must not advertise unpublished translations.
                            if ( ! $post || ( 'publish' !== $post->post_status
                                && ! current_user_can( 'read_post', $translated_id ) ) ) {
                                continue;
                            }
                        }
                        $available[ $language ] = $translated_id;
                    }

                    return (object) $available;
                },
                'schema' => $schema,
            ) );
        }
    }

    private static function update_field( $value, $object, $kind, $field, $object_type ) {
        $id = 'post' === $kind ? (int) $object->ID : (int) $object->term_id;
        $capability = 'post' === $kind ? 'edit_post' : 'edit_term';
        if ( ! current_user_can( $capability, $id ) ) {
            return new WP_Error( 'vip_translation_forbidden', 'Cannot edit this object.', array( 'status' => 403 ) );
        }
        $languages = pll_languages_list( array( 'hide_empty' => false, 'fields' => 'slug' ) );
        if ( 'lang' === $field ) {
            if ( ! is_string( $value ) || ! in_array( $value, $languages, true ) ) {
                return new WP_Error( 'vip_invalid_language', 'Unknown language.', array( 'status' => 400 ) );
            }
            $translations = 'post' === $kind ? pll_get_post_translations( $id ) : pll_get_term_translations( $id );
            $current = 'post' === $kind ? pll_get_post_language( $id ) : pll_get_term_language( $id );
            if ( $current && $current !== $value && count( $translations ) > 1 ) {
                return new WP_Error( 'vip_translation_conflict', 'Cannot change the language of a linked translation.', array( 'status' => 409 ) );
            }
            if ( 'post' === $kind ) {
                pll_set_post_language( $id, $value );
            } else {
                pll_set_term_language( $id, $value );
            }
            return true;
        }

        $translations = (array) $value;
        $own_language = 'post' === $kind ? pll_get_post_language( $id ) : pll_get_term_language( $id );
        if ( ! $own_language || ( isset( $translations[ $own_language ] ) && (int) $translations[ $own_language ] !== $id ) ) {
            return new WP_Error( 'vip_translation_conflict', 'Language must be assigned and own translation ID must match.', array( 'status' => 409 ) );
        }
        $translations[ $own_language ] = $id;
        $merged = array();
        foreach ( $translations as $language => $translated_id ) {
            $translated_id = (int) $translated_id;
            $candidate = 'post' === $kind ? get_post( $translated_id ) : get_term( $translated_id, $object_type );
            $actual_language = 'post' === $kind ? pll_get_post_language( $translated_id ) : pll_get_term_language( $translated_id );
            if ( ! in_array( $language, $languages, true ) || ! $candidate || is_wp_error( $candidate )
                || ( 'post' === $kind && $candidate->post_type !== $object_type ) || $actual_language !== $language ) {
                return new WP_Error( 'vip_invalid_translation', 'Translation type or language does not match.', array( 'status' => 400 ) );
            }
            if ( ! current_user_can( $capability, $translated_id ) ) {
                return new WP_Error( 'vip_translation_forbidden', 'Cannot edit a linked object.', array( 'status' => 403 ) );
            }
            $existing = 'post' === $kind ? pll_get_post_translations( $translated_id ) : pll_get_term_translations( $translated_id );
            foreach ( $existing as $existing_language => $existing_id ) {
                if ( ( isset( $translations[ $existing_language ] ) && (int) $translations[ $existing_language ] !== (int) $existing_id )
                    || ( isset( $merged[ $existing_language ] ) && (int) $merged[ $existing_language ] !== (int) $existing_id ) ) {
                    return new WP_Error( 'vip_translation_conflict', 'An existing translation would be replaced.', array( 'status' => 409 ) );
                }
                $merged[ $existing_language ] = (int) $existing_id;
            }
        }
        $merged = array_merge( $merged, $translations );
        if ( 'post' === $kind ) {
            pll_save_post_translations( $merged );
        } else {
            pll_save_term_translations( $merged );
        }
        return true;
    }
}

// Register parameters and fields before WordPress controllers build their routes.
add_action( 'rest_api_init', array( 'VIP_Client_Polylang_REST', 'init' ), 5 );
