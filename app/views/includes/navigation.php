    <script src="<?php echo URLROOT ?>/public/javascript/script.js"></script>
    <header>
        <a href="<?php echo URLROOT; ?>/pages/index"><i class='fas fa-home'></i></a> 
        <nav class='nav_links'>
        <?php
        if(isset($_SESSION['user_id'])){

            if($_SESSION['user_role'] == 'admin'){
                echo '<li><a href='; echo URLROOT; echo '/products/editProducts>Edit Products</a></li>';
                echo '<li><a href='; echo URLROOT; echo '/users/editUsers>Edit Users</a></li>';
                echo '<li><a href='; echo URLROOT; echo '/pages/requests>Requests</a></li>';
            }else{
                echo '<li><a href='; echo URLROOT; echo '/users/account><i class="fas fa-user"></i></a></li>';
                echo '<li><a href='; echo URLROOT; echo '/orders/getOrders>Orders</a></li>';
                echo '<li><a href='; echo URLROOT; echo '/products/displayProducts>Products</a></li>';
            echo '<li><a href='; echo URLROOT; echo '/products/shoppingCart><i class="fas fa-shopping-cart"><span class="h">12</span>';
            if(isset($_SESSION['products_qty']))
                    {
                       $count = count($_SESSION['products_qty']);
                       
                       echo "<span id=\"cart_count\"> $count </span>";
                    }
                    else
                    {
                       echo "<span id=\"cart_count\"> 0 </span>";
                    }
            echo '</i></a></li>';
            }
           
        }else{
            echo '<li><a href='; echo URLROOT; echo '/products/displayProducts>Products</a></li>';
            echo '<li><a href='; echo URLROOT; echo '/products/shoppingCart><i class="fas fa-shopping-cart"><span class="h">12</span>';
            if(isset($_SESSION['products_qty']))
                    {
                       $count = count($_SESSION['products_qty']);
                       
                       echo "<span id=\"cart_count\"> $count </span>";
                    }
                    else
                    {
                       echo "<span id=\"cart_count\"> 0 </span>";
                    }
            echo '</i></a></li>';
            
        }
        ?>
            <li><a href="<?php echo URLROOT; ?>/pages/contact">Contact</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/about">About</a></li>
        </nav>
        <?php

         if(isset($_SESSION['user_id']))
        {
            echo "<form action="; echo URLROOT; echo "/users/logout method='POST'>";
            echo '<button type="submit" name="submit">Log out</button>';
            echo "</form>";
        }
        else
        {
            echo "<a href="; echo URLROOT; echo "/users/login>Log in</a>";
        }

        ?>
    </header>
    </head>

   