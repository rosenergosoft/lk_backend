<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoreDisclosures extends Seeder
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
            'type' => '19m',
            'type_label' => '19м',
            'group' => '0',
            'title' => 'Об инвестиционных программах (о проекте инвестиционной программы)',
            'deadline' => 'Не позднее 10 дней со дня утверждения',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19u',
            'type_label' => '19у',
            'group' => '0',
            'title' => 'О выделенных оператором подвижной радиотелефонной связи абонентских номерах и (или) об адресах электронной почты',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '16v',
            'type_label' => '16в',
            'group' => '1',
            'title' => 'Об утвержденных тарифах на услуги по передаче тепловой энергии, теплоносителя',
            'deadline' => 'После подачи заявления в тарифную программу',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '16g',
            'type_label' => '16г',
            'group' => '1',
            'title' => 'Об утвержденной плате за услуги по поддержанию резервной тепловой мощности при отсутствии потребления тепловой энергии',
            'deadline' => 'После подачи заявления в тарифную программу',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18a',
            'type_label' => '18а',
            'group' => '1',
            'title' => 'Наименование юридического лица, фамилия, имя и отчество руководителя регулируемой организации',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18b',
            'type_label' => '18б',
            'group' => '1',
            'title' => 'Основной государственный регистрационный номер, дата его присвоения и наименование органа, принявшего решение о регистрации в качестве юридического лица',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18v',
            'type_label' => '18в',
            'group' => '1',
            'title' => 'Почтовый адрес, адрес фактического местонахождения органов управления регулируемой организации, контактные телефоны, а также (при наличии) официальный сайт в сети "Интернет" и адрес электронной почты',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18g',
            'type_label' => '18г',
            'group' => '1',
            'title' => 'Режим работы регулируемой организации, в том числе абонентских отделов, сбытовых подразделений и диспетчерских служб',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18d',
            'type_label' => '18д',
            'group' => '1',
            'title' => 'Регулируемый вид деятельности',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18e',
            'type_label' => '18е',
            'group' => '1',
            'title' => 'Протяженность магистральных сетей (в однотрубном исчислении) (километров)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18zh',
            'type_label' => '18ж',
            'group' => '1',
            'title' => 'Протяженность разводящих сетей (в однотрубном исчислении) (километров)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18z',
            'type_label' => '18з',
            'group' => '1',
            'title' => 'Количество теплоэлектростанций с указанием их установленной электрической и тепловой мощности (штук)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18i',
            'type_label' => '18и',
            'group' => '1',
            'title' => 'Количество тепловых станций с указанием их установленной тепловой мощности (штук)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18k',
            'type_label' => '18к',
            'group' => '1',
            'title' => 'Количество котельных с указанием их установленной тепловой мощности (штук)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18l',
            'type_label' => '18л',
            'group' => '1',
            'title' => 'Количество центральных тепловых пунктов (штук)',
            'deadline' => 'Заполняется единожды',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19k',
            'type_label' => '19к',
            'group' => '1',
            'title' => 'Об объеме приобретаемой регулируемой организацией тепловой энергии в рамках осуществления регулируемых видов деятельности (тыс. Гкал)',
            'deadline' => 'Ежегодно',
            'frequency' => 'YEARLY',
            'deadline_month' => 12
        ];

        $data[] = [
            'type' => '19u',
            'type_label' => '19у',
            'group' => '1',
            'title' => 'О показателях технико-экономического состояния систем теплоснабжения, в том числе показателях физического износа и энергетической эффективности объектов теплоснабжения',
            'deadline' => 'Ежегодно',
            'frequency' => 'YEARLY',
            'deadline_month' => 12
        ];

        DB::table($this->table)->insert($data);
    }
}
