<?php include '../includes/db.php' ;
    if( isset($_REQUEST['del_item_id'])){
        $del_item_sql = "DELETE FROM items WHERE item_id = '$_REQUEST[del_item_id]'";
        $del_item_run = mysqli_query($conn, $del_item_sql);
    }

    if( isset($_REQUEST['up_item_id'])){
        $item_title = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_title']));
        $item_description = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_description']));
        $item_category = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_category']));
        $item_quantity = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_quantity']));
        $item_cost = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_cost']));
        $item_price = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_price']));
        $item_discount = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_discount']));
        $item_delivery = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_delivery']));
        $item_id = $_REQUEST['up_item_id'];
        
        //$item_ins_sql = "INSERT INTO items (item_image, item_title, item_description, item_cat, item_qty, item_cost, item_price, item_discount, item_delivery) VALUES ('$path_address_db','$item_title', '$item_description', '$item_category', '$item_quantity', ' $item_cost', '$item_price', ' $item_discount', '$item_delivery' )";
        
        $item_up_sql = "UPDATE items SET item_title = '$item_title', item_description='$item_description', item_cat = '$item_category', item_qty='$item_quantity', item_cost='$item_cost', item_price='$item_price', item_discount='$item_discount', item_delivery='$item_delivery' WHERE item_id = '$item_id' ";
        
        $item_up_run = mysqli_query($conn, $item_up_sql);
        
    }

?>
  <table class="table table-bordered  table-striped">
            <thead>
                <tr class="item-head">
                    <th>S.no</th>
                    <th>Image</th>
                    <th>Item Title</th>
                    <th>Item Description</th>
                    <th>Item category</th>
                    <th>Item qty</th>
                    <th>Item cost</th>
                    <th>Item Discount</th>
                    <th>Item price</th>
                    <th>Item Delivery</th>
                    <th>Action</th>
                </tr>
            </thead>
    <tbody>
        <?php 
            $c=1;
            $sel_sql = "SELECT * FROM items";
            $sel_run = mysqli_query($conn, $sel_sql);
            while($rows = mysqli_fetch_assoc($sel_run)){
                $discounted_price = $rows['item_price'] - $rows['item_discount'];
                echo "
                    <tr>
                        <td>$c</td>
                        <td><img src='../$rows[item_image]' style='width:100px;'></td>
                        <td>$rows[item_title]</td>
                        <td>"; echo strip_tags($rows['item_description']); echo "</td>
                        <td>$rows[item_cat]</td>
                        <td>$rows[item_qty]</td>
                        <td>$rows[item_cost]</td>
                        <td>$rows[item_discount]</td>
                        <td>$discounted_price($rows[item_price])</td>
                        <td>$rows[item_delivery]</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-danger dropdown-toggle' data-toggle='dropdown'>Action<span class='caret'></span></button>
                                <ul class='dropdown-menu dropdown-menu-right'>
                                    <li>
                                        <a href='#edit_modal' data-toggle='modal' data-backdrop='static'>Edit</a>
                                    </li>"; ?>
                                    <li><a href="javascript:;" onclick="del_item(<?php echo $rows['item_id']; ?>);">Delete</a></li>
                           <?php  echo "</ul>
                            </div>
                            <div class='modal fade' id='edit_modal'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                         <div class='modal-header'>
                                            <h3 class='modal-title'>Edit Time</h3>
                                            <button class='close' data-dismiss='modal'>&times;</button>
                                         </div>
                                         <div class='modal-body'>
                                            <div id='form1'>    
                                                <div class='form-group'>
                                                    <label>Item Title</label>
                                                    <input type='text' id='item_title' value='$rows[item_title]' class='form-control'>
                                                </div>

                                                <div class='form-group'>
                                                    <lable>Item Description</lable>
                                                    <textarea id='item_description' value='$rows[item_description]' class='form-control' required></textarea>
                                                </div>

                                                <div class='form-group'>
                                                    <label>Item Category</label>
                                                    <select class='form-control' id='item_category' required>
                                                        <option>Select a Category</option>"; 

                                                            $cat_sql = "SELECT * FROM item_cat";
                                                            $cat_run = mysqli_query($conn, $cat_sql);
                                                            while($cat_rows = mysqli_fetch_assoc($cat_run)){
                                                                //$cat_name = ucwords($cat_rows['cat_name']);
                                                                if($cat_rows['cat_slug']== ''){
                                                                    $cat_slug = $cat_rows['cat_name'];
                                                                }else{
                                                                    $cat_slug = $cat_rows['cat_slug'];
                                                                }

                                                                if($cat_slug == $rows['item_cat']){
                                                                    echo "<option selected value='$cat_slug'>$cat_rows[cat_name]</option>";
                                                                }else{
                                                                    echo "
                                                                        <option value='$cat_slug'>$cat_rows[cat_name]</option>
                                                                    ";
                                                                }
                                                            }

                                                 echo  "  </select>
                                                </div>

                                                <div class='form-group'>
                                                    <label>Item Quantity</label>
                                                    <input type='number' id='item_quantity' value='$rows[item_qty]' class='form-control' required>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Item cost</label>
                                                    <input type='number' id='item_cost' value='$rows[item_cost]' class='form-control' required>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Item Discount</label>
                                                    <input type='number' id='item_discount' value='$rows[item_cost]' class='form-control' required>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Item price</label>
                                                    <input type='number' id='item_price' value='$rows[item_price]' class='form-control' required>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Item Delivery</label>
                                                    <input type='number' id='item_delivery' value='$rows[item_delivery]' class='form-control'>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='hidden' id='up_item_id' value='$rows[item_id]'>"; ?>
                                                    <button onclick="edit_item();" class='btn btn-primary btn-block'>Submit</button>
                                                </div>
                                           </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <div class='btn btn-danger' data-dismiss='modal'>close</div>
                                        </div>
                                     </div>
                                </div>
                           </div>
                        </td>
                    </tr>
                <?php
               $c++;
            }
           ?>
     </tbody>

  </table>