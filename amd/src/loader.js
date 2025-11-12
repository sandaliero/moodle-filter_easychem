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
 * Easychem JS Loader.
 *
 * @module     filter_easychem/loader
 * @copyright  2014 Carl LeBlond, 2025 Andrey Smirnov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    return {
        /**
         * Called by the filter when an equation is found while rendering the page.
         *
         * @method typeset
         */
        typeset: function() {
            // Wait for DOM to be ready and easychem to be loaded
            $(document).ready(function() {
                $('.echem-formula').each(function() {
                    var node = $(this);
                    var src = node.html();

                    // Take care of problem with | character and replace problem!
                    var str = src.split("|");
                    console.log(str); // Consider replacing with proper logging

                    for(var i = 0; i < str.length; i++) {
                        str[i] = str[i].replace("&gt;", ">").replace("&lt;","<");
                    }
                    src = str.join("|");

                    // Check if ChemSys is available
                    if (typeof ChemSys !== 'undefined') {
                        var res = ChemSys.compile(src);
                        node.empty();
                        ChemSys.draw(node[0], res);
                    } else {
                        console.error('Easychem ChemSys not loaded');
                    }
                });
            });
        }
    };
});
