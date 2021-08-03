<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opf',
        'inn',
        'name',
        'address',
        'bank_bik',
        'bank_name',
        'bank_corr_account',
        'check_account'
    ];
}
