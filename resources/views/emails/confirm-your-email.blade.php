@component('mail::message')
# One more step before joining {{env('APP_NAME')}}

We need you to confirm your email.

@component('mail::button', ['url' => route('email.confirm', $confirm_token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
