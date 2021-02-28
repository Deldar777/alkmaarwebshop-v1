<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>

<!-- Cart items details -->
<div class="small-container cart-page">
    <table>
        <tr>
            <th>Product</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php
        foreach($data['products'] as $p){
                echo '<tr>';
                echo '<td id="product">';
                echo '<div>';
                echo '<img id="photo" src='; echo URLROOT; echo  '/img/'; echo $p->product_img; echo '>'; 
                echo '<div>';
                echo '<p>'; echo $p->product_name; echo '</p>';
                echo '<small>Price: '; echo $p->product_price; echo '</small>';
                echo '<br>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td>'; echo $p->product_description; echo '</td>';

                $stock = $p->product_stock;


                // green for product more than 5 in stock, yellow less than 5, red if it is not available
                if($stock > 5){
                    echo '<td><span class="validfeedback">'; echo $stock; echo '</span></td>';
                }else if($stock > 0){
                    echo '<td><span class="validfeedbackYellow">'; echo $stock; echo '</span></td>';
                }else{
                    echo '<td><span class="invalidfeedback">'; echo $stock; echo '</span></td>';
                }
                echo "<td><a    name='Edit' href="; echo URLROOT; echo  "/products/productDetails?action=edit&id=$p->product_id>Edit</a></td>";
                echo "<td><a onclick=\"return  confirm('do you want to delete Y/N')\"  name='delete' href="; echo URLROOT; echo  "/products/delete?action=delete&id=$p->product_id>Delete</a></td>";
                echo '</tr>';
            }  
              
        ?>  
    </table>
    <br>
    <hr>
    <span class="validfeedback"> <?php echo $data['deleted']; ?></span>
    <span class="invalidfeedback"><?php echo $data['error']; ?></span>
    <br>
    <a id="addProduct" href="<?php echo URLROOT; ?>/products/addProduct">Add Product</a>
    