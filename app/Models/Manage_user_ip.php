<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manage_user_ip extends Model
{
    protected $table = 'manage_user_ip';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_number',
        'movie_id',
        'count_flag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
