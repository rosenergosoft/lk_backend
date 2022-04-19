<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalDisclosures extends Seeder
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
            'type' => '16a',
            'type_label' => '16а',
            'group' => '1', // тепло
            'title' => 'Об утвержденных тарифах на тепловую энергию (мощность)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '16b',
            'type_label' => '16б',
            'group' => '1', // тепло
            'title' => 'Об утвержденных тарифах на теплоноситель, поставляемый теплоснабжающими организациями потребителям, другим теплоснабжающим организациям',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '16d',
            'type_label' => '16д',
            'group' => '1', // тепло
            'title' => 'Об утвержденной плате за подключение (технологическое присоединение) к системе теплоснабжения',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '16e',
            'type_label' => '16е',
            'group' => '1', // тепло
            'title' => 'Об утвержденных тарифах на горячую воду с использованием открытых систем теплоснабжения',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '18',
            'type_label' => '18',
            'group' => '1', // тепло
            'title' => 'Общая информация о регулируемой организации',
            'deadline' => 'Отчитаться единожды, и по мере изменения информации',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19a',
            'type_label' => '19а',
            'group' => '1', // тепло
            'title' => 'О выручке от регулируемого вида деятельности (тыс. рублей) с разбивкой по видам деятельности',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19b',
            'type_label' => '19б',
            'group' => '1', // тепло
            'title' => 'О себестоимости производимых товаров (оказываемых услуг) по регулируемому виду деятельности (тыс. рублей)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19v',
            'type_label' => '19в',
            'group' => '1', // тепло
            'title' => 'О чистой прибыли, полученной от регулируемого вида деятельности',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19g',
            'type_label' => '19г',
            'group' => '1', // тепло
            'title' => 'Об изменении стоимости основных фондов',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19d',
            'type_label' => '19д',
            'group' => '1', // тепло
            'title' => 'О валовой прибыли (убытках) от реализации товаров и оказания услуг по регулируемому виду деятельности (тыс. рублей)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19e',
            'type_label' => '19е',
            'group' => '1', // тепло
            'title' => 'О годовой бухгалтерской отчетности, включая бухгалтерский баланс и приложения к нему',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19zh',
            'type_label' => '19ж',
            'group' => '1', // тепло
            'title' => 'Об установленной тепловой мощности объектов основных фондов',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19z',
            'type_label' => '19з',
            'group' => '1', // тепло
            'title' => 'О тепловой нагрузке по договорам, заключенным в рамках осуществления регулируемых видов деятельности (Гкал/ч)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19i',
            'type_label' => '19и',
            'group' => '1', // тепло
            'title' => 'Об объеме вырабатываемой регулируемой организацией тепловой энергии в рамках осуществления регулируемых видов деятельности (тыс. Гкал)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19l',
            'type_label' => '19л',
            'group' => '1', // тепло
            'title' => 'Об объеме тепловой энергии, отпускаемой потребителям',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19m',
            'type_label' => '19м',
            'group' => '1', // тепло
            'title' => 'О нормативах технологических потерь при передаче тепловой энергии, теплоносителя по тепловым сетям, утвержденных уполномоченным органом (Ккал/ч.мес.)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19n',
            'type_label' => '19н',
            'group' => '1', // тепло
            'title' => 'О фактическом объеме потерь при передаче тепловой энергии (тыс. Гкал)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19o',
            'type_label' => '19о',
            'group' => '1', // тепло
            'title' => 'О среднесписочной численности основного производственного персонала (человек)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19p',
            'type_label' => '19п',
            'group' => '1', // тепло
            'title' => 'О среднесписочной численности административно-управленческого персонала (человек)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19r',
            'type_label' => '19р',
            'group' => '1', // тепло
            'title' => 'Об удельном расходе условного топлива на единицу тепловой энергии',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19c',
            'type_label' => '19с',
            'group' => '1', // тепло
            'title' => 'Об удельном расходе электрической энергии на производство (передачу) тепловой энергии на единицу тепловой энергии',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '19t',
            'type_label' => '19т',
            'group' => '1', // тепло
            'title' => 'Об удельном расходе холодной воды на производство (передачу) тепловой энергии на единицу тепловой энергии, отпускаемой потребителям по договорам',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20a',
            'type_label' => '20а',
            'group' => '1', // тепло
            'title' => 'О количестве аварий на тепловых сетях (единиц на километр)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20b',
            'type_label' => '20б',
            'group' => '1', // тепло
            'title' => 'О количестве аварий на источниках тепловой энергии (единиц на источник)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20v',
            'type_label' => '20в',
            'group' => '1', // тепло
            'title' => 'О показателях надежности и качества, установленных в соответствии с законодательством Российской Федерации',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20g',
            'type_label' => '20г',
            'group' => '1', // тепло
            'title' => 'О доле числа исполненных в срок договоров о подключении (технологическом присоединении)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20d',
            'type_label' => '20д',
            'group' => '1', // тепло
            'title' => 'О средней продолжительности рассмотрения заявок на подключение (технологическое присоединение) (дней)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20e',
            'type_label' => '20е',
            'group' => '1', // тепло
            'title' => 'О выводе источников тепловой энергии, тепловых сетей из эксплуатации',
            'deadline' => 'Отчитаться до: 10 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '20zh',
            'type_label' => '20ж',
            'group' => '1', // тепло
            'title' => 'Об основаниях приостановления, ограничения и прекращения режима потребления тепловой энергии',
            'deadline' => 'Отчитаться до: 10 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21a',
            'type_label' => '21а',
            'group' => '1', // тепло
            'title' => 'О наименовании, дате утверждения и цели инвестиционной программы',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21b',
            'type_label' => '21б',
            'group' => '1', // тепло
            'title' => 'О наименовании органа исполнительной власти субъекта Российской Федерации, утвердившего инвестиционную программу',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21v',
            'type_label' => '21в',
            'group' => '1', // тепло
            'title' => 'О сроках начала и окончания реализации инвестиционной программы',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21g',
            'type_label' => '21г',
            'group' => '1', // тепло
            'title' => 'О потребностях в финансовых средствах, необходимых для реализации инвестиционной программы',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21d',
            'type_label' => '21д',
            'group' => '1', // тепло
            'title' => 'О плановых значениях целевых показателей инвестиционной программы (с разбивкой по мероприятиям)',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21e',
            'type_label' => '21е',
            'group' => '1', // тепло
            'title' => 'О фактических значениях целевых показателей инвестиционной программы',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21zh',
            'type_label' => '21ж',
            'group' => '1', // тепло
            'title' => 'Об использовании инвестиционных средств за отчетный год с разбивкой по кварталам',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня направления годового бухгалтерского баланса в налоговые органы',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '21z',
            'type_label' => '21з',
            'group' => '1', // тепло
            'title' => 'О внесении изменений в инвестиционную программу',
            'deadline' => 'Отчитаться в течение 10 календарных дней со дня принятия органом исполнительной власти субъекта Российской Федерации решения о внесении изменений в инвестиционную программу',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '22a',
            'type_label' => '22а',
            'group' => '1', // тепло
            'title' => 'О количестве поданных заявок на подключение (технологическое присоединение) к системе теплоснабжения в течение квартала',
            'deadline' => 'Отчитаться до: 1 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '22b',
            'type_label' => '22б',
            'group' => '1', // тепло
            'title' => 'О количестве исполненных заявок на подключение (технологическое присоединение) к системе теплоснабжения в течение квартала',
            'deadline' => 'Отчитаться до: 1 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '22v',
            'type_label' => '22в',
            'group' => '1', // тепло
            'title' => 'О количестве заявок на подключение к системе теплоснабжения, по которым принято решение об отказе',
            'deadline' => 'Отчитаться до: 1 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '22g',
            'type_label' => '22г',
            'group' => '1', // тепло
            'title' => 'О резерве мощности системы теплоснабжения в течение квартала',
            'deadline' => 'Отчитаться до: 1 [NEXT_AFTER_QUARTER_MONTH] [YEAR] г. [FREQUENCY]',
            'frequency' => 'quarterly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '24',
            'type_label' => '24',
            'group' => '1', // тепло
            'title' => 'Об условиях, на которых осуществляется поставка товаров (оказание услуг)',
            'deadline' => 'Отчитаться до 1 марта [YEAR] г. [FREQUENCY] и не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'yearly',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '25a',
            'type_label' => '25а',
            'group' => '1', // тепло
            'title' => 'Форма заявки на подключение (технологическое присоединение) к системе теплоснабжения',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '25b',
            'type_label' => '25б',
            'group' => '1', // тепло
            'title' => 'Перечень документов и сведений, представляемых одновременно с заявкой на подключение к системе теплоснабжения',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '25v',
            'type_label' => '25в',
            'group' => '1', // тепло
            'title' => 'Реквизиты нормативного правового акта, регламентирующего порядок действий заявителя и регулируемой организации при подаче, приеме, обработке заявки на подключение',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '25g',
            'type_label' => '25г',
            'group' => '1', // тепло
            'title' => 'Телефоны и адреса службы, ответственной за прием и обработку заявок на подключение (технологическое присоединение) к системе теплоснабжения',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '25d',
            'type_label' => '25д',
            'group' => '1', // тепло
            'title' => 'Регламент подключения к централизованной системе теплоснабжения, утверждаемый регулируемой организацией',
            'deadline' => 'Отчитаться не позднее 30 календарных дней со дня принятия соответствующего решения об установлении цен (тарифов) на очередной расчетный период регулирования',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

