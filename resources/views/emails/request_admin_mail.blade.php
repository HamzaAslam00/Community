@component('mail::message')
# Register Request

A user sent a request to get register with community please reach back.<br>
User Name: {{ $user['name'] }}<br>
User Email: {{ $user['email'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent