@extends("layouts.app")
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h3>{{$channel->name}}</h3>
                        </div>
                        <div class="col-2" style="text-align: right; display: -webkit-inline-box; margin-right:0;">
                            <a href="{{ route("slacker.dashboard") }}" class="btn btn-danger btn-sm mr-2" style="color: white;">Back</a>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-sm btn-danger" data-toggle="dropdown">Settings</a>
                                <div class="dropdown-menu">
                                    <a href="{{ route("slacker.channel.webhook.create", ['channel' => $channel]) }}" class="dropdown-item">Add Webhook</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="card">
                        <div class="card-body">
                    @foreach ($messages as $message)

                            <blockquote style="border: 2px solid #3fc1a5; border-bottom: 2px solid #3fc1a5;border-left: 10px solid #3fc1a5; padding:10px; @if($message->isMine()) text-align: right; border-right: 10px solid #3fc1a5; border-left: 2px solid #3fc1a5;  @endif">
                                <p style="font-weight: lighter; font-size: medium;font-style: italic;">{{ $message->getContent() }} </p>
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
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary" >Submit</button>
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

@endsection
