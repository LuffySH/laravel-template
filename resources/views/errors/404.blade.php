<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page not found</title>
</head>
<body>
<h1>Page not found</h1>

<p>Contact email <a href="mailto:{{Settings::adminSettings()->get('contact.email')}}">
        {{Settings::adminSettings()->get('contact.email')}} </a>
    for supporting</p>
<p>
    <a href="{{route('home')}}">Click here</a> to back to home page.
</p>
</body>
</html>