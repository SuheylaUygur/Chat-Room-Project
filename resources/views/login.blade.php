
@vite(['resources/css/login.css','resources/css/alert.css', 'resources/js/app.js'])
<br><br>
@if (count($errors) > 0)
<div class="alert alert-danger">
  <ul>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
  </ul>
</div>
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
<h2>Sign in/up Form</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="/register" method="POST">
			@csrf
			<h1>Create Account</h1>
			<input type="text" placeholder="first name" name="fname" />
            <input type="text" placeholder="last name" name="lname" />
			<input type="email" placeholder="email" name="email" />
            <input type="text" placeholder="username" name="username"/>
			<input type="password" placeholder="password" name="password" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="/login" method="POST">
			@csrf
			<h1>Sign in</h1>
			<input type="email" name="email" placeholder="email" />
			<input type="password" name="password" placeholder="password" />
			<button>Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start chat with people</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>


