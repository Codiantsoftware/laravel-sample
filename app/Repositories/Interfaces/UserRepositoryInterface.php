<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Method stateList
     *
     * @param id $id 
     *
     * @return User
     */
    public function getUser(int $id): ?User;

    /**
     * Method createUser
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Method updateUser
     *
     * @param array $data 
     * @param int   $id 
     * @param ?User $user [explicite description]
     *
     * @return void
     */
    public function updateUser(array $data, int $id, ?User $user = null): User;

    /**
     * Method sendOtp
     *
     * @param User $user [explicite description]
     *
     * @return bool
     */
    public function sendOtp(User $user): bool;

    /**
     * Method checkLogin
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function checkLogin(array $data): User;

    /**
     * Method verifyOtp
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function verifyOtp(array $data): User;

    /**
     * Method updatePassword
     *
     * @param array $data [explicite description]
     *
     * @return bool
     */
    public function updatePassword(array $data): bool;

    /**
     * Method getUserList
     *
     * @param array $data 
     * @param bool  $paginate 
     *
     * @return User|LengthAwarePaginator
     */
    public function getUserList(array $data, bool $paginate = true): User|LengthAwarePaginator;

    /**
     * Method changeStatus
     *
     * @param array $data 
     * @param int   $id 
     *
     * @return bool
     */
    public function changeStatus(array $data, int $id): bool;

    /**
     * Method getUserDetail
     *
     * @param int $id [explicite description]
     *
     * @return User
     */
    public function getUserDetail(int $id): ?User;

    /**
     * Method deleteUser
     *
     * @param User $user [explicite description]
     *
     * @return bool
     */
    public function deleteUser(User $user): bool;
    
    /**
     * Method getLatestUsers
     *
     * @param int $limit [explicite description]
     *
     * @return object
     */
    public function getLatestUsers(int $limit): object;
}
