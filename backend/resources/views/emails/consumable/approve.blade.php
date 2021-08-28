@component('mail::message')
# {{$consumable_application->approver->name}} 消耗品审批结果

{{$consumable_application->approver->name}} {{$consumable_application->status==1?'已同意':'已拒绝'}} 您 {{$consumable_application->number}} 个 {{$consumable_application->consumable->name}} 的申请。

@component('mail::button', ['url' => $url])
查看详情
@endcomponent

如果上面按钮不起作用，请复制以下链接到浏览器：
{{ $url }}

{{ config('app.name') }}
@endcomponent
