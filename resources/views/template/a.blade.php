<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="log/css/normalize.css">
	<link rel="stylesheet" href="log/css/sweetalert2.css">
	<link rel="stylesheet" href="log/css/material.min.css">
	<link rel="stylesheet" href="log/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="log/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="log/css/main.css">

  <!-- Favicons -->
  <link href="img/favicon.ico" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

	<script src="log/js/material.min.js" ></script>

</head>
<body background="img/fontLogin.jpg" style=" background-repeat: no-repeat; background-size: 100% 100%; background-attachment: fixed;">
	<div class="login-wrap cover">
		<div class="container-login">
			<p class="text-center" style="font-size: 80px;">
				<img src="img/user.png"/>
			</p>
			<p class="text-center text-condensedLight" style="color: #1abc9c ; ">Inicia sesión con tu cuenta</p>
			<form method="POST" action="{{ route('login') }}">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input id="email" type="email" class="mdl-textfield__input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

					@if ($errors->has('email'))
							<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
							</span>
					@endif

					<label for="email" class="mdl-textfield__label">{{ __('E-Mail Address') }}</label>


				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

						<input id="password" type="password" class="mdl-textfield__input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

						@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('password') }}</strong>
								</span>
						@endif

						<label for="password" class="mdl-textfield__label">{{ __('Password') }}</label>
				</div>
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" style="color: #1abc9c ; margin: 0 auto; display: block;">
                        INICIAR SESION
        </button>
			</form>
		</div>
	</div>
</body>
</html>
