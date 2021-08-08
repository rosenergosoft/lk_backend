<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DisclosureList extends Model
{
    protected $table = 'disclosure_list';

    public function disclosure () {
        return $this->hasOne(Disclosure::class, 'disclosure_label_id', 'id')
            ->where('disclosure.user_id', Auth::user()->id);
    }
}
