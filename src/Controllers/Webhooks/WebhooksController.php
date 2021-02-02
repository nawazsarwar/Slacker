<?php

namespace myPHPnotes\Slacker\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Models\Listen;
use myPHPnotes\Slacker\Views\View;
use Illuminate\Http\Request;
use myPHPnotes\Slacker\Models\Webhook;

class WebhooksController extends Controller
{

    public function create(Channel $channel)
    {
        if (!$channel->isMine()) {
            abort(404);
        }
        $webhooks = $channel->webhooks()->mine()->get();
        return view(View::path('webhooks.create'), compact('channel', 'webhooks'));
    }
    public function store(Request $request,Channel $channel)
    {
        if (!$channel->isMine()) {
            abort(404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
        ]);
        $validatedData['channel_id'] = $channel->id;
        $webhook = Webhook::create($validatedData);
        return redirect()->route('slacker.channel.webhook.create', compact('channel'))->withSuccess('Webhook successfully added to ' . $channel->name);
    }
    public function delete(Webhook $webhook)
    {
        if (!$webhook->isMine()) {
            abort(404);
        }
        $channel = $webhook->channel;
        $webhook->delete();
        return redirect(route('slacker.channel.webhook.create', ['channel' => $channel]))->withSuccess('Webhook successfully deleted from ' . $channel->name);

    }
    public function listen(Webhook $webhook, Request $request)
    {
        $message = Message::create([
            'channel_id' => $webhook->channel->id,
            'content' => json_encode($request->all()),
            'type' => $webhook->channel->type
        ]);
        if ($message) {
            return abort(200);
        }
        return abort(500);
    }



}
