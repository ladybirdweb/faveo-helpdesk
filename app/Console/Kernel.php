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
        if (env('DB_INSTALL') == 1) {
            if ($this->getCurrentQueue() != "sync") {
                $schedule->command('queue:listen '.$this->getCurrentQueue().' --sleep 60')->everyMinute();
            }
            $this->execute($schedule, 'fetching');
            $this->execute($schedule, 'notification');
            $this->execute($schedule, 'work');
        }
    }

    public function execute($schedule, $task)
    {
        $condition = new Condition();
        $command = $condition->getConditionValue($task);
        switch ($task) {
            case 'fetching':
                $this->getCondition($schedule->command('ticket:fetch'), $command);
                break;
            case 'notification':
                $this->getCondition($schedule->command('report:send'), $command);
                break;
            case 'work':
                $this->getCondition($schedule->command('ticket:close'), $command);
                break;
        }
    }

    public function getCondition($schedule, $command)
    {
        $condition = $command['condition'];
        $at = $command['at'];
        switch ($condition) {
            case 'everyMinute':
                $schedule->everyMinute();
                break;
            case 'everyFiveMinutes':
                $schedule->everyFiveMinutes();
                break;
            case 'everyTenMinutes':
                $schedule->everyTenMinutes();
                break;
            case 'everyThirtyMinutes':
                $schedule->everyThirtyMinutes();
                break;
            case 'hourly':
                $schedule->hourly();
                break;
            case 'daily':
                $schedule->daily();
                break;
            case 'dailyAt':
                $this->getConditionWithOption($schedule, $condition, $at);
                break;
            case 'weekly':
                $schedule->weekly();
                break;
            case 'monthly':
                $schedule->monthly();
                break;
            case 'yearly':
                $schedule->yearly();
                break;
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
}
