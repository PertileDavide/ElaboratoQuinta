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
        .accordion {
        width:100%;
        background: linear-gradient(-45deg,#ff3333,#ffa64d);
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        outline: none;
        transition: 0.5s;
        margin-bottom:20px;
        }
        .active, .accordion:hover {
            color:#fff;
            background:#ff3333;
        }
        .panel {
        background-color: white;
        display: none;
        overflow: hidden;
        margin-bottom:20px;
        }
        .elementInsideBox {
            margin-top:5%;
            margin-bottom:10px;
        }
        .info{
            width:100%;
            background-color:#ffa64d;
            height:60px;
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

        <section class="contact" id="contact" style="height:50px">
        </section>
        <section class="about" id="about" style="height:100vh;overflow-y:auto">
            <div class="max-width">
                <?php
                    $softwareconn=new mysqli("localhost","pertile4465","","my_pertile4465");
                    $softwareconn->query('SET NAMES utf8');
                    $software=$softwareconn->query("SELECT * from software ORDER BY name ASC");
                    if($software->num_rows>0){
                        while($row=$software->fetch_assoc()){
                            echo "<button id='".str_replace(' ', '', $row["name"])."' class='accordion' style='font-size:25px'><center><b>".$row["name"]."</b></center></button>";
                            echo "<div class='panel'>";
                                echo "<div class='info'>";
                                    echo "<center><div style='font-size:25px;padding-top:15px'><b>KEYS LEFT: <i>".$row["available"]."</i></b></div></center>";
                                echo "</div>";
                                    echo "<hr>";
                                echo "<div class='info'>";
                                    echo "<center><div style='font-size:25px;padding-top:15px'><b>PRICE: <i>".$row["price"]."&euro;</i></b></div></center>";
                                echo "</div>";
                                echo "<center><img src='software/".str_replace(' ', '', $row["name"]).".webp' alt='".$row["name"]."' width='80%' class='elementInsideBox'></center>";
                                
                                echo "<center><p class='elementInsideBox'>".$row["description"]."</p></center>";
                                echo "<form action='FinishTransaction.php' method='get'>";
                                    echo "<input type='hidden' name='product' value='".$row["name"]."' >";
                                    echo "<br><br><center><button>BUY THIS PRODUCT</button></center>";
                                echo "</form>";
                                echo "<br><br><center><b><div style='font-size:20px;padding-top:15px;width:100%;background-color:#bfbfbf;height:110px;'>CHECK THE OFFICIAL WEB PAGE:<br><br> <a href='".$row["link"]."' style='text-transform:uppercase;'>".$row["name"]."</a></b>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }
                    $softwareconn->close();
                ?>
            </div>     
        </section>
        <footer >
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                panel.style.display = "none";
                } else {
                panel.style.display = "block";
                }
            });
            }
        </script>
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
