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
            $leftMenu.append(`<li class="list-group-item"><a href="#articleList/${element.id}">${element.category}</a></li>`)
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
        height: 500,
        plugins: "link table lists hr",
        statusbar: true,
        menubar: true,
        relative_urls: false,
        convert_urls: false,
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect link image | numlist bullist",
        // toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        // style_formats : [
        //     {title : 'Parahraph', inline : 'p'},
        //     {title : 'Bold text', inline : 'b'},
        //     {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
        //     {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
        //     {title : 'Example 1', inline : 'span', classes : 'example1'},
        //     {title : 'Example 2', inline : 'span', classes : 'example2'},
        //     {title : 'Span', inline : 'span'}
        // ]
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
