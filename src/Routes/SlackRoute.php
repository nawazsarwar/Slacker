<?php


namespace myPHPnotes\Slacker\Routes;

use Illuminate\Support\Facades\Route;
use myPHPnotes\Slacker\Controllers\DashboardController;
use myPHPnotes\Slacker\Controllers\Channels\ChannelsController;
use myPHPnotes\Slacker\Controllers\Messages\MessagesController;
use myPHPnotes\Slacker\Controllers\Webhooks\WebhooksController;

class SlackRoute  {

    protected $router;
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    public static function routes($prefix = "slacker")
    {
        Route::get($prefix . '/dashboard', [DashboardController::class, 'index'])->name('slacker.dashboard');

        Route::get($prefix . '/channel/create', [ChannelsController::class, 'create'])->name('slacker.channel.create');
        Route::post($prefix . '/channel/store', [ChannelsController::class, 'store'])->name('slacker.channel.store');

        Route::get($prefix . '/messages/{channel}/show', [MessagesController::class, 'display'])->name('slacker.channel.display');
        Route::post($prefix . '/messages/{channel}/store', [MessagesController::class, 'store'])->name('slacker.message.store');

        Route::get($prefix . '/channel/{channel}/webhook/create', [WebhooksController::class, 'create'])->name('slacker.channel.webhook.create')->middleware("auth");
        Route::post($prefix . '/channel/{channel}/webhook/create', [WebhooksController::class, 'store'])->name('slacker.channel.webhook.store')->middleware("auth");

        Route::get($prefix . '/channel/{webhook}/webhook/delete', [WebhooksController::class, 'delete'])->name('slacker.channel.webhook.delete')->middleware("auth");
        Route::post($prefix . '/{webhook}/webhook', [WebhooksController::class, 'listen'])->name('slacker.channel.webhook.listen');
    }

}
