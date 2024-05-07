@extends('layouts.frontend.app')
@section('title','Login')
@section('content')

<div class="nk-content ">
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="{{route('frontend.home')}}" class="logo-link">
                {{getAppName()}}
            </a>
        </div>
        <div class="card">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Login</h4>
                        <div class="nk-block-des">
                            <p>Access the User panel using your email and password.</p>
                        </div>
                    </div>
                </div>
                <form action="{{route('login.submit')}}" method="post" id="frontend-login-form" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="javascript:void(0);"
                                class="form-icon form-icon-right passcode-switch lg"
                                data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" name="remember" id="remember" value="1" class="custom-control-input">
                            <label class="custom-control-label" for="remember">Remember Me</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="signInBtn" class="btn btn-lg btn-primary btn-block">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Frontend\LoginRequest','#frontend-login-form') !!}
{!! returnScriptWithNonce(asset_path('assets/js/frontend/auth/login.js')) !!}
@endpush
