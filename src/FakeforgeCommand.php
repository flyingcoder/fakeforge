<?php

namespace Flyingcoder\Fakeforge;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FakeforgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:hooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to prepare the server for webhooks.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $this->createFile('backend');
        $this->createFile('frontend');

        shell_exec("chmod +x sh/deploy/frontend-script.sh");
        shell_exec("chmod +x sh/deploy/backend-script.sh");

        $process = new Process([
                'sh/deploy/backend-script.sh',
                'sh/deploy/frontend-script.sh'
            ]);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    public function createFile($hook)
    {
        $cmd[] = "#!/bin/bash";
        $cmd[] = "cd ".config("fakeforge.path.{$hook}");
        $cmd[] = "git fetch --all";
        $cmd[] = "git checkout --force 'origin/master'";
        $content = implode("\n", $cmd);

        file_put_contents("sh/deploy/{$hook}-script.sh", $content);
    }
}
