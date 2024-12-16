<?php

namespace App\Observers;

use App\Models\Server;
use App\Server\ServerTypeFactory;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class ServerObserver
{
    /**
     * Handle the Server "created" event.
     */
    public function created(Server $server): void
    {
        $serverType = ServerTypeFactory::make($server);

        foreach ($serverType->tasks() as $task) {
            $task->save();
        }

        $batch = Bus::batch($serverType->jobs())
            ->progress(function (Batch $batch) {
                \Log::info("Batch {$batch->id} is at {$batch->progress()}%");
            })
            ->dispatch();

        $server->update([
            'batch_id' => $batch->id
        ]);
    }
}
