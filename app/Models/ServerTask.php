<?php

namespace App\Models;

use App\Server\States\Complete;
use App\Server\States\Failed;
use App\Server\States\InProgress;
use App\Server\States\Pending;
use App\Server\States\ServerTaskState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class ServerTask extends Model
{
    use HasStates;

    protected $fillable = ['server_id', 'order', 'job', 'state', 'title', 'description'];

    protected $casts = [
        'state' => ServerTaskState::class,
    ];

    public function isPending(): bool
    {
        return $this->state->equals(Pending::class);
    }

    public function isInProgress(): bool
    {
        return $this->state->equals(InProgress::class);
    }

    public function isComplete(): bool
    {
        return $this->state->equals(Complete::class);
    }

    public function isFailed(): bool
    {
        return $this->state->equals(Failed::class);
    }

    public function next()
    {
        return $this->whereBelongsTo($this->server)
            ->where('order', '>', $this->order)
            ->first();
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
