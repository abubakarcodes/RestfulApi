@component('mail::message')
# Hello {{$user->name}}

Welcome to restful api we happy you are with us. Kindly verify your email

@component('mail::button', ['url' => "{{route('verify', $user->verification_token)}}"])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
