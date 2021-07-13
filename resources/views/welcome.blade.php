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
    <section>
        <h2>Open-source Projects</h2>
        <ul>
            <li>
                <h3>Composer Manuscript</h3>
                <p><a href="https://github.com/davidpeach/composer-manuscript">View on Github</a></p>
                <p>A tool to quickly set up a local environment for developing PHP composer packages.</p>
            </li>
            <li>
                <h3>Laravel Base Command</h3>
                <p><a href="https://github.com/davidpeach/laravel-base-command">View on Github</a></p>
                <p>A little base package to help create an automated setup flow in a fresh Laravel project.</p>
            </li>
            <li>
                <h3>Laravel / Vue / Typescript Shopify App Scaffolder</h3>
                <p><a href="https://github.com/davidpeach/laravel-shopify-app-scaffolder">View on Github</a></p>
                <p>Quick-starting shopify app development in Laravel. Using Vue JS and Typescript too. Builds on top of Laravel Base Command <small>(see above)</small>.</p>
            </li>
        </ul>
    </section>
    <section>
        <h2>About this site</h2>
        <p>This will be my brand new home on the web and is starting off intentionally minimal / empty.</p>
        <p>You can still read my posts over on <a href="https://davidpeach.co.uk">davidpeach.co.uk</a>.</p>
        <p>My intention is to build this new site up over time as a way for me to get back deep into PHP development.</p>
        <p>My current job has me split between Laravel and JavaScript, so I needed to tip the balance back in PHP's favour. :P</p>
    </section>
</body>
</html>