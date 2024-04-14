@component('mail::message')
# Hai, {{ $mail_data['nama'] }}

{{ $mail_data['desc'] }}

@component('mail::button', ['url' => route('password.email.token',$mail_data['token'])])
Klik Untuk Melanjutkan
@endcomponent

Salam Hangat,<br>
SAS
@endcomponent
