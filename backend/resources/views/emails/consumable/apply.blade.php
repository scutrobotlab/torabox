@component('mail::message')
# {{$consumable_application->applicant->name}} 消耗品申请

{{$consumable_application->applicant->name}} 申请 {{$consumable_application->number}} 个 {{$consumable_application->consumable->name}}，该申请需要您的审核。

@component('mail::button', ['url' => $url])
前往审核
@endcomponent

如果上面按钮不起作用，请复制以下链接到浏览器：
{{ $url }}

{{ config('app.name') }}
@endcomponent
