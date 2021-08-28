@component('mail::message')
# {{$immovable_application->applicant->name}} 不动产申请

{{$immovable_application->applicant->name}} 申请 {{$immovable_application->action=='lend'?'借出':'还回'}} {{$immovable_application->immovable->name}}，该申请需要您的审核。

@component('mail::button', ['url' => $url])
前往审核
@endcomponent

如果上面按钮不起作用，请复制以下链接到浏览器：
{{ $url }}

{{ config('app.name') }}
@endcomponent
