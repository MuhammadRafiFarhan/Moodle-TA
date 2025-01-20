<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * TODO describe file settings
 *
 * @package    block_memo
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();
 
 if ($hassiteconfig) { // Check if the user has the capability to configure site settings.
     $settings = new admin_settingpage('block_memo', get_string('pluginname', 'block_memo'));
 
     // Add a setting to enable/disable the memo block globally.
     $settings->add(new admin_setting_configcheckbox(
         'block_memo/enableblock',
         get_string('enableblock', 'block_memo'),
         get_string('enableblockdesc', 'block_memo'),
         1 // Default is enabled.
     ));
 
     // Add a setting for the default memo content.
     $settings->add(new admin_setting_configtextarea(
         'block_memo/defaultcontent',
         get_string('defaultcontent', 'block_memo'),
         get_string('defaultcontentdesc', 'block_memo'),
         '' // Default is empty.
     ));
 
     $ADMIN->add('blocksettings', $settings);
 }
 