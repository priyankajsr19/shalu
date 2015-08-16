<?php

if (in_array(substr($_SERVER['REQUEST_URI'], -3), array('png', 'jpg', 'gif')))
{
	require_once(dirname(__FILE__).'/config/settings.inc.php');
	header('Location: '.__PS_BASE_URI__.'img/404.gif');
	exit;
}
elseif (in_array(substr($_SERVER['REQUEST_URI'], -3), array('.js', 'css')))
	die('');

require_once(dirname(__FILE__).'/config/config.inc.php');

ControllerFactory::getController('MeasurementController')->run();
