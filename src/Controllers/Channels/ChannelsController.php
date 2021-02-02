<?php

namespace myPHPnotes\Slacker\Controllers\Channels;

use App\Http\Controllers\Controller;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Views\View;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{

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


}
