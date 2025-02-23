@extends('layouts.app')

@section('content')
    <section style="height: 100%">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5">{{ __('auth.login') }}</h3>
                            <form method="POST" action="{{ route('login') }}" id="form_f4jkd23" onsubmit="event.preventDefault();submitPost('g-recaptcha-response', this.id);">
                                @csrf
                                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                <input type="hidden" name="action" value="validate_captcha">
                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           placeholder="{{ __('auth.email') }}" value="{{ old('email') }}" required
                                           autocomplete="email"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="{{ __('auth.password') }}" required
                                           autocomplete="current-password"/>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label ps-2" for="remember">
                                        {{ __('auth.remember') }}
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-own-primary btn-lg"
                                            type="submit">{{ __('auth.login_btn') }}</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between bd-highlight mb-3 mt-2">
                                <div class="p-2 bd-highlight"><a
                                        href="{{ route('register') }}">{{ __('layout.menu_register') }}</a></div>
                                <div class="p-2 bd-highlight"></div>
                                <div class="p-2 bd-highlight"><a
                                        href="{{ route('password.request') }}">{{ __('auth.forgot_pass') }}</a></div>
                            </div>
                            {{--<hr class="my-4">
                            <div class="d-grid gap-2 mb-2">
                                <a href="{{route('oauth.apple-login')}}" class="btn btn-block btn-social"
                                   style="background-color: #050708; color: white">
                                    <span class="fa-brands fa-apple"></span> {{__('auth.login_apple')}}
                                </a>
                            </div>
                            <div class="d-grid gap-2 mb-2">
                                <a href="{{route('oauth.microsoft-login')}}"
                                   class="btn btn-block btn-social btn-microsoft">
                                    <span class="fa-brands fa-microsoft"></span> {{__('auth.login_microsoft')}}
                                </a>
                            </div>
                            <div class="d-grid gap-2 mb-2">
                                <a href="{{route('oauth.google-login')}}" class="btn btn-block btn-social btn-google">
                                    <span class="fa-brands fa-google"></span> {{__('auth.login_google')}}
                                </a>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
