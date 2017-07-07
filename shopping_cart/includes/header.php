<nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="" class="navbar-brand">Online Shopping</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <?php
                        $cat_sql = "SELECT * FROM item_cat";
                        $cat_run = mysqli_query($conn, $cat_sql);
                        while($cat_rows = mysqli_fetch_assoc($cat_run)){
                            $cat_name = ucwords($cat_rows['cat_name']);
                            
                            if($cat_rows['cat_slug']==""){
                                $cat_slug = $cat_rows['cat_name'];
                            }else{
                                $cat_slug = $cat_rows['cat_slug'];
                            }
                            echo "<li><a href='category.php?category=$cat_slug'>$cat_name</a></li>";
                       }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
 </nav>

    