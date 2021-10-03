<?php

namespace App\Models;

use App\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appeal extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft'; // черновик
    const STATUS_ACCEPTED = 'accepted'; // в работе
    const STATUS_WAITING_USER_RESPONSE = 'replied'; // ожидает ответа пользователя
    const STATUS_COMPLETED = 'completed'; // выполнен

    protected $fillable = [
        'user_id',
        'status',
        'requester',
        'question'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClientScope());
        static::saving(function ($appeal) {
            $appeal->client_id = auth()->user()->client_id;
        });
    }

    public function docs (): HasMany
    {
        return $this->hasMany(AppDocs::class, 'entity_id', 'id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'entity_id', 'id')->where('type', 'appeals');
    }
}
