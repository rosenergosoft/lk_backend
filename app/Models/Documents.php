<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    static public function getAllPrepared($id = null): array
    {
        $out = [
            'phys' => [],
            'yur' => []
        ];
        if ($id){
            $userId = $id;
        } else {
            $userId = auth()->user()->id;
        }
        $documents = self::with(['signature'])->where('user_id', $userId)->get();
        foreach ($documents as $doc) {
            if ($doc->type === Documents::TYPE_PERSONAL_ID || $doc->type === Documents::TYPE_PROXY) {
                $out['phys'][] = $doc;
            } else {
                $out['yur'][] = $doc;
            }
        }

        return $out;
    }

    public function signature(): HasOne
    {
        return $this->hasOne(DocumentSignature::class,'document_id');
    }
}
