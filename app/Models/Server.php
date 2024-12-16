<?php

namespace App\Models;

use App\Observers\ServerObserver;
use App\Server\States\InProgress;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ServerObserver::class])]
class Server extends Model
{
    protected $fillable = ['batch_id', 'type', 'provisioned_at'];

    public function taskCurrentlyProgress()
    {
        return $this->tasks()->whereState('state',InProgress::class)->first();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ServerTask::class)
            ->orderBy('order', 'asc');
    }
}
