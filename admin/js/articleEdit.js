const $articleCategory = $('#article-category');
const $articleTitle = $('#article-title');
const $articleSend = $('#article-send');
const $articleDescription = $('#article-description');
const $articleVisible = $('#article-visible');

const $gallery = $('#gallery');
const $articleGallery = $('#article-gallery');
const $articleGalleryToggle = $('#article-gallery-toggle');
const $fileArticleId = $('#file-article-id');

let articleData = null;
let intervalTinymce;
let articleEditListeners = false;

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
                .append($(`<img class='gallery__img' src='${thumbLink}'>`)
                    .on('click', () => {
                        if (isImage) {
                            tinymce.activeEditor.execCommand('mceInsertContent', false, `<img src='${link}'>`);
                        } else {
                            tinymce.activeEditor.execCommand('mceInsertContent', false, `<a href='${link}'>${file.filename}</a>`);
                        }
                    }))
                .append(`<span class='gallery__text'>${file.filename}</span>`)
                .append($(`<button class='btn btn-danger btn-sm gallery__delete'>Delete</button>`)
                    .on('click', () => {
                        ajaxRequest('GET', {
                            action: 'deleteFile',
                            file: file.filename
                        }, () => {
                            fillGallery();
                        });
                    }));
            $articleGallery.append($container);
        });
    });

}

function setDataToForm(data) {
    $articleTitle.val(data.title);
    $articleDescription.val(data.description);
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
            text: tinymce.activeEditor.getContent()
        }, () => {
            window.location.hash = 'articleList/' + $articleCategory.val();
        });
    });

    $articleGalleryToggle.on('click', () => {
        $articleGallery.toggle();
    });
}

function articleEdit() {
    fillCategorySelect();
    getArticleById();
    setArticleEditListeners();

    fillGallery();
    // ajaxRequest('GET', {
    //     action: 'getArticlesWOTByCategory',
    //     category: 'бв'
    // }, (data) => {
    //     $('#testdiv').html(data.body.text);
    // });

    // $('#testbtn').on('click', () => {
    //     // tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="https://overclockers.ru/assets/logo.png">');
    //     tinymce.activeEditor.setContent('<span>some</span> html');
    // });

    //
    // $('#uploadFile').on('submit', (e) => {
    //     e.preventDefault();
    //     const test = new FormData(e.target);
    //     test.append('action', 'test');
    //     $.ajax({
    //         url: apiUrl,
    //         processData: false,
    //         contentType: false,
    //         type: 'POST',
    //         data: test
    //     }).fail((jqXHR) => {
    //         console.log(jqXHR);
    //     }).done((data) => {
    //         console.log(data);
    //     });
    // });
}