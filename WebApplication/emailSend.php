<?php
    session_start();
    $textToExpose=0;
    if(isset($_SESSION["tech_software"])){
        if(isset($_POST["inviaEmail"])){
            if(isset($_POST["name"]) && isset($_POST["fromEmail"]) && isset($_POST["subject"]) && isset($_POST["text"])){
                if($_POST["name"]!="" && $_POST["subject"]!="" && $_POST["text"]!=""){
                    $email=filter_var($_POST["fromEmail"], FILTER_SANITIZE_EMAIL);
                    $email=filter_var($_POST["fromEmail"], FILTER_SANITIZE_URL);
                    $email=filter_var($_POST["fromEmail"], FILTER_SANITIZE_STRING);
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $textToExpose=1;
                        $u=$_POST["name"];
                        $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
                        $searchUser="SELECT email from accounts where username=?;";
                        $stmt=$mysqli->prepare($searchUser);
                        $stmt->bind_param("s",$u);
                        $stmt->execute();
                        $foundUser=$stmt->get_result();
                        if($foundUser->num_rows>0){
                            $result=$foundUser->fetch_assoc();
                            if(password_verify($email,$result["email"]) && $u==$_SESSION["tech_software"]){
                                $to="official.techsoftware@gmail.com";
                                $subject=$_POST["subject"];
                                $message=$_POST["text"]."<br><br><br><br>";
                                $headers="From: ".$_POST['fromEmail']." \r\n";
                                $headers.="MIME-Version:1.0"."\r\n";
                                $headers.="Content-type:text/html;charset=UTF-8"."\r\n";

                                mail($to,$subject,$message,$headers);
                            }else $textToExpose=0;
                        }else $textToExpose=0;
                        $mysqli->close();
                    }
                }
            }
        }
    }else{
        $textToExpose=2;
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

        <section class="home" id="home">
             <?php
                if($textToExpose==0)
                    echo "<h1 class='centra'>SORRY, BUT WE CAN'T FORWARD THE E-MAIL<br><span style='color:orange;'>TRY TO CHECK IF YOUR DATA ARE CORRECT</span></h1>";
                if($textToExpose==1)
                    echo "<h1 class='centra'>THE MAIL IS BEEN SENT <span style='color:green;'>CORRECTLY</span></h1>";
                if($textToExpose==2)
                    echo "<h1 class='centra'>YOU CAN'T SEND EMAIL BECAUSE <span style='color:#00ffff;'>YOU'RE NOT LOGGED</span></h1>";
            ?>
        </section>

        <footer>
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
