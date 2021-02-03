<?php

namespace myPHPnotes\Slacker\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Models\Listen;
use myPHPnotes\Slacker\Models\Message;
use myPHPnotes\Slacker\Models\Webhook;
use myPHPnotes\Slacker\Views\View;

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
            'type' => $webhook->channel->type,
            'owner_id' => $webhook->owner_id
        ]);
        abort(200);
    }



}
