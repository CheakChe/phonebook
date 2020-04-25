const new_task = document.querySelector('.new_task');
const task_place = document.querySelector('.tasks__new');
if (new_task) {
    new_task.addEventListener('click', function () {
        if (task_place.innerHTML === '') {
            task_place.innerHTML =
                '<div class="tasks__new-task d-lg-flex d-md-block text-center">' +
                '  <div class="d-md-flex d-md-block tasks__item align-items-center">\n' +
                '<span class="task__number">Новая задача</span>\n' +
                '    <div class="m-2"><input class="mr-1 ml-1" required type="text" placeholder="Имя" name="nameNew" value=""></div>\n' +
                '    <div class="m-2"><input class="mr-1 ml-1" required type="email" placeholder="Почта" name="emailNew" value=""></div>\n' +
                '    <div class="m-2"><input class="mr-1 ml-1" required type="text" placeholder="Задача" name="taskNew" value=""></div>\n' +
                '  </div>\n' +
                '  <button class="btn btn-dark align-self-end" type="submit" name="save" value="new">Добавить задачу</button>' +
                '</div>';
        } else {
            task_place.innerHTML = '';
        }
    });
}