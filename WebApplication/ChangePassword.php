<?php
    session_start();
    $messageToShow=0;
    $whichError="";
        if(isset($_POST["submit"])){
            $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
            
            $u=$_POST["username"];
            $p1=$_POST["oldpassword"];
            $p2=$_POST["newpassword"];
            $u=$mysqli->real_escape_string($u);
            $p1=$mysqli->real_escape_string($p1);
            $p2=$mysqli->real_escape_string($p2);

            if(strlen($p2)<8)
            {
                $whichError="YOUR PASSWORD MUST BE AT LEAST 8 CHARACTERS";
            }
            if(!preg_match("#[0-9]+#",$p2)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 NUMBER";
            }
            if(!preg_match("#[A-Z]+#",$p2)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 CAPITAL LETTER";
            }
            if(!preg_match("#[a-z]+#",$p2)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 LOWERCASE LETTER";
            }
            $pattern='%#@';
            if (!preg_match('/[' . $pattern . ']/', $p2)) {
                $whichError="YOUR PASSWORD MUST CONTAIN A SPECIAL CHARACTER= $pattern";
            }
            if($p2===$u){
                $whichError="YOUR PASSWORD CAN NOT BE EQUAL AT YOUR USERNAME";
            }

            $searchUser="SELECT passwordU,verified from accounts where username=?;";
            $stmt=$mysqli->prepare($searchUser);
            $stmt->bind_param("s",$u);
            $stmt->execute();
            $foundUser=$stmt->get_result();

            if($whichError==""){
                if($foundUser->num_rows>0){
                    $result=$foundUser->fetch_assoc();
                    if(password_verify($p1,$result["passwordU"]) && $result["verified"]==1){
                        $pChange=password_hash($p2,PASSWORD_BCRYPT);
                        $changepsw="UPDATE accounts set passwordU=? where username=?;";
                        $stmt=$mysqli->prepare($changepsw);
                        $stmt->bind_param("ss",$pChange,$u);
                        $stmt->execute();
                        session_destroy();
                        header('Location: Login.php');
                    }else $messageToShow=2;
                }else $messageToShow=1;
            }else $messageToShow=3;
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
                        echo "<li><a href='Exit.php'><b>Exit</b></a></li>";
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
                        <input class="user-input" type="password" name="oldpassword" placeholder="Old Password" required>
                        <input class="user-input" type="password" name="newpassword" placeholder="New Password" required>
                        <div class="options-01">
                            <a href="ForgotPassword.php">Forgot password?</a>
                        </div>
                        <input class="bth" type="submit" name="submit">
                    </form>
                    <?php
                        }else if($messageToShow==1){
                            echo "<h1 class='centra'>IMPOSSIBLE TO FIND THIS USER<br><span style='color:red;'> YOU HAVE TO REGISTER</span></h1>";
                        }else if($messageToShow==2){
                            echo "<h1 class='centra'>IMPOSSIBLE TO CHANGE YOUR PASSWORD <br><span style='color:red;'> DATA ARE NOT CORRECT OR ACCOUNT IS NOT VERIFIED!</span></h1>";
                        }else{
                            echo "<h1 class='centra'>$whichError</h1>";
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
