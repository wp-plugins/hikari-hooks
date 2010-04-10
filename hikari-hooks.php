<?php
/*
Plugin Name: Hikari Hooks Troubleshooter
Plugin URI: http://Hikari.ws/hooks-troubleshooter/
Description: Creates a draggable window with informations about all functions hooked to Wordpress actions and filters, so that we can follow what is being run on each hook.
Version: 0.01.06
Author: Hikari
Author URI: http://Hikari.ws
*/

/**!
*
* I, Hikari, from http://Hikari.WS , and the original author of the Wordpress plugin named
* Hikari Hooks Troubleshooter, please keep this license terms and credit me if you redistribute the plugin
*
* Hikari Hooks Troubleshooter,  is licensed under the Creative Commons Attribution-Noncommercial-Share Alike 3.0
* To view a copy of this license, please visit http://creativecommons.org/licenses/by-nc-sa/3.0/
*
*   This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
/*****************************************************************************
* © Copyright Hikari (http://wordpress.Hikari.ws), 2010
* If you want to redistribute this script, please leave a link to
* http://hikari.WS
*****************************************************************************/

define('HkHook_basename',plugin_basename(__FILE__));
define('HkHook_pluginfile',__FILE__);
define('HkHook_cap','troubleshoot_hooks');



require_once 'hikari-tools.php';
require_once 'hikari-hooks-options.php';
require_once 'wp_view_type.php';
require_once 'hikari-hooks-core.php';