//        $data[] = [
//            'type' => '26a',
//            'type_label' => '26а',
//            'group' => '1', // тепло
//            'title' => 'Регламент подключения к централизованной системе теплоснабжения, утверждаемый регулируемой организацией',
//            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
//            'frequency' => 'other',
//            'deadline_month' => 0
//        ];

        $data[] = [
            'type' => '26',
            'type_label' => '26',
            'group' => '1', // тепло
            'title' => 'О способах приобретения, стоимости и объемах товаров, необходимых для производства регулируемых товаров и (или) оказания регулируемых услуг',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27a',
            'type_label' => '27а',
            'group' => '1', // тепло
            'title' => 'Предлагаемый метод регулирования',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27b',
            'type_label' => '27б',
            'group' => '1', // тепло
            'title' => 'Расчетная величина цены (тарифов)',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27v',
            'type_label' => '27в',
            'group' => '1', // тепло
            'title' => 'Срок действия цен (тарифов)',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27g',
            'type_label' => '27г',
            'group' => '1', // тепло
            'title' => 'Долгосрочные параметры регулирования (в случае если их установление предусмотрено выбранным методом регулирования)',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27d',
            'type_label' => '27д',
            'group' => '1', // тепло
            'title' => 'Необходимая валовая выручка на соответствующий период, в том числе с разбивкой по годам',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27e',
            'type_label' => '27е',
            'group' => '1', // тепло
            'title' => 'Годовой объем полезного отпуска тепловой энергии (теплоносителя)',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        $data[] = [
            'type' => '27zh',
            'type_label' => '27ж',
            'group' => '1', // тепло
            'title' => 'Размер экономически обоснованных расходов, не учтенных при регулировании тарифов в предыдущий период регулирования (при их наличии)',
            'deadline' => 'Отчитаться в течение 10 календарных дней с момента подачи регулируемой организацией заявления об установлении цен',
            'frequency' => 'other',
            'deadline_month' => 0
        ];

        DB::table($this->table)->insert($data);
    }
}
