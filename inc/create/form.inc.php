<?php // Filename: form.inc.php ?>

<!-- Note the use of sticky fields below -->
<!-- Note the use of the PHP Ternary operator
Scroll down the page
http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
-->
<?php
    // sticky for the radio buttons
    // first, define two variables used in html tag to specify whether the option is checked
    $financial_aid_yes = '';
    $financial_aid_no = '';
    // if the value for financial_aid exists
    if (isset($_POST['financial_aid'])) {
        // if the user clicked on yes, set the yes radio option to checked 
        if ($_POST['financial_aid'] == 1) {
            $financial_aid_yes = 'checked'; 
        // otherwise, if the user clicked on no, set no to checked 
        } elseif ($_POST['financial_aid'] == 0) { 
            $financial_aid_no = 'checked'; 
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

<!-- Displays the form that allows users to post data to the database, with sticky fields  -->
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
    <label class="col-form-label" for="financial_aid">Financial Aid </label><br>
        <input type="radio" name="financial_aid" id="financial_aid_yes" value="1" <?php echo $financial_aid_yes; ?>>   
        <label for="Yes">Yes </label>
        <input type="radio" name="financial_aid" id="financial_aid_no" value="0" <?php echo $financial_aid_no; ?>>
        <label for="No">No </label>
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
    <a href="display-records.php">Cancel</a>&nbsp;&nbsp;
    <button class="btn btn-primary" type="submit">Save Record</button>
</form>