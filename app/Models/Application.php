<?php

namespace App\Models;

use App\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft'; // черновик
    const STATUS_ACCEPTED = 'accepted'; // в работе
    const STATUS_IN_PROGRESS = 'in_progress'; // исполняется
    const STATUS_PROGRESS_PREPARING = 'preparing'; // подготовка тех условий
    const STATUS_PROGRESS_INVOICE = 'invoice'; // счет на оплату
    const STATUS_WAITING_COMPANY_RESPONSE = 'waiting_company_resp'; // ожидает ответа компании
    const STATUS_COMPLETED = 'completed'; // выполнен
    const STATUS_DECLINED = 'declined'; // отклонен

    CONST APPLICATION_TYPE_ELECTRICITY = 'electricity';
    CONST APPLICATION_TYPE_WARM = 'warm';
    CONST APPLICATION_TYPE_WATER = 'water';

    static $connectionType = [
        'Постоянное подключение',
        'Временное на период выполнения постоянной схемы электроснабжения',
        'Временное подключение передвижного объекта'
    ];

    static $constructionReason = [
        'Новое строительство',
        'Увеличение максимальной мощности',
        'Изменение точки присоединения',
        'Изменение категории надежности',
        'Увеличение максимальной мощности и изменение точки присоединения',
        'Увеличение максимальной мощности и изменение категории надежности'
    ];

    static $integrityCategory = [
        '',
        'I',
        'II',
        'III'
    ];

    static $powerLevel = [
        '',
        '0.22 кВт',
        '0.38 кВт',
        '6 кВт',
        '10 кВт'
    ];

    static $loadType = [
        '',
        'Другое',
        'Гостиницы и рестораны',
        'Государственное управление и обеспечение военной безопасности; обязательное социальное обеспечение',
        'Деятельность экстерриториальных организаций',
        'Добыча полезных ископаемых',
        'Здравоохранение и предоставление социальных услуг',
        'Обрабатывающие производства',
        'Образование',
        'Операции с недвижимым имуществом, аренда и предоставление услуг',
        'Оптовая и розничная торговля; ремонт автотранспортных средств, мотоциклов, бытовых изделий и предмет',
        'Предоставление прочих коммунальных, социальных и персональных услуг',
        'Предоставление услуг по ведению домашнего хозяйства',
        'Производство и распределение электроэнергии, газа и воды (генерация)',
        'Производство и распределение электроэнергии, газа и воды (прочие)',
        'Производство и распределение электроэнергии, газа и воды (электрические сети ТСО)',
        'Прочее',
        'Рыболовство, рыбоводство',
        'Сельское хозяйство, охота и лесное хозяйство',
        'Строительство',
        'Транспорт и связь',
        'Финансовая деятельность'
    ];

    static $emergencyAuto = [
        'Нет',
        'Да'
    ];

    static $estimationQuater = [
        '',
        '1',
        '2',
        '3',
        '4'
    ];
    static $pricing = [
        '',
        '1 (Расчет = цена * объем потребления. Тариф по передаче эл.эн. одноставочный)',
        '2 (Расчет = сумма стоимости эл.эн для каждой зоны суток. Тариф по передаче эл.эн. одноставочный)',
        '3 (Расчет = сумма стоимости эл.эн. за каждый час плюс стоимость мощности. Тариф по передаче эл.эн. одноставочный)',
        '4 (Расчет = сумма стоимости эл.эн. за каждый час плюс стоимость мощности. Тариф по передаче эл.эн. двухставочный)',
        '5 (Расчет = сумма фактической стоимости эл.эн. по каждому часу, сумма отклонений от плана и стоимости мощности. Тариф одноставочный)',
        '6 (Расчет = сумма фактической стоимости эл.эн. по каждому часу, сумма отклонений от плана и стоимости мощности. Тариф двухставочный)'
    ];

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'connectionType',
        'requester',
        'contractNumber',
        'contractDate',
        'connectionDuration',
        'objectName',
        'objectLocation',
        'kadastrNum',
        'constructionReason',
        'connectorsCount',
        'maxPower',
        'previousMaxPower',
        'integrityCategory',
        'powerLevel',
        'loadType',
        'emergencyAuto',
        'estimationYear',
        'estimationQuater',
        'power',
        'vendor_id',
        'pricing',
        'limitingParams',
        'typeOfLand',
        'landBoundaries',
        'legalBase',
        'warmOther',
        'warmHotWaterH',
        'warmHotWaterR',
        'warmVentilation',
        'warmHeating',
        'warmTotal',
        'numberOfStoreys',
        'commissioningDate',
        'totalArea',
        'constructionVolume',
        'objectPurpose',
        'objectLocation',
        'other',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClientScope());
        static::saving(function ($application) {
            $application->client_id = auth()->user()->client_id;
        });
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function docs (): HasMany
    {
        return $this->hasMany(AppDocs::class, 'entity_id', 'id')->with('user');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'entity_id', 'id')->where('type', 'applications_electricity');
    }
}
