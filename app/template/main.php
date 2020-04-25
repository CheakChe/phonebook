<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <button class="modal__open-add">Добавить запись</button>
    </div>
    <div class="phones row justify-content-center mt-5">
        <div class="phones__items">
            <?php foreach ($vars['phones'] as $key => $item): ?>
                <div class="phones__item item-<?= $item['id'] ?>">
                    <p>
                        <span class="phones__number"><?= $key + 1 ?></span>
                        <span class="phones__second-name"><?= $item['second-name'] ?></span>
                        <span class="phones__phone-number"><?= $item['phone-number'] ?></span>
                        <span class="phones__id" hidden><?= $item['id'] ?></span>
                    </p>
                    <button class="modal__open">Редактировать</button>
                    <button class="delete-phone">Удалить</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= htmlspecialchars_decode($vars['modal']) ?>