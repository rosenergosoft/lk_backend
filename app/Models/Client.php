<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const TYPE_ELECTRICITY = 1;
    const TYPE_WARM = 2;
    const TYPE_WATER = 3;
    const TYPE_SEWERAGE = 4;

    public function getTypeAttribute($value)
    {
        if ($value){
            return explode(',',$value);
        }
        return [];
    }

    public function setTypeAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['type'] = implode(',',$value);
        }
    }
}
