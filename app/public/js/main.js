const edit = document.querySelectorAll('.phones .phones__item .modal__open');
const close = document.querySelectorAll('.modal__close');
const modal = document.querySelector('.modal.form');
const form = document.querySelector('.modal form');
const modalMessage = document.querySelector('.modal.message');
const phoneBook = document.querySelector('.phones .phones__items');
const deletePhone = document.querySelectorAll('.phones .phones__item .delete-phone');

if (edit) {
    edit.forEach(e => {
        e.addEventListener('click', function () {
            const spans = e.previousElementSibling.querySelectorAll('span');
            modal.querySelector('p span').innerText = ' ' + spans[0].innerText;
            modal.querySelector('input#second-name').value = spans[1].innerText;
            modal.querySelector('input#phone-number').value = spans[2].innerText;
            modal.querySelector('input#id').value = spans[3].innerText;
            modal.classList.add('show-modal')
        });
    });
}

if (form) {
    form.addEventListener('submit', function () {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/index/updatePhone');
        let formData = new FormData(document.forms.editPhone);
        xhr.send(formData);
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let response = JSON.parse(xhr.response);
                result(response);
                if (response['status']) {
                    let id = modal.querySelector('input#id').value;
                    let phone = phoneBook.querySelector('.item-' + id)
                    phone.querySelector('.phones__second-name').innerHTML = modal.querySelector('input#second-name').value;
                    phone.querySelector('.phones__phone-number').innerHTML = modal.querySelector('input#phone-number').value;
                }
            }
        };
        xhr.onerror = function () {

        };
    });
}
close.forEach(e => {
    e.addEventListener('click', function () {
        let modal = e.closest('.modal');
        modal.classList.remove('show-modal');
    });
});

deletePhone.forEach(e => {
    e.addEventListener('click', function () {

        let id = e.parentElement.querySelector('.phones__id');
        id = id.innerHTML;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/ajax/index/deletePhone');
        let formData = new FormData();
        formData.append('id', id);
        xhr.send(formData);
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let response = JSON.parse(xhr.response);
                result(response);
                let id = e.closest('.phones__item').querySelector('p .phones__id').innerHTML;
                let phone = phoneBook.querySelector('.item-' + id);
                phone.innerHTML = null;


            }
        };
        xhr.onerror = function () {

        };
    });
});

function log(text) {
    console.log(text);
}

function result(response) {
    modalMessage.classList.add('show-modal');
    modalMessage.querySelector('p').innerHTML = response['message'];
}
