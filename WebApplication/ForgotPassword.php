<?php
    session_start();
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    $messageToShow=0;
    if(isset($_POST["submit"])){
        $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");    
        $u=$_POST["username"];
        $u=$mysqli->real_escape_string($u);

        $email=filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $email=filter_var($_POST["email"], FILTER_SANITIZE_URL);
        $email=filter_var($_POST["email"], FILTER_SANITIZE_STRING);
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
            $messageToShow=3;
            $searchUser="SELECT email from accounts where username=?;";
            $stmt=$mysqli->prepare($searchUser);
            $stmt->bind_param("s",$u);
            $stmt->execute();
            $foundUser=$stmt->get_result();

            $finishedPsw="";
            if($foundUser->num_rows>0){
                $result=$foundUser->fetch_assoc();
                if(password_verify($email,$result["email"])){
                    $finishedPsw= generateRandomString(10);
                    $encryptedPsw=password_hash($finishedPsw,PASSWORD_BCRYPT);
                    $updateProvvisiorio="UPDATE accounts SET passwordU='$encryptedPsw' where username=? ";
                    $stmt=$mysqli->prepare($updateProvvisiorio);
                    $stmt->bind_param("s",$u);
                    $stmt->execute();
                    $foundUser=$stmt->get_result();
                        
                    $to=$email;
            		$subject="Forgot Password";
            		$message="<h1>Forgot Password</h1><h3>In this mail you will find a temporary password:</h3>$finishedPsw<br>We suggest you to log in our site and change the passord with a strongest one";
            		$headers="From: official.techsoftware@gmail.com \r\n";
            		$headers.="MIME-Version:1.0"."\r\n";
            		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";

            		mail($to,$subject,$message,$headers);
                    $messageToShow=1;
                }else $messageToShow=2;
            }else $messageToShow=4;
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
        <link rel="stylesheet" href="Login.css" type="text/css" >
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
        <div>
            <div>
                <?php
                    if($messageToShow==0){
                ?>
                <div class="form centra">
                    <form class="login-from" action="" method="post" >
                        <i class="fas fa-user"></i>
                        <input class="user-input" type="text" name="username" placeholder="Username" required>
                        <input class="user-input" type="text" name="email" placeholder="Email" required>
                        <input class="bth" type="submit" name="submit">
                    </form>
                    <?php
                        }else if($messageToShow==1){
                            echo "<h1 class='centra'>WE'VE SENT YOU AN EMAIL TO CHANGE PASSWORD<span style='color:green;'> CHECK YOUR MAILBOX !</span></h1>";
                        }else if($messageToShow==2){
                            echo "<h1 class='centra'>USERNAME AND MAIL DON'T MATCH<span style='color:red;'> CHECK YOUR DATA !</span></h1>";
                        }else if($messageToShow==3){
                            echo "<h1 class='centra'><span style='color:red;'> YOUR MAIL IS NOT VALID !</span></h1>";
                        }else{
                            echo "<h1 class='centra'>IMPOSSIBLE TO FIND THIS USER<br><span style='color:red;'> YOU HAVE TO REGISTER AN ACCOUNT</span></h1>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <footer style="margin-top:100px;">
        <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
    </footer>   
    <script src="Form.js"></script>
    <script src="script.js"></script>

    </body>
</html>
