<?php
class LoginLogoutController
{
    private UserModel $userModel;
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    public function logout(): void
    {
        try {
            header('Content-Type: application/json');
            // Check if the user is logged in
            if (isset ($_SESSION['user'])) {
                // Destroy the session
                session_destroy();
                $jsonData = json_encode(['success' => true, 'message' => 'User has been logged out']);
                http_response_code(200);
                echo $jsonData;
                exit;
            } else {
                $jsonData = json_encode(['success' => false, 'message' => 'User is not logged in']);
                http_response_code(401);
                echo $jsonData;
                exit;
            }
        } catch (Exception $e) {
            $jsonData = json_encode(['success' => false, 'message' => "Internal server error:" . $e->getMessage()]);
            http_response_code(500);
            echo $jsonData;
            exit;
        }
    }
    public function login(): void
    {
        try {
            header('Content-Type: application/json');
            // Check if the user is already logged in
            if (isset ($_SESSION['user'])) {
                // User is already logged in, return an appropriate response
                $jsonData = json_encode(['success' => false, 'message' => 'User is already logged in']);
                http_response_code(400);
                echo $jsonData;
                exit;
            }

            $requestData = json_decode(file_get_contents('php://input'), true);
            // Call model
            $success = $this->userModel->login($requestData['email'], $requestData['password']);
            if ($success) {
                http_response_code(201);
                $response = ['success' => true, 'message' => 'User has logged in'];
                $jsonData = json_encode($response);
                echo $jsonData;
                exit;
            } else {
                http_response_code(401);
                $response = ['success' => false, 'message' => 'Incorrect email or password'];
                $jsonData = json_encode($response);
                echo $jsonData;
                exit;
            }
        } catch (Exception $e) {
            $jsonData = json_encode(['success' => false, 'message' => "Internal server error:" . $e->getMessage()]);
            http_response_code(500);
            echo $jsonData;
            exit;
        }
    }
}