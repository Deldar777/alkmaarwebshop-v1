<?php
require APPROOT . '/views/includes/head.php';
?>
<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container-form">
    <div class="wrapper-form">
        <h2>Register</h2>
        <form action="<?php echo URLROOT; ?>/users/register" method="POST">

        <input type="text" placeholder="Firstname *" name="firstname">
        <span class="invalidfeedback">
            <?php echo $data['firstnameError']; ?>
        </span>

        <input type="text" placeholder="Lastname *" name="lastname">
        <span class="invalidfeedback">
            <?php echo $data['lastnameError']; ?>
        </span>

        <input type="email" placeholder="Email *" name="email">
        <span class="invalidfeedback">
            <?php echo $data['emailError']; ?>
        </span>

        <input type="password" placeholder="Password *" name="password">
        <span class="invalidfeedback">
            <?php echo $data['passwordError']; ?>
        </span>

        <input type="password" placeholder="Confirm Password *" name="confirmPassword">
        <span class="invalidfeedback">
            <?php echo $data['confirmPasswordError']; ?>
        </span>
        <br>
        <button id="submit" type="submit" value="submit">Submit</button>
        <p class="options">Not registered yet? <a   id="link"  href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
        <br>

<?php if(isset($_GET['action'])){
    if($_GET['action'] == 'registered'){
        echo '<h1 class="validfeedback">You have been registerd successfully</h1>';
    }else{
        echo '<h1 class="invalidfeedback">Sorry for the inconveniences but something went wrong!</h1>';
    }
    }
    
echo '
    </form>
    </div>
</div>';
?>

