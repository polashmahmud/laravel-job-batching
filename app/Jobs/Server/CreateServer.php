<?php

namespace App\Jobs\Server;

use App\Jobs\Server\Interfaces\ServerJob;
use App\Models\Server;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateServer implements ShouldQueue, ServerJob
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
        // SSH Server Credentials
        $server_ip = '104.251.216.142';
        $username = 'root';

        // Commands: Update, Upgrade, Install and Setup Nginx
        $commands = [
            "sudo apt-get update -y", // Update package list
            "sudo apt-get upgrade -y", // Upgrade all packages
            "sudo apt-get install -y nginx", // Install Nginx
            "sudo systemctl start nginx", // Start Nginx
            "sudo systemctl enable nginx", // Enable Nginx on boot
        ];

        try {
            foreach ($commands as $cmd) {
                // SSH Command Execution
                $command = "ssh {$username}@{$server_ip} '{$cmd}'";

                $process = Process::fromShellCommandline($command);
                $process->setTimeout(300); // Timeout in seconds
                $process->run();

                // Check if the process was successful
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }

                Log::info("Command executed successfully: {$cmd}");
            }

            Log::info("Server updated, upgraded, and Nginx installed successfully!");

        } catch (\Exception $e) {
            Log::error("Error updating server or setting up Nginx: ".$e->getMessage());
            throw new \Exception("Error: ".$e->getMessage());
        }
    }


    public function middleware(): array
    {
        return [new SkipIfBatchCancelled()];
    }

    public function title(): string
    {
        return 'Create Server #'.$this->server->id;
    }

    public function description(): string
    {
        return 'Creating a new server';
    }
}
