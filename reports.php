<?php
/*
Plugin Name: Weather Alerts
Plugin URI: http://ruvictor.com
Description: This plugin is showing Weather Alerts.
Author: Victor Rusu
Author URI: http://ruvictor.com
Version: 1.0
Licence: GPLv2
*/

//Exit if accessed directly
if(!defined('ABSPATH')){
	exit;
}

function ruvictor_weather_alert(){
	$ch = curl_init();
	$header = array('HTTP_ACCEPT: application/atom+xml;version=1', 'Cookie: foo=bar\r\n', 'User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n');

	curl_setopt($ch, CURLOPT_URL, "https://api.weather.gov/alerts/active/zone/AKZ201"); # URL to post to
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); # return into a variable
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header ); # custom headers, see above

	$result = curl_exec( $ch ); # run!
	$result = json_decode($result);
	curl_close($ch);
	if(substr($result->features[0]->properties->effective, 0,10) == date("Y-m-d"))
		$content = '<div class="weather_alert">' . $result->features[0]->properties->headline . '</div>';
	else
		$content = '';
	return $content;
}
add_shortcode('weather_alert', 'ruvictor_weather_alert');
?>