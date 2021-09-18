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

    protected $fillable = [
        'user_id',
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

    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'entity_id', 'id')->where('type', 'applications_electricity');
    }
}
