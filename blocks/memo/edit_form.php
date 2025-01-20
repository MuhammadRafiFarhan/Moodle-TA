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
 * Form for editing block_memo instances
 *
 * @package    block_memo
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/edit_form.php');

class block_memo_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Add a header for memo block settings.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Add a text input field for a default memo title.
        $mform->addElement('text', 'config_title', get_string('defaulttitle', 'block_memo'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('pluginname', 'block_memo'));

        // Add a textarea for default memo content.
        $mform->addElement('textarea', 'config_content', get_string('defaultcontent', 'block_memo'), 'wrap="virtual" rows="4" cols="50"');
        $mform->setType('config_content', PARAM_TEXT);
        $mform->setDefault('config_content', '');
    }
}