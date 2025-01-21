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
 * @package    block_memo_block
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();
 
 class block_memo_block extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_memo_block');
    }

    public function get_content() {
        global $DB, $USER, $OUTPUT;

        // Initialize $this->content if not already initialized
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        // Check if the form was submitted to save a new memo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['memo_text'])) {
            $memo_text = clean_text($_POST['memo_text']);

            // Ensure the memo_text is not empty
            if (!empty($memo_text)) {
                // Create a new record for the memo
                $memo_record = new stdClass();
                $memo_record->memo_text = $memo_text;
                $memo_record->userid = $USER->id;
                $memo_record->block_instance_id = $this->instance->id;  // Fix here
                $memo_record->created_at = date('Y-m-d H:i:s');

                // Save the memo to the database
                $DB->insert_record('block_memo_settings', $memo_record);

                // Store a flag in the session to trigger the redirect after content is generated
                $_SESSION['memo_saved'] = true;
            } else {
                $this->content->text = '<p>Please enter some text for the memo.</p>';
            }
        }

        // Retrieve all memos associated with the current user
        $memos = $DB->get_records('block_memo_settings', ['userid' => $USER->id]);

        // Display the saved memos
        if ($memos) {
            $memos_content = '';
            foreach ($memos as $memo) {
                $memos_content .= '<div class="memo-item">';
                $memos_content .= '<p>' . format_text($memo->memo_text) . '</p>';
                $memos_content .= '<p><em>' . userdate($memo->created_at) . '</em></p>';
                $memos_content .= '</div>';
            }
            $this->content->text = $memos_content;
        } else {
            $this->content->text = '<p>No memos saved yet.</p>';
        }

        // Display the form to add a new memo
        $this->content->text .= '
            <div class="memo-content">
                <form method="POST">
                    <textarea name="memo_text" rows="4" cols="50" placeholder="Enter your memo here..." class="memo-textarea"></textarea><br>
                    <input type="submit" value="Save Memo" />
                </form>
            </div>
        ';

        // Perform the redirect after the content is generated (post-content rendering)
        if (isset($_SESSION['memo_saved']) && $_SESSION['memo_saved'] === true) {
            unset($_SESSION['memo_saved']);  // Clear the session flag
            redirect(new moodle_url('/'), get_string('memosaved', 'block_memo_block'));
        }

        return $this->content;
    }

    public function applicable_formats() {
        return ['site-index' => true, 'course-view' => true, 'my' => true];
    }

    public function has_config() {
        return true;
    }
}