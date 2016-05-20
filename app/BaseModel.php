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

        require_once base_path('vendor' . DIRECTORY_SEPARATOR . 'htmlpurifier' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'HTMLPurifier.auto.php');

        $config = \HTMLPurifier_Config::createDefault();
        //dd($config);
        $purifier = new \HTMLPurifier($config);
        
        if ($value != strip_tags($value)) {
            $value = $purifier->purify($value);
        }
        parent::setAttribute($property, $value);
    }

}
