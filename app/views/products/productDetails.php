<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';

    
?>

<div class="container-form">
    <div class="wrapper-form">
        <h1>Edit Product</h1>
        <form action="<?php echo URLROOT ?>/products/update&id=<?php echo $data['id']; ?>" method="POST">

            <input type="text" name="name" placeholder="Product Name" value="<?php echo $data['name'] ?>">
            <span class="invalidfeedback">
            <?php echo $data['nameError']; ?>
            </span>

            <input type="text" name="desc" placeholder="Product Description" value="<?php echo $data['desc'] ?>">
            <span class="invalidfeedback">
            <?php echo $data['descError']; ?>
            </span>

            <input type="text" name="price" placeholder="Product Price" value="<?php echo $data['price'] ?>">
            <span class="invalidfeedback">
            <?php echo $data['priceError']; ?>
            </span>

            <input type="text" name="stock" placeholder="Product Stock" value="<?php echo $data['stock'] ?>">
            <span class="invalidfeedback">
            <?php echo $data['stockError']; ?>
            </span>

            <input type="text" name="img" placeholder="Image" value="<?php echo $data['img'] ?>">
            <span class="invalidfeedback">
            <?php echo $data['imgError']; ?>
            </span>

            <br>

            <button id="submit" type="submit" value="submit">Update</button>
        </form>
        <span class="validfeedback">
        <?php
        if(isset($data['updateStatus'])){
        echo $data['updateStatus'];
        }
        ?>
        </span>

        <span class="invalidfeedback">
        <?php
        if(isset($data['updateStatusError'])){
        echo $data['updateStatusError'];
        }
        ?>
        </span>
        
    </div>
</div>




