@component('mail::message')
# Hello {{$user->name}}

You have changed you email so kindly reverify your email. Thanks

@component('mail::button', ['url' => "{{route('verify', $user->verification_token)}}"])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
