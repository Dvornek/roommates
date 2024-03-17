<?php
class UserController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function fetchUser(): void
    {
        try {
            header('Content-Type: application/json');
            if (isset ($_SESSION["user"])) {
                // Call service
                $response = $this->userService->fetchUser($_SESSION['user']['email']);
                $jsonData = json_encode($response);
                if ($response['success']) {
                    http_response_code(200);
                    echo $jsonData;
                    exit;
                } else {
                    http_response_code(400);
                    echo $jsonData;
                    exit;
                }
            } else {
                $this->unauthenticatedUser();
            }
        } catch (Exception $e) {
            $this->serverError($e);
        }
    }
    public function createUser(): void
    {
        try {
            header('Content-Type: application/json');
            if (!isset ($_SESSION["user"])) {
                $requestData = json_decode(file_get_contents('php://input'), true);
                // Call service
                $response = $this->userService->createUser($requestData);
                $jsonData = json_encode($response);
                if ($response['success']) {
                    http_response_code(201);
                    echo $jsonData;
                    exit;
                } else {
                    http_response_code(400);
                    echo $jsonData;
                    exit;
                }
            } else {
                http_response_code(400);
                $jsonData = json_encode(["success" => false, "message" => "You are already authenticated. Can not make new user"]);
                echo $jsonData;
                exit;
            }
        } catch (Exception $e) {
            $this->serverError($e);
        }
    }
    public function updateUser(): void
    {
        try {
            header('Content-Type: application/json');
            if (isset ($_SESSION["user"])) {
                $requestData = json_decode(file_get_contents('php://input'), true);
                // Call service
                $response = $this->userService->updateUser($requestData);
                $jsonData = json_encode($response);
                if ($response['success']) {
                    http_response_code(200);
                    echo $jsonData;
                    exit;
                } else {
                    http_response_code(400);
                    echo $jsonData;
                    exit;
                }
            } else {
                $this->unauthenticatedUser();
            }
        } catch (Exception $e) {
            $this->serverError($e);
        }
    }
    public function updateDescription(): void
    {

        header('Content-Type: application/json');
        if (isset ($_SESSION["user"])) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $response = $this->userService->updateDescription($requestData);
            if ($response['success']) {
                http_response_code(200);
                $jsonData = json_encode($response);
                echo $jsonData;
            } else {
                http_response_code(400);
                $jsonData = json_encode($response);
                echo $jsonData;
            }
        } else {
            $this->unauthenticatedUser();
        }

    }
    public function updateBudget(): void
    {

        header('Content-Type: application/json');
        if (isset ($_SESSION["user"])) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $response = $this->userService->updateBudget($requestData);
            if ($response['success']) {
                http_response_code(200);
                $jsonData = json_encode($response);
                echo $jsonData;
            } else {
                http_response_code(400);
                $jsonData = json_encode($response);
                echo $jsonData;
            }
        } else {
            $this->unauthenticatedUser();
        }

    }
    public function getRole(): void
    {
        header('Content-Type: application/json');
        if (isset ($_SESSION["user"])) {
            $jsonData = json_encode(["role" => $_SESSION['user']['role']]);
            echo $jsonData;
            exit;
        } else {
            // User is not authenticated
            $jsonData = json_encode(['role' => 'guest']);
            echo $jsonData;
            exit;
        }
    }
    public function changePassword(): void
    {
        header('Content-Type: application/json');
        if (isset ($_SESSION['user'])) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $response = $this->userService->changePassword($requestData);
            if ($response['success']) {
                http_response_code(200);
                $jsonData = json_encode($response);
                echo $jsonData;
            } else {
                http_response_code(400);
                $jsonData = json_encode($response);
                echo $jsonData;
            }
        } else
            $this->unauthenticatedUser();
    }
    public function fetchUsersWithSameParameters(): void
    {
        header('Content-Type: application/json');

        $requestData = json_decode(file_get_contents('php://input'), true);
        $response = $this->userService->fetchUsersWithSameParameters($requestData);
        if ($response['success']) {
            http_response_code(200);
            $jsonData = json_encode($response);
            echo $jsonData;
        } else {
            http_response_code(400);
            $jsonData = json_encode($response);
            echo $jsonData;
        }

    }
    public function fetchLastTwelveUsers(): void
    {
        header('Content-Type: application/json');
        $response = $this->userService->fetchLastTwelveUsers();
        if ($response['success']) {
            http_response_code(200);
            $jsonData = json_encode($response);
            echo $jsonData;
        } else {
            http_response_code(500);
            $jsonData = json_encode($response);
            echo $jsonData;
        }

    }
    private function serverError(Exception $e): void
    {
        $jsonData = json_encode(['success' => false, 'message' => "Internal server error:" . $e->getMessage()]);
        http_response_code(500);
        echo $jsonData;
        exit;
    }
    private function unauthenticatedUser(): void
    {
        http_response_code(401);
        $jsonData = json_encode(['success' => false, 'message' => "User is unauthenticated"]);
        echo $jsonData;
        exit;
    }
}