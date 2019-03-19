<?php // Filename: search-records.php

$pageTitle = "Advanced Search";
require_once 'inc/layout/header.inc.php';
require_once 'inc/db/mysqli_connect.inc.php';
require_once 'inc/functions/functions.inc.php';
require_once 'inc/app/config.inc.php';
?>


<div class="container">
	<div class="row mt-5">
		<div class="col-lg-12">

<?php 

// Code to display search results
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// variable to check if current field is the first one to be filled, so the sql query can be written accordingly
// we change it to 1 when a previous field had been filled before so we know to start the query with an AND
$firstEntry = 0;

    // go through each field, checking to see if it's filled
    // if yes, change the firstEntry to 1, and add the query snippit to a variable that will be concatenated to the final sql query
    if (!empty($_POST["first"])) {
        $firstEntry = 1;
        $first = $_POST["first"];
        $firstSQL = " first_name LIKE '" . $first . "' ";

    // else, leave the variable blank so nothing is added to the final sql query string
    } else {
        $firstSQL = '';
    }

    // repeat above steps to all fields in the form
    if (!empty($_POST["last"])) {
        $last = $_POST["last"];
        if ($firstEntry == 0) {
            $lastSQL = " last_name LIKE '" . $last . "' ";
            $firstEntry = 1;
        } else {
            $lastSQL = " AND last_name LIKE '" . $last . "' ";
        }
    } else {
        $lastSQL = '';
    }

    if (!empty($_POST["sid"])) {
        $sid = $_POST["sid"];
        if ($firstEntry == 0) {
            $sidSQL = " sid LIKE " . $sid . " ";
            $firstEntry = 1;
        } else {
            $sidSQL = " AND sid LIKE " . $sid . " ";
        }
    } else {
        $sidSQL = '';
    }

    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        if ($firstEntry == 0) {
            $emailSQL = " email LIKE '" . $email . "' ";
            $firstEntry = 1;
        } else {
            $emailSQL = " AND email LIKE '" . $email . "' ";
        }
    } else {
        $emailSQL = '';
    }

    if (!empty($_POST["phone"])) {
        $phone = $_POST["phone"];
        if ($firstEntry == 0) {
            $phoneSQL = " phone LIKE '" . $phone . "' ";
            $firstEntry = 1;
        } else {
            $phoneSQL = " AND phone LIKE '" . $phone . "' ";
        }
    } else {
        $phoneSQL = '';
    }

    if (!empty($_POST["gpa"])) {
        $gpa = $_POST["gpa"];
        if ($firstEntry == 0) {
            $gpaSQL = " gpa LIKE " . $gpa . " ";
            $firstEntry = 1;
        } else {
            $gpaSQL = " AND gpa LIKE " . $gpa . " ";
        }
    } else {
        $gpaSQL = '';
    }

    if (!empty($_POST['financial_aid'])) {
        $financial_aid = $_POST["financial_aid"];
        if ($firstEntry == 0) {
            $financial_aidSQL = " financial_aid LIKE " . $financial_aid . " ";
            $firstEntry = 1;
        } else {
            $financial_aidSQL = " AND financial_aid LIKE " . $financial_aid . " ";
        }
    } else {
        $financial_aidSQL = '';
    }

    if (!empty($_POST["degree_program"])) {
        $degree_program = $_POST["degree_program"];
        if ($firstEntry == 0) {
            $degree_programSQL = " degree_program LIKE '" . $degree_program . "' ";
            $firstEntry = 1;
        } else {
            $degree_programSQL = " AND degree_program LIKE '" . $degree_program . "' ";
        }
    } else {
        $degree_programSQL = '';
    }

    if (!empty($_POST["grad_date"])) {
        $grad_date = $_POST["grad_date"];
        if ($firstEntry == 0) {
            $grad_dateSQL = " grad_date LIKE " . $grad_date . " ";
            $firstEntry = 1;
        } else {
            $grad_dateSQL = " AND grad_date LIKE " . $grad_date . " ";
        }
    } else {
        $grad_dateSQL = '';
    }

    // put all the values from above into the final sql query
    $sql = "SELECT * FROM $db_table WHERE" . $firstSQL . $lastSQL . $sidSQL . $emailSQL . $phoneSQL . $gpaSQL . $financial_aidSQL . $degree_programSQL . $grad_dateSQL . " ORDER by last_name ASC";
    // echo $sql;
    
    $result = $db->query($sql);


