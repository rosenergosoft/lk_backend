<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'type',
        'hash',
        'sign',
        'sms_code'
    ];

    const TYPE_SMS = 'sms';
    const TYPE_EDS = 'eds';
}
