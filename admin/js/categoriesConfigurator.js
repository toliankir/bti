const $categoryTable = $('#categories_list');
const $inputCategoryName = $('#categoryName');
const $modalCategoryName = $('#modal-category_name');
const $modalCategoryDescription = $('#modal-category_description');
const $modalCategoryId = $('#modal-category_id');
const $categorySortByName = $('#category-sort_by_name');

let categoriesConfiguratorListeners = false;

const $leftMenu = $('#leftMenu');

let sortOrder = -1;
let allCategoriesData = {};

//File table by categories data
function showAllCategories(allCategoriesData) {
    leftMenuInit();
    $categoryTable.html('');
    allCategoriesData.forEach((categoryElement) => {

        const $categoryName = $(`<td><span>${categoryElement.category}</span></td>`);
        $($categoryName.find('span')[0])
            .css({'cursor': 'pointer'})
            .on('click', (clickedElement) => {
                const $clickElement = $(clickedElement.target);
                console.log($clickElement.text());
                $inputCategoryName.val($clickElement.text() + '\\');
            });

        //Delete button element
        const $categoryDelete = $('<button class="btn ml-2 btn-danger">Delete</button>')
            .on('click', () => {
                ajaxRequest('GET', {
                    action: 'deleteCategoryById',
                    id: categoryElement.id
                }, () => {
                    categoriesConfigurator();
                });
            });

        //Edit button element
        const $categoryEdit = $('<button class="btn btn-success" data-toggle="modal" data-target="#categoryModal">Edit</button>')
            .on('click', () => {
                $modalCategoryName.val(categoryElement.category);
                $modalCategoryDescription.val(categoryElement.description);
                $modalCategoryId.val(categoryElement.id);
            });

        const $actionMenu = $('<td></td>')
            .append($categoryEdit)
            .append($categoryDelete);


        $($categoryTable.append(`<tr></tr>`))
            .append(`<td>${categoryElement.id}</td>`)
            .append($categoryName)
            .append(`<td>${categoryElement.description}</td>`)
            .append($actionMenu);
    });
}

function setCategoriesConfiguratorListeners() {
    if (categoriesConfiguratorListeners) {
        return;
    }
    categoriesConfiguratorListeners = true;

    $categorySortByName
        .css({
            'cursor': 'pointer'
        })
        .on('click', () => {
            console.log(sortOrder);
            showAllCategories(allCategoriesData.sort((a, b) => {
                return a.category.localeCompare(b.category) * sortOrder;
            }));
        });
}

function categoriesConfigurator() {
    ajaxRequest('GET', {
        action: 'getAllCategories'
    }, (responseData) => {
        allCategoriesData = responseData.body;
        showAllCategories(allCategoriesData);
    });
    setCategoriesConfiguratorListeners();
}
