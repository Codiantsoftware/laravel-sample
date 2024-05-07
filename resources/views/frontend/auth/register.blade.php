@extends('layouts.frontend.app')
@section('title','Create Account')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.2.5/swiper-bundle.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

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
                        <h4 class="nk-block-title">Create Account</h4>
                        {{-- <div class="nk-block-des">
                            <p>Access the User panel using your email and password.</p>
                        </div> --}}
                    </div>
                </div>
                <form id="signupForm1" method="post" action="{{route('user.signup') }}" onsubmit="return false;">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="fum" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="fum" placeholder="Enter your full name">
                    </div>
                    <div class="form-group">
                        <label for="eml" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="eml" placeholder="Enter your Email">
                    </div>

                    <div class="form-group">
                        <label for="pnm" class="form-label">Phone Number</label>
                        <div class="d-flex">
                            <input type="number" inputmode="numeric" name="phone_number" class="form-control" id="pnm" placeholder="Enter your phone number" aria-describedby="pnm-error">
                        </div>

                        <span id="pnm-error" class="help-block error-help-block"></span>
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
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" value="" minlength="8" maxlength="15">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="javascript:void(0);"
                                class="form-icon form-icon-right passcode-switch lg"
                                data-target="password_confirmation">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="Enter confirm password" value="" minlength="8" maxlength="15">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger ripple-effect-dark w-100" id="signupBtn">Sign up</button>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Frontend\SignupRequest','#signupForm1') !!}

<script nonce="{{ csp_nonce('script') }}" src="{{asset_path('assets/js/frontend/auth/register.js')}}"> </script>
@endpush
