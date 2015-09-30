@extends('themes.default1.installer.layout.installer')
@section('content')
<h1>Prerequisites</h1>
<div class="login-box-body" >
<!-- form-box -->
<?php
define('PROBE_VERSION', '4.2');
define('PROBE_FOR', '<b>Faveo</b>HELPDESK 1.0 and Newer');
define('STATUS_OK', 'ok');
define('STATUS_WARNING', 'warning');
define('STATUS_ERROR', 'error');
class TestResult {
	var $message;
	var $status;

	function TestResult($message, $status = STATUS_OK) {
		$this->message = $message;
		$this->status = $status;
	}
}
?>

<p>Test/Probe Prerequisites required to be installed</p>

<div id="wrapper">
      <h1>Probe</h1>

        <b>Probe Version:</b>
        <?php echo PROBE_VERSION?>
        <br>
        <b>Testing For:</b>
        <?php echo PROBE_FOR?>
  	<h2>1. Environment test</h2>
	 <ul>
	 <?php

function validate_php(&$results) {
	if (version_compare(PHP_VERSION, '5.5') == -1) {
		$results[] = new TestResult('Minimum PHP version required in order to run Faveo HELPDESK is PHP 5.5. Your PHP version: ' . PHP_VERSION, STATUS_ERROR);
		return false;
	} else {
		$results[] = new TestResult('Your PHP version is ' . PHP_VERSION, STATUS_OK);
		return true;
	} // if
} // validate_php

/**
 * Convert filesize value from php.ini to bytes
 *
 * Convert PHP config value (2M, 8M, 200K...) to bytes. This function was taken from PHP documentation. $val is string
 * value that need to be converted
 *
 * @param string $val
 * @return integer
 */
function php_config_value_to_bytes($val) {
	$val = trim($val);
	$last = strtolower($val{strlen($val) - 1});
	switch ($last) {
		// The 'G' modifier is available since PHP 5.1.0
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	} // if

	return (integer) $val;
} // php_config_value_to_bytes

/**
 * Validate memory limit
 *
 * @param array $result
 */
function validate_memory_limit(&$results) {
	$memory_limit = php_config_value_to_bytes(ini_get('memory_limit'));

	$formatted_memory_limit = $memory_limit === -1 ? 'unlimited' : format_file_size($memory_limit);

	if ($memory_limit === -1 || $memory_limit >= 67108864) {
		$results[] = new TestResult('Your memory limit is: ' . $formatted_memory_limit, STATUS_OK);
		return true;
	} else {
		$results[] = new TestResult('Your memory is too low to complete the installation. Minimal value is 64MB, and you have it set to ' . $formatted_memory_limit, STATUS_ERROR);
		return false;
	} // if
} // validate_memory_limit

/**
 * Format filesize
 *
 * @param string $value
 * @return string
 */
function format_file_size($value) {
	$data = array(
		'TB' => 1099511627776,
		'GB' => 1073741824,
		'MB' => 1048576,
		'kb' => 1024,
	);

	// commented because of integer overflow on 32bit sistems
	// http://php.net/manual/en/language.types.integer.php#language.types.integer.overflow
	// $value = (integer) $value;
	foreach ($data as $unit => $bytes) {
		$in_unit = $value / $bytes;
		if ($in_unit > 0.9) {
			return trim(trim(number_format($in_unit, 2), '0'), '.') . $unit;
		} // if
	} // foreach

	return $value . 'b';
} // format_file_size

function validate_zend_compatibility_mode(&$results) {
	$ok = true;

	if (version_compare(PHP_VERSION, '5.0') >= 0) {
		if (ini_get('zend.ze1_compatibility_mode')) {
			$results[] = new TestResult('zend.ze1_compatibility_mode is set to On. This can cause some strange problems. It is strongly suggested to turn this value to Off (in your php.ini file)', STATUS_WARNING);
			$ok = false;
		} else {
			$results[] = new TestResult('zend.ze1_compatibility_mode is turned Off', STATUS_OK);
		} // if
	} // if

	return $ok;
} // validate_zend_compatibility_mode

