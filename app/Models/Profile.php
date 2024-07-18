<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'profiles';

    protected $fillable = [
        'age',
        'biodata',
        'address',
        'user_id'
    ];
}
