<?php

namespace myPHPnotes\Slacker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use myPHPnotes\Slacker\Models\Message;

class Webhook extends Model {
    protected $guarded = ['id', 'identifier'];
    public function getRouteKeyName()
    {
        return 'identifier';
    }
    protected static function boot()
    {
        parent::boot();
        Webhook::creating(function($model) {
            $model->owner_id = auth()->user()->id;
            $model->identifier = md5(random_bytes(15));
        });
    }
    public function getConnection()
    {
        parent::setConnection(config('slacker.database.connection', parent::getConnection()));
        return parent::getConnection();
    }
    public function getTable()
    {
        parent::setTable(config('slacker.database.tables.webhooks', parent::getTable()));
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
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    public function url()
    {
        return route("slacker.channel.webhook.listen", ['webhook' => $this]);
    }
    public function isMine()
    {
        if ($this->owner_id === auth()->user()->id) {
            return true;
        }
        return false;
    }
}
