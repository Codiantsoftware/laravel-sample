<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\Frontend\SignupRequest;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest')->except(['register']);
    }

    /**
     * Display the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle user registration.
     *
     * @param SignupRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(SignupRequest $request)
    {
        // Create new user
        $this->userRepository->createUser($request->all());

        // Return success response
        return $this->successResponse(trans('auth.register_successfully'));
    }

}
