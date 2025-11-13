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

namespace filter_easychem;

use moodle_url;

/**
 * Filter converting [%  %] to easychem chemical structures and formulas
 *
 * @package    filter_easychem
 * @copyright  2014 Carl LeBlond, 2025 Andrey Smirnov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class text_filter extends \core_filters\text_filter {

    protected static $globalconfig;

    #[\Override]
    public function filter($text, array $options = []) {
        global $CFG, $PAGE, $easychemconfigured;
        $search = "(\[\%(.*?)\\%])is";
        $newtext = preg_replace_callback($search, array($this, 'callback'), $text);
        if (($newtext != $text) && !isset($easychemconfigured)) {
            $easychemconfigured = true;
            $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/filter/easychem/js/easychem.js'));
            $PAGE->requires->js_call_amd('filter_easychem/loader', 'typeset');
        }
        return $newtext;
    }

    private function callback(array $matches) {
        global $CFG, $PAGE;
        $embed = '<div class="echem-formula" align="center">'.$matches[1].'</div>';
        return $embed;
    }
}
