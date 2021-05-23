<?php
    session_start();
    $messageToShow=0;
    require('Config.php');
    \Stripe\Stripe::setVerifySslCerts(false);
    function generateProductKey() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 1; $i <= 29; $i++) {
            if($i%6==0)
                $randomString .='-';
            else
                $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    if(isset($_SESSION["tech_software"])){
        if(isset($_POST["stripeToken"])){
            if($_POST["stripeToken"]!=$_SESSION["temp"]){
                $token=$_POST["stripeToken"];
                $_SESSION["temp"]=$token;
                $data=\Stripe\Charge::create(array(
                    "amount"=>$_POST["price"],
                    "currency"=>$_POST["currency"],
                    "description"=>"Tech Software",
                    "source"=>$token,
                ));
                $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
                $account=$_SESSION["tech_software"];
                $software=$_POST["name"];
                $productKey=generateProductKey();
                $orderId=$data["id"];
                try{
                    $mysqli->begin_transaction();
                    $sql="INSERT INTO orders(order_id,account,software_name,product_key) values ('$orderId','$account','$software','$productKey')";
                    $mysqli->query($sql);
                    $mysqli->query("UPDATE software SET available=available-1 WHERE name='$software'");
                    $mysqli->commit();
                }catch(mysqli_sql_exception $exception){
                    $mysqli->rollback();
                    $messageToShow=4;
                }
                if($messageToShow!=4){
                    $to=$data["billing_details"]["name"];
                    $subject="PRODUCT-KEY";
                    $message="<br>The product key for the software <b>$software</b> is <b>$productKey</b><br><br><br>";
                    $headers="From: official.techsoftware@gmail.com \r\n";
                    $headers.="MIME-Version:1.0"."\r\n";
                    $headers.="Content-type:text/html;charset=UTF-8"."\r\n";

                    mail($to,$subject,$message,$headers);
                }
                $mysqli->close();
            }else $messageToShow=3;
        }else $messageToShow=2;
    }else $messageToShow=1;
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
                if($messageToShow==0)
                    echo "<h1 class='centra'>TRANSACTION REGISTERED <span style='color:green;'>SUCCESSFULLY</span><br>CHECK YOUR MAIL FOR THE PRODUCT-KEY</h1>";
                if($messageToShow==1)
                    echo "<h1 class='centra'>YOU CAN'T ACCESS THIS PAGE BECAUSE <span style='color:orange;'>YOU'RE NOT LOGGED</span></h1>";
                if($messageToShow==2)
                    echo "<h1 class='centra'>YOU HAVE TO BUY A PRODUCT TO REGISTER A TRANSACTION</h1>";
                if($messageToShow==3)
                    echo "<h1 class='centra'>YOU CAN'T REGISTER THE SAME PRODUCT-KEY TWICE</h1>";
                if($messageToShow==4)
                    echo "<h1 class='centra'><span style='color:red;'>ERROR WITH YOUR TRANSACTION</span></h1>";
            ?>
        </section>

        <footer>
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
