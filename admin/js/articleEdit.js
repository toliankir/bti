const $articleCategory = $('#article-category');
const $articleTitle = $('#article-title');
const $articleSend = $('#article-send');
const $articleDescription = $('#article-description');
const $articleVisible = $('#article-visible');
const $articleExt = $('#article-ext');

const $gallery = $('#gallery');
const $articleGallery = $('#article-gallery');
const $articleGalleryToggle = $('#article-gallery-toggle');
const $fileArticleId = $('#file-article-id');

let articleData = null;
let intervalTinymce;
let articleEditListeners = false;
let articleCategories = [];

function fillCategorySelect(id = null) {
    ajaxRequest('GET', {
        action: 'getAllCategories'
    }, (responseData) => {
        allCategoriesData = responseData.body;
        $articleCategory.html('');
        allCategoriesData.forEach((category) => {
            $articleCategory.append(`<option value="${category.id}">${category.category}</option>`);
        });
        if (id) {
            $articleCategory.val(id);
        }
    })
}

function getArticleById() {
    if (route[2] === '') {
        route[2] = 0;
    }
    ajaxRequest('GET', {
        action: 'getArticleById',
        id: route[2]
    }, (responseData) => {
        articleData = responseData.body;
        if (responseData.statusCode !== 200) {
            articleData = {
                category: route[1] !== '' ? decodeURIComponent(route[1]) : '',
                description: '',
                ext: '',
                id: route[2] ? route[2] : 'new',
                text: '',
                timestamp: '',
                title: '',
                visible: 1
            };
        }
        fillCategorySelect(articleData.category);
        setDataToForm(articleData);

        if (articleData.id === 'new') {
            $articleSend.val('Add article');
            $gallery.hide();
        } else {
            $articleSend.val('Save article');
            $fileArticleId.val(articleData.id);
            $gallery.show();
        }
    });
}

function fillGallery() {
    ajaxRequest('GET', {
        action: 'getFilesForArticle',
        id: route[2]
    }, (response) => {
        const files = response.body;
        $articleGallery.html('');
        files.forEach((file) => {
            const $container = $('<div class="gallery__item"></div>');
            const link = `${uploadFileLink}/${file.filename}`;
            const fileExtension = file.filename.split('.').pop();

            let isImage = true;
            imageFormat.indexOf(fileExtension) !== -1 ? isImage = true : isImage = false;
            const thumbLink = isImage ? link : `${assetsLink}/fileicons/${fileExtension}.svg`;

            $container
                .append($(`<img class='gallery__img' src='${thumbLink}'>`))
                .append($('<div class="gallery__menu"></div>')
                    .append($('<a>Дбавить в текст</a>')
                        .on('click', () => {
                            if (isImage) {
                                tinymce.activeEditor.execCommand('mceInsertContent', false, `<img src='${link}'>`);
                            } else {
                                tinymce.activeEditor.execCommand('mceInsertContent', false, `<a href='${link}'>${file.filename}</a>`);
                            }
                        }))
                    .append($('<a data-toggle="modal" data-target="#fileModal">Редактировать</a>')
                        .on('click', () => {
                            $modalFileArticle.val(file.article);
                            $modalFileDescription.val(file.description);
                            $modalFileId.val(file.id === '' ? 0 : file.id);
                            $modalFilename.val(file.filename);
                        }))
                    .append($('<a>Сделать основной</a>')
                        .on('click', () => {
                            ajaxRequest('GET', {
                                action: 'updateExtProperty',
                                articleId: articleData.id,
                                key: 'mainImage',
                                value: file.filename
                            }, () => {
                                getArticleById();
                            });
                        }))
                    .append($('<a>Удалить</a>')
                        .on('click', () => {
                            ajaxRequest('GET', {
                                action: 'deleteFile',
                                file: file.filename
                            }, () => {
                                fillGallery();
                            });
                        })));

            $articleGallery.append($container);

            // $($container.find('.gallery__menu')).css('top', $container.height() + 5);
            // console.log($container.width());
        });
    });

}

function setDataToForm(data) {
    $articleTitle.val(data.title);
    $articleDescription.val(data.description);
    $articleExt.val(data.ext);
    $articleVisible.prop('checked', data.visible !== '0');
    intervalTinymce = setInterval(() => {
        if (typeof tinymce.activeEditor.contentDocument !== "undefined") {
            clearInterval(intervalTinymce);
            tinymce.activeEditor.setContent(data.text);
        }
    }, 250);
}

function setArticleEditListeners() {
    if (articleEditListeners) {
        return;
    }
    articleEditListeners = true;
    $articleSend.on('click', () => {
        ajaxRequest('POST', {
            action: 'updateArticle',
            id: articleData.id,
            title: $articleTitle.val(),
            categoryId: $articleCategory.val(),
            visible: $articleVisible.is(':checked'),
            description: $articleDescription.val(),
            text: tinymce.activeEditor.getContent(),
            ext: $articleExt.val(),
        }, () => {
            window.location.hash = 'articleList/' + $articleCategory.val();
        });
    });

    $articleGalleryToggle.on('click', () => {
        $articleGallery.toggle(300);
    });


}

function articleEdit() {
    fillCategorySelect();
    getArticleById();
    setArticleEditListeners();
    fillGallery();
    // $articleGallery.hide();
}
