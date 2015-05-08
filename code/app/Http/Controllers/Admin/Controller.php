<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller
 *
 * @package     Controllers
 * @author      Ladybird <info@ladybirdweb.com>
 */
abstract class Controller extends BaseController {

	use DispatchesCommands,
	ValidatesRequests;
}
