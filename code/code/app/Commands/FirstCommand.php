<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class FirstCommand extends Command implements SelfHandling {
	
	/**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'user:active';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Command description.';
 
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
        public function fire()
        {
                //
        }
 
        /**
         * Get the console command arguments.
         *
         * @return array
         */
        protected function getArguments()
        {
                return array(
                        array('example', InputArgument::REQUIRED, 'An example argument.'),
                );
        }
 
        /**
         * Get the console command options.
         *
         * @return array
         */
        protected function getOptions()
        {
                return array(
                        array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
                );
        }

}
