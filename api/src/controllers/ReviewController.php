<?php
class ReviewController
{
    private ReviewService $userService;
    public function __construct(ReviewService $userService)
    {
        $this->userService = $userService;
    }
    public function fetchOtherUserProfileByEmail(): void
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        header('Content-Type: application/json');
        $response = $this->userService->fetchOtherUserProfileByEmail($requestData['email']);
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
    }
    public function rateUser()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if (isset ($_SESSION['user'])) {
            if ($_SESSION['user']['email'] !== $requestData['email']) {
                $response = $this->userService->rateUser($requestData);
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
                http_response_code(401);
                $jsonData = json_encode(['success' => false, 'message' => 'You cannot rate yourself']);
                echo $jsonData;
            }
        } else {
            $this->unauthenticatedUser();
        }
    }
    private function unauthenticatedUser(): void
    {
        http_response_code(401);
        $jsonData = json_encode(['success' => false, 'message' => "User is unauthenticated"]);
        echo $jsonData;
        exit;
    }
}