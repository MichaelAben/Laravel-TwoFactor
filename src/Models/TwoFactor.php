<?php

namespace MabenDev\TwoFactor\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
    protected $fillable = [
        'user_id',
        'secret',
        'setup',
    ];

    protected $casts = [
        'setup' => 'boolean',
    ];
}
