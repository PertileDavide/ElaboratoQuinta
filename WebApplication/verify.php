<?php
    session_start();
    $messageToShow="YOU CAN'T ACCESS THIS PAGE DIRECTLY!";
    if(isset($_GET["vkey"])){
        $vkey=$_GET["vkey"];

        $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
        $resultVerification=$mysqli->query("SELECT verified,vkey,creationdate FROM accounts WHERE verified=0 AND vkey='$vkey';"); 
        if($resultVerification->num_rows>0){
            $checkTime=$resultVerification->fetch_assoc();
            $savedTime=$checkTime["creationdate"];
            if(time()<(strtotime($savedTime)+600)){
                $update=$mysqli->query("UPDATE accounts SET verified=1 WHERE vkey='$vkey';");
                if($update){
                    $messageToShow="ACCOUNT HAS BEEN VERIFIED!<br><span style='color:green;'>NOW YOU CAN LOGIN IN THE WEBSITE</span>";
                }else{
                    $messageToShow="<span style='color:red;'>ERROR TO VERIFY YOUR ACCOUNT</span>";
                }
            }else{
                $messageToShow="<span style='color:red;'>TIME TO VERIFY ACCCOUNT EXCEEDED<br>YOU HAVE TO REDO REGISTRATION</span>";
                $mysqli->query("DELETE FROM accounts WHERE verified=0 && vkey='$vkey';");
            }
        }else{
            $messageToShow="<span style='color:red;'>THIS ACCOUNT IS INVALID OR ALREADY VERIFIED</span>";
        }
        $mysqli->close();
    }
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

        <section class="home" id="home" >
            <h1 class="centra"><?php echo $messageToShow ?></h1>
        </section>

        <footer>
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
