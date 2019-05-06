<?php

namespace App\Console;

use App\Model\MailJob\Condition;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Inspire',
        'App\Console\Commands\SendReport',
        'App\Console\Commands\CloseWork',
        'App\Console\Commands\TicketFetch',
        'App\Console\Commands\UpdateEncryption',
        \App\Console\Commands\DropTables::class,
        \App\Console\Commands\Install::class,
        \App\Console\Commands\InstallDB::class,
        \App\Console\Commands\SetupTestEnv::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (isInstall()) {
            $this->execute($schedule, 'fetching');
            $this->execute($schedule, 'notification');
            $this->execute($schedule, 'work');
            if ($this->getCurrentQueue() != 'sync') {
                //TODO remove this. Use supervisord.
                //$schedule->command('queue:listen '.$this->getCurrentQueue().' --sleep 60')->everyMinute();
            }
        }
    }

    public function execute($schedule, $task)
    {
        $condition = new Condition();
        $command = $condition->getConditionValue($task);
        $overlapping = $condition->getWithoutOverlappingState($task);
        switch ($task) {
            case 'fetching':
                $this->getOverlapping($this->getCondition($schedule->command('ticket:fetch'), $command), $overlapping);
                break;
            case 'notification':
                $this->getOverlapping($this->getCondition($schedule->command('report:send'), $command), $overlapping);
                break;
            case 'work':
                $this->getOverlapping($this->getCondition($schedule->command('ticket:close'), $command), $overlapping);
                break;
        }
    }

    public function getCondition($schedule, $command)
    {
        $condition = $command['condition'];
        $at = $command['at'];
        switch ($condition) {
            case 'everyMinute':
                return $schedule->everyMinute();
                break;
            case 'everyFiveMinutes':
                return $schedule->everyFiveMinutes();
                break;
            case 'everyTenMinutes':
                return $schedule->everyTenMinutes();
                break;
            case 'everyThirtyMinutes':
                return $schedule->everyThirtyMinutes();
                break;
            case 'hourly':
                return $schedule->hourly();
                break;
            case 'daily':
                return $schedule->daily();
                break;
            case 'dailyAt':
                return $this->getConditionWithOption($schedule, $condition, $at);
                break;
            case 'weekly':
                return $schedule->weekly();
                break;
            case 'monthly':
                return $schedule->monthly();
                break;
            case 'yearly':
                return $schedule->yearly();
                break;
            default :
                return $schedule;
        }
    }

    public function getConditionWithOption($schedule, $command, $at)
    {
        switch ($command) {
            case 'dailyAt':
                $schedule->dailyAt($at);
                break;
        }
    }

    public function getCurrentQueue()
    {
        $queue = 'database';
        $services = new \App\Model\MailJob\QueueService();
        $current = $services->where('status', 1)->first();
        if ($current) {
            $queue = $current->short_name;
        }

        return $queue;
    }

    /**
     * Check if the command must run with or without overlapping.
     *
     * @param $schedule
     * @param $overlapping
     */
    public function getOverlapping($schedule, $overlapping)
    {
        if($overlapping){
            $schedule->withoutOverlapping();
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