// if there are no results, display the error. else, display the table
if (!$result){
    echo "<p class=\"display-4 mt-4 text-center\">No results found for your search.</p>";
    echo '<img class="mx-auto d-block mt-4" src="img/frown.png" alt="A sad face">';
    echo "<p class=\"display-4 mt-4 text-center\">Please try again.</p>";
} else if ($result->num_rows == 0) {
    echo "<p class=\"display-4 mt-4 text-center\">No results found for your search.</p>";
    echo '<img class="mx-auto d-block mt-4" src="img/frown.png" alt="A sad face">';
    echo "<p class=\"display-4 mt-4 text-center\">Please try again.</p>";
} else {
    echo "<h2 class=\"mt-4 text-center\">$result->num_rows record(s) found for your search.</h2>";
    display_record_table($result);
} 
}
?>


<?php
    // sticky for the radio buttons
    // first, define two variables used in html tag to specify whether the option is checked
    $yes = '';
    $no = '';
    
    // if the value for financial_aid exists
    if (isset($_POST['financial_aid'])) {
        // if the user clicked on yes, set the yes radio option to checked
        if ($_POST['financial_aid'] == 1) {
            $yes = 'checked';
        // otherwise, if the user clicked on no, set no to checked
        } elseif ($_POST['financial_aid'] == 0) {
            $no = 'checked';    
        }
    } 
    
    // for the sticky select
    // if the value of degree_program exists, set the variable to whatever was selected so it is echoed out later
    if (isset($_POST['degree_program'])) {
        $degree_program = $_POST['degree_program'];
    } else {
        $degree_program = "";
    }

?>


            <h1>Advanced Search</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <label class="col-form-label" for="first">First Name </label>
                <input class="form-control" type="text" id="first" name="first" value="<?php echo (isset($first) ? $first: '');?>">
                <br>
                <label class="col-form-label" for="last">Last Name </label>
                <input class="form-control" type="text" id="last" name="last" value="<?php echo (isset($last) ? $last: '');?>">
                <br>
                <label class="col-form-label" for="id">Student ID </label>
                <input class="form-control" type="text" id="id" name="id" value="<?php echo (isset($id) ? $id: '');?>">
                <br>
                <label class="col-form-label" for="email">Email </label>
                <input class="form-control" type="text" id="email" name="email" value="<?php echo (isset($email) ? $email: '');?>">
                <br>
                <label class="col-form-label" for="phone">Phone </label>
                <input class="form-control" type="text" id="phone" name="phone" value="<?php echo (isset($phone) ? $phone: '');?>">
                <br>
                <label class="col-form-label" for="gpa">GPA </label>
                <input class="form-control" type="text" id="gpa" name="gpa" value="<?php echo (isset($gpa) ? $gpa: '');?>">
                <br>
                <label class="col-form-label" for="financial-aid">Financial Aid</label><br>
                    <label for="yes">Yes </label>
                    <input type="radio" name="financial_aid" id="yes" value="1" <?php echo $yes; ?> >
                    <label for="no">No </label>
                    <input type="radio" name="financial_aid" id="no" value="0" <?php echo $no; ?> >
                <br><br>
                <label class="col-form-label" for="degree_program">Degree Program </label>
                <select class="custom-select" name="degree_program" id="degree_program">
                    <option value="none" <?php if($degree_program == "none") echo ' selected="selected"';?>>None</option>
                    <option value="graphic_design" <?php if($degree_program == "graphic_design") echo ' selected="selected"';?>>Graphic Design</option>
                    <option value="web_design" <?php if($degree_program == "web_design") echo ' selected="selected"';?>>Web Design</option>
                    <option value="computer_science" <?php if($degree_program == "computer_science") echo ' selected="selected"';?>>Computer Science</option>
                    <option value="web_development" <?php if($degree_program == "web_development") echo ' selected="selected"';?>>Web Development</option>
                    <option value="web_support" <?php if($degree_program == "web_support") echo ' selected="selected"';?>>Web Support</option>
                </select>
                <br><br>
                <label class="col-form-label" for="grad_date">Graduation Date </label>
                <input type="date" id="grad_date" name="grad_date" min="1900-01-01" max="2100-12-31">
                <br><br>
                <a href="advanced-search.php">Clear</a>&nbsp;&nbsp;
                <button class="btn btn-primary" type="submit">Search</button>
            </form>



        </div>
    </div>
</div>
<?php require 'inc/layout/footer.inc.php';?>