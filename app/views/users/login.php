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
        <h2>Sign in</h2>
        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
        <input type="text" placeholder="Username *" name="username">
        <span class="invalidfeedback">
            <?php echo $data['usernameError']; ?>
        </span>
        <input type="password" placeholder="Password *" name="password">
        <span class="invalidfeedback">
            <?php echo $data['passwordError']; ?>
        </span>
        <br>
        <button id="submit" type="submit" value="submit">Submit</button>
        <p class="options">Not registered yet? <a   id="link"  href="<?php echo URLROOT; ?>/users/register">Create an account!</a></p>
    </form>
    </div>
</div>