<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disclosure extends Model
{
    protected $fillable = [
        'content',
        'is_show',
        'is_processed',
        'disclosure_label_id',
        'client_id',
        'group_by'
    ];
    protected $table = 'disclosure';

    public function docs (): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DisclosureDocs::class, "disclosure_id", "id");
    }

    public function disclosureList() {
        return $this->belongsTo(DisclosureList::class, 'disclosure_label_id', 'id');
    }
}
