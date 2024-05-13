<?php

namespace App\Repositories;

use App\Models\User as UserModel;

class UserRepository
{
    public $errors = [];
    public $userModel;

    /**
     * Constructor
     * 
     * @param UserModel $userModel
     *
     * @return void
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Create User
     * 
     * @param array $data
     *
     * @return UserModel
     */
    public function save(array $data)
    {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($this->userModel->save($data)) {
            return $this->userModel->getByEmail($data['email']); 
        }
    }

    /**
     * Check has same name
     * 
     * @param string $email
     *
     * @return bool
     */
    public function emailExists(string $email)
    {
        return $this->userModel->getByEmail($email);
    }

    /**
     * Get User by id
     * 
     * @param int $id
     *
     * @return User
     */
    public function getById(int $id)
    {
        return $this->userModel->getById($id);
    }

    /**
     * Get User by id
     * 
     * @param int $id
     *
     * @return User
     */
    public static function getUser(int $id)
    {
        $user = new UserModel();
        return $user->getById($id);
    }

    /**
     * Authenticate User
     * 
     * @param string $email
     * @param string $password
     *
     * @return User|bool
     */
    public static function authenticate(string $email, string $password)
    {
        $user = new UserModel();
        $user = $user->getByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }
}
