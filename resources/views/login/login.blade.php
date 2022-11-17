<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <base href="/">
    <Link rel="shortcut icon" href="public/images/logo/logo.png">
    <link rel="stylesheet" type="text/css" href="resources/css/login.css">
</head>
<body>
    <div class="container">
        <header>LOGIN</header>
        @include('login.alert')
        <form form action="{{route('store')}}" method="POST">
        @csrf
            <div class="input-field">
				<input type="text" name="email" required>
				<label>MNV/Email</label>
			</div>
			<div class="input-field">
				<input class="pswrd" name="password" type="password" required>
				<label>Password</label>
            </div>
            <div class="button">
                <div class="inner"></div>
                <button type="submit" value="login">Login</button>
            </div>
        </form>
    </div>
    <script>
        var hidden = document.querySelector(".alert");
        var close = document.querySelector(".close");
        close.addEventListener("click", ()=>{
            hidden.style.display = 'none';
        });
    </script>
</body>
</html>
