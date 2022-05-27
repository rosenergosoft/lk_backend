<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model {

    protected $table = 'company_information';

    static $fields = [
        [
            'name' => 'name',
            'field_name'=> 'Название'
        ],
        [
            'name' => 'short_name',
            'field_name'=> 'Короткое название'
        ],
        [
            'name' => 'address',
            'field_name'=> 'Юридический адрес'
        ],
        [
            'name' => 'phone1',
            'field_name'=> 'Номер телефона 1'
        ],
        [
            'name' => 'phone2',
            'field_name'=> 'Номер телефона 2'
        ],
        [
            'name' => 'email',
            'field_name'=> 'Email'
        ],
    ];

    static function getValue($collection, $name) {
        $item = $collection->firstWhere('name', $name);
        return $item->value ?? "";
    }
}
