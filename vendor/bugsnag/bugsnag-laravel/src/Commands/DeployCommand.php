<?php

namespace Bugsnag\BugsnagLaravel\Commands;

use Bugsnag\Bugsnag\Utils;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class DeployCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bugsnag:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies Bugsnag of a build';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $builderName = $this->option('builder');
        if (is_null($builderName)) {
            if (class_exists(Process::class)) {
                $process = new Process('whoami');
                $process->run();
                if ($process->isSuccessful()) {
                    $builderName = trim($process->getOutput());
                }
            } else {
                $builderName = Utils::getBuilderName();
            }
        }
        Bugsnag::build($this->option('repository'), $this->option('revision'), $this->option('provider'), $builderName);

        $this->info('Notified Bugsnag of the build!');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['repository', null, InputOption::VALUE_OPTIONAL, 'The repository from which you are deploying the code.', null],
            ['branch', null, InputOption::VALUE_OPTIONAL, 'The source control branch from which you are deploying.  Deprecated.', null],
            ['revision', null, InputOption::VALUE_OPTIONAL, 'The source control revision you are currently deploying.', null],
            ['provider', null, InputOption::VALUE_OPTIONAL, 'The provider of your source control repository.', null],
            ['builder', null, InputOption::VALUE_OPTIONAL, 'The machine or person who has executed the build', null],
        ];
    }
}
