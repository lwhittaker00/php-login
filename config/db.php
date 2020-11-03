<?php
ob_start(); # Enables the user of headers
if(!isset($_SESSION)){
    session_start();
}

$hostname='';
$username='';
$password='';
$dbname='';

$connection = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.");

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['initialize'])) {
    initialize();
}
function initialize() {
    // Temporary variable, used to store current query
    $filename='/php-login/config/university.sql';
    $templine = '';
    // Read in entire file
    $lines = file($_SERVER['DOCUMENT_ROOT'].$filename);
    // Loop through each line
    foreach ($lines as $line) {
	echo $line.'<br>';
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
	    continue;
	if (substr($line,0,2)=='/*')
	    continue;

	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';') {
	    // Perform the query
	    mysqli_query($connection,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
	    // Reset temp variable to empty
	    $templine = '';
	}
    }    // Temporary variable, used to store current query
    echo "Database Established!";
}
?>
