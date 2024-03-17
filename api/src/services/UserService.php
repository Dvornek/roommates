<?php
class UserService
{
    private UserModel $userModel;
    private UserValidator $userValidator;
    public function __construct(UserModel $userModel, UserValidator $userValidator)
    {
        $this->userModel = $userModel;
        $this->userValidator = $userValidator;
    }
    public function fetchUser(string $email): array
    {
        $user = $this->userModel->fetchUserByEmail($email);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else
            return ['success' => false, 'message' => "User is not found"];
    }
    public function createUser(array $requestData): array
    {
        try {
            // If validation fails, $errors(array) will contain error messages
            $errors = $this->userValidator->validateRegistration($requestData);
            $email = $requestData['email'];
            $password = $requestData['password'];
            $fname = $requestData['fname'];
            $lname = $requestData['lname'];
            $dob = $requestData['dob'];
            $gender = $requestData['gender'];
            $telephone = $requestData['telephone'];
            //If email is not unique add email to $errors
            if (!$this->userModel->isEmailUnique($email))
                $errors['email'] = 'Е-адреса се већ користи';
            if (empty ($errors)) {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $userId = $this->userModel->save($email, $hashedPassword, $fname, $lname, $dob, $gender, $telephone);
                if ($userId) {
                    // Set session data
                    $_SESSION['user'] = [
                        'userId' => $userId,
                        'email' => $email,
                        'fname' => $fname,
                        'lname' => $lname,
                        'dob' => $dob,
                        'gender' => $gender,
                        'telephone' => $telephone,
                        'role' => 'user'
                    ];
                    return ['success' => true, 'message' => 'User has been created'];
                } else
                    return ['success' => false, 'message' => 'Database error'];
            } else
                return ['success' => false, 'message' => 'Validation errors', 'errors' => $errors];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Internal server error from service: ' . $e->getMessage()];
        }
    }
    public function updateUser(array $requestData): array
    {
        try {
            // If validation fails, $errors will contain error messages
            $errors = $this->userValidator->validateNewUserData($requestData);

            $email = $requestData['email'];
            $fname = $requestData['fname'];
            $lname = $requestData['lname'];
            $telephone = $requestData['telephone'];
            $city = $requestData['city'];
            $oldEmail = $_SESSION['user']['email'];
            $userId = $_SESSION['user']['userId'];
            // Check if email is changed, and if so, check uniqueness
            if ($oldEmail !== $email && !$this->userModel->isEmailUnique($email)) {
                $errors['email'] = 'Email is already used';
            }
            if (empty ($errors)) {
                $success = $this->userModel->updateUser($userId, $email, $fname, $lname, $telephone, $city);
                if ($success) {
                    // Set session data
                    $_SESSION['user'] = [
                        'userId' => $userId,
                        'email' => $email,
                        'fname' => $fname,
                        'lname' => $lname,
                        'telephone' => $telephone,
                        'role' => 'user'
                    ];
                    return ['success' => true, 'message' => 'User has been updated'];
                } else
                    return ['success' => false, 'message' => 'Database error'];
            } else
                return ['success' => false, 'message' => 'Validation errors', 'errors' => $errors];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Internal server error from service: ' . $e->getMessage()];
        }
    }
    public function changePassword(array $userData): array
    {
        // If validation fails, $errors will contain error messages
        $errors = $this->userValidator->validatePasswordChange($userData);
        if (empty ($errors)) {
            $userId = $_SESSION['user']['userId'];
            // Hash password
            $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
            $success = $this->userModel->changePassword($hashedPassword, $userId);
            if ($success)
                return ['success' => true, 'message' => 'Password is changed'];
            else
                return ['success' => false, 'message' => 'Database error'];
        } else
            return ['success' => false, 'message' => "Passwords do not match"];
    }
    public function updateDescription(array $userData): array
    {
        $errors = $this->userValidator->validateDescription($userData);
        if (empty ($errors)) {
            $success = $this->userModel->updateDescription($userData['description'], $_SESSION['user']['userId']);
            if ($success)
                return ['success' => true, 'message' => 'Description is updated'];
            else
                return ['success' => false, 'message' => "Database error"];
        } else
            return ['success' => false, 'errors' => $errors];
    }
    public function updateBudget(array $userData): array
    {
        $errors = $this->userValidator->validateBudget($userData);
        if (empty ($errors)) {
            $success = $this->userModel->updateBudget($userData['budget'], $_SESSION['user']['userId']);
            if ($success)
                return ['success' => true, 'message' => 'Budget is updated'];
            else
                return ['success' => false, 'message' => "Database error"];
        } else
            return ['success' => false, 'errors' => $errors];
    }
    public function fetchUsersWithSameParameters(array $requestData): array
    {
        $users = $this->userModel->fetchUsersWithSameParameters($requestData);
        if ($users)
            return ['success' => true, 'user' => $users];
        else
            return ['success' => false, 'message' => "No users found with that criteria"];
    }
    public function fetchLastTwelveUsers(): array
    {
        $users = $this->userModel->fetchLastTwelveUsers();
        if ($users) {
            return ["success" => true, "users" => $users];
        } else
            return ["success" => false, "users" => []];
    }
}