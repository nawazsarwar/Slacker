<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$channel->name }}'s Webhooks</div>

                <div class="card-body">
                    @if(!count($webhooks))
                    <div style="text-align: center;">
                        <i>You don't have any active webhook with this channel.</i>
                    </div>
                    @endif
                    <div class="row">
                        @foreach ($webhooks as $webhook)
                            <div class="col-4 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h2>{{$webhook->name}}</h2>
                                        <p>
                                            Type: {{ $webhook->type}} <br>
                                            Created: {{ $webhook->created_at->calendar() }} <br><br>
                                            Endpoint:
                                            <code>
                                                {{ $webhook->url() }}
                                            </code>
                                        </p>
                                        <a class="btn btn-sm btn-danger" href="{{ route('slacker.channel.webhook.delete', ['webhook' => $webhook]) }}">Delete</a>
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
