<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disclosure extends Model
{
    protected $table = 'disclosure';

    public function docs () {
        return $this->hasMany(DisclosureDocs::class, "disclosure_id", "id");
    }
}
