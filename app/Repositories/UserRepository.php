<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Notifications\OtpVerification;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

       
    /**
     * Method __construct
     *
     * @param User $model [explicite description]
     *
     * @return void
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

        
    /**
     * Method getUser
     *
     * @param int $id [explicite description]
     *
     * @return User
     */
    public function getUser(int $id): ?User
    {
        return $this->model->find($id);
    }

        
    /**
     * Method createUser
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        return $this->create($data);
    
    }

        
    /**
     * Method updateUser
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     * @param ?User $user [explicite description]
     *
     * @return User
     */
    public function updateUser(array $data, int $id, ?User $user = null): User
    {
        if (! $user) {
            $user = $this->getUser($id);
        }
        if (! empty($user) && ! empty($data['profile_image'])) {
            $data['profile_image'] = uploadFile(
                $data['profile_image'],
                config('constants.image.profile.path')
            );
            if (! empty($user->profile_image)) {
                deleteFile($user->profile_image);
            }
        } else {
            unset($data['profile_image']);
        }
        $updated = $this->update($data, $id);
        if ($updated) {
            return $this->getUser($user->id);
        }

        return $user;
    }

        
    /**
     * Method sendOtp
     *
     * @param User $user [explicite description]
     *
     * @return bool
     */
    public function sendOtp(User $user): bool
    {
        $otpExpiryTime = Carbon::now()->addMinutes(config('constants.otp.max_time'));
        $user->otp = generateOtp();
        $user->otp_expires_at = $otpExpiryTime;
        $user->save();
        $user->notify(new OtpVerification($user));

        return true;
    }

        
    /**
     * Method checkLogin
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function checkLogin(array $data): User
    {
        $user = $this->model->where('email', $data['email'])->first();
        if (empty($user)) {
            throw new CustomException(__('message.error.invalid_login_details'));
        }
        //Check profile active
        if (User::STATUS_INACTIVE === $user->status) {
            throw new CustomException(__('message.error.account_is_inactive'));
        }
        //Check for otp verification
        if (! $user->isVerified() && config('constants.verification_required')) {
            // Send otp if email is not verified.
            $this->sendOtp($user);
            throw new CustomException(__('message.error.account_not_verified'));
        }

        return $user;
    }

        
    /**
     * Method verifyOtp
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function verifyOtp(array $data): User
    {
        $user = $this->firstWhere(['email' => $data['email']]);
        if (empty($user)) {
            throw new CustomException(__('message.error.email.not_found'), 400);
        }
        $currentTime = Carbon::now();
        if (empty($user->otp) || $currentTime > $user->otp_expires_at) {
            throw ValidationException::withMessages(['otp' => __('message.error.otp.expired')]);
        }

        throw_if($user->otp != $data['otp'], CustomException::class, __('message.error.otp.not_matched'), 400);

        if ($user->otp == $data['otp']) {
            if (User::VERIFY_TYPE_OTP == $data['type']) {
                return $user;
            }
            $userData = ['otp' => null, 'otp_expires_at' => null];
            if (! empty($data['type']) && User::VERIFY_TYPE_REGISTER == $data['type']) {
                $userData['email_verified_at'] = Carbon::now();
                $userData['status'] = User::STATUS_ACTIVE;
            }
            if (! empty($data['type']) && User::VERIFY_TYPE_RESET == $data['type']) {
                $userData['password'] = $data['password'];
            }
            $this->updateUser($userData, $user->id);

            return $user;
        }
        throw ValidationException::withMessages(['otp' => __('message.error.otp.expired')]);
    }

        
    /**
     * Method updatePassword
     *
     * @param array $data [explicite description]
     *
     * @return bool
     */
    public function updatePassword(array $data): bool
    {
        $user = $this->getUser(getLoggedInUserDetail()->id);
        throw_if(
            empty($user),
            CustomException::class,
            __('message.error.user_not_found'),
            400
        );

        $user->password = $data['password'];
        if ($user->save()) {
            return true;
        }
        throw new CustomException(__('message.error.something_went_wrong'), 400);
    }

        
    /**
     * Method getUserList
     *
     * @param array $data     [explicite description]
     * @param bool  $paginate [explicite description]
     *
     * @return User
     */
    public function getUserList(array $data, bool $paginate = true): User|LengthAwarePaginator
    {
        $sortFields = [
            'id' => 'id',
        ];

        $search = $data['search'] ?? '';
        $name = $data['name'] ?? '';
        $status = $data['status'] ?? '';
        $email = $data['email'] ?? '';
        $offset = $data['start'] ?? '';
        $sortDirection = $data['sortDirection'] ?? 'asc';
        $sort = $sortFields['id'];

        if (array_key_exists('sortColumn', $data) && isset($sortFields[$data['sortColumn']])) {
            $sort = $sortFields[$data['sortColumn']];
        }

        $limit = $data['size'] ?? config('constants.pagination_limit.defaultPagination');
        $this->model->offset($offset);
        $this->model->limit($limit);
        $user = $this->model
            ->when(
                $search,
                function ($q) use ($search): void {
                    $q->where(
                        function ($query) use ($search): void {
                            $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('phone_number', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        }
                    );
                }
            )
            ->when(
                $name,
                function ($q) use ($name): void {
                    $q->where('name', 'like', '%' . $name . '%');
                }
            )
            ->when(
                $status,
                function ($q) use ($status): void {
                    $q->where('status', $status);
                }
            )
            ->when(
                $email,
                function ($q) use ($email): void {
                    $q->where('email', 'like', '%' . $email . '%');
                }
            )
            ->where('user_type', User::TYPE_USER)
            ->orderBy($sort, $sortDirection);
        if (! $paginate) {
            $result = $user->get();
        } else {
            $result = $user->paginate($limit);
        }

        return $result;
    }

        
    /**
     * Method changeStatus
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $data, int $id): bool
    {
        $user = $this->getUser($id);
        if (! empty($user)) {
            return $this->model->where('id', $id)->update(
                [
                    'status' => $data['status'],
                ]
            );
        }
        throw new CustomException(__('message.error.exception.user_not_found'));
    }

        
    /**
     * Method getUserDetail
     *
     * @param int $id [explicite description]
     *
     * @return User
     */
    public function getUserDetail(int $id): ?User
    {
        return $this->model->find($id);
    }

    /**
     * Method deleteUser
     *
     * @param User $user [explicite description]
     *
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

        
    /**
     * Method getLatestUsers
     *
     * @param int $limit [explicite description]
     *
     * @return object
     */
    public function getLatestUsers(int $limit): object
    {
        return $this->model->where('user_type', User::TYPE_USER)->orderBy('id', 'desc')->limit($limit)->get();
    }
}
