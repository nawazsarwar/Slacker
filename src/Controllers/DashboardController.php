<?php


namespace myPHPnotes\Slacker\Controllers;

use App\Http\Controllers\Controller;
use myPHPnotes\Slacker\Models\Channel;
use myPHPnotes\Slacker\Views\View;


class DashboardController extends Controller {

    public function __construct()
    {
        $this->middleware("auth");
    }
    public function index()
    {
        $channels = Channel::where('owner_id', auth()->user()->id)->paginate(50);
        return view(View::path("dashboard"), ['channels' => $channels]);
    }
}
