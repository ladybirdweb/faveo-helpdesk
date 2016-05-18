<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



/**
 * ======================================
 * Attchment Model
 * ======================================
 * This is a model representing the attachment table.
 *
 * @author Ladybird <info@ladybirdweb.com>
 */
class BaseModel extends Model {

    public function setAttribute($property, $value) {
//
//        require_once base_path('vendor'.DIRECTORY_SEPARATOR.'htmlpurifier'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'HTMLPurifier.auto.php');
//              
//        $config = \HTMLPurifier_Config::createDefault();
//        $purifier = new \HTMLPurifier($config);
//        //settings name
//        if ($this->table == 'settings_system') {
//            if ($this->$property != 'name') {
//                $value = strip_tags($value);
//            } else {
//                $value = $purifier->purify($value);
//            }
//        }
//
//        $value = $purifier->purify($value);
//        parent::setAttribute($property, $value);        
    }

}
