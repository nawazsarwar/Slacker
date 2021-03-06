<?php

namespace myPHPnotes\Slacker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        parent::setConnection(config('slacker.database.connection', parent::getConnection()));
        return parent::getConnection();
    }
    public function getTable()
    {
        parent::setTable(config('slacker.database.tables.channels', parent::getTable()));
        return parent::getTable();
    }
    public function scopeMine(Builder $builder)
    {
        return $builder->where('owner_id', auth()->user()->id);
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
    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }
    public function isMine()
    {
        if ($this->owner_id === auth()->user()->id) {
            return true;
        }
        return false;
    }
}
