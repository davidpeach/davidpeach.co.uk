<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>David Peach</title>
    <style>
        html, body {
            font-family: sans-serif;
        }
        html {
            font-size: 16px;
        }
        body {
            font-size: 100%;
            padding: .25rem;
        }
        @media screen and (min-width: 38rem) {
            body { font-size: 120%; padding: .5rem;}
        }
        @media screen and (min-width: 48rem) {
            body { font-size: 140%; padding: 1rem;}
        }
        section {
            margin-top: 3em;
        }
        h1 {
            margin-bottom: 0;
        }
        h1 + p {
            font-size: 1.3em;
            margin-top: .25em;
            margin-bottom: 2em;
        }

        p {
            max-width: 48rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <h1>David Peach</h1>
    <p>a personal digital reboot</p>
    @yield('main')
</body>
</html>