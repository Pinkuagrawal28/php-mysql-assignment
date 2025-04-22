<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($uri) {
        case '/':
            require_once './../app/views/index.php';
            break;
    }
}
