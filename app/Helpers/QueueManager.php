<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class QueueManager
{
    public static function startQueueWorker($authToken)
    {
        try {
            if (self::queueSize() == 0)
                return;
            try {
                // Check if a queue worker process is already running
                $existingProcess = new Process(['pgrep', '-f', 'queue:work']);
                $existingProcess->run();

                if ($existingProcess->isSuccessful()) {
                    // Stop the existing process
                    $pid = trim($existingProcess->getOutput());
                    Log::info("Stopping existing queue worker process with PID: $pid");
                    $stopProcess = new Process(['kill', $pid]);
                    $stopProcess->run();

                    if (!$stopProcess->isSuccessful()) {
                        Log::error('Failed to stop the existing queue worker process.');
                        return;
                    }
                }
                //code...
            } catch (\Throwable $th) {
                Log::error('Error checking existing queue worker process: ' . $th->getMessage());
            }

            // Start a new queue worker process
            $command = [
                'php',
                base_path('artisan'),
                'queue:work',
                '--stop-when-empty',
                '--tries=3'
            ];

            $process = new Process($command);
            $process->setTimeout(null); // No timeout for the overall process
            $process->start();

            $startTime = time(); // Record the start time
            while ($process->isRunning() && self::queueSize() > 0) {
                // Check if 1 minute has passed
                if (time() - $startTime >= 60) {
                    // Hit the API
                    Log::info('base url is:' . env("APP_URL"));
                    if (self::queueSize() == 0)
                        break;
                    Log::info(self::queueSize());
                    // break;
                    $response = null;
                    try {
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            // 'Authorization' => "Bearer $authToken"
                        ])->get(env("APP_URL").'/api/start-queue');
                        Log::info('API response: ' . $response->body());
                    } catch (\Throwable $th) {
                        log::error('Error hitting API: ' . $th->getMessage());
                    }

                    // Log the API response
                    if ($response->successful()) {
                        Log::info('API hit successfully: ' . $response->body());
                        return;
                    } else {
                        Log::error('Failed to hit API: ' . $response->body());
                    }

                    // Reset the start time
                    $startTime = time();
                }

                // Optionally log or monitor the process here
                Log::info('Queue worker is running...');
                sleep(5); // Prevent tight looping
            }

            Log::info("Queue is running " . $process->isRunning() . " , queue size is: " . self::queueSize());

            Log::info('Queue worker finished processing all jobs.');
        } catch (\Exception $e) {
            Log::error('Queue worker failed: ' . $e->getMessage());
        }
    }

    public static function queueSize()
    {
        return Queue::size();
    }
}
