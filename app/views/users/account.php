<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>


<div class="account">
    <div class="a">
        <h1>Your account</h1>
    </div>
    
    <form class="account" action="<?php echo URLROOT; ?>/users/changeEmail" method="POST">
        <div class="email">

            <div class="title">
                <Button>Change</Button>
            </div>
            
            <div class="content">
                <br>
                <label >Email Address:</label>
                <input name="new_email" type="text" value="<?php echo $_SESSION['user_email'];?>">
            </div>
    </div>
    <div class="error">
        <span class="invalidfeedback"><?php echo $data['emptyError'] ?></span>
        <span class="invalidfeedback"><?php echo $data['sameError'] ?></span>
        <span class="invalidfeedback"><?php echo $data['invalidError'] ?></span>
        <span class="invalidfeedback"><?php echo $data['existsError'] ?></span>
    </div>
   </form>
   


   <form class="account" action="<?php echo URLROOT; ?>/users/changePassword" method="POST"> 
        <div class="email">

            <div class="title">
                <button>Change</button>
            </div>
            
            <div class="content">
                <label >Current Password:</label>
                <input type="password" name="current_password">
                <span class="invalidfeedback"><?php echo $data['emptyCurrent'] ?></span>
                <br>
                <label >New Password:</label>
                <input type="password" name="new_password">
                <span class="invalidfeedback"><?php echo $data['emptyNew'] ?></span>
                <br>
                <label >Repeat Password:</label>
                <input type="password" name="repeat_password">
                <span class="invalidfeedback"><?php echo $data['emptyRepeat'] ?></span>
                <br>
            </div>

    </div>
</form>

</div>


</div>