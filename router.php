<?php
require_once BASE_PATH . '/app/configs/session.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($uri) {
        case '/':
            require_once './../app/views/index.php';
            break;

        case '/response':
            require_once './../app/controller/formController/response.controller.php';
            break;

        case '/login':
            require_once './../app/views/auth/login.view.php';
            break;

        case '/register':
            require_once './../app/views/auth/register.view.php';
            break;

        case '/logout':
            require_once './../app/controller/userController/logout.controller.php';
            break;

        case '/reset':
            require_once './../app/views/auth/reset.view.php';
            break;

        case '/changepassword':
            require_once './../app/controller/userController/changepassword.controller.php';
            break;

        case '/form':
            if (empty($_SESSION['user_id'])) {
                require_once './../app/views/shared/403.view.php';
                break;
            }

            $page = $_GET['q'] ?? '1';
            switch ($page) {
                case '1':
                    require_once './../app/views/form/question1.view.php';
                    break;
                case '2':
                    require_once './../app/views/form/question2.view.php';
                    break;
                case '3':
                    require_once './../app/views/form/question3.view.php';
                    break;
                case '4':
                    require_once './../app/views/form/question4.view.php';
                    break;
                default:
                    require_once './../app/views/shared/404.view.php';
                    break;
            }
            break;
    }
}

//POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($uri) {
        case '/login':
            require_once './../app/controller/userController/login.controller.php';
            break;

        case '/register':
            require_once './../app/controller/userController/register.controller.php';
            break;

        case '/otpsend':
            require_once './../app/controller/userController/otpsend.controller.php';
            break;

        case '/otpverify':
            require_once './../app/controller/userController/otpverify.controller.php';
            break;

        case '/sendresetlink':
            require_once './../app/controller/userController/resetlink.controller.php';
            break;
        case '/resetpassword':
            require_once './../app/controller/userController/resetpassword.controller.php';
            break;

        case '/form':
            if (empty($_SESSION['user_id'])) {
                require_once './../app/views/shared/403.view.php';
                break;
            }

            $page = $_GET['q'] ?? '1';
            switch ($page) {
                case '1':
                    require_once './../app/controller/formController/question1.controller.php';
                    break;
                case '2':
                    require_once './../app/controller/formController/question2.controller.php';
                    break;
                case '3':
                    require_once './../app/controller/formController/question3.controller.php';
                    break;
                case '4':
                    require_once './../app/controller/formController/question4.controller.php';
                    break;
                default:
                    require_once './../app/views/shared/404.view.php';
                    break;
            }
            break;

        default:
            echo "Invalid POST route";
            break;
    }
}
