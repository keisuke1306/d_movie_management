<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily_access extends Model
{
    protected $table = 'daily_access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'access_date',
        'access_count',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
