<x-guest-layout>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <div class="ec-brand">
                            <a href="#" title="Vhan">
                                <img class="ec-brand-icon" src="{{ asset('logo2.webp') }}" alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <h4 class="text-dark mb-5">Sign In</h4>
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="form-control" placeholder="Enter your Email" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                </div>
                                
                                <div class="form-group col-md-12 ">
                                    <x-label for="password" value="{{ __('Password') }}" />
                                    <x-input id="password" class="form-control" placeholder="Enter your Password" type="password" name="password" required autocomplete="current-password" />
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="d-flex my-2 justify-content-between">
                                        <div class="d-inline-block mr-3">
                                            <div class="control control-checkbox">{{ __('Remember me') }}
                                                <input id="remember_me" name="remember" />
                                                <div class="control-indicator"></div>
                                            </div>
                                        </div>
                                        
                                        @if (Route::has('password.request'))
                                        <p><a class="text-blue" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a></p>
                                        @endif
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-block mb-4">{{ __('Log in') }}</button>
                                    
                                    <p class="sign-upp">{{ __("Don't have an account yet ?") }}
                                        <a class="text-blue" href="{{ route('register') }}">Sign Up</a>
                                     </p>
                                    
                                     @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    
                                    <x-validation-errors class="my-2" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-guest-layout>
