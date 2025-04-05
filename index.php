<?php
$config = require_once 'config.php';

use Controllers\FormController;
use Controllers\AjaxController;

spl_autoload_register(function ($class) {
    $prefix = 'Controllers\\';
    $base_dir = __DIR__ . '/controllers/';
    if (str_starts_with($class, $prefix)) {
        $class = str_replace($prefix, '', $class);
        $file = $base_dir . $class . '.php';
        if (file_exists($file)) require $file;
    }

    $prefix = 'Models\\';
    $base_dir = __DIR__ . '/models/';
    if (str_starts_with($class, $prefix)) {
        $class = str_replace($prefix, '', $class);
        $file = $base_dir . $class . '.php';
        if (file_exists($file)) require $file;
    }
});

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $ajaxController = new AjaxController($config);
    $action = $_POST['action'];
    if (method_exists($ajaxController, $action)) {
        $ajaxController->$action();
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action!']);
    }
    exit;
} else {
    $controller = new FormController($config);
    $controller->showForm();
}
