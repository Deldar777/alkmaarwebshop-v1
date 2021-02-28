<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>

<?php
//unset($_SESSION['products_qty']);

if(isset($_SESSION['products_qty']) && count($_SESSION['products_qty']) > 0){


    echo'<div class="small-container cart-page">
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
    ';

    $subtotal = 0;
    $tax = 0;
    $total = 0;

    try{
        for ($x = 0; $x < count($_SESSION['products_qty']); $x++) {
        echo'<tr>
            <td>';
        echo '<img id="photo" src='; echo URLROOT; echo  '/img/'; echo $_SESSION['products_qty'][$x]['product']['img']; echo '>'; 
        echo '<p>'; echo$_SESSION['products_qty'][$x]['product']['name']; echo '</p>';
        echo '<small>Price: '; echo $_SESSION['products_qty'][$x]['product']['price']; echo '</small>';
        echo '<br>';
        echo "<a onclick=\"return  confirm('do you want to remove this item from the shopping cart? Y/N')\"  href="; echo URLROOT; echo  '/products/remove?action=remove&id='; echo $_SESSION['products_qty'][$x]['product']['id']; echo'>Remove</a>';
        echo '</td>';

        echo'<td><a href="'; echo URLROOT; echo '/products/minus&id='; echo $_SESSION['products_qty'][$x]['product']['id']; echo ' "><i class="fas fa-minus fa-2x"></i></a>';
        echo '<span id="qty">'; echo $_SESSION['products_qty'][$x]['product']['qty']; echo '</span>';
        echo'<a href="'; echo URLROOT; echo '/products/plus&id='; echo $_SESSION['products_qty'][$x]['product']['id']; echo ' "><i class="fas fa-plus fa-2x"></i></a>
            </td>';


       
            
        echo '<td>';echo $_SESSION['products_qty'][$x]['product']['price'];echo ' x '; echo $_SESSION['products_qty'][$x]['product']['qty']; echo '</td>';
        echo '</tr>';

                
        $total += $_SESSION['products_qty'][$x]['product']['price'] * $_SESSION['products_qty'][$x]['product']['qty'];
    }

    echo '</table>
           <div class="total-price">
               <table>
                   <tr>
                       <td>Subtotal</td>
                       <td> €'; echo number_format($subtotal =  $total  - ($total * 0.21), 2, '.', ''); echo '</td>';
       echo           '</tr>
                       <tr>
                       <td>Tax</td>
                       <td> €'; echo number_format($tax =  $total * 0.21, 2, '.', '');echo '</td>
                   </tr>
                   <tr>
                       <td>Total</td>
                       <td> €'; echo number_format($total, 2, '.', '') ; echo '</td>
                   </tr>
               </table>
           </div>
       </div>';
    

    echo '<form class="center" action="'; echo  URLROOT; echo '/orders/makeOrder&total='; echo $total; echo '">';
    echo '<button type="submit">Order</button>';
    if(isset($data['availability'])){
        echo $data['availability'];
    }
    echo '</form>';
    

    
    

    }catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }

    
    
}
else
{
    echo '<h1 id="center">Your cart is empty</h1>';
}




if(isset($_GET['action'])){
        
    if($_GET['action'] == 'successful'){
        
        echo '<h2 id="center" class="validfeedback">Your order is ready to go! Navigate to the orders page to track your order</h2>';
    }
    }

?>
