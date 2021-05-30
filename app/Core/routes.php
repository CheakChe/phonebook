<?php

use App\Controllers\IndexController;
use App\Core\Router;

Router::get('', [IndexController::class]);
Router::get('/news', [IndexController::class, 'news']);
Router::post('/feedback', [IndexController::class, 'feedback']);
Router::post('/addPhone', [IndexController::class, 'Phone']);
