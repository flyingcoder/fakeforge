<?php

namespace Flyingcoder\Fakeforge;

use Illuminate\Console\Command;

class FakeforgeInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:init';

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

        shell_exec("chmod +x public/sh/deploy/frontend-script.sh");
        shell_exec("chmod +x public/sh/deploy/backend-script.sh");
    }

    public function createFile($hook)
    {
        $cmd[] = "#!/bin/bash";
        $cmd[] = "# redirect stdout/stderr to a file";
        $cmd[] = '#exec > '.config("fakeforge.path.{$hook}").'/output.log 2>&1';
        $cmd[] = "cd ".config("fakeforge.path.{$hook}");
        $cmd[] = "git stash";
        $cmd[] = "git pull origin master &";
        $cmd[] = "wait";

        if($hook == 'backend') {
            $cmd[] = "composer install --no-interaction --prefer-dist --optimize-autoloader";
            $cmd[] = "if [ -f artisan ]";
            $cmd[] = "then";
            $cmd[] = "    php artisan migrate --force";
            $cmd[] = "fi";
        } else {
            $cmd[] = "npm i";
            $cmd[] = "npm run build";
        }
        $cmd[] = "git log --name-status HEAD^..HEAD";
        
        $content = implode("\n", $cmd);

        file_put_contents("public/sh/deploy/{$hook}-script.sh", $content);
    }
}
