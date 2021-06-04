let edit = document.querySelectorAll('.phones .phones__item .modal__open');
const close = document.querySelectorAll('.modal__close');
const modal = document.querySelector('.modal.form');
const phone = document.querySelector('.modal form');
const modalMessage = document.querySelector('.modal.message');
const phoneBook = document.querySelector('.phones .phones__items');
let deletePhone = document.querySelectorAll('.phones .phones__item .delete-phone');
const add = document.querySelector('.modal__open-add');
const phonesItems = document.querySelector('.phones__items');

if (edit) {
    edit.forEach(e => {
        e.addEventListener('click', function () {
            editfuction(e);
        });
    });
}
if (add) {
    add.addEventListener('click', function () {
        modal.querySelector('p').innerText = 'Добавление телефонной записи';
        modal.querySelector('input#second-name').value = null;
        modal.querySelector('input#phone-number').value = null;
        modal.querySelector('input#id').value = null;
        modal.classList.add('show-modal');
        modal.querySelector('form').classList.add('addPhone');
    });
}

if (phone) {
    phone.addEventListener('submit', function () {
        let xhr = new XMLHttpRequest();
        let url = modal.querySelector('form').getAttribute('class');
        xhr.open('POST', '/addPhone');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        let formData = new FormData(document.forms.Phone);
        if (url === 'addPhone') {
            formData.append("add", 'true');
        }
        xhr.send(formData);
        xhr.onload = function () {
            if (xhr.status !== 200) {
                log('Ошибка: ' + xhr.status);
            } else {
                let response = JSON.parse(xhr.response);
                result(response);
                if (response['status']) {
                    if (url === 'addPhone') {
                        let last_id = phonesItems.querySelectorAll('.phones__number');
                        last_id = last_id[last_id.length - 1];
                        if (last_id === undefined) {
                            last_id = 1;
                        } else {
                            last_id = (Number(last_id.innerHTML) + 1);
                        }
                        phonesItems.insertAdjacentHTML("beforeend", '<div class="phones__item item-' + response['new-phone']['id'] + '">\n' +
                            '                    <p>\n' +
                            '                        <span class="phones__number">' + last_id + '</span>\n' +
                            '                        <span class="phones__second-name">' + response['new-phone']['second-name'] + '</span>\n' +
                            '                        <span class="phones__phone-number">' + response['new-phone']['phone-number'] + '</span>\n' +
                            '                        <span class="phones__id" hidden>' + response['new-phone']['id'] + '</span>\n' +
                            '                    </p>\n' +
                            '                    <button class="modal__open">Редактировать</button>\n' +
                            '                    <button class="delete-phone">Удалить</button>\n' +
                            '                </div>');
                        edit = document.querySelectorAll('.phones .phones__item .modal__open');
                        deletePhone = document.querySelectorAll('.phones .phones__item .delete-phone');
                        if (edit) {
                            edit.forEach(e => {
                                e.addEventListener('click', function () {
                                    editfuction(e);
                                });
                            });
                        }
                        if (deletePhone) {
                            deletePhone.forEach(e => {
                                e.addEventListener('click', function () {
                                    deleteFunction(e);
                                });
                            });
                        }
                    } else {
                        let id = modal.querySelector('input#id').value;
                        let phone = phoneBook.querySelector('.item-' + id);
                        phone.querySelector('.phones__second-name').innerHTML = modal.querySelector('input#second-name').value;
                        phone.querySelector('.phones__phone-number').innerHTML = modal.querySelector('input#phone-number').value;
                    }
                }
            }
        };
        xhr.onerror = function () {
            log(xhr.response)
        };
    });
}

close.forEach(e => {
    e.addEventListener('click', function () {
        let modal = e.closest('.modal');
        modal.classList.remove('show-modal');
        if (modal.querySelector('form')) {
            modal.querySelector('form').removeAttribute('class');
        }
    });
});

if (deletePhone) {
    deletePhone.forEach(e => {
        e.addEventListener('click', function () {
            deleteFunction(e);
        });
    });
}

function log(text) {
    console.log(text);
}

function result(response) {
    modalMessage.classList.add('show-modal');
    modalMessage.querySelector('p').innerHTML = response['message'];
}

function editfuction(e) {
    const spans = e.previousElementSibling.querySelectorAll('span');
    modal.querySelector('p').innerText = 'Редактирование телефонной записи номер ' + spans[0].innerText;
    modal.querySelector('input#second-name').value = spans[1].innerText;
    modal.querySelector('input#phone-number').value = spans[2].innerText;
    modal.querySelector('input#id').value = spans[3].innerText;
    modal.classList.add('show-modal');
    modal.querySelector('form').classList.add('editPhone');
}

function deleteFunction(e) {
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
            phone.remove();
        }
    };
    xhr.onerror = function () {
        log(xhr.response)
    };
}
