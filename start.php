<?php
/**
 * This file is included when the plugin starts
 */

require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/events.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/lib/page_handlers.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "security_tools_init");

/**
 * Function is called when the Elgg system initializes
 *
 * @return void
 */
function security_tools_init() {
	// check if we are running upgrade.php
	if (defined("UPGRADING")) {
		security_tools_protect_upgrade();
	}

	// extend views
	elgg_extend_view("admin/settings/advanced/site_secret", "security_tools/site_secret");
	elgg_extend_view("input/password", "security_tools/input_password", 100);

	// register page handlers
	elgg_register_page_handler("email_change_confirmation", "security_tools_email_change_confirmation_page_handler");
	
	// register events
	elgg_register_event_handler("make_admin", "user", "security_tools_make_admin_handler");
	elgg_register_event_handler("remove_admin", "user", "security_tools_remove_admin_handler");
	
	// register plugin hooks
	elgg_unregister_plugin_hook_handler("usersettings:save", "user", "users_settings_save");
	elgg_register_plugin_hook_handler("usersettings:save", "user", "security_tools_usersettings_save_handler");
	
}
