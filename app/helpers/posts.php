<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('makePostSlug')) {
    function makePostSlug(Carbon $date, string $title)
    {
        return vsprintf('%s/%s', [
            $date->format('Y/m/d'),
            Str::slug($title),
        ]);
    }
}
