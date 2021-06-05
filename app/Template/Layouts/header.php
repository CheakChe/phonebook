<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= env('WEBSITE_NAME') ?></title>
    <?php if (!empty($this->styles)): ?>
        <?php foreach ($this->styles as $key => $item): ?>
            <script src="./public/css/<?= $item ?>.css"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<header></header>
