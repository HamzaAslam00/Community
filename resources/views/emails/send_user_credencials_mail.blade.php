@component('mail::message')
# Hi {{ $user['name'] }}
Welcome to {{ config('app.name') }}, Use below mentioned credencials to login to the system.<br>
User Name: {{ $user['name'] }}<br>
User Email: {{ $user['email'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent