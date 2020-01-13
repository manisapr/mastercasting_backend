<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('time_elapsed_string'))
{
    function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	} 
}

if ( ! function_exists('test_helper'))
{
    function test_helper($var) {
	    echo $var;
	} 
}

if ( ! function_exists('date_convert'))
{
 //    function date_convert($time, $format, $newTZ = 'America/Chicago') {
	//     $date = new DateTime($time);
	// 	$date->setTimezone(new DateTimeZone($newTZ)); // +04

	// 	return $date->format($format);
	// }

	function date_convert($time, $format, $oldTZ = 'UTC', $newTZ='America/Chicago') {
        // create old time
        $d = new \DateTime($time, new \DateTimeZone($oldTZ));
        // convert to new tz
        $d->setTimezone(new \DateTimeZone($newTZ));

        // output with new format
        return $d->format($format);
    }
}


if(!function_exists('get_browser_name'))
{
	function get_browser_name()
	{
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
	       return 'ie';
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
	        return 'ie';
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
	       return 'mf';
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
	       return 'gc';
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
	       return "om";
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
	       return "o";
	    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
	       return "s";
	    else
	       return 'Something else';
	}
}