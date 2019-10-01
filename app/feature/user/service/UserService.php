<?php


namespace App\feature\user\service;


use App\feature\user\repository\UserRepository;

class UserService
{
    private $userRepository;

    public $user_id;

    public function __construct() {

        $this->userRepository = new UserRepository();
    }

    public function getUsers() {
        $user_repository = $this->userRepository;

        return $user_repository->get();
    }

    public function getUser() {
        $user_repository = $this->userRepository;

        return $user_repository->getUser($this->user_id);
    }

    public function saveUser($data) {
        $user_repository = $this->userRepository;

        return $user_repository->saveUser($data);
    }

    public function editUser($data) {
        $user_repository = $this->userRepository;

        $user_repository->update($data, [
            'user_id' => $this->user_id
        ]);

        return $this->getUser();
    }

    public function deleteUser(string $user_id) {
        $user_repository = $this->userRepository;

        return $user_repository->delete([
            'user_id' => $user_id
        ]);
    }
}