<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\MailJob\QueueService;

class CreateQueueServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name');
            $table->integer('status');
            $table->timestamps();
        });
        
        $queue = new QueueService();
        $services = ['sync'=>'Sync','database'=>'Local Database','beanstalkd'=>'Beanstalkd','sqs'=>'SQS','iron'=>'Iron','redis'=>'Redis'];
        $status = 0;
        foreach($services as $key=>$value){
            if($key=='database'){
               $status=1; 
            }
            $queue->create([
                'name'=>$value,
                'short_name'=>$key,
                'status'=>$status,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('queue_services');
    }
}
