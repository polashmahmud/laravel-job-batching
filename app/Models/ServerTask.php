<?php

namespace App\Models;

use App\Server\States\ServerTaskState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class ServerTask extends Model
{
    use HasStates;

    protected $fillable = ['server_id', 'order', 'job', 'state'];

    protected $casts = [
        'state' => ServerTaskState::class,
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
