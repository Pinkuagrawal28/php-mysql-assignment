<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($uri) {
        case '/':
            require_once './../app/views/index.php';
            break;

        case '/register':
            require_once './../app/views/auth/register.view.php';
            break;

        case '/login':
            require_once './../app/views/auth/login.view.php';
            break;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($uri) {
        case '/otpsend':
            require_once './../app/controller/userController/otpsend.controller.php';
            break;

        case '/otpverify':
            require_once './../app/controller/userController/otpverify.controller.php';
            break;

        case '/login':
              require_once './../app/controller/userController/login.controller.php';
              break;

    }
}
