<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>

<div class="container-form">
    <div class="wrapper-form">
        <h1>Add Product</h1>
        <form action="<?php echo URLROOT ?>/products/addProduct" method="POST">

            <input type="text" name="name" placeholder="Product Name">
            <span class="invalidfeedback">
            <?php echo $data['nameError']; ?>
            </span>

            <input type="text" name="desc" placeholder="Product Description">
            <span class="invalidfeedback">
            <?php echo $data['descError']; ?>
            </span>

            <input type="text" name="price" placeholder="Product Price">
            <span class="invalidfeedback">
            <?php echo $data['priceError']; ?>
            </span>

            <input type="text" name="stock" placeholder="Product Stock">
            <span class="invalidfeedback">
            <?php echo $data['stockError']; ?>
            </span>

            <input type="text" name="img" placeholder="Image">
            <span class="invalidfeedback">
            <?php echo $data['imgError']; ?>
            </span>

            <br>

            <button id="submit" type="submit" value="submit">Add</button>
        </form>
        
    </div>
</div>

