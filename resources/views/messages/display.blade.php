@extends("layouts.app")
@section('content')
<div class="container">
    @include("slacker::messages.partials.modal")
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div>
                    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm" style="padding: 0 10px;">
                        <div class="container">
                            <a class="navbar-brand" href="{{ route("slacker.channel.display", ['channel' => $channel]) }}">
                                {{$channel->name}}
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                            Settings
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route("slacker.channel.truncate", ['channel' => $channel]) }}">Truncate Channel</a>
                                            <a class="dropdown-item" href="{{ route("slacker.channel.webhook.create", ['channel' => $channel]) }}">Add Webhook</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="card" style="border: none;">
                        <div class="card-body">
                    @foreach ($messages as $message)
                            <blockquote
                            style="border: 2px solid #3fc1a5; border-bottom: 2px solid #3fc1a5;border-left: 10px solid #3fc1a5; padding:10px; @if($message->isMine()) text-align: right; border-right: 10px solid #3fc1a5; border-left: 2px solid #3fc1a5;  @endif"
                            >
                                @include("slacker::messages.partials.message")
                                <footer>By {{ $message->owner->name }} | {{ $message->created_at->calendar() }} ({{ $message->created_at->diffForHumans() }})</footer>
                            </blockquote>

                    @endforeach

                            <br>
                            <div class="comment-form">
                                <form action="{{ route("slacker.message.store", ['channel' => $channel ]) }}" method="POST" class="form"  >
                                    @csrf
                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <textarea rows="5" id="message" class="form-control" name="message" style="font-style: italic;" placeholder="Whats the progress?">Dear Team, </textarea>
                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                                                <a href="{{ route("slacker.dashboard") }}" class="btn btn-sm btn-danger float-right">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        if (window.jQuery) {
            console.log("jQuery found");

        } else {
            alert("Please include jQuery to the base template to make slacker run properly.");
        }
    }
    window.onload = function() {
        $(document).ready(function() {
            $("#showTraceButton").click(function(e) {
                e.preventDefault();
                button = $(this);
                if ($("#trace").css('display') == "none") {
                    button.html("Hide Stack Trace");
                } else {
                    button.html("Show Stack Trace");
                }
                $("#trace").slideToggle();
            });
            $(".slackmessage").click(function(e) {
                e.preventDefault();
                message_id = $(this).attr("data-message-id");
                $.ajax({
                    url: '{{ route("slacker.message.get", ['channel' => $channel ]) }}?message_id=' + message_id,
                }).done(function(response) {
                    $("#slackerMessageTitle").html("");
                    $("#slackerMessageBody #title").html("");

                    $("#slackerMessageTitle").text(response.username);

                    $("#slackerMessageBody #title").text(response.title);
                    $("#slackerMessageBody #searchTitle").attr("href", "https://www.google.com/search?q=" + response.title);
                    $("#slackerMessageBody #title").css("color", response.color);

                    $("#slackerMessageBody #level").text(response.level);
                    $("#slackerMessageBody #level").css("color", response.color);

                    $("#slackerMessageBody #time").text(response.humanTime);
                    $("#slackerMessageBody #time").attr("title", response.timestamp);

                    $("#slackerMessageBody #user_id").text(response.user_id);
                    $("#slackerMessageBody #main_cause").text(response.exception.file);
                    $("#slackerMessageBody #exception_type").text(response.exception.class);

                    $("#slackerMessageBody #trace #trace_body").html("");
                    for (let index = 0; index < response.exception.trace.length; index++) {
                        tr = '<tr><td><code style="color: black;">'  + response.exception.trace[index] + '</code></td></tr>'
                        $("#slackerMessageBody #trace #trace_body").append(tr);

                    }


                    $('#slackerMessageModal').modal("show");

                });
            })
        });
    }
</script>
@endsection
