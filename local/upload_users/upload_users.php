<?php
global $USER, $OUTPUT, $PAGE, $CFG;

require_once('../../config.php');
require_once($CFG->libdir . '/csvlib.class.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot . '/admin/tool/uploaduser/locallib.php');
require_once($CFG->dirroot . '/local/upload_users/upload_users_moodleform.php');
require_once($CFG->dirroot . '/local/upload_users/lib.php');

require_capability('local/csvuploader:uploadcsv', context_system::instance());

// Setting up necessary page context
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_upload_users')); // To display the title in the browser tab
$PAGE->set_url('/local/upload_users/upload_users.php');
$PAGE->set_cacheable(true);
$PAGE->set_heading(get_string('pluginname', 'local_upload_users'));

echo $OUTPUT->header();
echo $OUTPUT->heading_with_help(get_string('pluginname', 'local_upload_users'), 'pluginname', 'local_upload_users');

$mform = new upload_users_moodleform($CFG->wwwroot . '/local/upload_users/upload_users.php');
$returnurl = new moodle_url('local/upload_users/upload_users.php');

// Get formdata and parse the records
if ($data = $mform->get_data(false)) {
    $iid = csv_import_reader::get_new_iid('uploaduser');
    $cir = new csv_import_reader($iid, 'uploaduser');

    $content = $mform->get_file_content('userfile');

    $readcount = $cir->load_csv_content($content, 'UTF-8', ',');
    $csvloaderror = $cir->get_error();
    unset($content);

    if (!is_null($csvloaderror)) {
        print_error('csvloaderror', '', $returnurl, $csvloaderror);
    }

    // Function to create users from uploaded CSV
    $result = create_upload_users_job($cir, $data);

    $cir->close();
    $cir->cleanup(false); // only currently uploaded CSV file
}

echo $mform->render();
echo $OUTPUT->footer();
die();