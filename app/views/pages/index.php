<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>
<?php
    if(isset($_SESSION['user_id']))
    {
        echo "<div class='welcomeMessage'>";
    
        $time = date("H");
        $weclomeMessage = "";

        if($time < 13)
        {
            $weclomeMessage = "Good morning";
        }
        else if ($time < 18)
        {
            $weclomeMessage = "Good afternoon";
        }
        else
        {
            $weclomeMessage = "Good evening";
        }

        echo "<div class='welcomeMessage'>";
        echo "<h2>" .$weclomeMessage. " " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</h2>";
        echo "<h2>Today is " . date("d/M/y H:i:s") . "<br></h2>";
        echo "</div>";
    }else{
        echo "<div class='welcomeMessage'>";
        echo "<h2>Welcome to Webshop Alkmaar. Here can you find all you need for your computers and laptops parts</h2>";
        echo "<h2>Today is " . date("d/M/y H:i:s") . "<br></h2>";
        echo "</div>";
    }
    ?>
