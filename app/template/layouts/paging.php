<div class="paging d-flex">
    <?php for ($i = 1; $i <= $vars['count']; $i++): ?>
        <div class="paging__link mr-1 ml-1">
            <?php if (!preg_match("@\/page\/$i@i", $_SERVER['REQUEST_URI'])): ?>
                <a href="<?= $vars['url'] ?>page/<?= $i ?>"><?= $i ?></a>
            <?php else: ?>
                <p><?= $i ?></p>
            <?php endif; ?>
        </div>
    <?php endfor; ?>
</div>