function validate_extensions(&$results) {
	$ok = true;

	$required_extensions = array('mysqli', 'mcrypt', 'openssl', 'pdo', 'pdo_sqlite', 'pdo_mysql', 'sqlite3');

	foreach ($required_extensions as $required_extension) {
		if (extension_loaded($required_extension)) {
			$results[] = new TestResult("Required extension '$required_extension' found", STATUS_OK);
		} else {
			$results[] = new TestResult("Extension '$required_extension' is required in order to run Faveo Helpdesk ", STATUS_ERROR);
			$ok = false;
		} // if
	} // foreach

	// Check for eAccelerator
	if (extension_loaded('eAccelerator') && ini_get('eaccelerator.enable')) {
		$results[] = new TestResult("eAccelerator opcode cache enabled. <span class=\"details\">eAccelerator opcode cache causes Faveo Helpdesk to crash. <a href=\"https://eaccelerator.net/wiki/Settings\">Disable it</a> for folder where Faveo Helpdesk is installed, or use APC instead: <a href=\"http://www.php.net/apc\">http://www.php.net/apc</a>.</span>", STATUS_ERROR);
		$ok = false;
	} // if

	// Check for XCache
	if (extension_loaded('XCache') && ini_get('xcache.cacher')) {
		$results[] = new TestResult("XCache opcode cache enabled. <span class=\"details\">XCache opcode cache causes Faveo Helpdesk to crash. <a href=\"http://xcache.lighttpd.net/wiki/XcacheIni\">Disable it</a> for folder where Faveo Helpdesk is installed, or use APC instead: <a href=\"http://www.php.net/apc\">http://www.php.net/apc</a>.</span>", STATUS_ERROR);
		$ok = false;
	} // if

	$recommended_extensions = array(

		// 'gd' => 'GD is used for image manipulation. Without it, system is not able to create thumbnails for files or manage avatars, logos and project icons. Please refer to <a href="http://www.php.net/manual/en/image.installation.php">this</a> page for installation instructions',
		// 'mbstring' => 'MultiByte String is used for work with Unicode. Without it, system may not split words and string properly and you can have weird question mark characters in Recent Activities for example. Please refer to <a href="http://www.php.net/manual/en/mbstring.installation.php">this</a> page for installation instructions',
		'curl' => 'cURL is used to support various network tasks. Please refer to <a href="http://www.php.net/manual/en/curl.installation.php">this</a> page for installation instructions',
		// 'iconv' => 'Iconv is used for character set conversion. Without it, system is a bit slower when converting different character set. Please refer to <a href="http://www.php.net/manual/en/iconv.installation.php">this</a> page for installation instructions',
		// 'imap' => 'IMAP is used to connect to POP3 and IMAP servers. Without it, Incoming Mail module will not work. Please refer to <a href="http://www.php.net/manual/en/imap.installation.php">this</a> page for installation instructions',
		// 'zlib' => 'ZLIB is used to read and write gzip (.gz) compressed files',
		// SVN extension ommited, to avoid confusion
	);

	foreach ($recommended_extensions as $recommended_extension => $recommended_extension_desc) {
		if (extension_loaded($recommended_extension)) {
			$results[] = new TestResult("Recommended extension '$recommended_extension' found", STATUS_OK);
		} else {
			$results[] = new TestResult("Extension '$recommended_extension' was not found. <span class=\"details\">$recommended_extension_desc</span>", STATUS_WARNING);
		} // if
	} // foreach

	return $ok;
} // validate_extensions

// ---------------------------------------------------
//  Do the magic
// ---------------------------------------------------

$results = array();

$php_ok = validate_php($results);
$memory_ok = validate_memory_limit($results);
$extensions_ok = validate_extensions($results);
$compatibility_mode_ok = validate_zend_compatibility_mode($results);

foreach ($results as $result) {
	print '<li class="' . $result->status . '"><span>' . $result->status . '</span> &mdash; ' . $result->message . '</li>';
} // foreach
if ($php_ok && $memory_ok && $extensions_ok && $compatibility_mode_ok) {
	?>
</div> 	<form action="{{URL::route('postprerequisites')}}" method="post"><input type="hidden" name="_token" value="{{ csrf_token() }}"><br>
  <a href="{{URL::route('licence')}}" style="text-color:black" id="access1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prev</a> <input type="submit"  id="access" value="Next">
 	</form>
  <br>
 	<?php
} else {
	?></div><br>
<a href="{{URL::route('licence')}}" style="text-color:black"><button value="prev" id="access1">Prev</button></a> <input type="submit" value="Next" id="access" disabled=""> <?php
}
?>
<style type="text/css">
a:link    {color:#000;}  /* unvisited link  */
a:visited {color:#000;}  /* visited link    */
a:hover   {color:#000;}  /* mouse over link */
a:active  {color:#000;}
</style>
<p><br>
<div id="legend">
        <ul>
          <li class="ok"><span>ok</span> &mdash; All OK</li>
          <li class="warning"><span>warning</span> &mdash; Not a deal breaker, but it's recommended to have this installed for some features to work</li>
          <li class="error"><span>error</span> &mdash; Faveo HELPDESK require this feature and can't work without it</li>
        </ul>
      </div>
</div>
</p>

@stop