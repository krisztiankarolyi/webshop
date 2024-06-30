<?php
class User {
    private $collection;
    private $id;
    private $email;
    private $password;
    private $name;

    public function __construct($db) {
        $this->collection = $db->users; // a kollekció neve 'users'
    }

    public function login($email, $password) {
        $user = $this->collection->findOne(['email' => $email]);
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['_id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        } else {
            return false;
        }
    }

    // Setterek
    public function setId($id) {
        $this->id = new MongoDB\BSON\ObjectId($id);
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Getterek
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    // Metódusok
    public function save() {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name
        ];

        if ($this->id) {
            // Update meglévő felhasználó
            $result = $this->collection->updateOne(
                ['_id' => $this->id],
                ['$set' => $data]
            );
            return $result->getModifiedCount() > 0;
        } else {
            // Új felhasználó létrehozása
            $result = $this->collection->insertOne($data);
            $this->id = $result->getInsertedId();
            return $result->getInsertedCount() > 0;
        }
    }

    // Email alapján keresés
    public static function findByEmail($db, $email) {
        $collection = $db->users;
        $user = $collection->findOne(['email' => $email]);

        if ($user) {
            $userData = [
                '_id' => (string)$user['_id'],
                'email' => $user['email'],
                'password' => $user['password'],
                'name' => $user['name']
            ];

            $userObj = new User($db);
            $userObj->setId($user['_id']);
            $userObj->setEmail($user['email']);
            $userObj->setPassword($user['password']);
            $userObj->setName($user['name']);
            return $userObj;
        } else {
            return null;
        }
    }
}
?>
