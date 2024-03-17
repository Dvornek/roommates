<?php
class UserModel
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function isEmailUnique(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email=:email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count == 0;
    }
    public function save(string $email, string $password, string $fname, string $lname, string $dob, string $gender, string $telephone): int|bool
    {
        try {
            $sql = "INSERT INTO users (email, password, fname, lname,dob,gender,telephone) 
                    VALUES (:email, :password, :fname, :lname, :dob, :gender, :telephone)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->execute();
            return (int) $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function fetchUserByEmail(string $email): array|bool
    {
        try {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function updateUser(int $userId, string $email, string $fname, string $lname, string $telephone, string $city): bool
    {
        try {
            $sql = "UPDATE users SET email=:email,fname=:fname,lname=:lname,telephone=:telephone,city=:city WHERE id_user=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":telephone", $telephone);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":id", $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function updateDescription($description, $userId): bool
    {
        try {
            $sql = "UPDATE users SET description=:description WHERE id_user=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":id", $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function updateBudget($budget, $userId): bool
    {
        try {
            $sql = "UPDATE users SET budget=:budget WHERE id_user=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":budget", $budget);
            $stmt->bindParam(":id", $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function changePassword(string $password, $userId): bool
    {
        try {
            $sql = "UPDATE users SET password=:password WHERE id_user=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":id", $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function login(string $email, string $password): bool
    {
        // Find user by email
        $userData = $this->fetchUserByEmail($email);
        if ($userData && password_verify($password, $userData['password'])) {
            $_SESSION['user'] = [
                'userId' => $userData['id_user'],
                'email' => $userData['email'],
                'fname' => $userData['fname'],
                'lname' => $userData['lname'],
                'dob' => $userData['dob'],
                'gender' => $userData['gender'],
                'telephone' => $userData['telephone'],
                'budget' => $userData['budget'],
                'role' => $userData['role']
            ];
            return true;
        } else
            return false;
    }
    public function fetchUsersWithSameParameters(array $parameters): array|false
    {
        try {
            // $sql = "SELECT email,fname,lname,gender,dob,description,avatar,telephone,rating,city,budget FROM users WHERE city=:city AND budget<=:budget";
            $sql = "SELECT email, fname, lname, gender, dob, description, avatar, telephone, rating, city, budget FROM users WHERE city = :city";
            // If $budget is not null, add budget condition to the query
            if (isset ($parameters['budget'])) {
                $sql .= " AND budget <= :budget";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":city", $parameters['city']);
            // Bind budget parameter if it's not null
            if (isset ($parameters['budget'])) {
                $stmt->bindParam(":budget", $parameters['budget']);
            }
            $stmt->execute();
            return $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    public function fetchOtherUserProfileByEmail(string $email): array|bool
    {
        try {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function rateUser(string $rating, string $email): bool
    {
        try {
            $sql = "SELECT rating FROM users WHERE email=:email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $currentRating = $stmt->fetchColumn();
            if ($currentRating)
                $newRating = ($currentRating + $rating) / 2;
            else
                $newRating = $rating;
            $sql = "UPDATE users SET rating=:rating WHERE email=:email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":rating", $newRating);
            $stmt->bindParam(":email", $email);
            return $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function fetchLastTwelveUsers(): array|bool
    {
        try {
            $sql = "SELECT email, fname, lname, rating, budget FROM users ORDER BY id_user DESC LIMIT 12";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}