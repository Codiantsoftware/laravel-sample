<?php
use App\Http\Controllers\Frontend\Auth\{
    LoginController,
    RegisterController
};
use Illuminate\Support\Facades\Route;


Route::group(
    ['middleware' => ['check.login:web']],
    function () {
    	// login route
        Route::controller(LoginController::class)
            ->group(
                function () {
                    Route::get('/login', 'index')->name('login');
                    Route::post('/login', 'login')->name('login.submit');



                }
            );
        // register route
        Route::controller(RegisterController::class)
        ->group(
            function () {
                Route::get('/register', 'index')
                    ->name('user.signup-form');
                Route::post('/user-signup', 'register')->name('user.signup');
            }
        );
    }
);
