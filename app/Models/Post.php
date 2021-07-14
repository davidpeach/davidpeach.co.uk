<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'body_raw',
        'body_html',
    ];

    public $dates = [
        'published_at',
    ];

    public function setBodyRawAttribute($bodyRaw)
    {
        $this->attributes['body_raw'] = $bodyRaw;
        $this->attributes['body_html'] = Markdown::convertToHtml($bodyRaw);
    }
}
