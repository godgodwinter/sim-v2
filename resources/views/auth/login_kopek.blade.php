<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='{{asset('/')}}assets/css/kopekstylesheet.css'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <!-- <script src='main.js'></script> --><!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
</head>
<body>
    <div id="container">
        <div id="wrapper " class="row flex-col-reverse">
            <div id="loginForm" class="col-12 col-md-6">
                <h1>Login</h1>
                <span>Sign in to your account</span>
                <div id="inputField">
                    <input type="text" placeholder="Username" autocomplete="nope">
                </div>
                <div id="inputField">
                    <input type="password" placeholder="Password" autocomplete="nope">
                </div>
                <div id="inputSignIn">
                    <input type="submit" value="Login">
                </div>
                <p>Not registered? <a href="#">Create an account</a></p>
            </div>
            <div id="logoCompany" class="col-12 col-md-6">
                <div id="opacity">
                    <a href="#" target="_blank" id="linkLogo">
                        <img src="{{asset('/')}}assets/img/kopek/github.png" alt="Your Logo">
                    </a>
                    <p>
                        Your Company Name
                    </p>
                </div>
            </div>
        </div>
        <div id="credit">
            <p>
                Designed with
                <box-icon name='heart' type='solid' color='#ff1014' size="xs"></box-icon>
                by <a href="https://baemon.web.id/" target="_blank">Baemon Team</a>
            </p>
        </div>
        <div id="icon">
            <box-icon name='github' type='logo' animation='tada-hover' size='md'></box-icon>
        </div>
    </div>
</body>
</html>
