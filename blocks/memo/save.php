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
 * TODO describe file save
 *
 * @package    block_memo
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require_once('../../config.php');

 require_login();
 
 $context = context_system::instance();
 require_capability('block/memo:addinstance', $context);
 
 // Check if the request is valid.
 if (!confirm_sesskey()) {
     throw new moodle_exception('invalidsesskey');
 }
 
 // Get form data.
 $memo = required_param('memo', PARAM_TEXT);
 
 // Insert the memo into the database.
 $record = new stdClass();
 $record->userid = $USER->id;
 $record->content = $memo;
 $record->timecreated = time();
 
 $DB->insert_record('block_memo', $record);
 
 // Redirect back to the page where the form was submitted.
 redirect(new moodle_url('/my/'), get_string('memosaved', 'block_memo'), null, \core\output\notification::NOTIFY_SUCCESS);