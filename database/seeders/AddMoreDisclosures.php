<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddMoreDisclosures extends Seeder
{
    protected $table = 'disclosure_list';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'type' => '19g8',
            'type_label' => '19г-8',
            'group' => '0', // электричество
            'title' => 'О вводе в ремонт и выводе из ремонта электросетевых объектов с указанием сроков (сводная информация)',
            'deadline' => 'Отчитаться не позднее 1 [NEXT_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'monthly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19d',
            'type_label' => '19д',
            'group' => '0', // электричество
            'title' => 'О наличии (об отсутствии) технической возможности доступа к регулируемым товарам, работам и услугам субъектов естественных монополий и о регистрации и ходе реализации заявок на технологическое присоединение к электрическим сетям',
            'deadline' => 'Отчитаться не позднее 1 [NEXT_MONTH] [YEAR] г. [FREQUENCY] (в отношении трансформаторных подстанций 35 кВ и выше)',
            'frequency' => 'monthly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19i',
            'type_label' => '19и',
            'group' => '0', // электричество
            'title' => 'О порядке выполнения технологических, технических и других мероприятий, связанных с технологическим присоединением',
            'deadline' => '',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19l',
            'type_label' => '19л',
            'group' => '0', // электричество
            'title' => 'Об основных этапах обработки заявок',
            'deadline' => 'Подлежит доведению до сведения заявителей с момента поступления заявки с использованием личного кабинета заявителя',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19m',
            'type_label' => '19м',
            'group' => '0', // электричество
            'title' => 'Об объеме и о стоимости электрической энергии',
            'deadline' => 'Отчитаться не позднее 1 [NEXT_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'monthly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19n',
            'type_label' => '19н',
            'group' => '0', // электричество
            'title' => 'Об отчетах о реализации инвестиционной программы',
            'deadline' => 'Отчитаться до: 01 [NEXT_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19r',
            'type_label' => '19р',
            'group' => '0', // электричество
            'title' => 'О лицах, намеревающихся перераспределить максимальную мощность',
            'deadline' => 'Отчитаться в течение 5 рабочих дней со дня получения заявления от лица по письменному запросу',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19t',
            'type_label' => '19т',
            'group' => '0', // электричество
            'title' => 'Об объеме и о стоимости электрической энергии',
            'deadline' => 'Отчитаться не позднее 1 [NEXT_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'monthly',
            'deadline_month' => 0
        ];

        DB::table($this->table)->insert($data);
    }
}
