@extends("layouts.app")
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Slacker </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="text-right" style="text-align: right">
                                <a href="{{ route("slacker.channel.create") }}" class="btn btn-sm btn-danger">Add Channel</a>
                            </div>
                        </div>
                    </div>
                    @if(!count($channels))
                        <div class="row">
                            <div class="col-12">
                                <i>You don't have any active channels.</i>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        @foreach ($channels as $channel)
                                <div class="col-4 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2>{{$channel->name}}</h2>
                                            <p>
                                                Owner: {{$channel->owner->name }} <br>
                                                Created: {{ $channel->created_at->calendar() }}
                                            </p>
                                            <a class="btn btn-sm btn-danger" href="{{ route('slacker.channel.display', ['channel' => $channel]) }}">View Channel</a>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
