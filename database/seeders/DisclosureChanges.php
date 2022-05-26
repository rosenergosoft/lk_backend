<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DisclosureChanges extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'type' => '16v',
            'type_label' => '16в',
            'group' => '0',
            'title' => 'Об утвержденных тарифах на услуги по передаче тепловой энергии, теплоносителя',
            'deadline' => 'Отчитаться до: 1 апреля [YEAR] года',
            'frequency' => 'yearly',
            'deadline_month' => 4
        ];
    }
}
