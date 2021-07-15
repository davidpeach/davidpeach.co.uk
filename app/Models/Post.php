<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body_raw',
        'body_html',
        'status',
        'slug',
        'published_at',
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
