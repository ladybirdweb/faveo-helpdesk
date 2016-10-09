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
        $services = ['sync'=>'Sync','database'=>'Database','beanstalkd'=>'Beanstalkd','sqs'=>'SQS','iron'=>'Iron','redis'=>'Redis'];
        foreach($services as $key=>$value){
            $queue->create([
                'name'=>$value,
                'short_name'=>$key,
                'status'=>0,
            ]);
        }
        $q = $queue->where('short_name','database')->first();
        if($q){
           $q->status = 1;
           $q->save();
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
