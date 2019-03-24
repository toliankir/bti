const $articleListBody = $('#articleList-body');
const $addArticle = $('#add-article');
const $addLink = $('#add-link');
const $linkId = $('#link-id');
const $addCategoryLink = $('#add-category-link');
const $categoryLink = $('#category-link');

let articleListListeners = false;
let articles;

function fillArticleList() {
    if (route[1]) {
        ajaxRequest('GET', {
            action: 'getArticlesByCategoryId',
            category: route[1]
        }, (data) => {
            $articleListBody.html('');
            articles = data.body;
            articles.forEach((article) => {
                const $btnEdit = $('<button class="btn btn-success">Edit</button>')
                    .on('click', () => {
                        window.location.hash = 'articleEdit//' + article.id;
                    });
                const $btnDelete = $('<button class="btn ml-2 btn-danger">Delete</button>')
                    .on('click', () => {
                        ajaxRequest('GET', {
                            action: 'deleteArticleById',
                            id: article.id
                        }, () => {
                            fillArticleList();
                        });
                    });

                const $row = $('<tr></tr>')
                    .append(`<td>${article.id}</td>`)
                    .append(`<td>${article.title}</td>`)
                    .append(`<td>${article.description}</td>`)
                    // .append('<td><b>'+ (article.visible === '1' ? '+' : '-') +'</b></td>')
                    .append($('<td></td>')
                        .append($('<span>Вниз</i></span>')
                            .on('click', () => {
                                ajaxRequest('GET', {
                                    action: 'articleDown',
                                    id: article.id
                                }, () => {
                                    fillArticleList();
                                });
                            }))
                        .append($('<span>Вверх</span>')
                            .on('click', () => {
                                ajaxRequest('GET', {
                                    action: 'articleUp',
                                    id: article.id
                                }, () => {
                                    fillArticleList();
                                });
                            })))
                    .append($('<td></td>')
                        .append($btnEdit)
                        .append($btnDelete));
                $articleListBody.append($row);
            });
        });
    }
}

function addArticleListListeners() {
    if (articleListListeners) {
        return;
    }
    articleListListeners = true;
    $addArticle.on('click', () => {
        window.location.hash = 'articleEdit/' + route[1];
    });

    $addLink.on('click', () => {
        if ($linkId.val() === '') {
            return;
        }
        ajaxRequest('GET', {
            action: 'addLinkToArticle',
            categoryId: route[1],
            link: $linkId.val()
        }, () =>{
            fillArticleList();
        });
    });

    $addCategoryLink.on('click', () => {
        if ($categoryLink.val() === '') {
            return;
        }
        ajaxRequest('GET', {
            action: 'addCategoryLink',
            categoryId: route[1],
            link: $categoryLink.val()
        }, () =>{
            fillArticleList();
        });
    });

}
function articleList() {
    addArticleListListeners();
    fillArticleList();
}