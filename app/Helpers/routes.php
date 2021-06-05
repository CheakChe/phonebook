<?php

use App\Controllers\IndexController;
use App\Core\Router;

Router::get('', [IndexController::class, 'index']);
Router::post('/news', [IndexController::class, 'news']);
Router::post('/feedback', [IndexController::class, 'feedback']);
Router::post('/addPhone', [IndexController::class, 'phone']);
