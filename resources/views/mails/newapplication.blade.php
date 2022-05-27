@component('mail::message')
    Была добавлена новая заявка
    @component('mail::button', ['url' => $url])
        Перейти к личному кабинету
    @endcomponent
    Спасибо,<br>
    {{ config('app.name') }}
@endcomponent
