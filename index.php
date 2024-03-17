<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/api/core/router.php';
require_once __DIR__ . '/api/db/db_config.php';

session_start();
// ---------- AUTOLOADER -----------------------------------
function auto_loader($className)
{
    $baseDirs = [
        __DIR__ . '/api/src/controllers/',
        __DIR__ . '/api/src/services/',
        __DIR__ . '/api/src/validation/',
        __DIR__ . '/api/src/models/'
    ];
    // Loop through base directories
    foreach ($baseDirs as $baseDir) {
        // Construct full path to the class file
        $file = $baseDir . $className . '.php';
        // Check if the file exists
        if (file_exists($file)) {
            // Include the class file
            require_once $file;
            return; // Stop searching once the class is found and included
        }
    }
}
// Register the autoloader function
spl_autoload_register("auto_loader");
// ---------------------------------------------------------

// Instantiate dependencies
$userModel = new UserModel($pdo);
$userValidator = new UserValidator();
$userService = new UserService($userModel, $userValidator);
$userController = new UserController($userService);

$loginLogoutController = new LoginLogoutController($userModel);
$reviewService = new ReviewService($userModel, $userValidator);
$reviewController = new ReviewController($reviewService);

$router = new Router();
// API ROUTING
$router->get('/roommates/api/usersz', function () use ($userController) {
    echo 'works';
});
$router->get('/roommates/api/users', function () use ($userController) {
    $userController->fetchUser(); // Fetch logged in user
});
$router->get('/roommates/api/role', function () use ($userController) {
    $userController->getRole(); //Get role
});
$router->post('/roommates/api/fetch-users-with-same-parameters', function () use ($userController) {
    $userController->fetchUsersWithSameParameters(); //Fetch users with same filters
});
$router->post('/roommates/api/display-user', function () use ($reviewController) {
    $reviewController->fetchOtherUserProfileByEmail();
});
$router->get('/roommates/api/fetch-twelve', function () use ($userController) {
    $userController->fetchLastTwelveUsers();
});
$router->post('/roommates/api/users', function () use ($userController) {
    $userController->createUser(); //Register user
});
$router->post('/roommates/api/logout', function () use ($loginLogoutController) {
    $loginLogoutController->logout(); // Logout user
});
$router->post('/roommates/api/login', function () use ($loginLogoutController) {
    $loginLogoutController->login(); // Login user
});
$router->patch('/roommates/api/users', function () use ($userController) {
    $userController->updateUser();
});
$router->patch('/roommates/api/password-change', function () use ($userController) {
    $userController->changePassword();
});
$router->patch('/roommates/api/update-description', function () use ($userController) {
    $userController->updateDescription();
});
$router->patch('/roommates/api/update-budget', function () use ($userController) {
    $userController->updateBudget();
});
$router->patch('/roommates/api/rate-user', function () use ($reviewController) {
    $reviewController->rateUser();
});

// PAGE ROUTING
// Define an array of URIs
$uris = ['/roommates/home', '/roommates/login', '/roommates/registration', '/roommates/my-profile', '/roommates/display-profile', '/roommates/about-us'];

// Loop through the URIs and define routing for each
foreach ($uris as $uri) {
    $router->get($uri, function () {
        require_once __DIR__ . '/public/index.php';
    });
}
// 404 PAGE
$router->get('/roommates/404', function () {
    http_response_code(404);
    require_once __DIR__ . '/public/html/404.html';
});
// Resolve the route based on the request method and URI
$router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
