<?php
/**
 * Plugin Name: Publishing Conditions
 * Description: Prevent yourself from publishing unfinished posts.
 * Version:     1.0.2
 * Author:      Mauro Bringolf
 * Author URI:  https://maurobringolf.ch
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: publishing-conditions
 *
 * @package Publishing_Conditions
 */

namespace MauroBringolf\Publishing_Conditions;

require_once 'src/class-main.php';

Main::instance()->run();
