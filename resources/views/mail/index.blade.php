<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body style="background: -webkit-linear-gradient(to bottom right, #c31432, #240b36); background: linear-gradient(to bottom right, #c31432, #240b36); padding: 20px;">
    <div style="width: 70%;margin: 20px auto;padding: 20px;background: #FFF;text-align: center; border-radius: 10px;">
        <h2 style="font-size: 36px;">WELCOME!</h2>

        <p>{{ $data['subject'] }}</p>
        <b><p style="text-align:center;">{{ $data['user'] }}</p></b>

        <div style="margin: 2px 10px; border-bottom: 1px solid #dfe4ea;"></div>

        <div style="padding: 20px 35px;border-radius: 15px;width: 60%; margin: auto;">

            @isset($data['new_name'])
                <p><b>Name and Surname:</b> {{ $data['new_name'] }}</p>
            @endisset

            @isset($data['login'])
                <p><b>Login:</b> {{ $data['login'] }}</p>
            @endisset

            @isset($data['password'])
                <p><b>Password:</b> {{ $data['password'] }}</p>
            @endisset
            
            @isset($data['rola'])
                <p><b>Role: </b> {{ $data['rola'] }}</p>
            @endisset
            
        </div>

        <div style="margin: 2px 10px; border-bottom: 1px solid #dfe4ea;"></div>

        <p style="font-size: 12px;">To go to the site and log in, click the button below.</p>

        <a href="{{ route('login') }}" class="button" style="background-color: #3498db;border-radius: 10px;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Go to the site</a>
    </div>
</body>
</html>