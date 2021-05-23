<?php
    session_start();

    $whichError="";
    if(!isset($_SESSION["tech_software"])){
        $messageToShow=0;
        if(isset($_POST["submit"])){
            $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");
            $u=$_POST["username"];
            if(strlen($u)<5){
                $whichError="YOUR USERNAME MUST BE AT LEAST 5 CHARACTERS";
            }
            $email=filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $email=filter_var($_POST["email"], FILTER_SANITIZE_URL);
            $email=filter_var($_POST["email"], FILTER_SANITIZE_STRING);
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $whichError="EMAIL IS NOT VALID";
            }
            $p1=$_POST["password"];
            $u=$mysqli->real_escape_string($u);
            $email=$mysqli->real_escape_string($email);
            $p1=$mysqli->real_escape_string($p1);

            if(strlen($p1)<8)
            {
                $whichError="YOUR PASSWORD MUST BE AT LEAST 8 CHARACTERS";
            }
            if(!preg_match("#[0-9]+#",$p1)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 NUMBER";
            }
            if(!preg_match("#[A-Z]+#",$p1)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 CAPITAL LETTER";
            }
            if(!preg_match("#[a-z]+#",$p1)) {
                $whichError="YOUR PASSWORD MUST CONTAIN AT LEAST 1 LOWERCASE LETTER";
            }
            $pattern='%#@';
            if (!preg_match('/[' . $pattern . ']/', $p1)) {
                $whichError="YOUR PASSWORD MUST CONTAIN A SPECIAL CHARACTER= $pattern";
            }
            if($p1===$u){
                $whichError="YOUR PASSWORD CAN NOT BE EQUAL AT YOUR USERNAME";
            }
            if($whichError==""){
                $alreadyIn=0;

                $sql="SELECT username from accounts";
                $findUser = $mysqli->query($sql);
                if($findUser->num_rows>0){
                    while($row=$findUser->fetch_assoc()){
                        if($u==$row["username"]){
                            $alreadyIn=1;
                        }
                    }
                }
                $sql="SELECT email from accounts";
                $findEmail = $mysqli->query($sql);
                if($findEmail->num_rows>0){
                    while($row=$findEmail->fetch_assoc()){
                        if(password_verify($email,$row["email"])){
                            $alreadyIn=1;
                        }
                    }
                }

                $vkey=password_hash(time().$u,PASSWORD_BCRYPT);
                $safeEmail=password_hash($email,PASSWORD_BCRYPT);
                $safePsw=password_hash($p1,PASSWORD_BCRYPT);

                if($alreadyIn===0){
                    $sql="INSERT into accounts(username,passwordU,email,vkey) values(?,?,?,?);";
                    $stmt=$mysqli->prepare($sql);
                    $stmt->bind_param("ssss",$u,$safePsw,$safeEmail,$vkey);
                    $stmt->execute();

                    $to=$email;
                    $subject="Email Verification";
                    $message="<h1>ACTION REQUIRED TO ACTIVATE YOUR ACCOUNT</h1><br><a href='https://pertile4465.altervista.org/NonDefinitivo/verify.php?vkey=$vkey'>Register Account</a><br><br> ";
                    $headers="From: official.techsoftware@gmail.com \r\n";
                    $headers.="MIME-Version:1.0"."\r\n";
                    $headers.="Content-type:text/html;charset=UTF-8"."\r\n";

                    mail($to,$subject,$message,$headers);
                }else{
                    $whichError="USER ALREADY REGISTERED WITH THIS USERNAME OR EMAIL";
                    $messageToShow=2;
                } 
            }else{
                $messageToShow=2;
            }
            $mysqli->close();
        }
    }else{
        $messageToShow=1;
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
                    <li><a href="#">Contact us</a></li>
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
                        <input class="user-input" type="email" name="email" placeholder="Email Address" required>
                        <input class="user-input" type="password" name="password" placeholder="Password" required>
                        <input class="bth" type="submit" name="submit" value="SING UP">
                        <div class="options-02">
                            <p>Already Registered? <a href="Login.php"> Sing In</a></p>
                        </div>
                    </form>
                </div>
                <?php
                }else if($messageToShow==1){
                    echo "<h1 class='centra'>YOU CAN'T REGISTER ANOTHER ACCOUNT UNTIL YOU'RE LOGGED</h1>";
                }else{
                    echo "<h1 class='centra'>$whichError</h1>";
                }
                ?>
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
