<?php

namespace myPHPnotes\Slacker\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use myPHPnotes\Slacker\Models\Channel;

class Message extends Model {
    protected $guarded = ['id'];
    protected $fillable = [
        'channel_id',
        'content',
        'type',
        'owner_id'
    ];
    protected static function boot()
    {
        parent::boot();
        if (auth()->user()) {
            Message::creating(function($model) {
                $model->owner_id = auth()->user()->id;
            });
        }
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
    public function getMessageObject()
    {
        return (json_decode($this->content, true));
    }
    public function getSlackUsername()
    {
        return $this->getMessageObject()['username'];
    }
    public function getSlackTitle()
    {
        return $this->getMessageObject()['attachments'][0]['title'] . ": ". $this->getMessageObject()['attachments'][0]['text'];
    }
    public function getSlackException()
    {
        return json_decode(trim( $this->getMessageObject()['attachments'][0]['fields'][2]['value'], "```"));
    }
    public function getSlackTitleColor()
    {
        $color = $this->getMessageObject()['attachments'][0]['color'] ;
        switch ($color) {
            case 'danger':
                return "#c00";
                break;

            default:
                return "#167ac6";
                break;
        }
    }
    public function getSlackUserId()
    {
        return $this->getMessageObject()['attachments'][0]['fields'][1]['value'];
    }
    public function getSlackLevel()
    {
        return $this->getMessageObject()['attachments'][0]['fields'][0]['value'];
    }
    public function getSlackTime()
    {
        return new Carbon($this->getMessageObject()['attachments'][0]['ts']);
    }
    public function getModalContent()
    {
        return [
            'username' => $this->getSlackUsername(),
            'color' => $this->getSlackTitleColor(),
            'user_id' => $this->getSlackUserId(),
            'level' => $this->getSlackLevel(),
            'title' => $this->getSlackTitle(),
            'timestamp' => $this->getSlackTime(),
            'humanTime' => $this->getSlackTime()->calendar(),
            'exception' => $this->getSlackException()
        ];
    }
}
