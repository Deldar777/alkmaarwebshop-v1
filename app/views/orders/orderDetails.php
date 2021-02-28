<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>

<div class="small-container cart-page">
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Description</th>
            <th>Quantity</th>
        </tr>

        <?php

        $subtotal = 0;
        $tax = 0;
        $total = 0;

        echo '<h1 class="center">Order Number '; echo $data['products'][0]->Order_id; echo '</h1>';

        foreach($data['products'] as $p){
                echo '<tr>';
                echo '<td>';
                echo '<div>';
                echo '<img id="photo" src="'; echo  URLROOT; echo '/img/'; echo $p->product_img; echo '">'; 
                echo '<div>';
                echo '<p>'; echo $p->product_name; echo '</p>';
                echo '<br>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td>'; echo $p->product_price; echo '</td>';
                echo '<td>'; echo $p->product_description; echo '</td>';
                echo '<td> x '; echo $p->qty; echo '</td>';
                echo '</tr>';

                $total += $p->product_price * $p->qty;
            }
            
            echo '</table>';


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



              
        
    