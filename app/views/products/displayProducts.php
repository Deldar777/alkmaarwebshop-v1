<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>

<div class='elements'>

<?php
if(isset($data['availability'])){
        echo '<span class="center">'; echo $data['availability']; echo '</span>';
    }
if(count($data['products']) != null){
    foreach($data['products'] as $product){

    $id = $product->product_id;
        echo   '<div class="product">';
        echo    "<form action='"; echo URLROOT; echo  "/Products/addToCart?action=add&id=$id' method='POST'>";
        echo      '<div><img src="'; echo URLROOT; echo '/img/'; echo $product->product_img; echo '" alt="Photo"></div>

                        <div class="content">
                            <h3>'; echo  $product->product_name;  echo '</h3>
                            <br>';

                            $stock = $product->product_stock; 

                            // green for product more than 5 in stock, yellow less than 5, red if it is not available
                            if($stock > 5){
                                echo '<td><span class="validfeedback">'; echo $stock; echo ' in stock</span></td>';
                            }else if($stock > 0){
                                echo '<td><span class="validfeedbackYellow">'; echo $stock; echo ' in stock</span></td>';
                            }else{
                                echo '<td><span class="invalidfeedback">Not avialable</span></td>';
                            }

                            
                            echo '<p>'; echo $product->product_description; echo '</p>
                            <br>';
                            echo '<h4 class="price">price: <span>'; echo $product->product_price; echo '</span></h4><br>
                            <button name="addProduct">Add to Cart</button>
                        </div>
                </form>
            </div>';
        
    }
    
}else{
    echo"<h3 id='center'>There are no products yet. We are stocking our warehouses.</h3>";
}
?>
</div>



