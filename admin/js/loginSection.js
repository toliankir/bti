const $loginField = $('#loginField');
const $passwordField = $('#passwordField');
const $loginBtn = $('#login');
const $loginSection = $('#loginSection');

function loginSection() {

    $loginBtn.on('click', () => {
        ajaxRequest('GET', {
            login: $loginField.val(),
            password: $passwordField.val(),
        }, (data) => {
            if (data.statusCode !== 200) {
                return;
            }
            document.location.hash = '';
            router();
        });
    });

}