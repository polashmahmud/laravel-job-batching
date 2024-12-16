<?php

namespace App\Observers;

use App\Models\Server;
use App\Server\ServerTypeFactory;
use App\Server\States\Complete;
use App\Server\States\InProgress;
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
            ->before(function (Batch $batch) use ($server) {
                $server->tasks->first()->state->transitionTo(InProgress::class);
            })
            ->progress(function (Batch $batch) use ($server) {
                $task = $server->taskCurrentlyProgress();

                $task->state->transitionTo(Complete::class);
            })
            ->dispatch();

        $server->update([
            'batch_id' => $batch->id
        ]);
    }
}
