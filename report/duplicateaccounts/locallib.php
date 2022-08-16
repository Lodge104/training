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
 * Duplicate user accounts report
 *
 * @package    report_duplicateaccounts
 * @copyright  2013 Jen Andes {jen.andes2011@gmail.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Return list of duplicate user accounts
 *
 * @return array
 */
function report_duplicateaccounts_print_result($page=0, $recordsperpage=0){
	global $DB;

	return $DB->get_records_sql("SELECT id,username,lastname,firstname,email,city, country FROM {user}
    			WHERE lastname IN (SELECT lastname FROM {user}  WHERE deleted<>1 GROUP BY lastname HAVING count(lastname)>1) AND firstname IN (SELECT firstname FROM {user} WHERE deleted<>1 GROUP BY firstname HAVING count(firstname)>1) ORDER BY firstname", null, $page, $recordsperpage);   	

}
