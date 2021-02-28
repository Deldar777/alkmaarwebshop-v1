<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>


  

    <form class="contact-form" action="<?php echo URLROOT ?>/pages/contact" method="POST">
    <h1>Contact Us</h1>
    <div class="txtb">
    <label>Full Name :</label>
    <input type="text" name="name" placeholder="Enter Your Name">
    </div>
    <span class="invalidfeedback">
        <?php echo $data['nameError']; ?>
    </span>

    <div class="txtb">
    <label>Email :</label>
    <input type="email" name="email" placeholder="Enter Your Email">
    </div>
    <span class="invalidfeedback">
        <?php echo $data['emailError']; ?>
    </span>

    <div class="txtb">
    <label>Phone Number :</label>
    <input type="text" name="phoneNumber" placeholder="Enter Your Phone Number">
    </div>
    <span class="invalidfeedback">
        <?php echo $data['phoneNumberError']; ?>
    </span>

    <div class="txtb">
    <label>Message :</label>
    <textarea name="message" ></textarea>
    </div>
    <span class="invalidfeedback">
        <?php echo $data['messageError']; ?>
    </span>

    
    <button class="btn">Send</button>
    <?php
    if(isset($data['succeeded'])){
        echo '<div class="center">';
        echo $data['succeeded'];
        echo '</div>';
    }
    
    ?>
    </form>

    

    
