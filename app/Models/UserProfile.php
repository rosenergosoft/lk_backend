<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'account',
        'pasport',
        'pasport_granted_by',
        'pasport_date',
        'reg_address',
        'phys_address'
    ];
}
