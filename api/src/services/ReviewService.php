<?php
class ReviewService
{
    private UserModel $model;
    private UserValidator $userValidator;
    public function __construct(UserModel $model, UserValidator $userValidator)
    {
        $this->model = $model;
        $this->userValidator = $userValidator;
    }
    public function fetchOtherUserProfileByEmail(string $email): array
    {
        $user = $this->model->fetchOtherUserProfileByEmail($email);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Database error'];
        }
    }
    public function rateUser(array $requestData): array
    {
        $errors = $this->userValidator->validateRating($requestData);
        $success = $this->model->rateUser($requestData['rating'], $requestData['email']);
        if ($success) {
            return ['success' => true, 'message' => 'User is rated'];
        } else
            return ['success' => false, 'message' => 'User is not rated'];
    }

}