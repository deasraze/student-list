(function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})();

(function () {
    let close = document.querySelector('#notification-close')

    if (close) {
        close.addEventListener('click', () => {
            window.history.replaceState({}, document.title, window.location.href.split('?')[0]);
        })
    }
})();
