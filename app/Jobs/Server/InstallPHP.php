<?php

namespace App\Jobs\Server;

use App\Jobs\Server\Interfaces\ServerJob;
use App\Models\Server;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;

class InstallPHP implements ShouldQueue, ServerJob
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

    public function middleware(): array
    {
        return [new SkipIfBatchCancelled()];
    }

    public function title(): string
    {
        return 'Install PHP';
    }

    public function description(): string
    {
        return 'Installing PHP';
    }
}
