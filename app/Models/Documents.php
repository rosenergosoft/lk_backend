<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    const TYPE_PERSONAL_ID = 'personal_id';
    const TYPE_PROXY = 'proxy';

    const TYPE_YUR_PROXY = 'yur_proxy';
    const TYPE_YUR_USTAV = 'yur_ustav';
    const TYPE_YUR_PRIKAZ = 'yur_prikaz';
    const TYPE_YUR_SGR = 'yur_sgr';
    const TYPE_YUR_SPZUN = 'yur_spzun';
}
