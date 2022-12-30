<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//Production Value: 
defined('SITE_ROOT') ? null : define('SITE_ROOT', '');
defined('BASE_URL') ? null : define('BASE_URL', '');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
defined('LAYOUT_PATH') ? null : define('LAYOUT_PATH', SITE_ROOT.DS.'layouts');


//Define Contstants
defined('FULFILLMENT_REQUEST') ? null : define('FULFILLMENT_REQUEST', 0);
defined('STANDARD_USER') ? null : define('STANDARD_USER', 1);
defined('ADMINISTRATOR') ? null : define('ADMINISTRATOR', 2);
defined('PRIMARY_ADMINISTRATOR') ? null : define('PRIMARY_ADMINISTRATOR', 3);
defined('IS_DEMO') ? null : define('IS_DEMO', false);

//load configuration file
require_once(LIB_PATH.DS.'config.php');

//load functions
require_once(LIB_PATH.DS.'functions.php');

//load objects
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'pagination.php');

//load database related classes
require_once(LIB_PATH.DS.'admin_menu.php');
require_once(LIB_PATH.DS.'contact.php');
require_once(LIB_PATH.DS.'country.php');
require_once(LIB_PATH.DS.'expert.php');
require_once(LIB_PATH.DS.'journal.php');
require_once(LIB_PATH.DS.'media.php');
require_once(LIB_PATH.DS.'page.php');
require_once(LIB_PATH.DS.'quick_access.php');
require_once(LIB_PATH.DS.'request.php');
require_once(LIB_PATH.DS.'setting.php');
require_once(LIB_PATH.DS.'slideshow.php');
require_once(LIB_PATH.DS.'slideshow_picture.php');
require_once(LIB_PATH.DS.'user.php');