<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Software</title>
        <link rel="stylesheet" href="style.css" type="text/css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    </head>
    <style>
		.centra{
			position:absolute;
            		top:50%;
            		left:50%;
            		transform:translate(-50%,-47%);
		}
		@media (max-width: 1000px){
			.centra{
				transform:translate(-50%,-30%);
			}
		}
		@media (max-width: 750px){
			.centra{
				transform:translate(-50%,-20%);
			}
		}
		@media (max-width: 500px){
			.centra{
				transform:translate(-50%,-5%);
			}
		}
	</style>
    <body bgcolor="black">
        <div class="scroll-up-btn">
            <i class="fas fa-angle-up"></i>
        </div>
        <nav class="navbar">
            <div class="max-width">
                <div class="logo"><a href="Index.php#about">Tech <span>Software</span></a></div>
                <ul class="menu">
                    <li><a href="Index.php">Home</a></li>
                    <li><a href="Shop.php">Shop</a></li>
                    <li><a href="Purchases.php">Purchase</a></li>
                    <li><a href="Index.php#contact">Contact us</a></li>
                    <?php
                    if(!isset($_SESSION["tech_software"]))
                        echo "<li><a href='Login.php'>Login</a></li>";
                    else
                        echo "<li><a href='Exit.php'>Exit</a></li>";
                    ?>
                </ul>
                <div class="menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </nav>

        <section class="home" id="home">
            <?php
                require('Config.php');
                if(isset($_SESSION["tech_software"])){
                    if(isset($_GET["product"])){
                        $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
                        $product=$_GET["product"];
                        try{
                            $mysqli->begin_transaction();
                            $searchProd="SELECT * FROM software WHERE name=?";
                            $stmt=$mysqli->prepare($searchProd);
                            $stmt->bind_param("s",$product);
                            $stmt->execute();
                            $foundProd=$stmt->get_result();
                            $mysqli->commit();
                        }catch(mysqli_sql_exception $exception){
                            $mysqli->rollback();
                        }                  
                        if($foundProd){
                            $row=$foundProd->fetch_assoc();
                            if($row["available"]>0){
                                $price=$row["price"]*100;
                                ?>
                                <form action="RegisterTransaction.php" method="post">
                                <div class='centra'>
                                    <script 
                                        src ="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="<?php echo $publishableKey?>"
                                        data-amount="<?php echo $price ?>"
                                        data-name="<?php echo $product ?>"
                                        data-description="Tech Software"
                                        data-currency="EUR"
                                    >
                                    </script>
                                </div>
                                <?php
                                echo "<input type='hidden' name='name' value='$product' >";
                                echo "<input type='hidden' name='price' value='$price' >";
                                echo "<input type='hidden' name='currency' value='EUR'>";
                                echo "</form>";
                            }else{
                                echo "<h1 class='centra'>WE ARE SORRY BUT THERE ARE NO PRODUCT-KEY LEFT</h1>";
                            }
                        }else{
                            echo "<h1 class='centra'>WE DON'T HAVE THIS PRODCUT IN OUR SHOP OR ERROR OCCURRED</h1>";
                        }
                        $mysqli->close();
                    }else echo "<h1 class='centra'>YOU HAVE TO CHOOSE A PRODUCT FROM OUR SHOP</h1>";
                }else echo "<h1 class='centra'>YOU NEED TO BE LOGGED TO BUY A PRODUCT</h1>";
            ?>
        </section>

        <footer>
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
