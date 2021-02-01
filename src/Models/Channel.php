<?php

namespace myPHPnotes\Slacker\Models; 

use Illuminate\Database\Eloquent\Model;
use myPHPnotes\Slacker\Models\Message;

class Channel extends Model {
    protected $guarded = ['id'];
    protected static function boot()
    {
        parent::boot();
        Channel::creating(function($model) {
            $model->owner_id = auth()->user()->id;
        });
    }
    public function getConnection()
    {
        return config('slacker.database.tables.channels', parent::getConnection());
    }
    public function getTable()
    {
        return config('slacker.database.tables.channels', parent::getTable());
    }
    public function owner()
    {
        return $this->belongsTo(config('slacker.models.User'));
    }
    public function users()
    {
        return $this->belongsToMany(config('slacker.models.User'), "channel_user","channel_id" ,"user_id");
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}