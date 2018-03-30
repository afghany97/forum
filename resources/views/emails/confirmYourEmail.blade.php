@component('mail::message')
# Confirm Your email

click the following URI to confirm your email.

@component('mail::button', ['url' => url("/register/confirm/" . $user->confirmation_token)])
Confirm My Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
