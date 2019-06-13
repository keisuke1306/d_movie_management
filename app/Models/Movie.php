<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $table = 'movie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'title',
        'video_id',
        'status',
        'point',
        'access_count',
        'description',
        'thumbnail',
        'memo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
