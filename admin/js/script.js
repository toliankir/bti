const apiUrl = 'api/';
const assetsLink = `http://${window.location.host}/assets`;
const uploadFileLink = `http://${window.location.host}/assets/upload`;
const imageFormat = ['gif', 'png', 'jpg', 'jpeg', 'svg'];

const $categoriesToggle = $('#categories-toggle');

let route;

function ajaxRequest(method, data, doneFunction = null) {
    $.ajax({
        url: apiUrl,
        dataType: 'json',
        type: method,
        data: data
    }).fail((jqXHR) => {
        console.log(jqXHR);
    }).done((data) => {
        if (doneFunction === null) {
            return;
        }
        doneFunction(data);
    });
}


function leftMenuInit() {
    const list = [];

    ajaxRequest('GET', {
        action: 'getAllCategories'
    }, (responseData) => {
        $leftMenu.html('');
        allCategoriesData = responseData.body;
        allCategoriesData.sort((a, b) => a.category.localeCompare(b.category)).forEach((element) => {
            $leftMenu.append(`<li><a href="#articleList/${element.id}">${element.category}</a></li>`)
        });
    });
}


function router() {
    $('section').hide();
    route = (window.location.hash.slice(1, window.location.hash.length)).split('/');
    if (!route[0] || typeof window[route[0]] !== 'function') {
        return;
    }

    window[route[0]]();
    $('#' + route[0]).show();
}

$(document).ready(function () {
    router();
    $(window).on('hashchange', function () {
        router();
    });

    leftMenuInit();

    $('form').on('submit', (event) => {
        event.preventDefault();
        $('.modal').modal('hide');
        const formData = new FormData(event.target);
        formData.append('action', $(event.target).attr('id'));
        $.ajax({
            url: apiUrl,
            processData: false,
            contentType: false,
            type: 'POST',
            data: formData
        }).fail((jqXHR) => {
            console.log(jqXHR);
        }).done(() => {
            router();
        });
    });

    tinymce.init({
        selector: "#article-text",
        width: '100%',
        height: 300,
        plugins: "link table",
        statusbar: true,
        menubar: true,
        relative_urls: false,
        convert_urls: false,
        toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    });

    // Prevent bootstrap dialog from blocking focusin
    $(document).on('focusin', function (e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });

    $categoriesToggle
        .on('click', () => {
            $leftMenu.toggle(400);
        });

});
