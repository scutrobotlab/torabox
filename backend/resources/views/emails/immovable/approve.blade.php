@component('mail::message')
# {{$immovable_application->approver->name}} 不动产审批结果

{{$immovable_application->approver->name}} {{$immovable_application->status==1?'已同意':'已拒绝'}} 您 {{$immovable_application->action=='lend'?'借出':'还回'}} {{$immovable_application->immovable->name}} 的申请。

@component('mail::button', ['url' => $url])
查看详情
@endcomponent

如果上面按钮不起作用，请复制以下链接到浏览器：
{{ $url }}

{{ config('app.name') }}
@endcomponent
