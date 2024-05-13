<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Core\View;
use App\Middlewares\Web;
use App\Auth;

class Signup extends Web
{
    /**
     * Show the signup page
     * 
     * @return void
     */
    public function index()
    {
        View::renderTemplate('Signup/index.html');
    }

    /**
     * Sign up a new user
     * 
     * @return void
     */
    public function create()
    {
        $data = $_POST;
        $userRepository = new UserRepository(new \App\Models\User);
        $error = $this->validateUser($data, $userRepository);

        if (empty($error)) {
            $user = $userRepository->save($data);
            Auth::login($user);
            $this->redirect('/');
        } else {
            View::renderTemplate(
                'Signup/index.html',
                [
                    'errors' => $error,
                    'data' => $data
                ]
            );
        }
    }

    /**
     * Validate user
     * 
     * @param array          $data
     * @param UserRepository $userRepository
     *
     * @return string|void
     */
    public function validateUser(array $data, UserRepository $userRepository)
    {
        $arrayFiled = [
            'name',
            'email',
            'password'
        ];

        foreach ($arrayFiled as $field) {
            if (!array_key_exists($field, $data) || empty($data[$field])) {
                return $field . ' is required';
            }
        }

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            return 'Invalid email';
        }
        if ($userRepository->emailExists($data['email'])) {
            return 'Email already taken';
        }
        if (strlen($data['password']) < 6) {
            return 'Please enter at least 6 characters for the password';
        }
        if (strlen($data['password']) > 20) {
            return 'Please enter no more than
                20 characters for the password';
        }
        if (preg_match('/.*[a-z]+.*/i', $data['password']) == 0) {
            return 'Password needs at least one letter';
        }
        if (preg_match('/.*\d+.*/i', $data['password']) == 0) {
            return 'Password needs at least one number';
        }
    }
}
