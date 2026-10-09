<?php
/**
 * Plugin Name: PALIY Product Crop
 * Description: Товары и услуги с ручным кадрированием изображения и REST API-полями.
 * Version: 2.28.1
 * Author: PALIY
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PALIY_PRODUCT_CROP_VERSION', '2.28.1');
define('PALIY_PRODUCT_CROP_CARD_WIDTH', 360);
define('PALIY_PRODUCT_CROP_CARD_HEIGHT', 390);

add_action('init', 'paliy_product_crop_register_content_types');
function paliy_product_crop_register_content_types(): void
{
    register_post_type('paliy_product', [
        'labels' => [
            'name' => 'Товары',
            'singular_name' => 'Товар',
            'add_new' => 'Добавить товар',
            'add_new_item' => 'Добавить товар',
            'edit_item' => 'Редактировать товар',
            'new_item' => 'Новый товар',
            'view_item' => 'Просмотреть товар',
            'search_items' => 'Искать товары',
            'not_found' => 'Товары не найдены',
            'menu_name' => 'Товары',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        'show_in_rest' => true,
        'rest_base' => 'products',
        'menu_icon' => 'dashicons-cart',
        'supports' => ['title', 'editor'],
        'rewrite' => ['slug' => 'products'],
    ]);

    register_post_type('paliy_service', [
        'labels' => [
            'name' => 'Услуги',
            'singular_name' => 'Услуга',
            'add_new' => 'Добавить услугу',
            'add_new_item' => 'Добавить услугу',
            'edit_item' => 'Редактировать услугу',
            'new_item' => 'Новая услуга',
            'view_item' => 'Просмотреть услугу',
            'search_items' => 'Искать услуги',
            'not_found' => 'Услуги не найдены',
            'menu_name' => 'Услуги',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'services',
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'excerpt', 'custom-fields'],
        'rewrite' => ['slug' => 'services'],
    ]);

    register_post_type('paliy_news', [
        'labels' => [
            'name' => 'Новости',
            'singular_name' => 'Новость',
            'add_new' => 'Добавить новость',
            'add_new_item' => 'Добавить новость',
            'edit_item' => 'Редактировать новость',
            'new_item' => 'Новая новость',
            'view_item' => 'Просмотреть новость',
            'search_items' => 'Искать новости',
            'not_found' => 'Новости не найдены',
            'menu_name' => 'Новости',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'news',
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'rewrite' => ['slug' => 'news'],
    ]);

    register_post_type('paliy_review', [
        'labels' => [
            'name' => 'Отзывы',
            'singular_name' => 'Отзыв',
            'add_new' => 'Добавить отзыв',
            'add_new_item' => 'Добавить отзыв',
            'edit_item' => 'Редактировать отзыв',
            'new_item' => 'Новый отзыв',
            'view_item' => 'Просмотреть отзыв',
            'search_items' => 'Искать отзывы',
            'not_found' => 'Отзывы не найдены',
            'menu_name' => 'Отзывы',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'reviews',
        'menu_icon' => 'dashicons-format-quote',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'rewrite' => ['slug' => 'reviews'],
    ]);

    register_post_type('paliy_video', [
        'labels' => [
            'name' => 'Видео',
            'singular_name' => 'Видео',
            'add_new' => 'Добавить видео',
            'add_new_item' => 'Добавить видео',
            'edit_item' => 'Редактировать видео',
            'new_item' => 'Новое видео',
            'view_item' => 'Просмотреть видео',
            'search_items' => 'Искать видео',
            'not_found' => 'Видео не найдено',
            'menu_name' => 'Видео',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'videos',
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'rewrite' => ['slug' => 'videos'],
    ]);

    register_post_type('paliy_feedback', [
        'labels' => [
            'name' => 'Заявки',
            'singular_name' => 'Заявка',
            'edit_item' => 'Просмотреть заявку',
            'view_item' => 'Просмотреть заявку',
            'search_items' => 'Искать заявки',
            'not_found' => 'Заявки не найдены',
            'menu_name' => 'Заявки',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => false,
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title'],
    ]);

    register_taxonomy('service_category', ['paliy_service'], [
        'labels' => [
            'name' => 'Категории услуг',
            'singular_name' => 'Категория услуги',
            'search_items' => 'Искать категории услуг',
            'all_items' => 'Все категории услуг',
            'edit_item' => 'Редактировать категорию услуги',
            'update_item' => 'Обновить категорию услуги',
            'add_new_item' => 'Добавить категорию услуг',
            'new_item_name' => 'Название новой категории',
            'menu_name' => 'Категории услуг',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'service-categories',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'service-categories'],
    ]);

    register_taxonomy('news_category', ['paliy_news'], [
        'labels' => [
            'name' => 'Категории новостей',
            'singular_name' => 'Категория новости',
            'search_items' => 'Искать категории новостей',
            'all_items' => 'Все категории новостей',
            'edit_item' => 'Редактировать категорию новости',
            'update_item' => 'Обновить категорию новости',
            'add_new_item' => 'Добавить категорию новостей',
            'new_item_name' => 'Название новой категории',
            'menu_name' => 'Категории новостей',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'news-categories',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'news-categories'],
    ]);

    register_taxonomy('review_category', ['paliy_review'], [
        'labels' => [
            'name' => 'Категории отзывов',
            'singular_name' => 'Категория отзыва',
            'search_items' => 'Искать категории отзывов',
            'all_items' => 'Все категории отзывов',
            'edit_item' => 'Редактировать категорию отзыва',
            'update_item' => 'Обновить категорию отзыва',
            'add_new_item' => 'Добавить категорию отзывов',
            'new_item_name' => 'Название новой категории',
            'menu_name' => 'Категории отзывов',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'review-categories',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'review-categories'],
    ]);

    register_post_type('paliy_faq', [
        'labels' => [
            'name' => 'FAQ',
            'singular_name' => 'Вопрос FAQ',
            'add_new' => 'Добавить вопрос',
            'add_new_item' => 'Добавить вопрос',
            'edit_item' => 'Редактировать вопрос',
            'new_item' => 'Новый вопрос',
            'view_item' => 'Просмотреть вопрос',
            'search_items' => 'Искать вопросы',
            'not_found' => 'Вопросы не найдены',
            'menu_name' => 'FAQ',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'faq',
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor'],
        'rewrite' => ['slug' => 'faq'],
    ]);

    register_taxonomy('faq_tag', ['paliy_faq'], [
        'labels' => [
            'name' => 'Теги FAQ',
            'singular_name' => 'Тег FAQ',
            'search_items' => 'Искать теги FAQ',
            'all_items' => 'Все теги FAQ',
            'edit_item' => 'Редактировать тег FAQ',
            'update_item' => 'Обновить тег FAQ',
            'add_new_item' => 'Добавить тег FAQ',
            'new_item_name' => 'Название нового тега',
            'menu_name' => 'Теги FAQ',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rest_base' => 'faq-tags',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'faq-tags'],
    ]);

    paliy_product_crop_register_service_fields();
    paliy_product_crop_register_feedback_fields();
}

function paliy_product_crop_sanitize_discount($value): string
{
    $value = preg_replace('/[^0-9]/', '', (string) $value);

    return preg_match('/^[1-9][0-9]$/', $value) ? $value : '';
}

function paliy_product_crop_sanitize_reservio_url($value): string
{
    $url = esc_url_raw((string) $value);

    return preg_match('/^https?:\/\//i', $url) ? $url : '';
}

function paliy_product_crop_sanitize_service_tariffs($value): array
{
    if (!is_array($value)) {
        return [];
    }

    $tariffs = [];
    foreach ($value as $tariff) {
        if (!is_array($tariff)) {
            continue;
        }

        $name = sanitize_text_field($tariff['name'] ?? '');
        $price = sanitize_text_field($tariff['price'] ?? '');
        $time = sanitize_text_field($tariff['time'] ?? '');
        $people_count = sanitize_text_field($tariff['people_count'] ?? '');
        $reservio_url = paliy_product_crop_sanitize_reservio_url($tariff['reservio_url'] ?? '');
        $description = wp_kses_post($tariff['description'] ?? '');

        if ($name === '' && $price === '' && $time === '' && $people_count === '' && $reservio_url === '' && trim(wp_strip_all_tags($description)) === '') {
            continue;
        }

        $tariffs[] = [
            'name' => $name,
            'price' => $price,
            'time' => $time,
            'people_count' => $people_count,
            'reservio_url' => $reservio_url,
            'description' => $description,
        ];
    }

    return array_slice($tariffs, 0, 50);
}

function paliy_product_crop_register_service_fields(): void
{
    foreach ([
        'service_description' => 'Краткое описание услуги.',
        'service_time' => 'Время оказания услуги.',
        'service_price' => 'Цена услуги.',
        'service_discount' => 'Скидка на услугу.',
        'service_people_count' => 'Количество человек.',
        'reservio_url' => 'Ссылка на Reservio.',
    ] as $meta_key => $description) {
        register_post_meta('paliy_service', $meta_key, [
            'type' => 'string',
            'single' => true,
            'default' => '',
            'description' => $description,
            'show_in_rest' => true,
            'sanitize_callback' => $meta_key === 'service_description'
                ? 'sanitize_textarea_field'
                : ($meta_key === 'service_discount'
                    ? 'paliy_product_crop_sanitize_discount'
                    : ($meta_key === 'reservio_url' ? 'paliy_product_crop_sanitize_reservio_url' : 'sanitize_text_field')),
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }

    register_post_meta('paliy_service', 'service_tariffs', [
        'type' => 'array',
        'single' => true,
        'default' => [],
        'description' => 'Тарифы услуги.',
        'show_in_rest' => [
            'schema' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'name' => ['type' => 'string'],
                        'price' => ['type' => 'string'],
                        'time' => ['type' => 'string'],
                        'people_count' => ['type' => 'string'],
                        'reservio_url' => ['type' => 'string'],
                        'description' => ['type' => 'string'],
                    ],
                ],
            ],
        ],
        'sanitize_callback' => 'paliy_product_crop_sanitize_service_tariffs',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_news', 'news_description', [
        'type' => 'string',
        'single' => true,
        'default' => '',
        'description' => 'Краткое описание новости.',
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_textarea_field',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_review', 'review_image_id', [
        'type' => 'integer',
        'single' => true,
        'default' => 0,
        'description' => 'Фотография автора отзыва.',
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_review', 'review_name', [
        'type' => 'string',
        'single' => true,
        'default' => '',
        'description' => 'ФИО автора отзыва.',
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_review', 'review_date', [
        'type' => 'string',
        'single' => true,
        'default' => '',
        'description' => 'Дата публикации отзыва.',
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_review', 'review_description', [
        'type' => 'string',
        'single' => true,
        'default' => '',
        'description' => 'Описание отзыва.',
        'show_in_rest' => true,
        'sanitize_callback' => 'wp_kses_post',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_term_meta('service_category', 'service_category_image_id', [
        'type' => 'integer',
        'single' => true,
        'default' => 0,
        'description' => 'Изображение категории услуг.',
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => static function (): bool {
            return current_user_can('manage_categories');
        },
    ]);

    register_term_meta('service_category', 'service_category_is_primary', [
        'type' => 'boolean',
        'single' => true,
        'default' => false,
        'description' => 'Основная категория услуг.',
        'show_in_rest' => true,
        'sanitize_callback' => static function ($value): bool {
            return (bool) $value;
        },
        'auth_callback' => static function (): bool {
            return current_user_can('manage_categories');
        },
    ]);

    foreach (paliy_product_crop_get_service_category_sections() as $section) {
        foreach (['title', 'subtitle'] as $field) {
            register_post_meta('page', 'paliy_service_category_' . $section['key'] . '_' . $field, [
                'type' => 'string',
                'single' => true,
                'default' => '',
                'description' => $section['name'] . ': ' . $field . '.',
                'show_in_rest' => true,
                'sanitize_callback' => 'wp_kses_post',
                'auth_callback' => static function (): bool {
                    return current_user_can('edit_posts');
                },
            ]);
        }
    }

    foreach (paliy_product_crop_get_news_category_sections() as $section) {
        foreach (['title', 'subtitle'] as $field) {
            register_post_meta('page', 'paliy_news_category_' . $section['key'] . '_' . $field, [
                'type' => 'string',
                'single' => true,
                'default' => '',
                'description' => $section['name'] . ': ' . $field . '.',
                'show_in_rest' => true,
                'sanitize_callback' => 'wp_kses_post',
                'auth_callback' => static function (): bool {
                    return current_user_can('edit_posts');
                },
            ]);
        }
    }

    foreach (['page', 'paliy_service', 'paliy_news'] as $post_type) {
        register_post_meta($post_type, 'paliy_related_video_ids', [
            'type' => 'array',
            'single' => true,
            'default' => [],
            'description' => 'Видео, связанные с этой записью. Можно выбрать от 1 до 4 видео.',
            'show_in_rest' => [
                'schema' => [
                    'type' => 'array',
                    'items' => ['type' => 'integer'],
                ],
            ],
            'sanitize_callback' => 'paliy_product_crop_sanitize_related_video_ids',
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }

    register_post_meta('paliy_video', 'paliy_video_external_url', [
        'type' => 'string',
        'single' => true,
        'default' => '',
        'description' => 'Внешняя ссылка на видео.',
        'show_in_rest' => true,
        'sanitize_callback' => 'paliy_product_crop_sanitize_video_external_url',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('paliy_video', 'paliy_video_attachment_id', [
        'type' => 'integer',
        'single' => true,
        'default' => 0,
        'description' => 'ID загруженного видеофайла.',
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    foreach ([
        'paliy_about_intro_title' => ['description' => 'Заголовок блока «О нас».', 'sanitize_callback' => 'wp_kses_post'],
        'paliy_about_intro_subtitle' => ['description' => 'Подзаголовок блока «О нас».', 'sanitize_callback' => 'wp_kses_post'],
        'paliy_about_founder_title' => ['description' => 'Заголовок блока «Основатель».', 'sanitize_callback' => 'sanitize_text_field'],
        'paliy_about_founder_subtitle' => ['description' => 'Подзаголовок блока «Основатель».', 'sanitize_callback' => 'wp_kses_post'],
        'paliy_about_founder_name' => ['description' => 'ФИО основателя.', 'sanitize_callback' => 'sanitize_text_field'],
        'paliy_about_founder_position' => ['description' => 'Должность основателя.', 'sanitize_callback' => 'sanitize_text_field'],
        'paliy_about_founder_description' => ['description' => 'Описание основателя.', 'sanitize_callback' => 'wp_kses_post'],
        'paliy_about_gallery_title' => ['description' => 'Заголовок фотогалереи.', 'sanitize_callback' => 'wp_kses_post'],
        'paliy_about_gallery_description' => ['description' => 'Описание фотогалереи.', 'sanitize_callback' => 'wp_kses_post'],
    ] as $meta_key => $settings) {
        register_post_meta('page', $meta_key, [
            'type' => 'string',
            'single' => true,
            'default' => '',
            'description' => $settings['description'],
            'show_in_rest' => true,
            'sanitize_callback' => $settings['sanitize_callback'],
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }

    register_post_meta('page', 'paliy_about_founder_image_id', [
        'type' => 'integer',
        'single' => true,
        'default' => 0,
        'description' => 'Изображение основателя.',
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('page', 'paliy_about_team_members', [
        'type' => 'array',
        'single' => true,
        'default' => [],
        'description' => 'Участники команды страницы «О нас».',
        'show_in_rest' => [
            'schema' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'image_id' => ['type' => 'integer'],
                        'crop' => ['type' => 'object'],
                        'card_relpath' => ['type' => 'string'],
                        'name' => ['type' => 'string'],
                        'position' => ['type' => 'string'],
                    ],
                ],
            ],
        ],
        'sanitize_callback' => 'paliy_product_crop_sanitize_about_team_members',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    register_post_meta('page', 'paliy_about_gallery_ids', [
        'type' => 'array',
        'single' => true,
        'default' => [],
        'description' => 'Фотографии галереи страницы «О нас». Максимум 50 изображений.',
        'show_in_rest' => [
            'schema' => [
                'type' => 'array',
                'items' => ['type' => 'integer'],
            ],
        ],
        'sanitize_callback' => 'paliy_product_crop_sanitize_about_gallery_ids',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    foreach ([
        'paliy_contacts_intro_title' => 'Заголовок страницы «Контакты».',
        'paliy_contacts_intro_subtitle' => 'Подзаголовок страницы «Контакты».',
        'paliy_contacts_feedback_title' => 'Заголовок формы обратной связи.',
        'paliy_contacts_feedback_description' => 'Описание формы обратной связи.',
        'paliy_contacts_feedback_instagram' => 'Ссылка Instagram в форме обратной связи.',
        'paliy_contacts_feedback_facebook' => 'Ссылка Facebook в форме обратной связи.',
    ] as $meta_key => $description) {
        register_post_meta('page', $meta_key, [
            'type' => 'string',
            'single' => true,
            'default' => '',
            'description' => $description,
            'show_in_rest' => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }

    register_post_meta('page', 'paliy_contacts_clinics', [
        'type' => 'array',
        'single' => true,
        'default' => [],
        'description' => 'Карточки клиник страницы «Контакты».',
        'show_in_rest' => [
            'schema' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'name' => ['type' => 'string'],
                        'address' => ['type' => 'string'],
                        'hours' => ['type' => 'string'],
                        'email' => ['type' => 'string', 'format' => 'email'],
                    ],
                ],
            ],
        ],
        'sanitize_callback' => 'paliy_product_crop_sanitize_contacts_clinics',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

    foreach (['service_category', 'news_category'] as $taxonomy) {
        foreach ([
            'paliy_category_title' => 'Заголовок категории.',
            'paliy_category_subtitle' => 'Подзаголовок категории.',
        ] as $meta_key => $description) {
            register_term_meta($taxonomy, $meta_key, [
                'type' => 'string',
                'single' => true,
                'default' => '',
                'description' => $description,
                'show_in_rest' => true,
                'sanitize_callback' => 'wp_kses_post',
                'auth_callback' => static function (): bool {
                    return current_user_can('manage_categories');
                },
            ]);
        }
    }

    foreach (['page', 'paliy_product', 'paliy_service', 'paliy_news', 'paliy_review', 'paliy_video', 'paliy_faq'] as $post_type) {
        foreach ([
            'paliy_seo_title' => [
                'description' => 'SEO-заголовок страницы.',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'paliy_seo_description' => [
                'description' => 'SEO-описание страницы.',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            'paliy_seo_og_title' => [
                'description' => 'Заголовок Open Graph для социальных сетей.',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'paliy_seo_og_description' => [
                'description' => 'Описание Open Graph для социальных сетей.',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
        ] as $meta_key => $settings) {
            register_post_meta($post_type, $meta_key, [
                'type' => 'string',
                'single' => true,
                'default' => '',
                'description' => $settings['description'],
                'show_in_rest' => true,
                'sanitize_callback' => $settings['sanitize_callback'],
                'auth_callback' => static function (): bool {
                    return current_user_can('edit_posts');
                },
            ]);
        }

        register_post_meta($post_type, 'paliy_seo_og_image_id', [
            'type' => 'integer',
            'single' => true,
            'default' => 0,
            'description' => 'ID изображения Open Graph.',
            'show_in_rest' => true,
            'sanitize_callback' => 'absint',
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);

        register_post_meta($post_type, 'paliy_seo_noindex', [
            'type' => 'boolean',
            'single' => true,
            'default' => false,
            'description' => 'Запретить индексацию страницы поисковыми системами.',
            'show_in_rest' => true,
            'sanitize_callback' => static function ($value): bool {
                return (bool) $value;
            },
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }
}

function paliy_product_crop_register_feedback_fields(): void
{
    foreach ([
        'feedback_name' => 'Имя заявителя.',
        'feedback_phone' => 'Телефон заявителя.',
        'feedback_message' => 'Сообщение заявителя.',
        'feedback_page_title' => 'Заголовок страницы, с которой отправлена заявка.',
        'feedback_page_url' => 'Ссылка на страницу, с которой отправлена заявка.',
        'feedback_language' => 'Язык формы.',
        'feedback_status' => 'Статус заявки.',
    ] as $meta_key => $description) {
        register_post_meta('paliy_feedback', $meta_key, [
            'type' => 'string',
            'single' => true,
            'default' => '',
            'description' => $description,
            'show_in_rest' => false,
            'sanitize_callback' => $meta_key === 'feedback_message'
                ? 'sanitize_textarea_field'
                : ($meta_key === 'feedback_page_url' ? 'esc_url_raw' : 'sanitize_text_field'),
            'auth_callback' => static function (): bool {
                return current_user_can('edit_posts');
            },
        ]);
    }

    register_post_meta('paliy_feedback', 'feedback_service_id', [
        'type' => 'integer',
        'single' => true,
        'default' => 0,
        'description' => 'Услуга, выбранная в форме.',
        'show_in_rest' => false,
        'sanitize_callback' => 'absint',
        'auth_callback' => static function (): bool {
            return current_user_can('edit_posts');
        },
    ]);

}

function paliy_product_crop_get_service_category_sections(): array
{
    return [
        ['key' => 'nase_sluzby', 'name' => 'Naše služby'],
        ['key' => 'nejzadanejsi_procedury', 'name' => 'Nejžádanější procedury'],
        ['key' => 'akademie', 'name' => 'AKADEMIE'],
        ['key' => 'propagace', 'name' => 'Propagace'],
    ];
}

function paliy_product_crop_get_news_category_sections(): array
{
    return [
        ['key' => 'proc_my', 'name' => 'Proč my'],
        ['key' => 'technologie', 'name' => 'Technologie'],
    ];
}

register_activation_hook(__FILE__, 'paliy_product_crop_activate');
function paliy_product_crop_activate(): void
{
    paliy_product_crop_register_content_types();
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'paliy_product_crop_deactivate');
function paliy_product_crop_deactivate(): void
{
    flush_rewrite_rules();
}

add_action('add_meta_boxes', 'paliy_product_crop_add_meta_box');
function paliy_product_crop_add_meta_box(): void
{
    add_meta_box(
        'paliy-product-image',
        'Изображения услуги или товара',
        'paliy_product_crop_render_meta_box',
        ['paliy_product', 'paliy_service'],
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-service-fields',
        'Данные услуги',
        'paliy_product_crop_render_service_fields',
        'paliy_service',
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-news-fields',
        'Данные новости',
        'paliy_product_crop_render_news_fields',
        'paliy_news',
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-review-fields',
        'Данные отзыва',
        'paliy_product_crop_render_review_fields',
        'paliy_review',
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-seo-fields',
        'SEO',
        'paliy_product_crop_render_seo_fields',
        ['page', 'paliy_product', 'paliy_service', 'paliy_news', 'paliy_review', 'paliy_video', 'paliy_faq'],
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-rest-api-link',
        'REST API',
        'paliy_product_crop_render_rest_api_link',
        ['page', 'paliy_product', 'paliy_service', 'paliy_news', 'paliy_review', 'paliy_video', 'paliy_faq'],
        'side',
        'high'
    );

    add_meta_box(
        'paliy-related-videos',
        'Видео',
        'paliy_product_crop_render_related_videos',
        ['page', 'paliy_service', 'paliy_news'],
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-video-source',
        'Источник видео',
        'paliy_product_crop_render_video_source',
        'paliy_video',
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-feedback-fields',
        'Данные заявки',
        'paliy_product_crop_render_feedback_fields',
        'paliy_feedback',
        'normal',
        'high'
    );
}

function paliy_product_crop_render_feedback_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_feedback_fields_save', 'paliy_feedback_fields_nonce');
    $service_id = (int) get_post_meta($post->ID, 'feedback_service_id', true);
    $status = (string) get_post_meta($post->ID, 'feedback_status', true);
    $language = (string) get_post_meta($post->ID, 'feedback_language', true);
    ?>
    <div class="paliy-feedback-fields">
        <p>
            <label for="feedback_name"><strong>Имя</strong></label>
            <input class="widefat" type="text" id="feedback_name" name="feedback_name" value="<?php echo esc_attr(get_post_meta($post->ID, 'feedback_name', true)); ?>">
        </p>
        <p>
            <label for="feedback_phone"><strong>Телефон</strong></label>
            <input class="widefat" type="text" id="feedback_phone" name="feedback_phone" value="<?php echo esc_attr(get_post_meta($post->ID, 'feedback_phone', true)); ?>">
        </p>
        <p>
            <label for="feedback_message"><strong>Сообщение</strong></label>
            <textarea class="widefat" rows="6" id="feedback_message" name="feedback_message"><?php echo esc_textarea(get_post_meta($post->ID, 'feedback_message', true)); ?></textarea>
        </p>
        <p>
            <label for="feedback_page_title"><strong>Заголовок страницы</strong></label>
            <input class="widefat" type="text" id="feedback_page_title" name="feedback_page_title" value="<?php echo esc_attr(get_post_meta($post->ID, 'feedback_page_title', true)); ?>">
        </p>
        <p>
            <label for="feedback_page_url"><strong>Ссылка на страницу</strong></label>
            <input class="widefat" type="url" id="feedback_page_url" name="feedback_page_url" value="<?php echo esc_attr(get_post_meta($post->ID, 'feedback_page_url', true)); ?>">
        </p>
        <p>
            <label for="feedback_service_id"><strong>ID услуги</strong></label>
            <input class="small-text" type="number" min="0" id="feedback_service_id" name="feedback_service_id" value="<?php echo esc_attr($service_id); ?>">
            <?php if ($service_id && get_post_type($service_id) === 'paliy_service') : ?>
                <span class="description"> <?php echo esc_html(get_the_title($service_id)); ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="feedback_language"><strong>Язык формы</strong></label>
            <select id="feedback_language" name="feedback_language">
                <option value="cs" <?php selected($language, 'cs'); ?>>Čeština</option>
                <option value="sk" <?php selected($language, 'sk'); ?>>Slovenčina</option>
            </select>
        </p>
        <p>
            <label for="feedback_status"><strong>Статус</strong></label>
            <select id="feedback_status" name="feedback_status">
                <?php foreach (['new' => 'Новая', 'in_progress' => 'В работе', 'done' => 'Обработана', 'spam' => 'Спам'] as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($status ?: 'new', $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p class="description">Заявки создаются через REST API и не публикуются на сайте.</p>
    </div>
    <?php
}

function paliy_product_crop_render_video_source(WP_Post $post): void
{
    wp_nonce_field('paliy_video_source_save', 'paliy_video_source_nonce');
    $external_url = (string) get_post_meta($post->ID, 'paliy_video_external_url', true);
    $attachment_id = (int) get_post_meta($post->ID, 'paliy_video_attachment_id', true);
    $attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
    $attachment_title = $attachment_id ? get_the_title($attachment_id) : '';
    ?>
    <p class="description">Укажите внешнюю ссылку или загрузите видеофайл. Используется только один источник.</p>
    <p>
        <label for="paliy_video_external_url"><strong>Ссылка на видео</strong></label>
        <input class="widefat" type="url" id="paliy_video_external_url" name="paliy_video_external_url" value="<?php echo esc_attr($external_url); ?>" placeholder="https://www.youtube.com/watch?v=...">
        <span class="description">Поддерживаются YouTube, Vimeo и прямые ссылки на видеофайлы.</span>
    </p>
    <p><strong>Или загрузить файл</strong></p>
    <input type="hidden" id="paliy_video_attachment_id" name="paliy_video_attachment_id" value="<?php echo esc_attr($attachment_id); ?>">
    <button type="button" class="button" id="paliy-select-video-file">Выбрать видеофайл</button>
    <button type="button" class="button-link-delete" id="paliy-remove-video-file" <?php disabled(!$attachment_id); ?>>Удалить файл</button>
    <div id="paliy-video-file-preview" class="paliy-video-file-preview" <?php echo $attachment_url ? '' : 'hidden'; ?>>
        <?php if ($attachment_url) : ?>
            <a href="<?php echo esc_url($attachment_url); ?>" target="_blank" rel="noopener">
                <?php echo esc_html($attachment_title ?: basename((string) wp_parse_url($attachment_url, PHP_URL_PATH))); ?>
            </a>
        <?php endif; ?>
    </div>
    <p id="paliy-video-source-status" class="description" aria-live="polite"></p>
    <?php
}

function paliy_product_crop_render_related_videos(WP_Post $post): void
{
    wp_nonce_field('paliy_related_videos_save', 'paliy_related_videos_nonce');
    $selected_ids = paliy_product_crop_sanitize_related_video_ids(get_post_meta($post->ID, 'paliy_related_video_ids', true));
    $videos = get_posts([
        'post_type' => 'paliy_video',
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'posts_per_page' => 100,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
    ?>
    <p class="description">Выберите от 1 до 4 видео из списка. Одно видео можно использовать на нескольких страницах.</p>
    <div class="paliy-related-videos" data-max="4">
        <?php if (!$videos) : ?>
            <p>Видео пока не созданы. Сначала добавьте записи в разделе «Видео».</p>
        <?php else : ?>
            <?php foreach ($videos as $video) : ?>
                <label class="paliy-related-video-option">
                    <input
                        type="checkbox"
                        name="paliy_related_video_ids[]"
                        value="<?php echo esc_attr($video->ID); ?>"
                        <?php checked(in_array($video->ID, $selected_ids, true)); ?>
                    >
                    <span><?php echo esc_html(get_the_title($video) ?: '(Без названия)'); ?></span>
                    <small>ID: <?php echo esc_html($video->ID); ?></small>
                </label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php
}

add_action('add_meta_boxes_page', 'paliy_product_crop_add_homepage_content_meta_boxes');
function paliy_product_crop_add_homepage_content_meta_boxes(WP_Post $post): void
{
    if (!paliy_product_crop_is_homepage_page($post)) {
        return;
    }

    add_meta_box(
        'paliy-service-category-page-fields',
        'Тексты страницы категорий услуг',
        'paliy_product_crop_render_service_category_page_fields',
        'page',
        'normal',
        'high'
    );

    add_meta_box(
        'paliy-news-category-page-fields',
        'Тексты страницы категорий новостей',
        'paliy_product_crop_render_news_category_page_fields',
        'page',
        'normal',
        'high'
    );
}

function paliy_product_crop_is_homepage_page($post): bool
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post);
    $front_page_id = (int) get_option('page_on_front');

    return $front_page_id > 0 && $post_id === $front_page_id;
}

function paliy_product_crop_is_about_page($post): bool
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post);
    if (!$post_id || get_post_type($post_id) !== 'page') {
        return false;
    }

    $slug = sanitize_title((string) get_post_field('post_name', $post_id));
    $title = function_exists('mb_strtolower')
        ? mb_strtolower((string) get_the_title($post_id))
        : strtolower((string) get_the_title($post_id));

    return in_array($slug, ['o-nas', 'about-us', 'about'], true)
        || in_array($title, ['о нас', 'o nás', 'o nas', 'about us'], true);
}

function paliy_product_crop_is_contacts_page($post): bool
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post);
    if (!$post_id || get_post_type($post_id) !== 'page') {
        return false;
    }

    $slug = sanitize_title((string) get_post_field('post_name', $post_id));
    $title = function_exists('mb_strtolower')
        ? mb_strtolower((string) get_the_title($post_id))
        : strtolower((string) get_the_title($post_id));

    return in_array($slug, ['kontakty', 'contacts', 'contact'], true)
        || in_array($title, ['контакты', 'kontakty', 'contacts', 'contact'], true);
}

add_action('add_meta_boxes_page', 'paliy_product_crop_add_contacts_meta_box', 21);
function paliy_product_crop_add_contacts_meta_box(WP_Post $post): void
{
    if (!paliy_product_crop_is_contacts_page($post)) {
        return;
    }

    add_meta_box(
        'paliy-contacts-fields',
        'Данные страницы «Контакты»',
        'paliy_product_crop_render_contacts_fields',
        'page',
        'normal',
        'high'
    );
}

function paliy_product_crop_render_contacts_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_contacts_fields_save', 'paliy_contacts_fields_nonce');
    $clinics = paliy_product_crop_sanitize_contacts_clinics(get_post_meta($post->ID, 'paliy_contacts_clinics', true));
    ?>
    <p class="description">Заполните данные страницы «Контакты». Richtext-поля поддерживают форматирование текста.</p>

    <div class="paliy-contacts-section">
        <h3>Вступительный блок</h3>
        <?php paliy_product_crop_render_about_editor('Заголовок', 'paliy_contacts_intro_title', 'paliy_contacts_intro_title', get_post_meta($post->ID, 'paliy_contacts_intro_title', true), 2); ?>
        <?php paliy_product_crop_render_about_editor('Подзаголовок', 'paliy_contacts_intro_subtitle', 'paliy_contacts_intro_subtitle', get_post_meta($post->ID, 'paliy_contacts_intro_subtitle', true), 3); ?>
    </div>

    <div class="paliy-contacts-section">
        <div class="paliy-about-section-heading">
            <h3>Карточки клиник</h3>
            <button type="button" class="button" id="paliy-contacts-add-clinic">Добавить карточку</button>
        </div>
        <p class="description">Добавьте одну или несколько карточек с адресами клиник.</p>
        <input type="hidden" name="paliy_contacts_clinics_present" value="1">
        <div id="paliy-contacts-clinics">
            <?php foreach ($clinics as $index => $clinic) : ?>
                <?php paliy_product_crop_render_contacts_clinic((string) $index, $clinic); ?>
            <?php endforeach; ?>
        </div>
        <template id="paliy-contacts-clinic-template"><?php paliy_product_crop_render_contacts_clinic('__INDEX__', []); ?></template>
    </div>

    <div class="paliy-contacts-section">
        <h3>Форма обратной связи</h3>
        <?php paliy_product_crop_render_about_editor('Заголовок', 'paliy_contacts_feedback_title', 'paliy_contacts_feedback_title', get_post_meta($post->ID, 'paliy_contacts_feedback_title', true), 2); ?>
        <?php paliy_product_crop_render_about_editor('Описание', 'paliy_contacts_feedback_description', 'paliy_contacts_feedback_description', get_post_meta($post->ID, 'paliy_contacts_feedback_description', true), 4); ?>
        <p>
            <label for="paliy_contacts_feedback_instagram"><strong>Instagram</strong></label>
            <input class="widefat" type="text" id="paliy_contacts_feedback_instagram" name="paliy_contacts_feedback_instagram" value="<?php echo esc_attr(get_post_meta($post->ID, 'paliy_contacts_feedback_instagram', true)); ?>" placeholder="https://instagram.com/...">
        </p>
        <p>
            <label for="paliy_contacts_feedback_facebook"><strong>Facebook</strong></label>
            <input class="widefat" type="text" id="paliy_contacts_feedback_facebook" name="paliy_contacts_feedback_facebook" value="<?php echo esc_attr(get_post_meta($post->ID, 'paliy_contacts_feedback_facebook', true)); ?>" placeholder="https://facebook.com/...">
        </p>
    </div>
    <?php
}

function paliy_product_crop_render_contacts_clinic(string $index, array $clinic): void
{
    ?>
    <article class="paliy-contacts-clinic" data-index="<?php echo esc_attr($index); ?>">
        <div class="paliy-about-section-heading">
            <strong>Карточка клиники</strong>
            <button type="button" class="button-link-delete paliy-contacts-remove-clinic">Удалить карточку</button>
        </div>
        <p>
            <label><strong>Название клиники</strong></label>
            <input class="widefat" type="text" name="paliy_contacts_clinics[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($clinic['name'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Адрес</strong></label>
            <input class="widefat" type="text" name="paliy_contacts_clinics[<?php echo esc_attr($index); ?>][address]" value="<?php echo esc_attr($clinic['address'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Часы работы</strong></label>
            <input class="widefat" type="text" name="paliy_contacts_clinics[<?php echo esc_attr($index); ?>][hours]" value="<?php echo esc_attr($clinic['hours'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>E-mail</strong></label>
            <input class="widefat" type="email" name="paliy_contacts_clinics[<?php echo esc_attr($index); ?>][email]" value="<?php echo esc_attr($clinic['email'] ?? ''); ?>" placeholder="clinic@example.com">
        </p>
    </article>
    <?php
}

add_action('add_meta_boxes_page', 'paliy_product_crop_add_about_meta_box', 20);
function paliy_product_crop_add_about_meta_box(WP_Post $post): void
{
    if (!paliy_product_crop_is_about_page($post)) {
        return;
    }

    add_meta_box(
        'paliy-about-fields',
        'Данные страницы «О нас»',
        'paliy_product_crop_render_about_fields',
        'page',
        'normal',
        'high'
    );
}

function paliy_product_crop_render_about_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_about_fields_save', 'paliy_about_fields_nonce');
    $team_members = paliy_product_crop_sanitize_about_team_members(get_post_meta($post->ID, 'paliy_about_team_members', true));
    $gallery_ids = paliy_product_crop_sanitize_about_gallery_ids(get_post_meta($post->ID, 'paliy_about_gallery_ids', true));
    ?>
    <p class="description">Эти данные являются единым источником контента для страницы «О нас» и главной страницы. Richtext-поля поддерживают форматирование.</p>

    <div class="paliy-about-section">
        <h3>О нас</h3>
        <?php paliy_product_crop_render_about_editor('Заголовок', 'paliy_about_intro_title', 'paliy_about_intro_title', get_post_meta($post->ID, 'paliy_about_intro_title', true), 2); ?>
        <?php paliy_product_crop_render_about_editor('Подзаголовок', 'paliy_about_intro_subtitle', 'paliy_about_intro_subtitle', get_post_meta($post->ID, 'paliy_about_intro_subtitle', true), 3); ?>
    </div>

    <div class="paliy-about-section">
        <h3>Основатель</h3>
        <?php paliy_product_crop_render_about_image_control('founder', (int) get_post_meta($post->ID, 'paliy_about_founder_image_id', true)); ?>
        <p>
            <label for="paliy_about_founder_title"><strong>Заголовок</strong></label>
            <input class="widefat" type="text" id="paliy_about_founder_title" name="paliy_about_founder_title" value="<?php echo esc_attr(get_post_meta($post->ID, 'paliy_about_founder_title', true)); ?>">
        </p>
        <?php paliy_product_crop_render_about_editor('Подзаголовок', 'paliy_about_founder_subtitle', 'paliy_about_founder_subtitle', get_post_meta($post->ID, 'paliy_about_founder_subtitle', true), 3); ?>
        <p>
            <label for="paliy_about_founder_name"><strong>ФИО</strong></label>
            <input class="widefat" type="text" id="paliy_about_founder_name" name="paliy_about_founder_name" value="<?php echo esc_attr(get_post_meta($post->ID, 'paliy_about_founder_name', true)); ?>">
        </p>
        <p>
            <label for="paliy_about_founder_position"><strong>Должность</strong></label>
            <input class="widefat" type="text" id="paliy_about_founder_position" name="paliy_about_founder_position" value="<?php echo esc_attr(get_post_meta($post->ID, 'paliy_about_founder_position', true)); ?>">
        </p>
        <?php paliy_product_crop_render_about_editor('Описание', 'paliy_about_founder_description', 'paliy_about_founder_description', get_post_meta($post->ID, 'paliy_about_founder_description', true), 5); ?>
    </div>

    <div class="paliy-about-section">
        <div class="paliy-about-section-heading">
            <h3>Наша команда</h3>
            <button type="button" class="button" id="paliy-about-add-team-member">Добавить участника</button>
        </div>
        <p class="description">Для каждого участника можно выбрать оригинальное фото и область карточки размером 360×390 px.</p>
        <input type="hidden" name="paliy_about_team_members_present" value="1">
        <div id="paliy-about-team-members">
            <?php foreach ($team_members as $index => $member) : ?>
                <?php paliy_product_crop_render_about_team_member((string) $index, $member); ?>
            <?php endforeach; ?>
        </div>
        <template id="paliy-about-team-template"><?php paliy_product_crop_render_about_team_member('__INDEX__', []); ?></template>
    </div>

    <div class="paliy-about-section">
        <h3>Фотогалерея</h3>
        <?php paliy_product_crop_render_about_editor('Заголовок', 'paliy_about_gallery_title', 'paliy_about_gallery_title', get_post_meta($post->ID, 'paliy_about_gallery_title', true), 2); ?>
        <?php paliy_product_crop_render_about_editor('Описание', 'paliy_about_gallery_description', 'paliy_about_gallery_description', get_post_meta($post->ID, 'paliy_about_gallery_description', true), 4); ?>
        <p>
            <button type="button" class="button" id="paliy-about-select-gallery">Добавить фотографии</button>
            <span id="paliy-about-gallery-count" class="description"><?php echo esc_html(count($gallery_ids)); ?> / 50</span>
        </p>
        <input type="hidden" name="paliy_about_gallery_present" value="1">
        <div id="paliy-about-gallery" class="paliy-about-gallery">
            <?php foreach ($gallery_ids as $image_id) : ?>
                <?php paliy_product_crop_render_about_gallery_image($image_id); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="paliy-about-team-crop-modal" class="paliy-product-crop-modal" hidden>
        <div class="paliy-product-crop-modal-inner">
            <div class="paliy-product-crop-modal-header">
                <strong>Выберите область для карточки 360×390</strong>
                <button type="button" class="button-link" id="paliy-about-close-team-crop">Закрыть</button>
            </div>
            <div class="paliy-product-crop-editor">
                <img id="paliy-about-team-crop-image" src="" alt="">
            </div>
            <p class="description">Соотношение сторон зафиксировано 12:13.</p>
            <button type="button" class="button button-primary" id="paliy-about-save-team-crop">Сохранить кадрирование</button>
        </div>
    </div>
    <?php
}

function paliy_product_crop_render_about_editor(string $label, string $name, string $editor_id, $value, int $rows): void
{
    echo '<p><strong>' . esc_html($label) . '</strong></p>';
    wp_editor((string) $value, $editor_id, [
        'textarea_name' => $name,
        'textarea_rows' => $rows,
        'media_buttons' => false,
        'teeny' => true,
        'quicktags' => false,
        'tinymce' => [
            'toolbar1' => 'bold,italic,link,unlink,removeformat',
            'toolbar2' => '',
        ],
    ]);
}

function paliy_product_crop_render_about_image_control(string $key, int $image_id): void
{
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
    <div class="paliy-about-image-control" data-key="<?php echo esc_attr($key); ?>">
        <p><strong>Фото</strong></p>
        <input type="hidden" id="paliy_about_<?php echo esc_attr($key); ?>_image_id" name="paliy_about_<?php echo esc_attr($key); ?>_image_id" value="<?php echo esc_attr($image_id); ?>">
        <button type="button" class="button paliy-about-select-image" data-key="<?php echo esc_attr($key); ?>">Выбрать изображение</button>
        <button type="button" class="button-link-delete paliy-about-remove-image" data-key="<?php echo esc_attr($key); ?>" <?php disabled(!$image_id); ?>>Удалить</button>
        <div class="paliy-about-image-preview" data-key="<?php echo esc_attr($key); ?>" <?php echo $image_url ? '' : 'hidden'; ?>>
            <img src="<?php echo esc_url($image_url); ?>" alt="">
        </div>
    </div>
    <?php
}

function paliy_product_crop_render_about_team_member(string $index, array $member): void
{
    $image_id = absint($member['image_id'] ?? 0);
    $original_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    $card_relpath = (string) ($member['card_relpath'] ?? '');
    $card_url = $card_relpath ? trailingslashit(wp_upload_dir()['baseurl']) . ltrim($card_relpath, '/\\') : '';
    ?>
    <article class="paliy-about-team-member" data-index="<?php echo esc_attr($index); ?>">
        <div class="paliy-about-team-member-heading">
            <strong>Участник команды</strong>
            <button type="button" class="button-link-delete paliy-about-remove-team-member">Удалить участника</button>
        </div>
        <input type="hidden" class="paliy-about-team-image-id" name="paliy_about_team_members[<?php echo esc_attr($index); ?>][image_id]" value="<?php echo esc_attr($image_id); ?>">
        <input type="hidden" class="paliy-about-team-crop" name="paliy_about_team_members[<?php echo esc_attr($index); ?>][crop]" value="<?php echo esc_attr(wp_json_encode($member['crop'] ?? [])); ?>">
        <p>
            <button type="button" class="button paliy-about-team-select-image">Выбрать фото</button>
            <button type="button" class="button paliy-about-team-crop-button" <?php disabled(!$image_id); ?>>Кадрировать 360×390</button>
        </p>
        <div class="paliy-about-team-images">
            <div>
                <span class="description">Оригинал</span>
                <img class="paliy-about-team-original" src="<?php echo esc_url($original_url); ?>" alt="" <?php echo $original_url ? '' : 'hidden'; ?>>
            </div>
            <div>
                <span class="description">Карточка 360×390</span>
                <img class="paliy-about-team-card" src="<?php echo esc_url($card_url); ?>" alt="" <?php echo $card_url ? '' : 'hidden'; ?>>
            </div>
        </div>
        <p>
            <label><strong>ФИО</strong></label>
            <input class="widefat" type="text" name="paliy_about_team_members[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($member['name'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Должность</strong></label>
            <input class="widefat" type="text" name="paliy_about_team_members[<?php echo esc_attr($index); ?>][position]" value="<?php echo esc_attr($member['position'] ?? ''); ?>">
        </p>
    </article>
    <?php
}

function paliy_product_crop_render_about_gallery_image(int $image_id): void
{
    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
    if (!$image_url) {
        return;
    }
    ?>
    <div class="paliy-about-gallery-item" data-image-id="<?php echo esc_attr($image_id); ?>">
        <input type="hidden" name="paliy_about_gallery_ids[]" value="<?php echo esc_attr($image_id); ?>">
        <img src="<?php echo esc_url($image_url); ?>" alt="">
        <button type="button" class="button-link-delete paliy-about-remove-gallery-image">Удалить</button>
    </div>
    <?php
}

function paliy_product_crop_render_service_category_page_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_service_category_page_fields_save', 'paliy_service_category_page_fields_nonce');
    ?>
    <p class="description">Заполните заголовок и подзаголовок для каждого раздела страницы категорий услуг. Поля поддерживают форматирование текста.</p>
    <div class="paliy-service-category-page-fields">
        <?php foreach (paliy_product_crop_get_service_category_sections() as $section) : ?>
            <section class="paliy-service-category-page-section">
                <h3><?php echo esc_html($section['name']); ?></h3>
                <?php foreach (['title' => 'Title', 'subtitle' => 'Subtitle'] as $field => $label) : ?>
                    <?php
                    $meta_key = 'paliy_service_category_' . $section['key'] . '_' . $field;
                    $editor_id = 'paliy_editor_' . $section['key'] . '_' . $field;
                    $value = (string) get_post_meta($post->ID, $meta_key, true);
                    ?>
                    <p><strong><?php echo esc_html($label); ?></strong></p>
                    <?php
                    wp_editor($value, $editor_id, [
                        'textarea_name' => $meta_key,
                        'textarea_rows' => $field === 'title' ? 2 : 3,
                        'media_buttons' => false,
                        'teeny' => true,
                        'quicktags' => false,
                        'tinymce' => [
                            'toolbar1' => 'bold,italic,link,unlink,removeformat',
                            'toolbar2' => '',
                        ],
                    ]);
                    ?>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    </div>
    <?php
}

function paliy_product_crop_render_news_category_page_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_news_category_page_fields_save', 'paliy_news_category_page_fields_nonce');
    ?>
    <p class="description">Заполните заголовок и подзаголовок для каждого раздела страницы категорий новостей. Поля поддерживают форматирование текста.</p>
    <div class="paliy-service-category-page-fields">
        <?php foreach (paliy_product_crop_get_news_category_sections() as $section) : ?>
            <section class="paliy-service-category-page-section">
                <h3><?php echo esc_html($section['name']); ?></h3>
                <?php foreach (['title' => 'Title', 'subtitle' => 'Subtitle'] as $field => $label) : ?>
                    <?php
                    $meta_key = 'paliy_news_category_' . $section['key'] . '_' . $field;
                    $editor_id = 'paliy_editor_news_' . $section['key'] . '_' . $field;
                    $value = (string) get_post_meta($post->ID, $meta_key, true);
                    ?>
                    <p><strong><?php echo esc_html($label); ?></strong></p>
                    <?php
                    wp_editor($value, $editor_id, [
                        'textarea_name' => $meta_key,
                        'textarea_rows' => $field === 'title' ? 2 : 3,
                        'media_buttons' => false,
                        'teeny' => true,
                        'quicktags' => false,
                        'tinymce' => [
                            'toolbar1' => 'bold,italic,link,unlink,removeformat',
                            'toolbar2' => '',
                        ],
                    ]);
                    ?>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    </div>
    <?php
}

add_action('service_category_add_form_fields', 'paliy_product_crop_render_service_category_add_field');
function paliy_product_crop_render_service_category_add_field(): void
{
    ?>
    <div class="form-field paliy-service-category-image-field">
        <label for="service_category_image_id">Изображение категории</label>
        <?php paliy_product_crop_render_service_category_image_controls(0); ?>
        <p class="description">Изображение будет доступно во frontend через REST API.</p>
    </div>
    <div class="form-field paliy-service-category-primary-field">
        <label for="service_category_is_primary">
            <input type="checkbox" id="service_category_is_primary" name="service_category_is_primary" value="1">
            <strong>Основная категория</strong>
        </label>
        <p class="description">Отметьте категорию как основную для использования во frontend.</p>
    </div>
    <?php paliy_product_crop_render_category_text_fields('service_category'); ?>
    <?php
}

add_action('service_category_edit_form_fields', 'paliy_product_crop_render_service_category_edit_field');
function paliy_product_crop_render_service_category_edit_field(WP_Term $term): void
{
    $image_id = (int) get_term_meta($term->term_id, 'service_category_image_id', true);
    $is_primary = (bool) get_term_meta($term->term_id, 'service_category_is_primary', true);
    ?>
    <tr class="form-field paliy-service-category-image-field">
        <th scope="row"><label for="service_category_image_id">Изображение категории</label></th>
        <td>
            <?php paliy_product_crop_render_service_category_image_controls($image_id); ?>
            <p class="description">Изображение будет доступно во frontend через REST API.</p>
        </td>
    </tr>
    <tr class="form-field paliy-service-category-primary-field">
        <th scope="row"><label for="service_category_is_primary">Основная категория</label></th>
        <td>
            <label>
                <input type="checkbox" id="service_category_is_primary" name="service_category_is_primary" value="1" <?php checked($is_primary, true); ?>>
                Использовать как основную категорию
            </label>
            <p class="description">Отметьте категорию как основную для использования во frontend.</p>
        </td>
    </tr>
    <?php paliy_product_crop_render_category_text_fields('service_category', $term); ?>
    <?php
}

add_action('news_category_add_form_fields', 'paliy_product_crop_render_news_category_add_fields');
function paliy_product_crop_render_news_category_add_fields(): void
{
    paliy_product_crop_render_category_text_fields('news_category');
}

add_action('news_category_edit_form_fields', 'paliy_product_crop_render_news_category_edit_fields');
function paliy_product_crop_render_news_category_edit_fields(WP_Term $term): void
{
    paliy_product_crop_render_category_text_fields('news_category', $term);
}

function paliy_product_crop_render_category_text_fields(string $taxonomy, ?WP_Term $term = null): void
{
    $title = $term ? (string) get_term_meta($term->term_id, 'paliy_category_title', true) : '';
    $subtitle = $term ? (string) get_term_meta($term->term_id, 'paliy_category_subtitle', true) : '';
    $prefix = $taxonomy === 'news_category' ? 'news' : 'service';
    wp_nonce_field('paliy_category_texts_save', 'paliy_category_texts_nonce');
    ?>
    <?php if ($term) : ?>
        <tr class="form-field paliy-category-text-field">
            <th scope="row"><label for="paliy_category_title_<?php echo esc_attr($prefix); ?>">Заголовок</label></th>
            <td>
                <?php paliy_product_crop_render_category_editor('Заголовок', 'paliy_category_title', 'paliy_category_title_' . $prefix, $title, 2); ?>
            </td>
        </tr>
        <tr class="form-field paliy-category-text-field">
            <th scope="row"><label for="paliy_category_subtitle_<?php echo esc_attr($prefix); ?>">Подзаголовок</label></th>
            <td>
                <?php paliy_product_crop_render_category_editor('Подзаголовок', 'paliy_category_subtitle', 'paliy_category_subtitle_' . $prefix, $subtitle, 4); ?>
            </td>
        </tr>
    <?php else : ?>
        <div class="form-field paliy-category-text-field">
            <label for="paliy_category_title_<?php echo esc_attr($prefix); ?>">Заголовок</label>
            <?php paliy_product_crop_render_category_editor('Заголовок', 'paliy_category_title', 'paliy_category_title_' . $prefix, $title, 2); ?>
        </div>
        <div class="form-field paliy-category-text-field">
            <label for="paliy_category_subtitle_<?php echo esc_attr($prefix); ?>">Подзаголовок</label>
            <?php paliy_product_crop_render_category_editor('Подзаголовок', 'paliy_category_subtitle', 'paliy_category_subtitle_' . $prefix, $subtitle, 4); ?>
        </div>
    <?php endif; ?>
    <?php
}

function paliy_product_crop_render_category_editor(string $label, string $name, string $editor_id, string $value, int $rows): void
{
    if ($label && !str_contains($editor_id, '_title_')) {
        echo '<p><strong>' . esc_html($label) . '</strong></p>';
    }

    wp_editor($value, $editor_id, [
        'textarea_name' => $name,
        'textarea_rows' => $rows,
        'media_buttons' => false,
        'teeny' => true,
        'quicktags' => false,
        'tinymce' => [
            'toolbar1' => 'bold,italic,link,unlink,removeformat',
            'toolbar2' => '',
        ],
    ]);
}

function paliy_product_crop_render_service_category_image_controls(int $image_id): void
{
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
    <?php wp_nonce_field('paliy_service_category_image_save', 'paliy_service_category_image_nonce'); ?>
    <input type="hidden" id="service_category_image_id" name="service_category_image_id" value="<?php echo esc_attr($image_id); ?>">
    <button type="button" class="button" id="paliy-select-service-category-image">Выбрать изображение</button>
    <button type="button" class="button-link-delete" id="paliy-remove-service-category-image" <?php disabled(!$image_id); ?>>Удалить</button>
    <div id="paliy-service-category-image-preview" class="paliy-service-category-image-preview" <?php echo $image_url ? '' : 'hidden'; ?>>
        <img src="<?php echo esc_url($image_url); ?>" alt="">
    </div>
    <?php
}

add_action('created_service_category', 'paliy_product_crop_save_service_category_fields');
add_action('edited_service_category', 'paliy_product_crop_save_service_category_fields');
add_action('created_service_category', 'paliy_product_crop_save_category_text_fields', 20);
add_action('edited_service_category', 'paliy_product_crop_save_category_text_fields', 20);
add_action('created_news_category', 'paliy_product_crop_save_category_text_fields', 20);
add_action('edited_news_category', 'paliy_product_crop_save_category_text_fields', 20);
function paliy_product_crop_save_service_category_fields(int $term_id): void
{
    if (!isset($_POST['paliy_service_category_image_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_service_category_image_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_service_category_image_save') || !current_user_can('manage_categories')) {
        return;
    }

    $image_id = isset($_POST['service_category_image_id']) ? absint($_POST['service_category_image_id']) : 0;
    if ($image_id && !wp_attachment_is_image($image_id)) {
        $image_id = 0;
    }

    if ($image_id) {
        update_term_meta($term_id, 'service_category_image_id', $image_id);
    } else {
        delete_term_meta($term_id, 'service_category_image_id');
    }

    if (isset($_POST['service_category_is_primary']) && $_POST['service_category_is_primary'] === '1') {
        update_term_meta($term_id, 'service_category_is_primary', true);
    } else {
        delete_term_meta($term_id, 'service_category_is_primary');
    }
}

function paliy_product_crop_save_category_text_fields(int $term_id): void
{
    if (!isset($_POST['paliy_category_texts_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_category_texts_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_category_texts_save') || !current_user_can('manage_categories')) {
        return;
    }

    foreach (['paliy_category_title', 'paliy_category_subtitle'] as $key) {
        $value = isset($_POST[$key]) ? wp_kses_post(wp_unslash($_POST[$key])) : '';
        if ($value === '') {
            delete_term_meta($term_id, $key);
        } else {
            update_term_meta($term_id, $key, $value);
        }
    }
}

add_filter('manage_edit-service_category_columns', 'paliy_product_crop_add_service_category_columns');
function paliy_product_crop_add_service_category_columns(array $columns): array
{
    unset($columns['description']);

    $columns['service_category_image'] = 'Изображение';
    $columns['service_category_primary'] = 'Основная';
    $columns['service_category_services_api'] = 'API услуг';

    return $columns;
}

add_filter('manage_service_category_custom_column', 'paliy_product_crop_render_service_category_columns', 10, 3);
function paliy_product_crop_render_service_category_columns(string $output, string $column, int $term_id): string
{
    if ($column === 'service_category_services_api') {
        $services_api_url = add_query_arg([
            'service-categories' => $term_id,
            'per_page' => 100,
        ], rest_url('wp/v2/services'));

        return '<div class="paliy-rest-api-control paliy-rest-api-table-control">'
            . '<a href="' . esc_url($services_api_url) . '" target="_blank" rel="noopener">Открыть услуги</a>'
            . '<button type="button" class="button-link paliy-copy-rest-api" data-api-url="' . esc_attr($services_api_url) . '">Скопировать</button>'
            . '<span class="paliy-rest-api-copy-status description" aria-live="polite"></span>'
            . '</div>';
    }

    if ($column === 'service_category_image') {
        $image_id = (int) get_term_meta($term_id, 'service_category_image_id', true);
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';

        return $image_url
            ? '<img class="paliy-service-category-table-image" src="' . esc_url($image_url) . '" alt="">'
            : '<span class="description">Нет</span>';
    }

    if ($column === 'service_category_primary') {
        return (bool) get_term_meta($term_id, 'service_category_is_primary', true)
            ? '<span class="dashicons dashicons-yes-alt" aria-label="Основная категория"></span>'
            : '<span class="description">Нет</span>';
    }

    return $output;
}

add_action('manage_edit-service_category_extra_tablenav', 'paliy_product_crop_render_service_categories_api_toolbar');
function paliy_product_crop_render_service_categories_api_toolbar(string $which): void
{
    if ($which !== 'top') {
        return;
    }

    $api_url = rest_url('wp/v2/service-categories');
    ?>
    <div class="paliy-pages-api-toolbar paliy-service-categories-api-toolbar">
        <strong>API всех категорий услуг:</strong>
        <a href="<?php echo esc_url($api_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($api_url); ?></a>
        <button type="button" class="button paliy-copy-rest-api" data-api-url="<?php echo esc_attr($api_url); ?>">Скопировать</button>
        <span class="paliy-rest-api-copy-status description" aria-live="polite"></span>
    </div>
    <?php
}

add_filter('manage_edit-news_category_columns', 'paliy_product_crop_add_news_category_news_api_column');
function paliy_product_crop_add_news_category_news_api_column(array $columns): array
{
    $columns['news_category_news_api'] = 'API новостей';

    return $columns;
}

add_filter('manage_news_category_custom_column', 'paliy_product_crop_render_news_category_news_api_column', 10, 3);
function paliy_product_crop_render_news_category_news_api_column(string $output, string $column, int $term_id): string
{
    if ($column !== 'news_category_news_api') {
        return $output;
    }

    $news_api_url = add_query_arg([
        'news-categories' => $term_id,
        'per_page' => 100,
    ], rest_url('wp/v2/news'));

    return '<div class="paliy-rest-api-control paliy-rest-api-table-control">'
        . '<a href="' . esc_url($news_api_url) . '" target="_blank" rel="noopener">Открыть новости</a>'
        . '<button type="button" class="button-link paliy-copy-rest-api" data-api-url="' . esc_attr($news_api_url) . '">Скопировать</button>'
        . '<span class="paliy-rest-api-copy-status description" aria-live="polite"></span>'
        . '</div>';
}

add_filter('manage_edit-review_category_columns', 'paliy_product_crop_add_review_category_reviews_api_column');
function paliy_product_crop_add_review_category_reviews_api_column(array $columns): array
{
    $columns['review_category_reviews_api'] = 'API отзывов';

    return $columns;
}

add_filter('manage_review_category_custom_column', 'paliy_product_crop_render_review_category_reviews_api_column', 10, 3);
function paliy_product_crop_render_review_category_reviews_api_column(string $output, string $column, int $term_id): string
{
    if ($column !== 'review_category_reviews_api') {
        return $output;
    }

    $reviews_api_url = add_query_arg([
        'review-categories' => $term_id,
        'per_page' => 100,
    ], rest_url('wp/v2/reviews'));

    return '<div class="paliy-rest-api-control paliy-rest-api-table-control">'
        . '<a href="' . esc_url($reviews_api_url) . '" target="_blank" rel="noopener">Открыть отзывы</a>'
        . '<button type="button" class="button-link paliy-copy-rest-api" data-api-url="' . esc_attr($reviews_api_url) . '">Скопировать</button>'
        . '<span class="paliy-rest-api-copy-status description" aria-live="polite"></span>'
        . '</div>';
}

add_filter('manage_edit-faq_tag_columns', 'paliy_product_crop_add_faq_tag_faq_api_column');
function paliy_product_crop_add_faq_tag_faq_api_column(array $columns): array
{
    $columns['faq_tag_faq_api'] = 'API FAQ';

    return $columns;
}

add_filter('manage_faq_tag_custom_column', 'paliy_product_crop_render_faq_tag_faq_api_column', 10, 3);
function paliy_product_crop_render_faq_tag_faq_api_column(string $output, string $column, int $term_id): string
{
    if ($column !== 'faq_tag_faq_api') {
        return $output;
    }

    $faq_api_url = add_query_arg([
        'faq-tags' => $term_id,
        'per_page' => 100,
    ], rest_url('wp/v2/faq'));

    return '<div class="paliy-rest-api-control paliy-rest-api-table-control">'
        . '<a href="' . esc_url($faq_api_url) . '" target="_blank" rel="noopener">Открыть FAQ</a>'
        . '<button type="button" class="button-link paliy-copy-rest-api" data-api-url="' . esc_attr($faq_api_url) . '">Скопировать</button>'
        . '<span class="paliy-rest-api-copy-status description" aria-live="polite"></span>'
        . '</div>';
}

function paliy_product_crop_render_rest_api_link(WP_Post $post): void
{
    if (!$post->ID) {
        echo '<p>Сначала сохраните запись, чтобы получить API-ссылку.</p>';
        return;
    }

    $api_url = paliy_product_crop_get_post_rest_url($post);
    ?>
    <div class="paliy-rest-api-control">
        <p class="description">JSON этой записи для подключения фронтенда.</p>
        <input
            type="url"
            class="widefat paliy-rest-api-url"
            value="<?php echo esc_attr($api_url); ?>"
            readonly
            aria-label="Ссылка REST API"
        >
        <p class="paliy-rest-api-actions">
            <a class="button" href="<?php echo esc_url($api_url); ?>" target="_blank" rel="noopener">Открыть JSON</a>
            <button type="button" class="button button-primary paliy-copy-rest-api" id="paliy-copy-rest-api" data-api-url="<?php echo esc_attr($api_url); ?>">Скопировать</button>
        </p>
        <span class="paliy-rest-api-copy-status description" aria-live="polite"></span>
    </div>
    <?php
}

function paliy_product_crop_get_post_rest_url(WP_Post $post): string
{
    $post_type = get_post_type_object($post->post_type);
    $rest_base = $post_type && !empty($post_type->rest_base) ? $post_type->rest_base : $post->post_type;

    return rest_url('wp/v2/' . trim($rest_base, '/') . '/' . $post->ID);
}

add_filter('manage_pages_columns', 'paliy_product_crop_add_pages_api_column');
function paliy_product_crop_add_pages_api_column(array $columns): array
{
    $columns['paliy_rest_api'] = 'REST API';

    return $columns;
}

add_action('manage_pages_custom_column', 'paliy_product_crop_render_pages_api_column', 10, 2);
function paliy_product_crop_render_pages_api_column(string $column, int $post_id): void
{
    if ($column !== 'paliy_rest_api') {
        return;
    }

    $post = get_post($post_id);
    if (!$post instanceof WP_Post) {
        return;
    }

    $api_url = paliy_product_crop_get_post_rest_url($post);
    ?>
    <div class="paliy-rest-api-control paliy-rest-api-table-control">
        <a href="<?php echo esc_url($api_url); ?>" target="_blank" rel="noopener">Открыть JSON</a>
        <button type="button" class="button-link paliy-copy-rest-api" data-api-url="<?php echo esc_attr($api_url); ?>">Скопировать</button>
        <span class="paliy-rest-api-copy-status description" aria-live="polite"></span>
    </div>
    <?php
}

add_action('manage_pages_extra_tablenav', 'paliy_product_crop_render_pages_api_toolbar');
function paliy_product_crop_render_pages_api_toolbar(string $which): void
{
    if ($which !== 'top') {
        return;
    }

    $api_url = rest_url('wp/v2/pages');
    ?>
    <div class="paliy-pages-api-toolbar">
        <strong>API всех страниц:</strong>
        <a href="<?php echo esc_url($api_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($api_url); ?></a>
        <button type="button" class="button paliy-copy-rest-api" data-api-url="<?php echo esc_attr($api_url); ?>">Скопировать</button>
        <span class="paliy-rest-api-copy-status description" aria-live="polite"></span>
    </div>
    <?php
}

function paliy_product_crop_render_seo_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_seo_fields_save', 'paliy_seo_fields_nonce');

    $fields = [
        'paliy_seo_title' => [
            'label' => 'SEO-заголовок',
            'type' => 'text',
            'placeholder' => 'Например: Перманентный макияж в Праге | PALIY',
            'description' => 'Если не заполнить, Nuxt сможет использовать обычный заголовок записи.',
        ],
        'paliy_seo_description' => [
            'label' => 'Meta description',
            'type' => 'textarea',
            'placeholder' => 'Краткое описание страницы для поисковой выдачи, до 160 символов.',
            'description' => 'Рекомендуемый размер — примерно 120–160 символов.',
        ],
        'paliy_seo_og_title' => [
            'label' => 'OG-заголовок',
            'type' => 'text',
            'placeholder' => 'Заголовок при публикации ссылки в соцсетях',
            'description' => 'Можно оставить пустым — тогда будет использован SEO-заголовок.',
        ],
        'paliy_seo_og_description' => [
            'label' => 'OG-описание',
            'type' => 'textarea',
            'placeholder' => 'Описание при публикации ссылки в соцсетях',
            'description' => 'Можно оставить пустым — тогда будет использовано meta description.',
        ],
    ];
    ?>
    <div class="paliy-seo-fields">
        <p class="description">Эти поля используются Nuxt для поисковых систем и предпросмотра ссылок в социальных сетях.</p>
        <?php foreach ($fields as $key => $field) : ?>
            <?php $value = (string) get_post_meta($post->ID, $key, true); ?>
            <p>
                <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label>
                <?php if ($field['type'] === 'textarea') : ?>
                    <textarea class="widefat" rows="3" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" placeholder="<?php echo esc_attr($field['placeholder']); ?>"><?php echo esc_textarea($value); ?></textarea>
                <?php else : ?>
                    <input class="widefat" type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($field['placeholder']); ?>">
                <?php endif; ?>
                <span class="description"><?php echo esc_html($field['description']); ?></span>
            </p>
        <?php endforeach; ?>

        <?php
        $og_image_id = (int) get_post_meta($post->ID, 'paliy_seo_og_image_id', true);
        $og_image_url = $og_image_id ? wp_get_attachment_image_url($og_image_id, 'medium') : '';
        ?>
        <p>
            <label><strong>OG-картинка</strong></label>
            <input type="hidden" id="paliy_seo_og_image_id" name="paliy_seo_og_image_id" value="<?php echo esc_attr($og_image_id); ?>">
            <button type="button" class="button" id="paliy-seo-select-og-image">Выбрать изображение</button>
            <button type="button" class="button-link-delete" id="paliy-seo-remove-og-image" <?php disabled(!$og_image_id); ?>>Удалить</button>
        </p>
        <div id="paliy-seo-og-image-preview" class="paliy-seo-og-image-preview" <?php echo $og_image_url ? '' : 'hidden'; ?>>
            <img src="<?php echo esc_url($og_image_url); ?>" alt="">
        </div>

        <p>
            <label for="paliy_seo_noindex">
                <input type="checkbox" id="paliy_seo_noindex" name="paliy_seo_noindex" value="1" <?php checked(in_array(get_post_meta($post->ID, 'paliy_seo_noindex', true), [true, 1, '1'], true), true); ?>>
                <strong>Не индексировать эту страницу</strong>
            </label>
        </p>
    </div>
    <?php
}

function paliy_product_crop_render_service_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_service_fields_save', 'paliy_service_fields_nonce');
    $fields = [
        'service_description' => [
            'label' => 'Описание',
            'type' => 'textarea',
            'placeholder' => 'Краткое описание услуги',
        ],
        'service_time' => [
            'label' => 'Время',
            'type' => 'text',
            'placeholder' => 'Например: 1,5 часа',
        ],
        'service_price' => [
            'label' => 'Цена',
            'type' => 'text',
            'placeholder' => 'Например: 5 000 ₽',
        ],
        'service_discount' => [
            'label' => 'Скидка',
            'type' => 'text',
            'placeholder' => 'Например: 20',
            'attributes' => 'inputmode="numeric" pattern="[1-9][0-9]" maxlength="2"',
            'description' => 'Укажите только двухзначное число процентов: от 10 до 99, без знака %.',
        ],
        'service_people_count' => [
            'label' => 'Количество человек',
            'type' => 'text',
            'placeholder' => 'Например: 1 человек',
        ],
        'reservio_url' => [
            'label' => 'Ссылка на Reservio',
            'type' => 'url',
            'placeholder' => 'https://reservio.com/...',
        ],
    ];
    ?>
    <div class="paliy-service-fields">
        <?php foreach ($fields as $key => $field) : ?>
            <?php $value = get_post_meta($post->ID, $key, true); ?>
            <p>
                <?php if ($field['type'] === 'checkbox') : ?>
                    <label for="<?php echo esc_attr($key); ?>">
                        <input type="checkbox" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(in_array($value, [true, 1, '1'], true), true); ?>>
                        <strong><?php echo esc_html($field['label']); ?></strong>
                    </label>
                <?php elseif ($field['type'] === 'textarea') : ?>
                    <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label>
                    <textarea class="widefat" rows="3" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" placeholder="<?php echo esc_attr($field['placeholder']); ?>"><?php echo esc_textarea($value); ?></textarea>
                <?php else : ?>
                    <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label>
                    <input class="widefat" type="<?php echo esc_attr($field['type'] ?? 'text'); ?>" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($field['placeholder']); ?>" <?php echo $field['attributes'] ?? ''; ?>>
                    <?php if (!empty($field['description'])) : ?>
                        <span class="description"><?php echo esc_html($field['description']); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>

        <?php
        $tariffs = paliy_product_crop_sanitize_service_tariffs(get_post_meta($post->ID, 'service_tariffs', true));
        ?>
        <div class="paliy-service-tariffs">
            <div class="paliy-about-section-heading">
                <h3>Тарифы</h3>
                <button type="button" class="button" id="paliy-service-add-tariff">Добавить тариф</button>
            </div>
            <p class="description">Добавьте один или несколько тарифов для этой услуги.</p>
            <input type="hidden" name="paliy_service_tariffs_present" value="1">
            <div id="paliy-service-tariffs-list">
                <?php foreach ($tariffs as $index => $tariff) : ?>
                    <?php paliy_product_crop_render_service_tariff((string) $index, $tariff); ?>
                <?php endforeach; ?>
            </div>
            <template id="paliy-service-tariff-template"><?php paliy_product_crop_render_service_tariff('__INDEX__', [], true); ?></template>
        </div>
    </div>
    <?php
}

function paliy_product_crop_render_service_tariff(string $index, array $tariff, bool $template = false): void
{
    $description = (string) ($tariff['description'] ?? '');
    $editor_id = 'paliy_service_tariff_' . $index . '_description';
    $textarea_name = 'paliy_service_tariffs[' . $index . '][description]';
    ?>
    <article class="paliy-service-tariff" data-index="<?php echo esc_attr($index); ?>">
        <div class="paliy-about-section-heading">
            <div class="paliy-service-tariff-title">
                <span class="paliy-service-tariff-drag-handle" title="Перетащите тариф для изменения порядка" aria-label="Перетащите тариф для изменения порядка">☷</span>
                <strong>Тариф</strong>
            </div>
            <button type="button" class="button-link-delete paliy-service-remove-tariff">Удалить тариф</button>
        </div>
        <p>
            <label><strong>Название</strong></label>
            <input class="widefat" type="text" name="paliy_service_tariffs[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($tariff['name'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Цена</strong></label>
            <input class="widefat" type="text" name="paliy_service_tariffs[<?php echo esc_attr($index); ?>][price]" value="<?php echo esc_attr($tariff['price'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Время</strong></label>
            <input class="widefat" type="text" name="paliy_service_tariffs[<?php echo esc_attr($index); ?>][time]" value="<?php echo esc_attr($tariff['time'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Кол-во человек</strong></label>
            <input class="widefat" type="text" name="paliy_service_tariffs[<?php echo esc_attr($index); ?>][people_count]" value="<?php echo esc_attr($tariff['people_count'] ?? ''); ?>">
        </p>
        <p>
            <label><strong>Ссылка на Reservio</strong></label>
            <input class="widefat" type="url" name="paliy_service_tariffs[<?php echo esc_attr($index); ?>][reservio_url]" value="<?php echo esc_attr($tariff['reservio_url'] ?? ''); ?>" placeholder="https://reservio.com/...">
        </p>
        <p><strong>Описание</strong></p>
        <?php if ($template) : ?>
            <textarea class="paliy-service-tariff-description" id="<?php echo esc_attr($editor_id); ?>" name="<?php echo esc_attr($textarea_name); ?>" rows="5"></textarea>
        <?php else : ?>
            <?php wp_editor($description, $editor_id, [
                'textarea_name' => $textarea_name,
                'textarea_rows' => 5,
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => false,
                'editor_class' => 'paliy-service-tariff-description',
                'tinymce' => [
                    'toolbar1' => 'bold,italic,link,unlink,removeformat',
                    'toolbar2' => '',
                ],
            ]); ?>
        <?php endif; ?>
    </article>
    <?php
}

function paliy_product_crop_render_news_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_news_fields_save', 'paliy_news_fields_nonce');
    $description = (string) get_post_meta($post->ID, 'news_description', true);
    ?>
    <div class="paliy-service-fields">
        <h3>Изображения новости или товара</h3>
        <?php paliy_product_crop_render_meta_box($post); ?>

        <p>
            <label for="news_description"><strong>Описание</strong></label>
            <textarea class="widefat" rows="3" id="news_description" name="news_description" placeholder="Краткое описание новости"><?php echo esc_textarea($description); ?></textarea>
        </p>
    </div>
    <?php
}

function paliy_product_crop_render_review_fields(WP_Post $post): void
{
    wp_nonce_field('paliy_review_fields_save', 'paliy_review_fields_nonce');
    $image_id = (int) get_post_meta($post->ID, 'review_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    $name = (string) get_post_meta($post->ID, 'review_name', true);
    $date = (string) get_post_meta($post->ID, 'review_date', true);
    $description = (string) get_post_meta($post->ID, 'review_description', true);
    ?>
    <div class="paliy-review-fields">
        <p>
            <label><strong>Фото</strong></label><br>
            <input type="hidden" id="review_image_id" name="review_image_id" value="<?php echo esc_attr($image_id); ?>">
            <button type="button" class="button" id="paliy-select-review-image">Выбрать изображение</button>
            <button type="button" class="button-link-delete" id="paliy-remove-review-image" <?php disabled(!$image_id); ?>>Удалить</button>
        </p>
        <div id="paliy-review-image-preview" class="paliy-review-image-preview" <?php echo $image_url ? '' : 'hidden'; ?>>
            <img src="<?php echo esc_url($image_url); ?>" alt="">
        </div>
        <p>
            <label for="review_name"><strong>ФИО</strong></label>
            <input class="widefat" type="text" id="review_name" name="review_name" value="<?php echo esc_attr($name); ?>">
        </p>
        <p>
            <label for="review_date"><strong>Дата публикации</strong></label>
            <input class="widefat" type="text" id="review_date" name="review_date" value="<?php echo esc_attr($date); ?>" placeholder="Например: 03.09.2026">
        </p>
        <p><strong>Описание</strong></p>
        <?php
        wp_editor($description, 'paliy_review_description', [
            'textarea_name' => 'review_description',
            'textarea_rows' => 6,
            'media_buttons' => false,
            'teeny' => true,
            'quicktags' => false,
            'tinymce' => [
                'toolbar1' => 'bold,italic,link,unlink,removeformat',
                'toolbar2' => '',
            ],
        ]);
        ?>
    </div>
    <?php
}

function paliy_product_crop_render_meta_box(WP_Post $post): void
{
    $attachment_id = (int) get_post_meta($post->ID, '_paliy_product_image_id', true);
    $original_url = $attachment_id ? wp_get_attachment_image_url($attachment_id, 'full') : '';
    $card_url = paliy_product_crop_get_card_url($post->ID);
    $crop = get_post_meta($post->ID, '_paliy_product_crop', true);

    wp_nonce_field('paliy_product_crop_save', 'paliy_product_crop_nonce');
    ?>
    <?php
    $content_label = match ($post->post_type) {
        'paliy_service' => 'услуги',
        'paliy_news' => 'новости',
        default => 'товара',
    };
    ?>
    <div
        class="paliy-product-crop-metabox"
        data-attachment-id="<?php echo esc_attr($attachment_id); ?>"
        data-crop="<?php echo esc_attr($crop); ?>"
    >
        <input type="hidden" name="paliy_product_image_id" id="paliy-product-image-id" value="<?php echo esc_attr($attachment_id); ?>">
        <input type="hidden" name="paliy_product_crop" id="paliy-product-crop-data" value="<?php echo esc_attr($crop); ?>">

        <p class="description">Загрузите оригинал, выберите область и сохраните <?php echo esc_html($content_label); ?>. Размер карточки: <?php echo esc_html(PALIY_PRODUCT_CROP_CARD_WIDTH . '×' . PALIY_PRODUCT_CROP_CARD_HEIGHT); ?> px.</p>

        <div class="paliy-product-crop-actions">
            <button type="button" class="button" id="paliy-select-product-image">Выбрать изображение</button>
            <button type="button" class="button button-primary" id="paliy-open-product-crop" <?php disabled(!$original_url); ?>>Кадрировать для карточки</button>
        </div>

        <div id="paliy-product-crop-status" class="paliy-product-crop-status" aria-live="polite"></div>

        <div class="paliy-product-images-preview">
            <div>
                <strong>Оригинал</strong>
                <div class="paliy-product-image-frame">
                    <img id="paliy-product-original-preview" src="<?php echo esc_url($original_url); ?>" alt="" <?php echo $original_url ? '' : 'hidden'; ?>>
                </div>
            </div>
            <div>
                <strong>Карточка <?php echo esc_html(PALIY_PRODUCT_CROP_CARD_WIDTH . '×' . PALIY_PRODUCT_CROP_CARD_HEIGHT); ?></strong>
                <div class="paliy-product-image-frame paliy-product-card-frame">
                    <img id="paliy-product-card-preview" src="<?php echo esc_url($card_url); ?>" alt="" <?php echo $card_url ? '' : 'hidden'; ?>>
                    <span id="paliy-product-card-empty" <?php echo $card_url ? 'hidden' : ''; ?>>Кадрирование ещё не создано</span>
                </div>
            </div>
        </div>

        <div id="paliy-product-crop-modal" class="paliy-product-crop-modal" hidden>
            <div class="paliy-product-crop-modal-inner">
                <div class="paliy-product-crop-modal-header">
                    <strong>Выберите область для карточки</strong>
                    <button type="button" class="button-link" id="paliy-close-product-crop">Закрыть</button>
                </div>
                <div class="paliy-product-crop-editor">
                    <img id="paliy-product-crop-image" src="" alt="">
                </div>
                <p class="description">Соотношение сторон зафиксировано 12:13. Перемещайте и масштабируйте область кадрирования.</p>
                <button type="button" class="button button-primary" id="paliy-save-product-crop">Сохранить кадрирование</button>
            </div>
        </div>
    </div>
    <?php
}

add_action('admin_enqueue_scripts', 'paliy_product_crop_enqueue_admin_assets');
function paliy_product_crop_enqueue_admin_assets(string $hook): void
{
    $screen = get_current_screen();
    $is_editor = in_array($hook, ['post.php', 'post-new.php'], true);
    $is_pages_list = $hook === 'edit.php' && $screen && $screen->post_type === 'page';
    $is_taxonomy_screen = in_array($hook, ['edit-tags.php', 'term.php'], true)
        && $screen
        && in_array($screen->taxonomy, ['service_category', 'news_category', 'review_category', 'faq_tag'], true);

    if (!$screen || (!$is_editor && !$is_pages_list && !$is_taxonomy_screen) || ($is_editor && !in_array($screen->post_type, ['page', 'paliy_product', 'paliy_service', 'paliy_news', 'paliy_video', 'paliy_faq', 'paliy_review'], true))) {
        return;
    }

    wp_enqueue_style(
        'paliy-product-crop-admin',
        plugin_dir_url(__FILE__) . 'assets/admin.css',
        [],
        PALIY_PRODUCT_CROP_VERSION
    );

    if ($is_pages_list || $is_taxonomy_screen) {
        if ($is_taxonomy_screen && $screen->taxonomy === 'service_category') {
            wp_enqueue_media();
        }
        wp_enqueue_script(
            'paliy-product-crop-admin',
            plugin_dir_url(__FILE__) . 'assets/admin.js',
            ['jquery', 'media-views', 'wp-hooks'],
            PALIY_PRODUCT_CROP_VERSION,
            true
        );
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style(
        'paliy-product-cropper',
        plugin_dir_url(__FILE__) . 'vendor/cropperjs/cropper.min.css',
        [],
        '1.6.2'
    );
    wp_enqueue_script(
        'paliy-product-cropper',
        plugin_dir_url(__FILE__) . 'vendor/cropperjs/cropper.min.js',
        [],
        '1.6.2',
        true
    );
        wp_enqueue_script(
            'paliy-product-crop-admin',
            plugin_dir_url(__FILE__) . 'assets/admin.js',
            ['jquery', 'jquery-ui-sortable', 'paliy-product-cropper', 'wp-api-fetch', 'wp-data', 'wp-editor', 'media-views', 'wp-hooks'],
        PALIY_PRODUCT_CROP_VERSION,
        true
    );
    wp_localize_script('paliy-product-crop-admin', 'paliyProductCropSettings', [
        'cardWidth' => PALIY_PRODUCT_CROP_CARD_WIDTH,
        'cardHeight' => PALIY_PRODUCT_CROP_CARD_HEIGHT,
        'apiRoot' => esc_url_raw(rest_url()),
        'apiNonce' => wp_create_nonce('wp_rest'),
    ]);
}

add_action('save_post_paliy_product', 'paliy_product_crop_save_product', 10, 3);
add_action('save_post_paliy_service', 'paliy_product_crop_save_product', 10, 3);
add_action('save_post_paliy_news', 'paliy_product_crop_save_product', 10, 3);
add_action('save_post_paliy_service', 'paliy_product_crop_save_service_fields', 10, 3);
add_action('save_post_paliy_news', 'paliy_product_crop_save_news_fields', 10, 3);
add_action('save_post_paliy_review', 'paliy_product_crop_save_review_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_related_videos', 10, 3);
add_action('save_post_paliy_service', 'paliy_product_crop_save_related_videos', 10, 3);
add_action('save_post_paliy_news', 'paliy_product_crop_save_related_videos', 10, 3);
add_action('save_post_paliy_video', 'paliy_product_crop_save_video_source', 10, 3);
add_filter('wp_insert_post_data', 'paliy_product_crop_validate_video_source_before_save', 10, 2);
add_action('save_post_paliy_feedback', 'paliy_product_crop_save_feedback_fields', 10, 3);
add_action('save_post_paliy_product', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_paliy_service', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_paliy_news', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_paliy_video', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_paliy_faq', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_seo_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_service_category_page_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_news_category_page_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_about_fields', 10, 3);
add_action('save_post_page', 'paliy_product_crop_save_contacts_fields', 10, 3);
function paliy_product_crop_save_product(int $post_id, WP_Post $post, bool $update): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id) || !isset($_POST['paliy_product_crop_nonce'])) {
        return;
    }

    // Gutenberg/autosave can send the nonce without the image fields.
    // Do not overwrite already saved image metadata in that case.
    if (!isset($_POST['paliy_product_image_id']) && !isset($_POST['paliy_product_crop'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_product_crop_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_product_crop_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $attachment_id = isset($_POST['paliy_product_image_id']) ? absint($_POST['paliy_product_image_id']) : 0;
    $saved_attachment_id = (int) get_post_meta($post_id, '_paliy_product_image_id', true);

    // Do not clear a saved image when Gutenberg/autosave submits an empty
    // metabox field. A new image is always sent as a positive attachment ID.
    if ($attachment_id > 0) {
        update_post_meta($post_id, '_paliy_product_image_id', $attachment_id);
    }

    $crop_raw = isset($_POST['paliy_product_crop']) ? wp_unslash($_POST['paliy_product_crop']) : '';
    if ($attachment_id < 1 && $saved_attachment_id > 0 && trim((string) $crop_raw) === '') {
        return;
    }

    $effective_attachment_id = $attachment_id > 0 ? $attachment_id : $saved_attachment_id;
    $crop = paliy_product_crop_sanitize_crop($crop_raw, $effective_attachment_id);

    if (!$crop) {
        delete_post_meta($post_id, '_paliy_product_crop');
        delete_post_meta($post_id, '_paliy_product_card_relpath');
        return;
    }

    $result = paliy_product_crop_generate_card($effective_attachment_id, $crop);
    if (is_wp_error($result)) {
        update_post_meta($post_id, '_paliy_product_crop_error', $result->get_error_message());
        return;
    }

    update_post_meta($post_id, '_paliy_product_crop', wp_json_encode($crop));
    update_post_meta($post_id, '_paliy_product_card_relpath', $result['relative_path']);
    delete_post_meta($post_id, '_paliy_product_crop_error');
}

function paliy_product_crop_save_service_category_page_fields(int $post_id, WP_Post $post, bool $update): void
{
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($post_id) || !paliy_product_crop_is_homepage_page($post)) {
        return;
    }

    if (!isset($_POST['paliy_service_category_page_fields_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_service_category_page_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_service_category_page_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (paliy_product_crop_get_service_category_sections() as $section) {
        foreach (['title', 'subtitle'] as $field) {
            $meta_key = 'paliy_service_category_' . $section['key'] . '_' . $field;
            if (!array_key_exists($meta_key, $_POST)) {
                continue;
            }

            $value = wp_kses_post(wp_unslash($_POST[$meta_key]));

            if ($value === '') {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $value);
            }
        }
    }
}

function paliy_product_crop_save_news_category_page_fields(int $post_id, WP_Post $post, bool $update): void
{
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($post_id) || !paliy_product_crop_is_homepage_page($post)) {
        return;
    }

    if (!isset($_POST['paliy_news_category_page_fields_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_news_category_page_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_news_category_page_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (paliy_product_crop_get_news_category_sections() as $section) {
        foreach (['title', 'subtitle'] as $field) {
            $meta_key = 'paliy_news_category_' . $section['key'] . '_' . $field;
            if (!array_key_exists($meta_key, $_POST)) {
                continue;
            }

            $value = wp_kses_post(wp_unslash($_POST[$meta_key]));

            if ($value === '') {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $value);
            }
        }
    }
}

function paliy_product_crop_save_about_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !paliy_product_crop_is_about_page($post)
        || !isset($_POST['paliy_about_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_about_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_about_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach ([
        'paliy_about_intro_title',
        'paliy_about_intro_subtitle',
        'paliy_about_founder_subtitle',
        'paliy_about_founder_description',
        'paliy_about_gallery_title',
        'paliy_about_gallery_description',
    ] as $key) {
        if (array_key_exists($key, $_POST)) {
            paliy_product_crop_save_about_meta($post_id, $key, wp_kses_post(wp_unslash($_POST[$key])));
        }
    }

    foreach (['paliy_about_founder_title', 'paliy_about_founder_name', 'paliy_about_founder_position'] as $key) {
        if (array_key_exists($key, $_POST)) {
            paliy_product_crop_save_about_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }

    if (isset($_POST['paliy_about_founder_image_id'])) {
        $founder_image_id = absint($_POST['paliy_about_founder_image_id']);
        if ($founder_image_id && !wp_attachment_is_image($founder_image_id)) {
            $founder_image_id = 0;
        }

        if ($founder_image_id) {
            update_post_meta($post_id, 'paliy_about_founder_image_id', $founder_image_id);
        } else {
            delete_post_meta($post_id, 'paliy_about_founder_image_id');
        }
    }

    if (isset($_POST['paliy_about_team_members_present'])) {
        $raw_members = isset($_POST['paliy_about_team_members']) && is_array($_POST['paliy_about_team_members'])
            ? wp_unslash($_POST['paliy_about_team_members'])
            : [];
        $members = paliy_product_crop_prepare_about_team_members($raw_members);

        if ($members) {
            update_post_meta($post_id, 'paliy_about_team_members', $members);
        } else {
            delete_post_meta($post_id, 'paliy_about_team_members');
        }
    }

    if (isset($_POST['paliy_about_gallery_present'])) {
        $gallery_ids = isset($_POST['paliy_about_gallery_ids']) ? paliy_product_crop_sanitize_about_gallery_ids(wp_unslash($_POST['paliy_about_gallery_ids'])) : [];
        if ($gallery_ids) {
            update_post_meta($post_id, 'paliy_about_gallery_ids', $gallery_ids);
        } else {
            delete_post_meta($post_id, 'paliy_about_gallery_ids');
        }
    }
}

function paliy_product_crop_sanitize_contacts_clinics($value): array
{
    if (!is_array($value)) {
        return [];
    }

    $clinics = [];
    foreach ($value as $clinic) {
        if (!is_array($clinic)) {
            continue;
        }

        $name = sanitize_text_field($clinic['name'] ?? '');
        $address = sanitize_text_field($clinic['address'] ?? '');
        $hours = sanitize_text_field($clinic['hours'] ?? '');
        $email = sanitize_email($clinic['email'] ?? '');

        if ($name === '' && $address === '' && $hours === '' && $email === '') {
            continue;
        }

        $clinics[] = [
            'name' => $name,
            'address' => $address,
            'hours' => $hours,
            'email' => $email,
        ];
    }

    return array_slice($clinics, 0, 50);
}

function paliy_product_crop_save_contacts_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !paliy_product_crop_is_contacts_page($post)
        || !isset($_POST['paliy_contacts_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_contacts_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_contacts_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach ([
        'paliy_contacts_intro_title',
        'paliy_contacts_intro_subtitle',
        'paliy_contacts_feedback_title',
        'paliy_contacts_feedback_description',
    ] as $key) {
        if (array_key_exists($key, $_POST)) {
            paliy_product_crop_save_about_meta($post_id, $key, wp_kses_post(wp_unslash($_POST[$key])));
        }
    }

    foreach (['paliy_contacts_feedback_instagram', 'paliy_contacts_feedback_facebook'] as $key) {
        if (array_key_exists($key, $_POST)) {
            paliy_product_crop_save_about_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }

    if (isset($_POST['paliy_contacts_clinics_present'])) {
        $raw_clinics = isset($_POST['paliy_contacts_clinics']) && is_array($_POST['paliy_contacts_clinics'])
            ? wp_unslash($_POST['paliy_contacts_clinics'])
            : [];
        $clinics = paliy_product_crop_sanitize_contacts_clinics($raw_clinics);

        if ($clinics) {
            update_post_meta($post_id, 'paliy_contacts_clinics', $clinics);
        } else {
            delete_post_meta($post_id, 'paliy_contacts_clinics');
        }
    }
}

function paliy_product_crop_save_about_meta(int $post_id, string $key, string $value): void
{
    if ($value === '') {
        delete_post_meta($post_id, $key);
    } else {
        update_post_meta($post_id, $key, $value);
    }
}

function paliy_product_crop_sanitize_about_team_members($value): array
{
    if (!is_array($value)) {
        return [];
    }

    $members = [];
    foreach ($value as $member) {
        if (!is_array($member)) {
            continue;
        }

        $image_id = absint($member['image_id'] ?? 0);
        if ($image_id && !wp_attachment_is_image($image_id)) {
            $image_id = 0;
        }

        $crop_value = $member['crop'] ?? [];
        $crop_raw = is_array($crop_value) ? wp_json_encode($crop_value) : (string) $crop_value;
        $crop = $image_id ? paliy_product_crop_sanitize_crop($crop_raw, $image_id) : null;
        $name = sanitize_text_field($member['name'] ?? '');
        $position = sanitize_text_field($member['position'] ?? '');

        if (!$image_id && $name === '' && $position === '') {
            continue;
        }

        $members[] = [
            'image_id' => $image_id,
            'crop' => $crop ?: [],
            'card_relpath' => sanitize_text_field($member['card_relpath'] ?? ''),
            'name' => $name,
            'position' => $position,
        ];
    }

    return $members;
}

function paliy_product_crop_prepare_about_team_members($value): array
{
    $members = paliy_product_crop_sanitize_about_team_members($value);

    foreach ($members as $index => &$member) {
        if (!$member['image_id'] || empty($member['crop'])) {
            $member['card_relpath'] = '';
            continue;
        }

        $result = paliy_product_crop_generate_card($member['image_id'], $member['crop'], 'about-team-' . $index);
        $member['card_relpath'] = is_wp_error($result) ? '' : (string) $result['relative_path'];
    }
    unset($member);

    return $members;
}

function paliy_product_crop_sanitize_about_gallery_ids($value): array
{
    if (!is_array($value)) {
        $value = $value ? [$value] : [];
    }

    $image_ids = [];
    foreach ($value as $image_id) {
        $image_id = absint($image_id);
        if ($image_id && wp_attachment_is_image($image_id) && !in_array($image_id, $image_ids, true)) {
            $image_ids[] = $image_id;
        }
    }

    return array_slice($image_ids, 0, 50);
}

function paliy_product_crop_save_service_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_service_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_service_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_service_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (['service_description', 'service_time', 'service_price', 'service_discount', 'service_people_count', 'reservio_url'] as $key) {
        if (!array_key_exists($key, $_POST)) {
            continue;
        }

        $raw_value = wp_unslash($_POST[$key]);
        $value = $key === 'service_description'
            ? sanitize_textarea_field($raw_value)
            : ($key === 'reservio_url' ? paliy_product_crop_sanitize_reservio_url($raw_value) : sanitize_text_field($raw_value));

        if ($key === 'service_discount' && $value !== '') {
            $value = paliy_product_crop_sanitize_discount($value);
            if ($value === '') {
                continue;
            }
        }
        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    if (isset($_POST['paliy_service_tariffs_present'])) {
        $raw_tariffs = isset($_POST['paliy_service_tariffs']) && is_array($_POST['paliy_service_tariffs'])
            ? wp_unslash($_POST['paliy_service_tariffs'])
            : [];
        $tariffs = paliy_product_crop_sanitize_service_tariffs($raw_tariffs);

        if ($tariffs) {
            update_post_meta($post_id, 'service_tariffs', $tariffs);
        } else {
            delete_post_meta($post_id, 'service_tariffs');
        }
    }

}

function paliy_product_crop_save_news_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_news_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_news_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_news_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    if (!array_key_exists('news_description', $_POST)) {
        return;
    }

    $description = sanitize_textarea_field(wp_unslash($_POST['news_description']));
    if ($description === '') {
        delete_post_meta($post_id, 'news_description');
    } else {
        update_post_meta($post_id, 'news_description', $description);
    }

}

function paliy_product_crop_save_review_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_review_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_review_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_review_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    if (array_key_exists('review_image_id', $_POST)) {
        $image_id = absint($_POST['review_image_id']);
        if ($image_id && !wp_attachment_is_image($image_id)) {
            $image_id = 0;
        }

        if ($image_id) {
            update_post_meta($post_id, 'review_image_id', $image_id);
        } else {
            delete_post_meta($post_id, 'review_image_id');
        }
    }

    foreach (['review_name', 'review_date'] as $key) {
        if (!array_key_exists($key, $_POST)) {
            continue;
        }

        $value = sanitize_text_field(wp_unslash($_POST[$key]));
        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    if (!array_key_exists('review_description', $_POST)) {
        return;
    }

    $description = wp_kses_post(wp_unslash($_POST['review_description']));
    if ($description === '') {
        delete_post_meta($post_id, 'review_description');
    } else {
        update_post_meta($post_id, 'review_description', $description);
    }
}

function paliy_product_crop_save_feedback_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_feedback_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_feedback_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_feedback_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (['feedback_name', 'feedback_phone', 'feedback_message', 'feedback_page_title', 'feedback_page_url', 'feedback_language'] as $key) {
        if (!array_key_exists($key, $_POST)) {
            continue;
        }

        $value = $key === 'feedback_message'
            ? sanitize_textarea_field(wp_unslash($_POST[$key]))
            : ($key === 'feedback_page_url'
                ? esc_url_raw(wp_unslash($_POST[$key]))
                : sanitize_text_field(wp_unslash($_POST[$key])));

        if ($key === 'feedback_language' && !in_array($value, ['cs', 'sk'], true)) {
            $value = 'cs';
        }

        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    if (array_key_exists('feedback_service_id', $_POST)) {
        $service_id = absint($_POST['feedback_service_id']);
        if ($service_id && get_post_type($service_id) !== 'paliy_service') {
            $service_id = 0;
        }
        update_post_meta($post_id, 'feedback_service_id', $service_id);
    }

    if (array_key_exists('feedback_status', $_POST)) {
        $status = sanitize_key(wp_unslash($_POST['feedback_status']));
        if (!in_array($status, ['new', 'in_progress', 'done', 'spam'], true)) {
            $status = 'new';
        }
        update_post_meta($post_id, 'feedback_status', $status);
    }

}

function paliy_product_crop_save_related_videos(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_related_videos_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_related_videos_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_related_videos_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $video_ids = isset($_POST['paliy_related_video_ids']) ? wp_unslash($_POST['paliy_related_video_ids']) : [];
    $video_ids = paliy_product_crop_sanitize_related_video_ids($video_ids);

    if ($video_ids) {
        update_post_meta($post_id, 'paliy_related_video_ids', $video_ids);
    } else {
        delete_post_meta($post_id, 'paliy_related_video_ids');
    }
}

function paliy_product_crop_validate_video_source_before_save(array $data, array $postarr): array
{
    if (
        ($data['post_type'] ?? '') !== 'paliy_video'
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision((int) ($postarr['ID'] ?? 0))
        || !isset($_POST['paliy_video_source_nonce'])
    ) {
        return $data;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_video_source_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_video_source_save')) {
        return $data;
    }

    $external_url = isset($_POST['paliy_video_external_url'])
        ? paliy_product_crop_sanitize_video_external_url(wp_unslash($_POST['paliy_video_external_url']))
        : '';
    $attachment_id = isset($_POST['paliy_video_attachment_id']) ? absint($_POST['paliy_video_attachment_id']) : 0;
    if ($attachment_id && strpos((string) get_post_mime_type($attachment_id), 'video/') !== 0) {
        $attachment_id = 0;
    }

    if (!$external_url && !$attachment_id) {
        wp_die(
            'Заполните поле «Ссылка на видео» или выберите видеофайл перед сохранением.',
            'Видео не сохранено',
            ['response' => 400, 'back_link' => true]
        );
    }

    return $data;
}

function paliy_product_crop_save_video_source(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_video_source_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_video_source_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_video_source_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $external_url = isset($_POST['paliy_video_external_url'])
        ? paliy_product_crop_sanitize_video_external_url(wp_unslash($_POST['paliy_video_external_url']))
        : '';
    $attachment_id = isset($_POST['paliy_video_attachment_id']) ? absint($_POST['paliy_video_attachment_id']) : 0;
    if ($attachment_id && strpos((string) get_post_mime_type($attachment_id), 'video/') !== 0) {
        $attachment_id = 0;
    }

    if ($external_url) {
        update_post_meta($post_id, 'paliy_video_external_url', $external_url);
        delete_post_meta($post_id, 'paliy_video_attachment_id');
    } elseif ($attachment_id) {
        delete_post_meta($post_id, 'paliy_video_external_url');
        update_post_meta($post_id, 'paliy_video_attachment_id', $attachment_id);
    } else {
        delete_post_meta($post_id, 'paliy_video_external_url');
        delete_post_meta($post_id, 'paliy_video_attachment_id');
    }
}

function paliy_product_crop_sanitize_video_external_url($value): string
{
    $url = esc_url_raw((string) $value);

    return preg_match('/^https?:\/\//i', $url) ? $url : '';
}

function paliy_product_crop_sanitize_related_video_ids($value): array
{
    if (!is_array($value)) {
        $value = $value ? [$value] : [];
    }

    $video_ids = [];
    foreach ($value as $video_id) {
        $video_id = absint($video_id);
        if ($video_id && get_post_type($video_id) === 'paliy_video' && !in_array($video_id, $video_ids, true)) {
            $video_ids[] = $video_id;
        }
    }

    return array_slice($video_ids, 0, 4);
}

function paliy_product_crop_save_seo_fields(int $post_id, WP_Post $post, bool $update): void
{
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || !isset($_POST['paliy_seo_fields_nonce'])
    ) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['paliy_seo_fields_nonce']));
    if (!wp_verify_nonce($nonce, 'paliy_seo_fields_save') || !current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (['paliy_seo_title', 'paliy_seo_og_title'] as $key) {
        $value = isset($_POST[$key]) ? sanitize_text_field(wp_unslash($_POST[$key])) : '';
        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    foreach (['paliy_seo_description', 'paliy_seo_og_description'] as $key) {
        $value = isset($_POST[$key]) ? sanitize_textarea_field(wp_unslash($_POST[$key])) : '';
        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    $og_image_id = isset($_POST['paliy_seo_og_image_id']) ? absint($_POST['paliy_seo_og_image_id']) : 0;
    if ($og_image_id && wp_attachment_is_image($og_image_id)) {
        update_post_meta($post_id, 'paliy_seo_og_image_id', $og_image_id);
    } else {
        delete_post_meta($post_id, 'paliy_seo_og_image_id');
    }

    if (isset($_POST['paliy_seo_noindex']) && $_POST['paliy_seo_noindex'] === '1') {
        update_post_meta($post_id, 'paliy_seo_noindex', true);
    } else {
        delete_post_meta($post_id, 'paliy_seo_noindex');
    }
}

function paliy_product_crop_sanitize_crop(string $raw, int $attachment_id): ?array
{
    if (!$attachment_id || !$raw) {
        return null;
    }

    $crop = json_decode($raw, true);
    if (!is_array($crop)) {
        return null;
    }

    $source = wp_get_attachment_image_src($attachment_id, 'full');
    if (!$source || empty($source[1]) || empty($source[2])) {
        return null;
    }

    $source_width = (int) $source[1];
    $source_height = (int) $source[2];
    $x = max(0, (int) round((float) ($crop['x'] ?? 0)));
    $y = max(0, (int) round((float) ($crop['y'] ?? 0)));
    $width = max(1, (int) round((float) ($crop['width'] ?? 0)));
    $height = max(1, (int) round((float) ($crop['height'] ?? 0)));

    $x = min($x, $source_width - 1);
    $y = min($y, $source_height - 1);
    $width = min($width, $source_width - $x);
    $height = min($height, $source_height - $y);

    if ($width < 1 || $height < 1) {
        return null;
    }

    return [
        'x' => $x,
        'y' => $y,
        'width' => $width,
        'height' => $height,
        'source_width' => $source_width,
        'source_height' => $source_height,
    ];
}

function paliy_product_crop_generate_card(int $attachment_id, array $crop, string $file_suffix = 'product-card')
{
    $source_path = get_attached_file($attachment_id);
    if (!$source_path || !file_exists($source_path)) {
        return new WP_Error('paliy_source_missing', 'Оригинальный файл изображения не найден.');
    }

    $editor = wp_get_image_editor($source_path);
    if (is_wp_error($editor)) {
        return $editor;
    }

    $editor->crop($crop['x'], $crop['y'], $crop['width'], $crop['height'], PALIY_PRODUCT_CROP_CARD_WIDTH, PALIY_PRODUCT_CROP_CARD_HEIGHT);

    $source_info = pathinfo($source_path);
    $file_suffix = sanitize_file_name($file_suffix) ?: 'product-card';
    $destination = trailingslashit($source_info['dirname']) . $source_info['filename'] . '-' . $file_suffix . '-' . PALIY_PRODUCT_CROP_CARD_WIDTH . 'x' . PALIY_PRODUCT_CROP_CARD_HEIGHT . '.jpg';

    // A previous card may have been created by a CLI/root process. Remove it
    // before saving so Image Editor does not try to overwrite an unwritable file.
    if (file_exists($destination) && !wp_delete_file($destination)) {
        return new WP_Error('paliy_card_not_writable', 'Не удалось заменить старую карточку: проверьте права папки uploads.');
    }

    $saved = $editor->save($destination, 'image/jpeg');
    if (is_wp_error($saved)) {
        return $saved;
    }

    @chmod($saved['path'], 0644);

    $uploads = wp_upload_dir();
    $relative_path = ltrim(str_replace(trailingslashit($uploads['basedir']), '', $destination), '/\\');

    return [
        'path' => $destination,
        'relative_path' => str_replace('\\', '/', $relative_path),
        'url' => trailingslashit($uploads['baseurl']) . str_replace('\\', '/', $relative_path),
    ];
}

function paliy_product_crop_get_card_url(int $post_id): string
{
    $relative_path = (string) get_post_meta($post_id, '_paliy_product_card_relpath', true);
    if (!$relative_path) {
        return '';
    }

    $uploads = wp_upload_dir();
    return trailingslashit($uploads['baseurl']) . ltrim($relative_path, '/');
}

add_action('rest_api_init', 'paliy_product_crop_register_rest_fields');
function paliy_product_crop_register_rest_fields(): void
{
    foreach (['paliy_product', 'paliy_service', 'paliy_news'] as $post_type) {
        register_rest_field($post_type, 'images', [
            'get_callback' => 'paliy_product_crop_rest_images',
            'schema' => [
                'description' => 'Оригинальное и кадрированное изображение.',
                'type' => 'object',
                'context' => ['view', 'edit'],
            ],
        ]);
    }

    register_rest_field('paliy_service', 'service_fields', [
        'get_callback' => 'paliy_product_crop_rest_service_fields',
        'schema' => [
            'description' => 'Дополнительные данные услуги.',
            'type' => 'object',
            'context' => ['view', 'edit'],
            'properties' => [
                'description' => ['type' => 'string'],
                'time' => ['type' => 'string'],
                'price' => ['type' => 'string'],
                'discount' => ['type' => 'string'],
                'people_count' => ['type' => 'string'],
                'reservio_url' => ['type' => 'string'],
                'tariffs' => ['type' => 'array'],
            ],
        ],
    ]);

    register_rest_field('paliy_news', 'news_fields', [
        'get_callback' => 'paliy_product_crop_rest_news_fields',
        'schema' => [
            'description' => 'Дополнительные данные новости.',
            'type' => 'object',
            'context' => ['view', 'edit'],
        ],
    ]);

    register_rest_field('paliy_review', 'review_fields', [
        'get_callback' => 'paliy_product_crop_rest_review_fields',
        'schema' => [
            'description' => 'Дополнительные данные отзыва.',
            'type' => 'object',
            'context' => ['view', 'edit'],
            'properties' => [
                'image' => ['type' => 'object'],
                'name' => ['type' => 'string'],
                'date' => ['type' => 'string'],
                'description' => ['type' => 'object'],
            ],
        ],
    ]);

    register_rest_field('paliy_faq', 'faq_tags', [
        'get_callback' => 'paliy_product_crop_rest_faq_tags',
        'schema' => [
            'description' => 'Теги, назначенные записи FAQ.',
            'type' => 'array',
            'context' => ['view', 'edit'],
            'items' => [
                'type' => 'object',
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'name' => ['type' => 'string'],
                    'slug' => ['type' => 'string'],
                    'description' => ['type' => 'string'],
                    'link' => ['type' => 'string', 'format' => 'uri'],
                ],
            ],
        ],
    ]);

    register_rest_field('page', 'about', [
        'get_callback' => 'paliy_product_crop_rest_about',
        'schema' => [
            'description' => 'Структурированные данные страницы «О нас».',
            'type' => 'object',
            'context' => ['view', 'edit'],
        ],
    ]);

    register_rest_field('page', 'contacts', [
        'get_callback' => 'paliy_product_crop_rest_contacts',
        'schema' => [
            'description' => 'Структурированные данные страницы «Контакты».',
            'type' => 'object',
            'context' => ['view', 'edit'],
            'properties' => [
                'intro' => ['type' => 'object'],
                'clinics' => ['type' => 'array'],
                'feedback' => ['type' => 'object'],
            ],
        ],
    ]);

    register_rest_field('paliy_video', 'video', [
        'get_callback' => 'paliy_product_crop_rest_video_source',
        'schema' => [
            'description' => 'Источник видео: внешняя ссылка или загруженный файл.',
            'type' => 'object',
            'context' => ['view', 'edit'],
            'properties' => [
                'type' => ['type' => 'string', 'enum' => ['external', 'upload', 'none']],
                'url' => ['type' => 'string', 'format' => 'uri'],
                'embed_url' => ['type' => 'string', 'format' => 'uri'],
                'attachment_id' => ['type' => 'integer'],
                'mime_type' => ['type' => 'string'],
            ],
        ],
    ]);

    foreach (['page', 'paliy_service', 'paliy_news'] as $post_type) {
        register_rest_field($post_type, 'videos', [
            'get_callback' => 'paliy_product_crop_rest_related_videos',
            'schema' => [
                'description' => 'Видео, связанные с этой записью.',
                'type' => 'array',
                'context' => ['view', 'edit'],
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'title' => ['type' => 'object'],
                        'slug' => ['type' => 'string'],
                        'link' => ['type' => 'string', 'format' => 'uri'],
                        'image' => ['type' => 'string', 'format' => 'uri'],
                        'video' => ['type' => 'object'],
                    ],
                ],
            ],
        ]);
    }

    register_rest_field('page', 'service_category_sections', [
        'get_callback' => 'paliy_product_crop_rest_service_category_sections',
        'schema' => [
            'description' => 'Тексты разделов страницы категорий услуг.',
            'type' => 'array',
            'context' => ['view', 'edit'],
            'items' => [
                'type' => 'object',
                'properties' => [
                    'key' => ['type' => 'string'],
                    'name' => ['type' => 'string'],
                    'title' => ['type' => 'object'],
                    'subtitle' => ['type' => 'object'],
                ],
            ],
        ],
    ]);

    register_rest_field('page', 'news_category_sections', [
        'get_callback' => 'paliy_product_crop_rest_news_category_sections',
        'schema' => [
            'description' => 'Тексты разделов страницы категорий новостей.',
            'type' => 'array',
            'context' => ['view', 'edit'],
            'items' => [
                'type' => 'object',
                'properties' => [
                    'key' => ['type' => 'string'],
                    'name' => ['type' => 'string'],
                    'title' => ['type' => 'object'],
                    'subtitle' => ['type' => 'object'],
                ],
            ],
        ],
    ]);

    register_rest_field('service_category', 'image', [
        'get_callback' => 'paliy_product_crop_rest_service_category_image',
        'update_callback' => 'paliy_product_crop_update_service_category_image',
        'schema' => [
            'description' => 'Изображение категории услуг.',
            'type' => 'object',
            'context' => ['view', 'edit'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'url' => ['type' => 'string', 'format' => 'uri'],
                'alt' => ['type' => 'string'],
            ],
        ],
    ]);

    register_rest_field('service_category', 'is_primary', [
        'get_callback' => 'paliy_product_crop_rest_service_category_is_primary',
        'update_callback' => 'paliy_product_crop_update_service_category_is_primary',
        'schema' => [
            'description' => 'Признак основной категории услуг.',
            'type' => 'boolean',
            'context' => ['view', 'edit'],
        ],
    ]);

    foreach (['service_category', 'news_category'] as $taxonomy) {
        register_rest_field($taxonomy, 'category_texts', [
            'get_callback' => 'paliy_product_crop_rest_category_texts',
            'schema' => [
                'description' => 'Заголовок и подзаголовок категории.',
                'type' => 'object',
                'context' => ['view', 'edit'],
                'properties' => [
                    'title' => ['type' => 'object'],
                    'subtitle' => ['type' => 'object'],
                ],
            ],
        ]);
    }

    foreach (['page', 'paliy_product', 'paliy_service', 'paliy_news', 'paliy_video', 'paliy_faq'] as $post_type) {
        register_rest_field($post_type, 'seo', [
            'get_callback' => 'paliy_product_crop_rest_seo',
            'schema' => [
                'description' => 'SEO-данные страницы для Nuxt.',
                'type' => 'object',
                'context' => ['view', 'edit'],
            ],
        ]);
    }
}

function paliy_product_crop_rest_service_category_sections($post): array
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post['id'] ?? 0);
    if (!paliy_product_crop_is_homepage_page($post_id)) {
        return [];
    }

    $sections = [];

    foreach (paliy_product_crop_get_service_category_sections() as $section) {
        $title_raw = (string) get_post_meta($post_id, 'paliy_service_category_' . $section['key'] . '_title', true);
        $subtitle_raw = (string) get_post_meta($post_id, 'paliy_service_category_' . $section['key'] . '_subtitle', true);
        $sections[] = [
            'key' => $section['key'],
            'name' => $section['name'],
            'title' => [
                'raw' => $title_raw,
                'rendered' => apply_filters('the_content', $title_raw),
            ],
            'subtitle' => [
                'raw' => $subtitle_raw,
                'rendered' => apply_filters('the_content', $subtitle_raw),
            ],
        ];
    }

    return $sections;
}

function paliy_product_crop_rest_news_category_sections($post): array
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post['id'] ?? 0);
    if (!paliy_product_crop_is_homepage_page($post_id)) {
        return [];
    }

    $sections = [];

    foreach (paliy_product_crop_get_news_category_sections() as $section) {
        $title_raw = (string) get_post_meta($post_id, 'paliy_news_category_' . $section['key'] . '_title', true);
        $subtitle_raw = (string) get_post_meta($post_id, 'paliy_news_category_' . $section['key'] . '_subtitle', true);
        $sections[] = [
            'key' => $section['key'],
            'name' => $section['name'],
            'title' => [
                'raw' => $title_raw,
                'rendered' => apply_filters('the_content', $title_raw),
            ],
            'subtitle' => [
                'raw' => $subtitle_raw,
                'rendered' => apply_filters('the_content', $subtitle_raw),
            ],
        ];
    }

    return $sections;
}

function paliy_product_crop_rest_related_videos(array $object): array
{
    $video_ids = paliy_product_crop_sanitize_related_video_ids(get_post_meta((int) ($object['id'] ?? 0), 'paliy_related_video_ids', true));
    $videos = [];

    foreach ($video_ids as $video_id) {
        if (get_post_status($video_id) !== 'publish') {
            continue;
        }

        $thumbnail_id = get_post_thumbnail_id($video_id);
        $videos[] = [
            'id' => $video_id,
            'title' => [
                'rendered' => get_the_title($video_id),
            ],
            'slug' => (string) get_post_field('post_name', $video_id),
            'link' => (string) get_permalink($video_id),
            'image' => $thumbnail_id ? (string) wp_get_attachment_image_url($thumbnail_id, 'full') : '',
            'video' => paliy_product_crop_rest_video_source(['id' => $video_id]),
        ];
    }

    return $videos;
}

function paliy_product_crop_rest_contacts($post): array
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post['id'] ?? 0);
    if (!paliy_product_crop_is_contacts_page($post_id)) {
        return [];
    }

    $clinics = paliy_product_crop_sanitize_contacts_clinics(get_post_meta($post_id, 'paliy_contacts_clinics', true));
    $clinic_data = [];
    foreach ($clinics as $clinic) {
        $clinic_data[] = [
            'name' => (string) $clinic['name'],
            'address' => (string) $clinic['address'],
            'hours' => (string) $clinic['hours'],
            'email' => (string) ($clinic['email'] ?? ''),
        ];
    }

    return [
        'intro' => [
            'title' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_contacts_intro_title', true)),
            'subtitle' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_contacts_intro_subtitle', true)),
        ],
        'clinics' => $clinic_data,
        'feedback' => [
            'title' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_contacts_feedback_title', true)),
            'description' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_contacts_feedback_description', true)),
            'instagram' => (string) get_post_meta($post_id, 'paliy_contacts_feedback_instagram', true),
            'facebook' => (string) get_post_meta($post_id, 'paliy_contacts_feedback_facebook', true),
        ],
    ];
}

function paliy_product_crop_rest_about($post): array
{
    $post_id = $post instanceof WP_Post ? $post->ID : absint($post['id'] ?? 0);
    if (!paliy_product_crop_is_about_page($post_id)) {
        return [];
    }

    $team_members = paliy_product_crop_sanitize_about_team_members(get_post_meta($post_id, 'paliy_about_team_members', true));
    $team = [];
    foreach ($team_members as $member) {
        $team[] = [
            'image' => paliy_product_crop_rest_about_image((int) $member['image_id'], (string) $member['card_relpath']),
            'name' => (string) $member['name'],
            'position' => (string) $member['position'],
        ];
    }

    $gallery = [];
    foreach (paliy_product_crop_sanitize_about_gallery_ids(get_post_meta($post_id, 'paliy_about_gallery_ids', true)) as $image_id) {
        $image = paliy_product_crop_rest_about_image($image_id);
        if ($image) {
            $gallery[] = $image;
        }
    }

    return [
        'intro' => [
            'title' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_intro_title', true)),
            'subtitle' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_intro_subtitle', true)),
        ],
        'founder' => [
            'image' => paliy_product_crop_rest_about_image((int) get_post_meta($post_id, 'paliy_about_founder_image_id', true)),
            'title' => (string) get_post_meta($post_id, 'paliy_about_founder_title', true),
            'subtitle' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_founder_subtitle', true)),
            'name' => (string) get_post_meta($post_id, 'paliy_about_founder_name', true),
            'position' => (string) get_post_meta($post_id, 'paliy_about_founder_position', true),
            'description' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_founder_description', true)),
        ],
        'team' => $team,
        'gallery' => [
            'title' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_gallery_title', true)),
            'description' => paliy_product_crop_about_richtext(get_post_meta($post_id, 'paliy_about_gallery_description', true)),
            'images' => $gallery,
        ],
    ];
}

function paliy_product_crop_about_richtext($value): array
{
    $value = (string) $value;

    return [
        'raw' => $value,
        'rendered' => apply_filters('the_content', $value),
    ];
}

function paliy_product_crop_rest_about_image(int $image_id, string $card_relpath = ''): ?array
{
    if (!$image_id || !wp_attachment_is_image($image_id)) {
        return null;
    }

    $source = wp_get_attachment_image_src($image_id, 'full');
    $card_url = $card_relpath
        ? trailingslashit(wp_upload_dir()['baseurl']) . ltrim($card_relpath, '/\\')
        : '';

    return [
        'id' => $image_id,
        'alt' => (string) get_post_meta($image_id, '_wp_attachment_image_alt', true),
        'original' => [
            'url' => (string) wp_get_attachment_image_url($image_id, 'full'),
            'width' => $source ? (int) $source[1] : 0,
            'height' => $source ? (int) $source[2] : 0,
        ],
        'card' => $card_url ? [
            'url' => $card_url,
            'width' => PALIY_PRODUCT_CROP_CARD_WIDTH,
            'height' => PALIY_PRODUCT_CROP_CARD_HEIGHT,
        ] : null,
    ];
}

function paliy_product_crop_rest_video_source(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);
    $external_url = (string) get_post_meta($post_id, 'paliy_video_external_url', true);
    $attachment_id = (int) get_post_meta($post_id, 'paliy_video_attachment_id', true);

    if ($external_url) {
        $embed_url = paliy_product_crop_get_video_embed_url($external_url);
        return [
            'type' => 'external',
            'url' => $external_url,
            'embed_url' => $embed_url,
            'attachment_id' => 0,
            'mime_type' => $embed_url ? '' : paliy_product_crop_get_video_mime_type_from_url($external_url),
        ];
    }

    if ($attachment_id && strpos((string) get_post_mime_type($attachment_id), 'video/') === 0) {
        return [
            'type' => 'upload',
            'url' => (string) wp_get_attachment_url($attachment_id),
            'embed_url' => '',
            'attachment_id' => $attachment_id,
            'mime_type' => (string) get_post_mime_type($attachment_id),
        ];
    }

    return [
        'type' => 'none',
        'url' => '',
        'embed_url' => '',
        'attachment_id' => 0,
        'mime_type' => '',
    ];
}

function paliy_product_crop_get_video_embed_url(string $url): string
{
    $host = strtolower((string) wp_parse_url($url, PHP_URL_HOST));
    $path = trim((string) wp_parse_url($url, PHP_URL_PATH), '/');
    $video_id = '';

    if (str_contains($host, 'youtu.be')) {
        $video_id = explode('/', $path)[0] ?? '';
    } elseif (str_contains($host, 'youtube.com')) {
        parse_str((string) wp_parse_url($url, PHP_URL_QUERY), $query);
        $video_id = (string) ($query['v'] ?? '');
        if (!$video_id && str_starts_with($path, 'embed/')) {
            $video_id = substr($path, 6);
        }
    } elseif (str_contains($host, 'vimeo.com')) {
        $video_id = preg_match('/(\d+)/', $path, $matches) ? $matches[1] : '';
        if ($video_id) {
            return 'https://player.vimeo.com/video/' . $video_id;
        }
    }

    return $video_id ? 'https://www.youtube.com/embed/' . rawurlencode($video_id) : '';
}

function paliy_product_crop_get_video_mime_type_from_url(string $url): string
{
    $path = (string) wp_parse_url($url, PHP_URL_PATH);
    $filetype = wp_check_filetype($path);

    return strpos((string) ($filetype['type'] ?? ''), 'video/') === 0 ? (string) $filetype['type'] : '';
}

function paliy_product_crop_rest_service_category_image($term): array
{
    $term_id = $term instanceof WP_Term ? $term->term_id : absint($term['id'] ?? 0);
    $image_id = (int) get_term_meta($term_id, 'service_category_image_id', true);

    return [
        'id' => $image_id,
        'url' => $image_id ? (string) wp_get_attachment_image_url($image_id, 'full') : '',
        'alt' => $image_id ? (string) get_post_meta($image_id, '_wp_attachment_image_alt', true) : '',
    ];
}

function paliy_product_crop_rest_category_texts($term): array
{
    $term_id = $term instanceof WP_Term ? $term->term_id : absint($term['id'] ?? 0);
    $title = (string) get_term_meta($term_id, 'paliy_category_title', true);
    $subtitle = (string) get_term_meta($term_id, 'paliy_category_subtitle', true);

    return [
        'title' => [
            'raw' => $title,
            'rendered' => apply_filters('the_content', $title),
        ],
        'subtitle' => [
            'raw' => $subtitle,
            'rendered' => apply_filters('the_content', $subtitle),
        ],
    ];
}

function paliy_product_crop_update_service_category_image($value, $term): void
{
    $term_id = $term instanceof WP_Term ? $term->term_id : absint($term['id'] ?? 0);
    $image_id = is_array($value) ? absint($value['id'] ?? $value['attachment_id'] ?? 0) : absint($value);

    if ($image_id && !wp_attachment_is_image($image_id)) {
        $image_id = 0;
    }

    if ($image_id) {
        update_term_meta($term_id, 'service_category_image_id', $image_id);
    } else {
        delete_term_meta($term_id, 'service_category_image_id');
    }
}

function paliy_product_crop_rest_service_category_is_primary($term): bool
{
    $term_id = $term instanceof WP_Term ? $term->term_id : absint($term['id'] ?? 0);

    return (bool) get_term_meta($term_id, 'service_category_is_primary', true);
}

function paliy_product_crop_update_service_category_is_primary($value, $term): void
{
    $term_id = $term instanceof WP_Term ? $term->term_id : absint($term['id'] ?? 0);

    if ((bool) $value) {
        update_term_meta($term_id, 'service_category_is_primary', true);
    } else {
        delete_term_meta($term_id, 'service_category_is_primary');
    }
}

add_action('rest_api_init', 'paliy_product_crop_register_image_save_route');
function paliy_product_crop_register_image_save_route(): void
{
    register_rest_route('paliy/v1', '/post-image', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => static function (WP_REST_Request $request): bool {
            $post_id = absint($request->get_param('post_id'));
            return $post_id > 0
                && in_array(get_post_type($post_id), ['paliy_product', 'paliy_service', 'paliy_news'], true)
                && current_user_can('edit_post', $post_id);
        },
        'callback' => 'paliy_product_crop_save_image_rest',
        'args' => [
            'post_id' => [
                'required' => true,
                'type' => 'integer',
                'minimum' => 1,
            ],
            'attachment_id' => [
                'required' => true,
                'type' => 'integer',
                'minimum' => 0,
            ],
            'crop' => [
                'required' => false,
                'type' => ['object', 'null'],
            ],
        ],
    ]);
}

add_action('rest_api_init', 'paliy_product_crop_register_feedback_route');
function paliy_product_crop_register_feedback_route(): void
{
    register_rest_route('paliy/v1', '/feedback', [
        'methods' => WP_REST_Server::CREATABLE,
        'permission_callback' => static function (): bool {
            return true;
        },
        'callback' => 'paliy_product_crop_create_feedback_rest',
        'args' => [
            'name' => ['required' => true, 'type' => 'string'],
            'phone' => ['required' => true, 'type' => 'string'],
            // The current Nuxt form calls this field "comment". Keep "message"
            // as the canonical API name and accept both during integration.
            'message' => ['required' => false, 'type' => 'string'],
            'comment' => ['required' => false, 'type' => 'string'],
            'service_id' => ['required' => false, 'type' => 'integer'],
            'language' => ['required' => false, 'type' => 'string'],
            'page_title' => ['required' => false, 'type' => 'string'],
            'page_url' => ['required' => false, 'type' => 'string'],
        ],
    ]);
}

function paliy_product_crop_feedback_log(string $message, array $context = []): void
{
    $suffix = $context ? ' ' . (string) wp_json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '';
    error_log('[PALIY feedback] ' . $message . $suffix);
}

function paliy_product_crop_create_feedback_rest(WP_REST_Request $request)
{
    $name = trim(sanitize_text_field((string) $request->get_param('name')));
    $phone = trim(sanitize_text_field((string) $request->get_param('phone')));
    $message_value = $request->get_param('message');
    if (!is_string($message_value) || trim($message_value) === '') {
        $message_value = $request->get_param('comment');
    }
    $message = trim(sanitize_textarea_field((string) $message_value));
    $language = sanitize_key((string) ($request->get_param('language') ?: 'cs'));
    $service_id = absint($request->get_param('service_id'));
    $page_title = trim(sanitize_text_field((string) $request->get_param('page_title')));
    $page_url = esc_url_raw((string) $request->get_param('page_url'));
    if ($name === '' || strlen($name) > 100) {
        return new WP_Error('paliy_feedback_invalid_name', 'Укажите имя.', ['status' => 400]);
    }

    if ($phone === '') {
        return new WP_Error('paliy_feedback_invalid_phone', 'Укажите номер телефона.', ['status' => 400]);
    }

    if ($message === '' || strlen($message) > 5000) {
        return new WP_Error('paliy_feedback_invalid_message', 'Введите сообщение.', ['status' => 400]);
    }

    if (!in_array($language, ['cs', 'sk'], true)) {
        return new WP_Error('paliy_feedback_invalid_language', 'Недопустимый язык формы.', ['status' => 400]);
    }

    if ($service_id && (get_post_type($service_id) !== 'paliy_service' || get_post_status($service_id) !== 'publish')) {
        return new WP_Error('paliy_feedback_invalid_service', 'Выбранная услуга недоступна.', ['status' => 400]);
    }

    if (strlen($page_title) > 200) {
        return new WP_Error('paliy_feedback_invalid_page_title', 'Заголовок страницы слишком длинный.', ['status' => 400]);
    }

    $post_id = wp_insert_post([
        'post_type' => 'paliy_feedback',
        'post_status' => 'private',
        'post_title' => sprintf(
            'Заявка от %s%s — %s',
            $name,
            $page_title !== '' ? ' — ' . $page_title : '',
            current_time('mysql')
        ),
    ], true);

    if (is_wp_error($post_id)) {
        paliy_product_crop_feedback_log('Could not create feedback post', ['error' => $post_id->get_error_code()]);
        return new WP_Error('paliy_feedback_storage_failed', 'Не удалось сохранить заявку.', ['status' => 500]);
    }

    update_post_meta($post_id, 'feedback_name', $name);
    update_post_meta($post_id, 'feedback_phone', $phone);
    update_post_meta($post_id, 'feedback_message', $message);
    update_post_meta($post_id, 'feedback_page_title', $page_title);
    update_post_meta($post_id, 'feedback_page_url', $page_url);
    update_post_meta($post_id, 'feedback_service_id', $service_id);
    update_post_meta($post_id, 'feedback_language', $language);
    update_post_meta($post_id, 'feedback_status', 'new');
    $recipient = defined('PALIY_FEEDBACK_EMAIL')
        ? (string) PALIY_FEEDBACK_EMAIL
        : (string) (getenv('PALIY_FEEDBACK_EMAIL') ?: get_option('admin_email'));
    $service_title = $service_id ? get_the_title($service_id) : '';
    $subject = $language === 'sk' ? 'Nový dopyt z webu PALIY' : 'Nová poptávka z webu PALIY';
    $body = $language === 'sk'
        ? "Nový dopyt z webu PALIY.\n\nMeno: {$name}\nTelefón: {$phone}\nSlužba: {$service_title}\nStránka: {$page_title}\nOdkaz: {$page_url}\n\nSpráva:\n{$message}\n\nID žiadosti: {$post_id}"
        : "Nová poptávka z webu PALIY.\n\nJméno: {$name}\nTelefon: {$phone}\nSlužba: {$service_title}\nStránka: {$page_title}\nOdkaz: {$page_url}\n\nZpráva:\n{$message}\n\nID žádosti: {$post_id}";
    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    if (!wp_mail($recipient, $subject, $body, $headers)) {
        paliy_product_crop_feedback_log('Feedback saved but email delivery failed', ['post_id' => $post_id]);
    }

    return new WP_REST_Response([
        'success' => true,
        'id' => (int) $post_id,
        'message' => $language === 'sk'
            ? 'Ďakujeme. Váš dopyt bol odoslaný.'
            : 'Děkujeme. Vaše poptávka byla odeslána.',
    ], 201);
}

function paliy_product_crop_save_image_rest(WP_REST_Request $request)
{
    $post_id = absint($request->get_param('post_id'));
    $attachment_id = absint($request->get_param('attachment_id'));

    if ($attachment_id && !wp_attachment_is_image($attachment_id)) {
        return new WP_Error('paliy_invalid_image', 'Выбранный файл не является изображением.', ['status' => 400]);
    }

    update_post_meta($post_id, '_paliy_product_image_id', $attachment_id);

    $crop_value = $request->get_param('crop');
    $crop_raw = is_array($crop_value) ? wp_json_encode($crop_value) : '';
    $crop = paliy_product_crop_sanitize_crop($crop_raw, $attachment_id);

    if (!$crop) {
        delete_post_meta($post_id, '_paliy_product_crop');
        delete_post_meta($post_id, '_paliy_product_card_relpath');
        delete_post_meta($post_id, '_paliy_product_crop_error');

        return rest_ensure_response(paliy_product_crop_rest_images(['id' => $post_id]));
    }

    $result = paliy_product_crop_generate_card($attachment_id, $crop);
    if (is_wp_error($result)) {
        update_post_meta($post_id, '_paliy_product_crop_error', $result->get_error_message());
        return $result;
    }

    update_post_meta($post_id, '_paliy_product_crop', wp_json_encode($crop));
    update_post_meta($post_id, '_paliy_product_card_relpath', $result['relative_path']);
    delete_post_meta($post_id, '_paliy_product_crop_error');

    return rest_ensure_response(paliy_product_crop_rest_images(['id' => $post_id]));
}

function paliy_product_crop_rest_service_tariffs(int $post_id): array
{
    $tariffs = paliy_product_crop_sanitize_service_tariffs(get_post_meta($post_id, 'service_tariffs', true));
    $result = [];

    foreach ($tariffs as $tariff) {
        $description = (string) $tariff['description'];
        $result[] = [
            'name' => (string) $tariff['name'],
            'price' => (string) $tariff['price'],
            'time' => (string) $tariff['time'],
            'people_count' => (string) $tariff['people_count'],
            'reservio_url' => (string) $tariff['reservio_url'],
            'description' => [
                'raw' => $description,
                'rendered' => apply_filters('the_content', $description),
            ],
        ];
    }

    return $result;
}

function paliy_product_crop_rest_service_fields(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);

    return [
        'description' => (string) get_post_meta($post_id, 'service_description', true),
        'time' => (string) get_post_meta($post_id, 'service_time', true),
        'price' => (string) get_post_meta($post_id, 'service_price', true),
        'discount' => (string) get_post_meta($post_id, 'service_discount', true),
        'people_count' => (string) get_post_meta($post_id, 'service_people_count', true),
        'reservio_url' => (string) get_post_meta($post_id, 'reservio_url', true),
        'tariffs' => paliy_product_crop_rest_service_tariffs($post_id),
    ];
}

function paliy_product_crop_rest_news_fields(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);

    return [
        'description' => (string) get_post_meta($post_id, 'news_description', true),
    ];
}

function paliy_product_crop_rest_faq_tags(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);
    $terms = get_the_terms($post_id, 'faq_tag');
    if (!$terms || is_wp_error($terms)) {
        return [];
    }

    $result = [];
    foreach ($terms as $term) {
        $term_link = get_term_link($term);
        $result[] = [
            'id' => (int) $term->term_id,
            'name' => (string) $term->name,
            'slug' => (string) $term->slug,
            'description' => (string) $term->description,
            'link' => is_wp_error($term_link) ? '' : (string) $term_link,
        ];
    }

    return $result;
}

function paliy_product_crop_rest_review_fields(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);
    $image_id = (int) get_post_meta($post_id, 'review_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
    $description = (string) get_post_meta($post_id, 'review_description', true);

    return [
        'image' => $image_url ? [
            'id' => $image_id,
            'url' => $image_url,
            'alt' => (string) get_post_meta($image_id, '_wp_attachment_image_alt', true),
        ] : null,
        'name' => (string) get_post_meta($post_id, 'review_name', true),
        'date' => (string) get_post_meta($post_id, 'review_date', true),
        'description' => [
            'raw' => $description,
            'rendered' => apply_filters('the_content', $description),
        ],
    ];
}

function paliy_product_crop_rest_images(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);
    $attachment_id = (int) get_post_meta($post_id, '_paliy_product_image_id', true);
    $original_url = $attachment_id ? wp_get_attachment_image_url($attachment_id, 'full') : '';
    $card_url = paliy_product_crop_get_card_url($post_id);
    $crop_raw = get_post_meta($post_id, '_paliy_product_crop', true);

    return [
        'original' => $original_url ? [
            'attachment_id' => $attachment_id,
            'url' => $original_url,
        ] : null,
        'card' => $card_url ? [
            'url' => $card_url,
            'width' => PALIY_PRODUCT_CROP_CARD_WIDTH,
            'height' => PALIY_PRODUCT_CROP_CARD_HEIGHT,
        ] : null,
        'crop' => $crop_raw ? json_decode($crop_raw, true) : null,
    ];
}

function paliy_product_crop_rest_seo(array $object): array
{
    $post_id = (int) ($object['id'] ?? 0);
    $og_image_id = (int) get_post_meta($post_id, 'paliy_seo_og_image_id', true);
    $og_image_url = $og_image_id ? wp_get_attachment_image_url($og_image_id, 'full') : '';

    return [
        'title' => (string) get_post_meta($post_id, 'paliy_seo_title', true),
        'description' => (string) get_post_meta($post_id, 'paliy_seo_description', true),
        'og_title' => (string) get_post_meta($post_id, 'paliy_seo_og_title', true),
        'og_description' => (string) get_post_meta($post_id, 'paliy_seo_og_description', true),
        'og_image' => $og_image_url ? [
            'attachment_id' => $og_image_id,
            'url' => $og_image_url,
        ] : null,
        'noindex' => in_array(get_post_meta($post_id, 'paliy_seo_noindex', true), [true, 1, '1'], true),
    ];
}
