<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

define('GEN_THEME_COMPONENTS', GEN_THEME_PATH . "/components");
define('GEN_CHILD_COMPONENTS', GEN_CHILD_PATH . "/components");

require_once GEN_MODULES_PATH . "/components/functions.php";
require_once GEN_CLASSES_PATH . "/GEN_Components_Manager.php";
require_once GEN_CLASSES_PATH . "/GEN_Component.php";
require_once GEN_CLASSES_PATH . "/GEN_Theme_Component.php";
