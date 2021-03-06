<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisclosureChanges extends Seeder
{
    protected $table = "disclosure_list";
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'type' => '15b',
            'type_label' => '15б',
            'group' => '2',
            'title' => 'Об утвержденных тарифах на техническую воду',
            'deadline' => 'Отчитаться единожды и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '15v',
            'type_label' => '15в',
            'group' => '2',
            'title' => 'Об утвержденных тарифах на транспортировку воды',
            'deadline' => 'Отчитаться единожды и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '15g',
            'type_label' => '15г',
            'group' => '2',
            'title' => 'Об утвержденных тарифах на подвоз воды',
            'deadline' => 'Отчитаться единожды и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '15zh',
            'type_label' => '15ж',
            'group' => '2',
            'title' => 'О результатах технического обследования централизованных систем холодного водоснабжения, в том числе о фактических значениях показателей технико-экономического состояния централизованных систем холодного водоснабжения',
            'deadline' => 'Отчитаться единожды и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '24d',
            'type_label' => '24д',
            'group' => '2',
            'title' => 'Регламент подключения к централизованной системе холодного водоснабжения, утверждаемый регулируемой организацией, включающий сроки, состав и последовательность действий при осуществлении подключения к централизованной системе холодного водоснабжения',
            'deadline' => 'Отчитаться единожды и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        DB::table($this->table)->insert($data);
    }
}
