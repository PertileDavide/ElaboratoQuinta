<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        .responsive{
            width:33.33%;
            display:inline-block;
        }
        .keys{
            font-size:20px;
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
        	.keys{
               		font-size:15px;
            	}
	}
	@media (max-width: 500px){
		.centra{
			transform:translate(-50%,-5%);
		}
        	.keys{
                	font-size:10px;
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

        <section class="about" id="about" style="height:100vh;overflow-y:auto">
            <div class="max-width">
                <br><br><br>
                <?php
                    if(isset($_SESSION["tech_software"])){
                        $mysqli=new mysqli("localhost","pertile4465","","my_pertile4465");;
                        $name=$_SESSION["tech_software"];
                        $result=$mysqli->query("SELECT software_name,count(*) as howmany FROM orders WHERE account='$name' GROUP BY software_name ORDER BY howmany DESC");
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $software=$row["software_name"];
                                $getKeys=$mysqli->query("SELECT product_key FROM orders WHERE account='$name' and software_name='$software' ");
                                echo "<div class='about-content' style='background-color:white;;height:300px'>
                                    <div class='column left' style='font-size:40px'><center>".$row["software_name"]."</center></div>";     
                                    echo "<div class='column right keys'>";
                                    while($keys=$getKeys->fetch_assoc())
                                        echo "<center style='margin-top:2%'><b>".$keys["product_key"]."</b></center>";
                                    echo "</div>";
                                echo "</div><br><br>";
                            }
                            $mysqli->close();
                        }else{
                            echo "<h1 class='centra'>YOU HAVE NO ORDERS WITH THIS ACCOUNT</h1>";
                        }
                    }else{
                        echo "<h1 class='centra'>YOU NEED TO BE LOGGED TO ACCESS THIS PAGE</h1>";
                    }
                ?>
            </div>
        </section>
  
        <footer style="margin-top:100px;">
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>

        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
