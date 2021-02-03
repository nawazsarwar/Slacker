<?php

namespace myPHPnotes\Slacker\Models;

use Illuminate\Database\Eloquent\Model;
use myPHPnotes\Slacker\Models\Channel;

class Message extends Model {
    protected $guarded = ['id'];
    protected $fillable = [
        'channel_id',
        'content',
        'type',
    ];
    protected static function boot()
    {
        parent::boot();
        Message::creating(function($model) {
            $model->owner_id = auth()->user()->id;
        });
    }
    public function getConnection()
    {
        parent::setConnection(config('slacker.database.connection', parent::getConnection()));
        return parent::getConnection();
    }
    public function getTable()
    {
        parent::setTable(config('slacker.database.tables.messages', parent::getTable()));
        return parent::getTable();
    }
    public function owner()
    {
        return $this->belongsTo(config('slacker.models.User'));
    }
    public function replyOf()
    {
        return $this->belongsTo(Message::class, "reply_message_id");
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class, "channel_id", "id");
    }
    public function getContent()
    {
        return $this->content;
    }
    public function isMine()
    {
        if ($this->owner_id === auth()->user()->id) {
            return true;
        }
        return false;
    }
}
