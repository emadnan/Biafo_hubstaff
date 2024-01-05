<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Password</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            width : 100vh;
        }

        .card {
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 300px;
            text-align: center;
            width: 100%;

        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Hi {{ $data['name'] }}!</h1>
        
        <p>To recover your password, please click the button below, and you will be sent your new password via email.</p>
        <a href="http://10.3.3.80/api/genrateNewPassword/{{$data['id']}}" class="btn btn-link">Forgot Your Password?</a>

        <p><b>Please keep this information safe and secure.</b></p>
    </div>
</body>
</html>
