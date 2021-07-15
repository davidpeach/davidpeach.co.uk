<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('makePostSlug')) {
    define('MAX_POST_SLUG_WORDS', 8);
    function makePostSlug(Carbon $date, string $title)
    {
        $titleArray = explode(' ', $title);
        if (count($titleArray) > MAX_POST_SLUG_WORDS) {
            $title = implode(
                ' ',
                array_slice($titleArray, 0, MAX_POST_SLUG_WORDS)
            );
        }

        return vsprintf('%s/%s', [
            $date->format('Y/m/d'),
            Str::slug($title),
        ]);
    }
}

function parseDateForHtmlInput(Carbon $date)
{
    return vsprintf('%sT%s', [
        $date->format('Y-m-d'),
        $date->format('H:i')
    ]);
}
