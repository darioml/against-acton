<?php

/*
	Bootstrap file which includes all of the various bits we're gonna use.
*/

//We need a database!
require __DIR__.'/db.php';

//If this is production, turn error reporting off...
if(!LOCAL)
{
    error_reporting(0);
}

//Model to interact with the signatures table.
require __DIR__.'/models/signatures.php';
$signatures = new signatures($db);

//Anti CSRF styff
require __DIR__.'/models/nocsrf.php';

//Let's get Twig set up
require __DIR__.'/../libs/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/views/');
$twig = new Twig_Environment($loader);

//User Agent Parsing library
include __DIR__.'/../libs/uaparser/php/uaparser.php';
//Our Model for it
include __DIR__.'/models/analytics.php';

define('CACHEDIR', __DIR__.'/../cache');

session_start();

if(LOCAL)
{
	if(!function_exists('pam_auth'))
	{
		function pam_auth($user, $pass)
		{
        	if ($pass == "loveacton")
        	{
        		return true;
        	}
        	return false;
        }
    }

	if(!function_exists('ldap_get_info'))
	{
        function ldap_get_info($user)
        {
            return array("",
                            "",
                            "Department",
                            "Faculty",
                            "Imperial College"
                            );
        }
    }
}
