<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/mysqli_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";

$orderby = 'last_name';
$filter = '';

// read the query from the url to get the letter to filter results by and how to sort them, store them in variables
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

if (isset($_GET['sortby'])) {
    $orderby = $_GET['sortby'];
}

if (isset($_GET['clearfilter'])){
    $filter = '';
}

// use the variables obtained from the url to query the database
$sql = "SELECT * FROM $db_table WHERE last_name LIKE '$filter%' ORDER BY $orderby ASC";

$result = $db->query($sql);

// check if any results exist for the letter specified, if not, display error message
if ($result->num_rows == 0) {
    echo "<h2 class=\"mt-4 alert alert-warning\">No Records for <strong>last names</strong> starting with <strong>$filter</strong></h2>";
} else { // otherwise, display the number of results in the alert box at the top of the page
    if(empty($filter)){
        $text = '';
    } else {
        $text = " - last names starting with $filter";
    }
    echo "<h2 class=\"mt-4 alert alert-primary\">$result->num_rows Records" . $text . '</h2>';
}

// display alphabet filters
display_letter_filters($filter);

// display message if any
display_message();

// display the data
display_record_table($result);

# close the database
$db->close();