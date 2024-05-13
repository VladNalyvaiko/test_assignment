<?php

namespace App\Models;

use Core\Model;
use PDO;

class User extends Model
{
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $id;

    public $roles = [
        'admin' => 1,
        'client' => 2
    ];

    /**
     * Get User by email
     * 
     * @param string $email
     *
     * @return User|bool
     */
    public function getByEmail(string $email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Get User by id
     * 
     * @param int $id
     *
     * @return User|bool
     */
    public function getById(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Save User
     * 
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data)
    {
        $sql = 'INSERT INTO users (name, email, password, role_id)
                VALUES (:name, :email, :password_hash, :role_id)';
        
        $stmt = $this->prepareQuery($sql);

        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $data['password_hash'], PDO::PARAM_STR);
        $stmt->bindValue(':role_id', $this->roles['client'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}