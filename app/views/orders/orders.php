<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>



        <?php
        if(!empty($data['orders'])){

            echo '<div class="small-container cart-page">
            <table>
                <tr>
                    <th>Order Number</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Details</th>
                </tr>';


            foreach($data['orders'] as $o){
                echo '<tr>';
                echo '<td>'; echo $o->order_id; echo '</td>';
                echo '<td>'; echo $o->total; echo '</td>';
                echo '<td>'; echo $o->order_date; echo '</td>';
                echo '<td><a href="'; echo URLROOT; echo  '/orders/orderDetails&id='; echo $o->order_id; echo '">More Details</a></td>';
                echo '</tr>';
                
            } 
            
            echo '</table>';

        }else{
            echo '<div class="center">';
            echo "No orders yet!<br>";
            echo '<a id"center" href="'; echo URLROOT; echo '/products/displayProducts">Make you first order</a>';
            echo '</div>';
        }        
    
?>
