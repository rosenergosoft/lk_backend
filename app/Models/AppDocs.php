<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppDocs extends Model
{
    protected $table = 'app_docs';

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
