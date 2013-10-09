<?php
/*********************************************************************
    setup.inc.php

    Master include file for setup/install scripts.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/

#This  version - changed on every release
define('THIS_VERSION', '1.7-git');

#inits - error reporting.
$error_reporting = E_ALL & ~E_NOTICE;
if (defined('E_STRICT')) # 5.4.0
    $error_reporting &= ~E_STRICT;
if (defined('E_DEPRECATED')) # 5.3.0
    $error_reporting &= ~(E_DEPRECATED | E_USER_DEPRECATED);

error_reporting($error_reporting);
ini_set('magic_quotes_gpc', 0);
ini_set('session.use_trans_sid', 0);
ini_set('session.cache_limiter', 'nocache');
ini_set('display_errors',1); //We want the user to see errors during install process.
ini_set('display_startup_errors',1);

#Disable Globals if enabled
if(ini_get('register_globals')) {
    ini_set('register_globals',0);
    foreach($_REQUEST as $key=>$val)
        if(isset($$key))
            unset($$key);
}

#clear global vars
$errors=array();
$msg='';

#define constants.
define('SETUPINC',true);
require('../bootstrap.php');

#start session
session_start();

define('URL',rtrim((Bootstrap::https()?'https':'http').'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']),'setup'));

#define paths
define('INC_DIR',dirname(__file__).'/inc/'); //local include dir!

#required files
require_once(INCLUDE_DIR.'class.setup.php');
require_once(INCLUDE_DIR.'class.validator.php');
require_once(INCLUDE_DIR.'class.passwd.php');
require_once(INCLUDE_DIR.'class.format.php');
require_once(INCLUDE_DIR.'class.misc.php');

if (extension_loaded('mysqli'))
    require_once INCLUDE_DIR.'mysqli.php';
else
    require(INCLUDE_DIR.'mysql.php');

?>
