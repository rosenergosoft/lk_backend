<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'code'
    ];

    static public function flushUserCodesForDocument($user_id, $document_id)
    {
        self::where('user_id', $user_id)->where('document_id',$document_id)->delete();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sendSms() {
        $login = 'tomfordrumm';
        $password = 'q9seswAg';
        $message = "Код для подписания документа: " . $this->code;
        $phone = $this->user->phone;

        $url = "https://smsc.ru/sys/send.php?login=$login&psw=$password&phones=$phone&mes=$message";

        $client = new Client();
        $response = $client->get($url);

        return $response;
    }
}
