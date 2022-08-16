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

require('../../config.php');
require_once($CFG->dirroot.'/report/duplicateaccounts/locallib.php');

$page 	        = optional_param('page', 0, PARAM_INT);
$perpage        = optional_param('perpage', 30, PARAM_INT);   

$PAGE->set_url('/report/duplicateaccounts/index.php');
$PAGE->set_pagelayout('report');

require_login();

$PAGE->set_title(get_string('pluginname','report_duplicateaccounts'));
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname','report_duplicateaccounts'));

$results = report_duplicateaccounts_print_result($page*$perpage, $perpage);
$resultcount = count(report_duplicateaccounts_print_result());

$baseurl = new moodle_url('/report/duplicateaccounts/index.php', array('perpage' => $perpage, 'page'=>$page));
$site = get_site();

flush();

if (!$results){    
    echo get_string('norecordfound','report_duplicateaccounts');
    $table = NULL;
}else{

	$table = new html_table();
    $table->head = array();
    $table->align = array();

    $table->head[] = 'Username';
    $table->head[] = 'Firstname';
    $table->head[] = 'Lastname';
    $table->head[] = 'Email';

    $table->width = "95%";

    foreach ($results as $r) {
    	$row = array();
        $row[] = "<a href=\"../../user/view.php?id=$r->id&amp;course=$site->id\">$r->username</a>";
        $row[] = $r->firstname;
        $row[] = $r->lastname;
        $row[] = $r->email;
        $table->data[] = $row; 
    }

    if (!empty($table)) {    
        echo html_writer::table($table);
        echo $OUTPUT->paging_bar($resultcount, $page, $perpage, $baseurl);
    }
}

echo $OUTPUT->footer();