<?php

namespace myPHPnotes\Slacker\Controllers\Channels;

use App\Http\Controllers\Controller;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Views\View;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }
    public function create()
    {
        return view(View::path('channels.create'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
        ]);

        unset($validatedData['_token']);
        unset($validatedData['Save']);

        $channel = Channel::create($validatedData);

        return redirect()->route('slacker.dashboard')->withSuccess('Channel ' . $request->name . ' created successfully');
    }
    public function truncate(Channel $channel)
    {
        $channel = Channel::where("owner_id", auth()->user()->id)->find($channel->id);
        if(!$channel) {
            abort(404);
        }
        $channel->messages()->truncate();
        return redirect(route("slacker.channel.display", ['channel' => $channel]))->withSuccess("Channel truncated.");
    }


}
