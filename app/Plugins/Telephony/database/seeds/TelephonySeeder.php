<?php

namespace App\Plugins\Telephony\database\seeds;

use Illuminate\Database\Seeder;
use DB;

class TelephonySeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
       $this->call(ProviderTableSeeder::class); 
    }
}

class ProviderTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
       DB::table('telephone_providers')->delete();;
       $providers = $this->providers();
       foreach($providers as $provider){
           DB::table('telephone_providers')->insert($provider);
       }
    }
    
    public function providers(){
        $time = date('Y-m-d H:m:i');
        return [
            ['name'=>'Exotel','short'=>'exotel','created_at'=>$time,'updated_at'=>$time,],
        ];
    }
}