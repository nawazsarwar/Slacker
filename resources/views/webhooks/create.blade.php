@extends("layouts.app")
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Webhook to {{ $channel->name }}</div>

                <div class="card-body">
                    <form class="form" action="{{route('slacker.channel.webhook.store', ['channel' => $channel ])}}" method="post">
                        @csrf

                        <div class="form-group row">


                            <div class="col-12">
                                <label for="">Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Den's Project in Laravel 8.0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="Slack Log">Slack Based Logger</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for=""></label>
                            <div class="col-6">
                                <input class="btn btn-danger btn-sm" type="submit" value="Add" name="Save">
                                <a class="btn btn-danger btn-sm" href="{{ route("slacker.channel.display", compact('channel')) }}">Back to {{$channel->name }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@include("slacker::webhooks.partials.list")
@endsection
