<?php

return [
    "database" => [
        'connection' => "mysql",
        'tables' = [
            'channels' => "channels",
            'channel_user' => "channel_user",
            'messages' => "messages"
        ]
    ],
    "models" => [
        "User" => App\Models\User::class
    ]
        

];