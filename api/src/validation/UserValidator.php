<?php
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class UserValidator
{
    public function validateRegistration(array $userData): array
    {
        $validator = v::key('email', v::email()->setTemplate('Е-адреса није исправна'))
            ->key('password', v::stringType()->length(6, 70)->setTemplate('Лозинка мора да садржи најмање 6, а највише 70 знакова'))
            ->key('confirmPassword', v::equals($userData['password'])->setTemplate('Лозинке се не подударају'))
            ->key('fname', v::stringType()->length(2, 40)->setTemplate('Име мора да садржи најмање 2, а највише 40 знакова'))
            ->key('lname', v::stringType()->length(2, 40)->setTemplate('Презиме мора да садржи најмање 2, а највише 40 знакова'))
            ->key('dob', v::stringType()->date('Y-m-d')->setTemplate('Формат датума рођења није исправан'))
            ->key('gender', v::stringType()->length(1, 20))
            ->key('telephone', v::phone()->setTemplate('Телефонски број није исправан'));
        return $this->validate($validator, $userData);

    }
    public function validateNewUserData(array $userData): array
    {
        $validator = v::key('email', v::email()->setTemplate('Е-адреса није исправна'))
            ->key('fname', v::stringType()->length(2, 40)->setTemplate('Име мора да садржи најмање 2, а највише 40 знакова'))
            ->key('lname', v::stringType()->length(2, 40)->setTemplate('Презиме мора да садржи најмање 2, а највише 40 знакова'))
            ->key('telephone', v::phone()->setTemplate('Телефонски број није исправан'))
            ->key('city', v::stringType()->length(null, 50));

        return $this->validate($validator, $userData);
    }
    public function validatePasswordChange(array $userData): array
    {
        $validator = v::key('password', v::stringType()->length(6, 70)->setTemplate('Лозинка мора да садржи најмање 6, а највише 70 знакова'))
            ->key('confirmPassword', v::equals($userData['password'])->setTemplate('Лозинке се не подударају'));
        return $this->validate($validator, $userData);
    }
    public function validateDescription(array $userData): array
    {
        $validator = v::key('description', v::stringType()->length(0, 255));
        return $this->validate($validator, $userData);
    }
    public function validateBudget(array $userData): array
    {
        $validator = v::key('budget', v::stringType()->notEmpty());
        return $this->validate($validator, $userData);
    }
    public function validateRating(array $userData): array
    {
        $validator = v::key('rating', v::stringType()->between(1, 5)->setTemplate('Ocena mora biti između 1 i 5'));//TODO FIX THIS VALIDATION
        return $this->validate($validator, $userData);
    }
    private function validate($validator, $userData)
    {
        try {
            // Validate user data against the defined rules
            $validator->assert($userData);
            return []; // Return empty array if validation succeeds
        } catch (NestedValidationException $e) {
            // Validation failed, extract error messages and return
            $errors = [];
            foreach ($e->getMessages() as $field => $message) {
                $errors[$field] = $message;
            }
            return $errors; // Return validation error messages
        }
    }
}