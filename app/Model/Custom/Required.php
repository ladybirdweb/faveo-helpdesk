<?php
namespace App\Model\Custom;
use Illuminate\Database\Eloquent\Model;
class Required extends Model
{
    protected $table="requireds";
    protected $fillable = [
        'field','agent','client','parent','form','option','label',
    ];
}