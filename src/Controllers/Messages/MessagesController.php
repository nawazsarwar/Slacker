<?php

namespace myPHPnotes\Slacker\Controllers\Messages;

use App\Http\Controllers\Controller;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Views\View;
use Illuminate\Http\Request;
use myPHPnotes\Slacker\Models\Message;

class MessagesController extends Controller
{
    public function display(Request $request, Channel $channel)
    {
        $channel = Channel::where("owner_id", auth()->user()->id)->find($channel->id);
        if(!$channel) {
            abort(404);
        }
        $messages = $channel->messages;
        return view(View::path("messages.display"), compact('channel', 'messages'));

    }
    public function store(Request $request, Channel $channel)
    {
        $channel = Channel::where("owner_id", auth()->user()->id)->find($channel->id);
        if(!$channel) {
            abort(404);
        }
        $validated = $request->validate([
            'message' => "required"
        ]);
        $channel->messages()->create([
            'content' => $validated['message'],
            'type' => 'COMMENTED_VIA_PORTAL'
        ]);
        return redirect()->route('slacker.channel.display', compact('channel'));
    }
}