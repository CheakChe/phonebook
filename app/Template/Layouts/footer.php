<footer></footer>
<?php if (!empty($this->scripts)): ?>
    <?php foreach ($this->scripts as $key => $item): ?>
        <script src="./public/js/<?= $item ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>