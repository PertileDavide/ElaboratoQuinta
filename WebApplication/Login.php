<?php
    session_start();
    $messageToShow=0;
    if(isset($_SESSION["tech_software"])){
        $messageToShow=3;
    }else{
        if(isset($_POST["submit"]) && $_POST["username"]!="" && $_POST["password"]!=""){
            $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
            $u=$_POST["username"];
            $p1=$_POST["password"];
            $u=$mysqli->real_escape_string($u);
            $p1=$mysqli->real_escape_string($p1);

            $searchUser="SELECT passwordU,verified from accounts where username=?;";
            $stmt=$mysqli->prepare($searchUser);
            $stmt->bind_param("s",$u);
            $stmt->execute();
            $foundUser=$stmt->get_result();

            if($foundUser->num_rows>0){
                $result=$foundUser->fetch_assoc();
                if(password_verify($p1,$result["passwordU"]) && $result["verified"]==1){
                    $_SESSION["tech_software"]=$u;
                    $_SESSION["temp"]="";
                    header('Location: Index.php');
                }else $messageToShow=2;
            }else{
                $messageToShow=1;
            }
            $mysqli->close();
        }
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

    <section class="home" id="home">
        <div>
            <div>
                <?php
                    if($messageToShow==0){
                ?>
                <div class="form centra">
                    <form class="login-from" action="" method="post">
                        <i class="fas fa-user"></i>
                        <input class="user-input" type="text" name="username" placeholder="Username" required>
                        <input class="user-input" type="password" name="password" placeholder="Password" required>
                        <div class="options-01">
                            <a href="ChangePassword.php">Change Password</a>
                        </div>
                        <input class="bth" type="submit" name="submit" value="LOGIN">
                        <div class="options-02">
                            <p>Not Registered? <a href="Register.php">Create Account</a></p>
                        </div>
                    </form>
                    <?php
                        }else if($messageToShow==1){
                            echo "<h1 class='centra'>IMPOSSIBLE TO FIND THIS USER<br><span style='color:red;'> YOU HAVE TO REGISTER BEFORE TO LOGIN</span></h1>";
                        }else if($messageToShow==2){
                            echo "<h1 class='centra'>IMPOSSIBLE TO LOG IN YOUR ACCOUNT.<br><span style='color:red;'> DATA ARE NOT CORRECT OR ACCOUNT IS NOT VERIFIED!</span></h1>";
                        }else{
                            echo "<h1 class='centra'>YOU'RE <span style='color:green;'> ALREADY LOGGED!</span></h1>";
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
