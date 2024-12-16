<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerTask extends Model
{
    protected $fillable = ['server_id', 'order', 'job'];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
