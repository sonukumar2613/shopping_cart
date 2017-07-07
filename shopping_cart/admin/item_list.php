<?php include "../includes/db.php"; 
    if(isset($_POST['item_submit'])){
        $item_title = mysqli_real_escape_string($conn, strip_tags($_POST['item_title']));
        $item_description = mysqli_real_escape_string($conn, strip_tags($_POST['item_description']));
        $item_category = mysqli_real_escape_string($conn, strip_tags($_POST['item_category']));
        $item_quantity = mysqli_real_escape_string($conn, strip_tags($_POST['item_quantity']));
        $item_cost = mysqli_real_escape_string($conn, strip_tags($_POST['item_cost']));
        $item_price = mysqli_real_escape_string($conn, strip_tags($_POST['item_price']));
        $item_discount = mysqli_real_escape_string($conn, strip_tags($_POST['item_discount']));
        $item_delivery = mysqli_real_escape_string($conn, strip_tags($_POST['item_delivery']));
                                                   
        if(isset($_FILES['item_image']['name'])){
            $file_name = $_FILES['item_image']['name'];
            $path_address = "../images/$file_name";
            $path_address_db = "images/$file_name";
            $img_confirm = 1;
            $file_type = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
            if($_FILES['item_image']['size'] > 2000000){
                $img_confirm = 0;
                echo 'This size is very big';
            }
            if($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif'){
                $img_confirm = 0;
                echo 'Type is not matching';
            }
            if($img_confirm == 0){
                
            }else{
                if(move_uploaded_file($_FILES['item_image']['tmp_name'], $path_address) ){
                    $item_ins_sql = "INSERT INTO items (item_image, item_title, item_description, item_cat, item_qty, item_cost, item_price, item_discount, item_delivery) VALUES ('$path_address_db','$item_title', '$item_description', '$item_category', '$item_quantity', ' $item_cost', '$item_price', ' $item_discount', '$item_delivery' );";
                    
                    $item_ins_run = mysqli_query($conn, $item_ins_sql);
                }
            }
        }else{
            echo 'sorry';
        }
    }
?>
<html>
    <head>
        <title>online shopping | Admin panel</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/admin-style.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script><!--these two cdn for text area in form -->
        <script>tinymce.init({ selector:'textarea' });</script>     <!--www.tinymce.com-->
        <script>
            
            
            function get_item_list_data(){
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState ==4 && xmlhttp.status == 200){
                        document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'item_list_process.php', true);
                xmlhttp.send();
            }
            
            //delete from admin item_list page
            function del_item(item_id){
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'item_list_process.php?del_item_id='+item_id, true);
                xmlhttp.send();
            }
            
            //edit in the item_list
            function edit_item(item_id){
                    item_id = document.getElementById('up_item_id').value;
                    item_title = document.getElementById('item_title').value;
                    item_description = document.getElementById('item_description').value;
                    item_category = document.getElementById('item_category').value;
                    item_quantity = document.getElementById('item_quantity').value;
                    item_cost = document.getElementById('item_cost').value;
                    item_price = document.getElementById('item_price').value;
                    item_discount = document.getElementById('item_discount').value;
                    item_delivery = document.getElementById('item_delivery').value;

                xmlhttp.open('GET','item_list_process.php?up_item_id='+item_id+'&item_title='+item_title+'&item_description='+item_description+'&item_category='+item_category+'&item_quantity='+item_quantity+'&item_cost='+item_cost+'&item_price='+item_price+'&item_discount='+item_discount+'&item_delivery='+item_delivery, true);
                xmlhttp.send();
                
            }
                 
        </script>
    </head>
    <body onload="get_item_list_data();">
        <?php include "includes/header.php" ?>
        <div class="container">
            
            <!--Add new Item button-->
            <button class="btn btn-danger" data-toggle="modal" data-backdrop="static" data-target="#add_new_item">Add New Item</button>
            
            
            <div id="add_new_item" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Add New Item</h3>
                            <button class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Item Image</label>
                                    <input type="file" name="item_image" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item Title</label>
                                    <input type="text" name="item_title" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <lable>Item Description</lable>
                                    <textarea class="form-control" name="item_description" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item Category</label>
                                    <select class="form-control" name="item_category" required>
                                        <option>Select a Category</option>
                                        <?php 
                                            $cat_sql = "SELECT * FROM item_cat";
                                            $cat_run = mysqli_query($conn, $cat_sql);
                                            while($cat_rows = mysqli_fetch_assoc($cat_run)){
                                                $cat_name = ucwords($cat_rows['cat_name']);
                                                if($cat_rows['cat_slug']==''){
                                                    $cat_slug = $cat_rows['cat_name'];
                                                }else{
                                                    $cat_slug = $cat_rows['cat_slug'];
                                                }
                                                echo "
                                                    <option value='$cat_slug'>$cat_name</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item Quantity</label>
                                    <input type="number" name="item_quantity" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item cost</label>
                                    <input type="number" name="item_cost" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item Discount</label>
                                    <input type="number" name="item_discount" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item price</label>
                                    <input type="number" name="item_price" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Item Delivery</label>
                                    <input type="number" name="item_delivery" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" name="item_submit" class="btn btn-primary btn-block">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="btn btn-danger" data-dismiss="modal">close</div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <div id="get_item_list_data">
                <!--Area to get the processed data from item_list data -->
            </div>
            
            
            
            
        </div>
        <?php include "includes/footer.php" ?>
        
    </body>
</html>