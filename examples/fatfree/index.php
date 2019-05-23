<?php

// Kickstart the framework
require_once __DIR__."/../../vendor/autoload.php";
use Pachel\dbClass;

$f3=Base::instance();

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config(__DIR__.'/config.ini');

$f3->set("db",dbClass::instance());

$f3->route('GET /',
	function($f3) {
		echo View::instance()->render('layout.html');
	}
);
$f3->run();
