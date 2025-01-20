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
 * Block block_memo
 *
 * Documentation: {@link https://moodledev.io/docs/apis/plugintypes/blocks}
 *
 * @package    block_memo
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_memo extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_memo');
        //$this->page->requires->css('/blocks/memo/styles.css');
    }

    public function applicable_formats() {
        return ['site' => true, 'course' => true];
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = $this->get_memo_form();
        $this->content->footer = '';

        return $this->content;
    }
    private function get_memo_form() {
        global $USER, $DB;
    
        $memos = $DB->get_records('block_memo', ['userid' => $USER->id]);
    
        $html = html_writer::start_tag('form', ['method' => 'post', 'action' => new moodle_url('/blocks/memo/save.php')]);
        $html .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()]);
        $html .= html_writer::tag('textarea', '', ['name' => 'memo', 'rows' => 4, 'cols' => 50]);
        $html .= html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('savememo', 'block_memo')]);
        $html .= html_writer::end_tag('form');
    
        if ($memos) {
            $html .= html_writer::start_tag('ul');
            foreach ($memos as $memo) {
                $html .= html_writer::tag('li', s($memo->content));
            }
            $html .= html_writer::end_tag('ul');
        }
    
        return $html;
    }
}
