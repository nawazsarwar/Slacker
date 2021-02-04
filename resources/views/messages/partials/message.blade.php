@if($message->type == "COMMENTED_VIA_PORTAL")
<p>
    <b>{{$message->owner->name}}</b><br>
    <span style="color: #167ac6;">{{ $message->getContent() }}</span>
</p>
@elseif($message->type == "Slack Log")
<p >
    <b>{{ $message->getSlackUsername() }}</b><br>
    <span class="slackmessage" data-message-id="{{$message->id}}" style="cursor: pointer; color: {{ $message->getSlackTitleColor() }};">{{ $message->getSlackTitle() }}</span>
</p>
@endif