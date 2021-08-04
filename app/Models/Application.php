<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft'; // черновик
    const STATUS_ACCEPTED = 'accepted'; // в работе
    const STATUS_IN_PROGRESS = 'in_progress'; // исполняется
    const STATUS_PROGRESS_PREPARING = 'preparing'; // подготовока тех условий
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
        'energoCompanyName',
        'pricing',
        'other',
    ];
}
