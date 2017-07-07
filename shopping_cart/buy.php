<?php session_start();
    include "includes/db.php";
    if( isset($_GET['chk_item_id'])){
        $date = date('Y-m-d h:i:s');
        $rand_num = mt_rand();
        if(isset($_SESSION['ref'])){
            
        }else{
            $_SESSION['ref'] = $date.'_'.$rand_num;
        }
        
        $chk_sql = "INSERT INTO checkout (chk_item, chk_ref, chk_timing, chk_qty) VALUES ('$_GET[chk_item_id]', '$_SESSION[ref]', '$date', 1)";
        if($chk_run = mysqli_query($conn, $chk_sql)){
           ?><script>window.location = "buy.php";</script><?php
        }
    }


    //for submit shipping address
    if(isset($_POST['order_submit'])){
        $name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
        $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
        $contact = mysqli_real_escape_string($conn, strip_tags($_POST['contact']));
        $city = mysqli_real_escape_string($conn, strip_tags($_POST['city']));
        $delivery_address = mysqli_real_escape_string($conn, strip_tags($_POST['delivery_address']));
        
        $order_ins_sql = "INSERT INTO orders (order_name, order_email, order_contact, order_city, order_delivery_address, order_checkout_ref, order_total) VALUES ('$name', '$email', '$contact', '$city', '$delivery_address', '$_SESSION[ref]', '$_SESSION[grand_total]')";
        mysqli_query($conn, $order_ins_sql);
    }
    
?>

<html>
    <head>
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script>
            
            function ajax_func(){
                xmlhttp = new XMLHttpRequest();
                
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'buy_process.php', true);
                xmlhttp.send();
            }
            
            
            
            function del_func(chk_id){
                xmlhttp = new XMLHttpRequest();
                
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET', 'buy_process.php?chk_del_id='+chk_id, true);
                xmlhttp.send();
            }
            
            
            function up_chk_qty(chk_qty,chk_id){
                xmlhttp = new XMLHttpRequest();
                
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                } 
                xmlhttp.open('GET', 'buy_process.php?up_chk_qty='+chk_qty+'&up_chk_id='+chk_id, true);
                xmlhttp.send();
            }
            
        </script>
    </head>
    <body onload="ajax_func();">
        <?php include 'includes/header.php'; ?>
        <div class="container">
            <div class="page-header">
                <h2 class="pull-left">Checkout</h2>
                <div class="pull-right"><button class="btn btn-success" data-toggle="modal" data-backdrop="static" data-target="#proceed_modal" >Proceed</button></div>
                <!-- The Proceed form's Modal -->
                <div id="proceed_modal" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal">&times;</button>
                                <h3>Enter Your Shipping Details</h3>
                            </div>
                            <div class="modal-body">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact">Contact Number</label>
                                        <input type="text" id="contact" name="contact" class="form-control" placeholder="Contact Number">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input list="cities" name="city" id="city" class="form-control">
                                        <datalist id="cities">
                                            <option>Patna</option>
                                            <option>Chandigarh</option>
                                            <option>Surat</option>
                                            <option>Ludhiyana</option>
                                            <option>Jaypur</option>
                                            <option>Nalanda</option>
                                            <option>Jahanabad</option>
                                            <option>Gaya</option>
                                            <option>Delhi</option>
                                        </datalist>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address">Shipping Address</label>
                                        <textarea class="form-control" name="delivery_address"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="submit" name="order_submit" class="btn btn-danger btn-block">
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="text-right">
                                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">Order Details</div>
                <div class="panel-body">
                   <!--                  -->
                        
                        <div id="get_processed_data">
                            
                            <!--the buy process data (buy_process.php) -->
                            
                        </div>
                        
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>