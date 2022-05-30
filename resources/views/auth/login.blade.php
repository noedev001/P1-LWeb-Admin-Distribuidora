
@extends('layouts.app')

@section('content')

<div class="container">
		</br></br></br></br></br>
	<div class="login-wrap cover">
	<div class="container-login">

		<p class="text-center" style="font-size: 80px;">
			<img src="img/user.png"/>
		</p>
		<p class="text-center text-condensedLight" style="color: #1abc9c ; ">Inicia sesión con tu cuenta</p>


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

												<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
													<input id="email" type="email" style="color: #1abc9c ;" class="mdl-textfield__input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

													@if ($errors->has('email'))
															<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('email') }}</strong>
															</span>
													@endif

													<label for="email"  class="mdl-textfield__label">{{('E-Mail Address') }}</label>


												</div>

												<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

														<input id="password" style="color: #1abc9c ;" type="password" class="mdl-textfield__input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

														@if ($errors->has('password'))
																<span class="invalid-feedback" role="alert">
																		<strong>{{ $errors->first('password') }}</strong>
																</span>
														@endif

														<label for="password" class="mdl-textfield__label">{{('Password') }}</label>
												</div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="color: #1abc9c ;">
                                    {{ __('Iniciar') }}
                                </button>
                            </div>
														<div class="col-md-12 offset-md-3">
														<a class="mdl-button mdl-js-button mdl-js-ripple-effect" style="color: #839192 ;" href="http://localhost:8000/"
														>
																{{ __('Regresar') }}
														</a>
														</div>
                        </div>
                    </form>


		</div>
		</div>
</div>
@endsection
