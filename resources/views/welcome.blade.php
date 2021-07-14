@extends('layouts.main')

@section('main')
    <section>
        <h2>About me</h2>
        <p>I am a <a href="https://www.php.net/">PHP</a> developer with about nine years experience. I have briefly looked into some other languages but keep coming back to PHP.</p>
        <p><a href="https://laravel.com">Laravel</a> is my PHP framework of choice and I still enjoy digging into core PHP.</p>
        <p>I have no real desire to become a "full-stack developer", although I don't mind <em>some</em> basic - intermediate <a href="https://en.wikipedia.org/wiki/JavaScript">JavaScript</a>. With <a href="https://vuejs.org/">VueJS</a> preferably.</p>
    </section>
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
@endsection