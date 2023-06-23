<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to My Site</title>
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
            width: 100%; /* Added width property */

        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Hi {{ $data['name'] }}!</h1>
        <p>This is a quick reminder that in order to start tracking time, you need to download the desktop app. WorkLog for Windows.</p>
        <p>Click the download button below:</p>
        
        <a href= "https://mega.nz/file/1bY1QbgD#mTHJZW-_uNdD5GmNjeYAjkdWuZizvQvTL9gC7CLlRdc">Download Here</a>

        <p>Your Username and password are below:</p>
        <p>Username: {{ $data['email'] }} </p>
        <p>Password: {{ $data['password'] }}</p>

        <p><b>Please keep this information safe and secure.</b></p>
    </div>
</body>
</html>
