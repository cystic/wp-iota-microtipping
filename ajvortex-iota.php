<?php 
/* 
Plugin Name: Iota Micro Tipping
Plugin URI: http://www.ecologie.io/2017/10/06/introducing-the-ecologie-io-wordpress-microtipping-plugin/
Description: IOTA Micro Tipping. Simple but flexible.
Version: 1.0.0 
Author: Daniel Darden 
Author URI: http://ecologie.io
*/ 

/*  Copyright 2017 Daniel Darden (email: junaidfx@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; If not, see <http://www.gnu.org/licenses/>
*/
define('AJ_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('AJ_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define('AJ_PLUGIN_NAME', trim( dirname( AJ_PLUGIN_BASENAME ), '/' ) );

require_once AJ_PLUGIN_PATH . '/initial_settings.php';

?>
