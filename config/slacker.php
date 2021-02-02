<?php

return [
    "database" => [
        'connection' => "mysql",
        'tables' => [
            'channels' => "channels",
            'channel_user' => "channel_user",
            'messages' => "messages",
            'webhooks' => "webhooks"
        ]
    ],
    "models" => [
        "User" => App\Models\User::class
    ]


];
