<footer>

</footer>
<?php if (!empty($vars['scripts'])): ?>
    <?php foreach ($vars['scripts'] as $key => $item): ?>
        <script src="/app/public/js/<?= $item ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>