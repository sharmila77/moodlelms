<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'sqlsrv';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle_lms_db';
$CFG->dbuser    = 'dbadmin';
$CFG->dbpass    = 'P@ssw0rd';
$CFG->prefix    = 'mdl_';
$CFG->wwwroot   = 'http://lmsstaging.moodle.in';
$CFG->localwwwroot   = 'http://lmsstaging.moodle.in';
$CFG->dataroot  = 'D:\\portal\\moodle_lms\\moodledata';
$CFG->admin     = 'admin';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbsocket' => '',
);

$CFG->directorypermissions = 0777;
$CFG->debug = (E_ALL | E_STRICT);
$CFG->debugdisplay = 1;

require_once(__DIR__ . '/lib/setup.php');
