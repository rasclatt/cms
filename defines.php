<?php
/**
*	@Copyright	nUberSoft.com All Rights Reserved.
*	@License	License available for review in license text document in root
*/
define("DS", DIRECTORY_SEPARATOR);
define("NBR_ROOT_DIR", __DIR__);
define('NBR_CORE', NBR_ROOT_DIR.DS.'core');
define('NBR_SETTINGS', NBR_CORE.DS.'settings');
define("NBR_WORKFLOWS", NBR_SETTINGS.DS.'workflows');
define("NBR_BLOCKFLOWS", NBR_SETTINGS.DS.'blockflows');
define("NBR_CLASS_CORE", NBR_ROOT_DIR.DS.'vendor');
define("NBR_PLUGINS", NBR_CORE.DS.'plugins');
define("NBR_CLIENT_DIR", NBR_ROOT_DIR.DS.'client');
define("NBR_CLIENT_PLUGINS", NBR_CLIENT_DIR.DS.'plugins');
define("NBR_CLIENT_SETTINGS", NBR_CLIENT_DIR.DS.'settings');
define("NBR_CLIENT_CACHE", NBR_CLIENT_SETTINGS.DS.'cache');
define("NBR_CLIENT_WORKFLOWS", NBR_CLIENT_SETTINGS.DS.'workflows');
define("NBR_CLIENT_BLOCKFLOWS", NBR_CLIENT_SETTINGS.DS.'blockflows');
define("NBR_CLIENT_TEMPLATES", NBR_CLIENT_DIR.DS.'template');
define("NBR_RENDER_LIB", NBR_CORE.DS.'renderlib');
define("NBR_TEMPLATE_DIR", NBR_CORE.DS.'template');
define("NBR_DEFAULT_TEMPLATE", NBR_TEMPLATE_DIR.DS.'default');
define("NBR_NAMESPACE_CORE", NBR_ROOT_DIR.DS.'vendor');
define("NBR_VENDOR", NBR_NAMESPACE_CORE);
define("NBR_FUNCTIONS", NBR_VENDOR.DS.'Nubersoft'.DS.'functions');
define("NBR_ENGINE_CORE", NBR_CORE.DS.'engine');
define("NBR_ENGINE_CLIENT", NBR_CLIENT_SETTINGS.DS.'engine');

define("NBR_CLIENT_FUNCTIONS", NBR_CLIENT_DIR.DS.'functions');
define("NBR_CORE_FUNCTIONS", NBR_CORE.DS.'functions');

define("NBR_DOMAIN_ROOT", NBR_ROOT_DIR.DS.'domain');
define("NBR_DOMAIN_CLIENT_DIR", NBR_DOMAIN_ROOT.DS.'client');
define("NBR_THUMB_DIR", NBR_DOMAIN_CLIENT_DIR.DS.'thumbs');
define("NBR_MEDIA", NBR_DOMAIN_CLIENT_DIR.DS.'media');
define("NBR_MEDIA_IMAGES", NBR_MEDIA.DS.'images');
define("NBR_MEDIA_CSS", NBR_MEDIA.DS.'css');
define("NBR_MEDIA_JS", NBR_MEDIA.DS.'js');
define("NBR_DATABASE_CREDS", NBR_CLIENT_SETTINGS.DS.'dbcreds.php');
define("URL_CORE_MEDIA", '/core/template/default/media');
define("URL_CORE_IMAGES", URL_CORE_MEDIA.'/images');
define("NBR_DOMAIN_DEFAULT_TEMPLATE", NBR_DOMAIN_ROOT.DS.'core'.DS.'template'.DS.'default');

# Set the environment. FALSE is NBR, WP -> Wordpress, MAGE -> Magento
define('NBR_PLATFORM',false);
# Add custom defines
if(is_file($defines = NBR_CLIENT_SETTINGS.DS.'defines.php')) {
	include_once($defines);
}