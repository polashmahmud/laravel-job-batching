<?php

namespace App\Jobs\Server;

use App\Jobs\Server\Interfaces\ServerJob;
use App\Models\Server;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FinalizeServer implements ShouldQueue, ServerJob
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Server $server)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(2);
    }

    public function title(): string
    {
        return 'Finalize Server';
    }

    public function description(): string
    {
        return 'Finalizing the server';
    }
}
