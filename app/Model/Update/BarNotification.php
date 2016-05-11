<?php namespace App\Model\Update;

use Illuminate\Database\Eloquent\Model;

class BarNotification extends Model {

	protected $table = "bar_notifications";
        protected $fillable = ['key','value'];

}
