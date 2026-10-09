(function ($) {
    'use strict';

    function prepareServiceFieldsPanel() {
        if (!document.body.classList.contains('post-type-paliy_service')) {
            return;
        }

        const panelButton = Array.from(document.querySelectorAll('button')).find((button) => {
            const text = button.textContent.trim();
            return text === 'Мета-боксы' || text === 'Поля для заполнения услуги';
        });

        if (panelButton) {
            const textNode = Array.from(panelButton.childNodes).find((node) => node.nodeType === Node.TEXT_NODE);
            if (textNode && textNode.nodeValue !== 'Поля для заполнения услуги') {
                textNode.nodeValue = 'Поля для заполнения услуги';
            }
            panelButton.setAttribute('aria-label', 'Поля для заполнения услуги');

            if (panelButton.getAttribute('aria-expanded') === 'false') {
                panelButton.click();
            }
        }

        ['#paliy-service-fields', '#paliy-product-image'].forEach((selector) => {
            const toggle = document.querySelector(`${selector} .handlediv`);
            if (toggle && toggle.getAttribute('aria-expanded') === 'false') {
                toggle.click();
            }
        });
    }

    prepareServiceFieldsPanel();
    const servicePanelObserver = new MutationObserver(() => {
        window.requestAnimationFrame(prepareServiceFieldsPanel);
    });
    servicePanelObserver.observe(document.body, { childList: true, subtree: true });

    $(document).on('input', '#service_discount', function () {
        const input = this;
        const digits = input.value.replace(/[^0-9]/g, '').slice(0, 2);
        input.value = digits;

        if (digits !== '' && !/^[1-9][0-9]$/.test(digits)) {
            input.setCustomValidity('Укажите двухзначную скидку от 10 до 99 без знака %.');
        } else {
            input.setCustomValidity('');
        }
    });

    function syncPaliyRichTextEditors() {
        if (!window.tinyMCE || !Array.isArray(window.tinyMCE.editors)) {
            return;
        }

        window.tinyMCE.editors.forEach((editor) => {
            if (editor && typeof editor.save === 'function') {
                editor.save();
            }
        });
    }

    function initializeServiceTariffEditors(scope) {
        if (!window.wp?.editor?.initialize) {
            return;
        }

        const root = scope && typeof scope.querySelectorAll === 'function' ? scope : document;
        root.querySelectorAll('textarea.paliy-service-tariff-description').forEach((textarea) => {
            if (!textarea.id || textarea.dataset.paliyEditorInitialized === '1') {
                return;
            }

            textarea.dataset.paliyEditorInitialized = '1';
            wp.editor.initialize(textarea.id, {
                tinymce: {
                    wpautop: true,
                    toolbar1: 'bold,italic,link,unlink,removeformat',
                    toolbar2: '',
                },
                quicktags: false,
                mediaButtons: false,
            });
        });
    }

    function getNextServiceTariffIndex() {
        let maxIndex = -1;
        document.querySelectorAll('#paliy-service-tariffs-list .paliy-service-tariff').forEach((tariff) => {
            const index = Number(tariff.dataset.index);
            if (Number.isFinite(index)) {
                maxIndex = Math.max(maxIndex, index);
            }
        });

        return maxIndex + 1;
    }

    function initializeServiceTariffsSortable() {
        const container = $('#paliy-service-tariffs-list');
        if (!container.length || typeof container.sortable !== 'function' || container.hasClass('ui-sortable')) {
            return;
        }

        container.sortable({
            axis: 'y',
            handle: '.paliy-service-tariff-drag-handle',
            items: '> .paliy-service-tariff',
            placeholder: 'paliy-service-tariff-placeholder',
            forcePlaceholderSize: true,
        });
    }

    initializeServiceTariffsSortable();

    $(document).on('click', '#paliy-service-add-tariff', function () {
        const template = document.getElementById('paliy-service-tariff-template');
        const container = document.getElementById('paliy-service-tariffs-list');
        if (!template || !container) {
            return;
        }

        const index = getNextServiceTariffIndex();
        const html = template.innerHTML.replaceAll('__INDEX__', String(index));
        container.insertAdjacentHTML('afterbegin', html);
        const tariff = container.querySelector(`.paliy-service-tariff[data-index="${index}"]`);
        if (tariff) {
            initializeServiceTariffEditors(tariff);
        }
        initializeServiceTariffsSortable();
    });

    $(document).on('click', '.paliy-service-remove-tariff', function () {
        $(this).closest('.paliy-service-tariff').remove();
    });

    $(document).on('submit', '#post', syncPaliyRichTextEditors);

    if (window.wp && wp.hooks && typeof wp.hooks.addAction === 'function') {
        wp.hooks.addAction('editor.savePost', 'paliy-product-crop/sync-richtext', syncPaliyRichTextEditors);
    }

    $(document).on('click', '.paliy-copy-rest-api', function () {
        const button = this;
        const url = button.dataset.apiUrl || '';
        const control = button.closest('.paliy-rest-api-control, .paliy-pages-api-toolbar');
        const status = control?.querySelector('.paliy-rest-api-copy-status');
        if (!url) {
            return;
        }

        const showCopied = () => {
            if (status) {
                status.textContent = 'Ссылка скопирована.';
            }
            button.textContent = 'Скопировано';
            window.setTimeout(() => {
                button.textContent = 'Скопировать';
            }, 1800);
        };

        if (navigator.clipboard?.writeText) {
            navigator.clipboard.writeText(url).then(showCopied);
            return;
        }

        const input = document.createElement('textarea');
        input.value = url;
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.focus();
        input.select();
        document.execCommand('copy');
        input.remove();
        showCopied();
    });

    let serviceCategoryMediaFrame = null;
    $(document).on('click', '#paliy-select-service-category-image', function () {
        if (!serviceCategoryMediaFrame) {
            serviceCategoryMediaFrame = wp.media({
                title: 'Выберите изображение категории',
                button: { text: 'Использовать изображение' },
                multiple: false,
                library: { type: 'image' },
            });

            serviceCategoryMediaFrame.on('select', function () {
                const attachment = serviceCategoryMediaFrame.state().get('selection').first().toJSON();
                const previewUrl = attachment.sizes?.medium?.url || attachment.url;
                $('#service_category_image_id').val(Number(attachment.id));
                $('#paliy-service-category-image-preview img').attr('src', previewUrl);
                $('#paliy-service-category-image-preview').prop('hidden', false);
                $('#paliy-remove-service-category-image').prop('disabled', false);
            });
        }

        serviceCategoryMediaFrame.open();
    });

    $(document).on('click', '#paliy-remove-service-category-image', function () {
        $('#service_category_image_id').val('0');
        $('#paliy-service-category-image-preview').prop('hidden', true);
        $(this).prop('disabled', true);
    });

    let reviewMediaFrame = null;
    $(document).on('click', '#paliy-select-review-image', function () {
        if (!reviewMediaFrame) {
            reviewMediaFrame = wp.media({
                title: 'Выберите фото автора отзыва',
                button: { text: 'Использовать изображение' },
                multiple: false,
                library: { type: 'image' },
            });

            reviewMediaFrame.on('select', function () {
                const attachment = reviewMediaFrame.state().get('selection').first().toJSON();
                const imageId = Number(attachment.id || 0);
                const imageUrl = attachment.sizes?.medium?.url || attachment.url || '';
                $('#review_image_id').val(imageId);
                $('#paliy-review-image-preview img').attr('src', imageUrl);
                $('#paliy-review-image-preview').prop('hidden', !imageUrl);
                $('#paliy-remove-review-image').prop('disabled', !imageId);
            });
        }

        reviewMediaFrame.open();
    });

    $(document).on('click', '#paliy-remove-review-image', function () {
        $('#review_image_id').val('0');
        $('#paliy-review-image-preview').prop('hidden', true);
        $(this).prop('disabled', true);
    });

    function getNextContactsClinicIndex() {
        let maxIndex = -1;
        $('#paliy-contacts-clinics .paliy-contacts-clinic').each(function () {
            const index = Number($(this).data('index'));
            if (Number.isFinite(index)) {
                maxIndex = Math.max(maxIndex, index);
            }
        });

        return maxIndex + 1;
    }

    $(document).on('click', '#paliy-contacts-add-clinic', function () {
        const template = document.getElementById('paliy-contacts-clinic-template');
        const container = document.getElementById('paliy-contacts-clinics');
        if (!template || !container) {
            return;
        }

        const index = getNextContactsClinicIndex();
        container.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', String(index)));
    });

    $(document).on('click', '.paliy-contacts-remove-clinic', function () {
        $(this).closest('.paliy-contacts-clinic').remove();
    });

    function updateRelatedVideoAvailability() {
        $('.paliy-related-videos').each(function () {
            const container = $(this);
            const selectedCount = container.find('input[type="checkbox"]:checked').length;
            container.find('input[type="checkbox"]:not(:checked)').prop('disabled', selectedCount >= 4);
        });
    }

    $(document).on('change', '.paliy-related-videos input[type="checkbox"]', updateRelatedVideoAvailability);
    updateRelatedVideoAvailability();

    let videoMediaFrame = null;
    const videoSourceLockName = 'paliy-video-source-required';

    function updateVideoSourceValidation() {
        const externalUrl = document.getElementById('paliy_video_external_url');
        const attachmentId = document.getElementById('paliy_video_attachment_id');
        const status = document.getElementById('paliy-video-source-status');
        if (!externalUrl || !attachmentId) {
            return true;
        }

        const hasExternalUrl = externalUrl.value.trim() !== '';
        const hasAttachment = Number(attachmentId.value || 0) > 0;
        const isValid = hasExternalUrl || hasAttachment;
        const message = 'Укажите ссылку на видео или выберите видеофайл.';

        externalUrl.setCustomValidity(isValid ? '' : message);
        if (status) {
            status.textContent = isValid ? '' : message;
            status.classList.toggle('paliy-video-source-error', !isValid);
        }

        const editorDispatch = window.wp?.data?.dispatch('core/editor');
        if (editorDispatch && typeof editorDispatch.lockPostSaving === 'function') {
            if (isValid) {
                editorDispatch.unlockPostSaving(videoSourceLockName);
            } else {
                editorDispatch.lockPostSaving(videoSourceLockName, message);
            }
        }

        return isValid;
    }

    $(document).on('click', '#paliy-select-video-file', function () {
        if (!videoMediaFrame) {
            videoMediaFrame = wp.media({
                title: 'Выберите видеофайл',
                button: { text: 'Использовать видеофайл' },
                multiple: false,
                library: { type: 'video' },
            });

            videoMediaFrame.on('select', function () {
                const attachment = videoMediaFrame.state().get('selection').first().toJSON();
                const mimeType = attachment.mime || attachment.type || '';
                if (mimeType !== 'video' && !mimeType.startsWith('video/')) {
                    window.alert('Можно выбрать только видеофайл.');
                    return;
                }

                const attachmentId = Number(attachment.id || 0);
                const attachmentUrl = attachment.url || '';
                const attachmentName = attachment.filename || attachment.title || attachmentUrl.split('/').pop();
                $('#paliy_video_attachment_id').val(attachmentId);
                $('#paliy_video_external_url').val('');
                $('#paliy-video-file-preview')
                    .html(attachmentUrl ? $('<a>', {
                        href: attachmentUrl,
                        target: '_blank',
                        rel: 'noopener',
                        text: attachmentName,
                    }) : '')
                    .prop('hidden', !attachmentUrl);
                $('#paliy-remove-video-file').prop('disabled', !attachmentId);
                updateVideoSourceValidation();
            });
        }

        videoMediaFrame.open();
    });

    $(document).on('input', '#paliy_video_external_url', function () {
        if ($(this).val().trim()) {
            $('#paliy_video_attachment_id').val('0');
            $('#paliy-video-file-preview').prop('hidden', true).empty();
            $('#paliy-remove-video-file').prop('disabled', true);
        }
        updateVideoSourceValidation();
    });

    $(document).on('click', '#paliy-remove-video-file', function () {
        $('#paliy_video_attachment_id').val('0');
        $('#paliy-video-file-preview').prop('hidden', true).empty();
        $(this).prop('disabled', true);
        updateVideoSourceValidation();
    });

    $(document).on('submit', '#post', function (event) {
        if (document.body.classList.contains('post-type-paliy_video') && !updateVideoSourceValidation()) {
            event.preventDefault();
            window.alert('Укажите ссылку на видео или выберите видеофайл перед сохранением.');
        }
    });

    updateVideoSourceValidation();

    let aboutImageMediaFrame = null;
    let aboutImageTarget = null;
    $(document).on('click', '.paliy-about-select-image', function () {
        aboutImageTarget = $(this).data('key') || 'founder';
        if (!aboutImageMediaFrame) {
            aboutImageMediaFrame = wp.media({
                title: 'Выберите изображение',
                button: { text: 'Использовать изображение' },
                multiple: false,
                library: { type: 'image' },
            });

            aboutImageMediaFrame.on('select', function () {
                const attachment = aboutImageMediaFrame.state().get('selection').first().toJSON();
                const imageId = Number(attachment.id || 0);
                const imageUrl = attachment.url || attachment.sizes?.medium?.url || '';
                const container = $(`.paliy-about-image-control[data-key="${aboutImageTarget}"]`);
                container.find('input[type="hidden"]').val(imageId);
                container.find('.paliy-about-image-preview img').attr('src', imageUrl);
                container.find('.paliy-about-image-preview').prop('hidden', !imageUrl);
                container.find('.paliy-about-remove-image').prop('disabled', !imageId);
            });
        }

        aboutImageMediaFrame.open();
    });

    $(document).on('click', '.paliy-about-remove-image', function () {
        const key = $(this).data('key') || 'founder';
        const container = $(`.paliy-about-image-control[data-key="${key}"]`);
        container.find('input[type="hidden"]').val('0');
        container.find('.paliy-about-image-preview').prop('hidden', true);
        $(this).prop('disabled', true);
    });

    let aboutTeamMediaFrame = null;
    let aboutTeamTargetRow = null;
    let aboutTeamCropper = null;
    let aboutTeamCropRow = null;
    let aboutTeamCropInitialized = false;
    const aboutTeamCropModal = document.getElementById('paliy-about-team-crop-modal');
    const aboutTeamCropImage = document.getElementById('paliy-about-team-crop-image');

    function updateAboutTeamIndexes() {
        let maxIndex = -1;
        $('#paliy-about-team-members .paliy-about-team-member').each(function () {
            const index = Number($(this).data('index'));
            if (Number.isFinite(index)) {
                maxIndex = Math.max(maxIndex, index);
            }
        });

        return maxIndex + 1;
    }

    function resetAboutTeamCropper() {
        if (aboutTeamCropper) {
            aboutTeamCropper.destroy();
            aboutTeamCropper = null;
        }
        aboutTeamCropInitialized = false;
        if (aboutTeamCropImage) {
            aboutTeamCropImage.onload = null;
            aboutTeamCropImage.removeAttribute('src');
        }
    }

    function closeAboutTeamCropModal() {
        resetAboutTeamCropper();
        if (aboutTeamCropModal) {
            aboutTeamCropModal.hidden = true;
        }
        aboutTeamCropRow = null;
    }

    $(document).on('click', '.paliy-about-team-select-image', function () {
        aboutTeamTargetRow = $(this).closest('.paliy-about-team-member');
        if (!aboutTeamMediaFrame) {
            aboutTeamMediaFrame = wp.media({
                title: 'Выберите фото участника команды',
                button: { text: 'Использовать фото' },
                multiple: false,
                library: { type: 'image' },
            });

            aboutTeamMediaFrame.on('select', function () {
                if (!aboutTeamTargetRow?.length) {
                    return;
                }

                const attachment = aboutTeamMediaFrame.state().get('selection').first().toJSON();
                const imageId = Number(attachment.id || 0);
                const imageUrl = attachment.url || '';
                aboutTeamTargetRow.find('.paliy-about-team-image-id').val(imageId);
                aboutTeamTargetRow.find('.paliy-about-team-crop').val('');
                aboutTeamTargetRow.find('.paliy-about-team-original').attr('src', imageUrl).prop('hidden', !imageUrl);
                aboutTeamTargetRow.find('.paliy-about-team-card').attr('src', '').prop('hidden', true);
                aboutTeamTargetRow.find('.paliy-about-team-crop-button').prop('disabled', !imageId);
            });
        }

        aboutTeamMediaFrame.open();
    });

    $(document).on('click', '#paliy-about-add-team-member', function () {
        const template = document.getElementById('paliy-about-team-template');
        const container = document.getElementById('paliy-about-team-members');
        if (!template || !container) {
            return;
        }

        const index = updateAboutTeamIndexes();
        container.insertAdjacentHTML('afterbegin', template.innerHTML.replaceAll('__INDEX__', String(index)));
    });

    $(document).on('click', '.paliy-about-remove-team-member', function () {
        $(this).closest('.paliy-about-team-member').remove();
    });

    $(document).on('click', '.paliy-about-team-crop-button', function () {
        const row = $(this).closest('.paliy-about-team-member');
        const imageUrl = row.find('.paliy-about-team-original').attr('src') || '';
        if (!imageUrl || !aboutTeamCropModal || !aboutTeamCropImage) {
            return;
        }

        aboutTeamCropRow = row;
        resetAboutTeamCropper();
        aboutTeamCropModal.hidden = false;

        const cropValue = row.find('.paliy-about-team-crop').val() || '';
        const initialize = () => {
            if (aboutTeamCropInitialized) {
                return;
            }
            aboutTeamCropInitialized = true;
            aboutTeamCropper = new Cropper(aboutTeamCropImage, {
                aspectRatio: 360 / 390,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
            });

            if (cropValue) {
                try {
                    const crop = JSON.parse(cropValue);
                    if (crop?.width && crop?.height) {
                        aboutTeamCropper.setData(crop);
                    }
                } catch (error) {
                    // Ignore invalid historical crop data and use the default area.
                }
            }
        };

        aboutTeamCropImage.onload = initialize;
        aboutTeamCropImage.src = imageUrl;
        if (aboutTeamCropImage.complete) {
            initialize();
        }
    });

    $(document).on('click', '#paliy-about-close-team-crop', closeAboutTeamCropModal);

    $(document).on('click', '#paliy-about-save-team-crop', function () {
        if (!aboutTeamCropper || !aboutTeamCropRow?.length) {
            return;
        }

        aboutTeamCropRow.find('.paliy-about-team-crop').val(JSON.stringify(aboutTeamCropper.getData(true)));
        aboutTeamCropRow.find('.paliy-about-team-card').prop('hidden', true);
        closeAboutTeamCropModal();
    });

    let aboutGalleryMediaFrame = null;

    function updateAboutGalleryCount() {
        const count = $('#paliy-about-gallery .paliy-about-gallery-item').length;
        $('#paliy-about-gallery-count').text(`${count} / 50`);
    }

    $(document).on('click', '#paliy-about-select-gallery', function () {
        if (!aboutGalleryMediaFrame) {
            aboutGalleryMediaFrame = wp.media({
                title: 'Выберите фотографии для галереи',
                button: { text: 'Добавить фотографии' },
                multiple: true,
                library: { type: 'image' },
            });

            aboutGalleryMediaFrame.on('select', function () {
                const gallery = $('#paliy-about-gallery');
                const existingIds = new Set(gallery.find('.paliy-about-gallery-item').map(function () {
                    return Number($(this).data('image-id'));
                }).get());
                let count = existingIds.size;

                aboutGalleryMediaFrame.state().get('selection').each(function (attachment) {
                    if (count >= 50 || existingIds.has(Number(attachment.id))) {
                        return;
                    }

                    const data = attachment.toJSON();
                    const imageUrl = data.sizes?.thumbnail?.url || data.url || '';
                    if (!imageUrl) {
                        return;
                    }

                    const item = $('<div>', {
                        class: 'paliy-about-gallery-item',
                        'data-image-id': Number(data.id),
                    });
                    $('<input>', {
                        type: 'hidden',
                        name: 'paliy_about_gallery_ids[]',
                        value: Number(data.id),
                    }).appendTo(item);
                    $('<img>', { src: imageUrl, alt: '' }).appendTo(item);
                    $('<button>', {
                        type: 'button',
                        class: 'button-link-delete paliy-about-remove-gallery-image',
                        text: 'Удалить',
                    }).appendTo(item);
                    gallery.append(item);
                    existingIds.add(Number(data.id));
                    count += 1;
                });

                updateAboutGalleryCount();
            });
        }

        aboutGalleryMediaFrame.open();
    });

    $(document).on('click', '.paliy-about-remove-gallery-image', function () {
        $(this).closest('.paliy-about-gallery-item').remove();
        updateAboutGalleryCount();
    });

    let seoMediaFrame = null;
    $('#paliy-seo-select-og-image').on('click', function () {
        if (!seoMediaFrame) {
            seoMediaFrame = wp.media({
                title: 'Выберите OG-картинку',
                button: { text: 'Использовать изображение' },
                multiple: false,
                library: { type: 'image' },
            });

            seoMediaFrame.on('select', function () {
                const attachment = seoMediaFrame.state().get('selection').first().toJSON();
                const previewUrl = attachment.sizes?.medium?.url || attachment.url;
                $('#paliy_seo_og_image_id').val(Number(attachment.id));
                $('#paliy-seo-og-image-preview img').attr('src', previewUrl);
                $('#paliy-seo-og-image-preview').prop('hidden', false);
                $('#paliy-seo-remove-og-image').prop('disabled', false);
            });
        }

        seoMediaFrame.open();
    });

    $('#paliy-seo-remove-og-image').on('click', function () {
        $('#paliy_seo_og_image_id').val('0');
        $('#paliy-seo-og-image-preview').prop('hidden', true);
        $(this).prop('disabled', true);
    });

    let mediaFrame = null;
    let cropper = null;
    const cropMetabox = document.querySelector('.paliy-product-crop-metabox');
    let selectedAttachmentId = Number($('#paliy-product-image-id').val() || cropMetabox?.dataset.attachmentId || 0);
    let lastSyncedImageState = '';
    let syncRetryTimer = null;
    const cropSettings = window.paliyProductCropSettings || { cardWidth: 360, cardHeight: 390 };

    const originalPreview = document.getElementById('paliy-product-original-preview');
    const cardPreview = document.getElementById('paliy-product-card-preview');
    const cardEmpty = document.getElementById('paliy-product-card-empty');
    const cropModal = document.getElementById('paliy-product-crop-modal');
    const cropImage = document.getElementById('paliy-product-crop-image');
    const cropData = document.getElementById('paliy-product-crop-data');
    const status = document.getElementById('paliy-product-crop-status');

    if (cropData && !cropData.value && cropMetabox?.dataset.crop) {
        cropData.value = cropMetabox.dataset.crop;
    }

    function getCropValue() {
        if (!cropData || !cropData.value) {
            return null;
        }

        try {
            return JSON.parse(cropData.value);
        } catch (error) {
            return null;
        }
    }

    function getCurrentPostId() {
        const urlPostId = Number(new URLSearchParams(window.location.search).get('post') || 0);
        if (urlPostId) {
            return urlPostId;
        }

        const inputPostId = Number(document.querySelector('input[name="post_ID"]')?.value || 0);
        if (inputPostId) {
            return inputPostId;
        }

        if (window.wp?.data) {
            const editor = wp.data.select('core/editor');
            if (editor?.getCurrentPostId) {
                return Number(editor.getCurrentPostId() || 0);
            }
            if (editor?.getEditedPostAttribute) {
                return Number(editor.getEditedPostAttribute('id') || 0);
            }
        }

        return 0;
    }

    function syncCurrentImage() {
        if (!selectedAttachmentId) {
            return false;
        }

        const postId = getCurrentPostId();
        if (!postId) {
            return false;
        }

        const crop = getCropValue();
        const state = JSON.stringify({ postId, selectedAttachmentId, crop });
        if (state === lastSyncedImageState) {
            return true;
        }

        setStatus('Сохраняю изображение…');
        const apiRoot = (cropSettings.apiRoot || `${window.location.origin}/wp-json/`).replace(/\/$/, '');
        const request = fetch(`${apiRoot}/paliy/v1/post-image`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': cropSettings.apiNonce || '',
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                post_id: postId,
                attachment_id: selectedAttachmentId,
                crop,
            }),
        }).then(async (response) => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Не удалось сохранить изображение.');
            }
            return data;
        }).then((response) => {
            lastSyncedImageState = state;
            if (response.card && response.card.url) {
                cardPreview.src = `${response.card.url}${response.card.url.includes('?') ? '&' : '?'}v=${Date.now()}`;
                cardPreview.hidden = false;
                cardEmpty.hidden = true;
            }
            setStatus('Изображение сохранено.');
        }).catch((error) => {
            setStatus(error.message || 'Не удалось сохранить изображение.', true);
        });

        return Boolean(request);
    }

    function scheduleImageSync() {
        if (syncRetryTimer) {
            window.clearTimeout(syncRetryTimer);
            syncRetryTimer = null;
        }

        if (syncCurrentImage()) {
            return;
        }

        syncRetryTimer = window.setTimeout(scheduleImageSync, 1000);
    }

    if (originalPreview && originalPreview.src) {
        cropImage.src = originalPreview.src;
    }

    function setStatus(message, isError) {
        status.textContent = message || '';
        status.classList.toggle('is-error', Boolean(isError));
    }

    function openCropper() {
        if (!cropImage.src || !selectedAttachmentId) {
            setStatus('Сначала выберите изображение.', true);
            return;
        }

        if (typeof Cropper === 'undefined') {
            setStatus('Не удалось загрузить редактор кадрирования.', true);
            return;
        }

        cropModal.hidden = false;
        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(cropImage, {
            aspectRatio: cropSettings.cardWidth / cropSettings.cardHeight,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            responsive: true,
            background: false,
            movable: true,
            zoomable: true,
            rotatable: false,
            scalable: false,
        });
    }

    $('#paliy-select-product-image').on('click', function () {
        if (!mediaFrame) {
            mediaFrame = wp.media({
                title: 'Выберите изображение',
                button: { text: 'Использовать изображение' },
                multiple: false,
                library: { type: 'image' },
            });

            mediaFrame.on('select', function () {
                const attachment = mediaFrame.state().get('selection').first().toJSON();
                selectedAttachmentId = Number(attachment.id);
                $('#paliy-product-image-id').val(selectedAttachmentId);
                if (cropMetabox) {
                    cropMetabox.dataset.attachmentId = String(selectedAttachmentId);
                    cropMetabox.dataset.crop = '';
                }
                originalPreview.src = attachment.url;
                originalPreview.hidden = false;
                cropImage.src = attachment.url;
                cropData.value = '';
                cardPreview.hidden = true;
                cardEmpty.hidden = false;
                $('#paliy-open-product-crop').prop('disabled', false);
                setStatus('Изображение выбрано. Теперь выполните кадрирование и обновите товар.');
                window.setTimeout(scheduleImageSync, 0);
            });
        }

        mediaFrame.open();
    });

    $('#paliy-open-product-crop').on('click', openCropper);

    $('#paliy-close-product-crop').on('click', function () {
        cropModal.hidden = true;
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    $('#paliy-save-product-crop').on('click', function () {
        if (!cropper) {
            return;
        }

        const data = cropper.getData(true);
        cropData.value = JSON.stringify({
            x: Math.round(data.x),
            y: Math.round(data.y),
            width: Math.round(data.width),
            height: Math.round(data.height),
        });

        const previewCanvas = cropper.getCroppedCanvas({ width: cropSettings.cardWidth, height: cropSettings.cardHeight });
        cardPreview.src = previewCanvas.toDataURL('image/jpeg', 0.85);
        cardPreview.hidden = false;
        cardEmpty.hidden = true;
        cropModal.hidden = true;
        cropper.destroy();
        cropper = null;
        setStatus(`Кадрирование сохранено в форме. Размер карточки: ${cropSettings.cardWidth}×${cropSettings.cardHeight}.`);
        scheduleImageSync();
    });

    if (window.wp && wp.data) {
        let wasSaving = false;
        wp.data.subscribe(() => {
            const editor = wp.data.select('core/editor');
            if (!editor) {
                return;
            }

            const isSaving = editor.isSavingPost();
            const isAutosaving = editor.isAutosavingPost();
            if (!wasSaving && isSaving && !isAutosaving) {
                syncPaliyRichTextEditors();
            }
            if (wasSaving && !isSaving && !isAutosaving) {
                syncCurrentImage();
            }
            wasSaving = isSaving;
        });
    }
}(jQuery));
