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
        .readmore{
            color:white;
            font-size:20px;
            text-decoration:underline;
        }
        .readmore:visited{
            color:white;
            text-decoration:underline;
        }
    </style>
    <body>
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
                    <li><a href="#contact">Contact us</a></li>
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

        <section class="home" id="home">
            <div class="max-width">
                <div class="home-contents">
                    <video autoplay muted loop id="myVideo" class="videobg">
                        <source src="trailer.webm" type="video/mp4" >
                    </video>
                </div>
            </div>
        </section>
        
        <section class="about" id="about">
            <div class="max-width">
                <h2 class="title">WHO WE ARE</h2>
                <div class="about-content">
                    <div class="column left">
                        <img src="tech.webp" alt="tech software image">
                    </div>
                    <div class="column right" style="font-size: 20px;">
                        <div class="text"><b>TECH SOFTWARE</b></div>
                        <p> is one of the best software seller that provide you the best solution at the best price you can find. You can buy our products 24/7 and if you have some questions or some troubles you can contact us in the apposite section, <i>at the bottom of this page</i><hr style="color:red;margin-top:30px;margin-bottom: 30px;"/></p>
                        <a href="Shop.php">Go to Shop section</a>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="services" id="services">
            <div class="max-width">
                <h2 class="title">SOFTWARE CATEGORIES</h2>
                <div class="serv-content">
                    <div class="card">
                        <div class="box">
                            <i class="fas fa-film"></i>
                            <div class="text">Video Editing</div>
                            <p>Video editing is the manipulation and arrangement of video shots. Video editing is used to structure and present all video information, including films and television shows, video advertisements and video essays.</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <i class="fas fa-key"></i>
                            <div class="text">Security</div>
                            <p>Security software is any type of software that secures and protects a computer, network or any computing-enabled device. It manages access control, provides data protection, secures the system against viruses and network.</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <i class="fas fa-network-wired"></i>
                            <div class="text">Other categories</div>
                            <p>Lot of categories that you are looking for is in our shop. Just search in our website and find the solution that is better for you. If you need something, you can contact us. We will ever be here for you</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="skills" id="skills">
            <div class="max-width">
                <h2 class="title">WHAT WE OFFER</h2>
                <div class="skills-content">
                    <div class="column left">
                        <div class="text">The better for our customers!</div>
                        <p>Let me introduce what we guarantee in our sales. <i>Security</i>,<i>Accessibility</i> and <i>Velocity</i> are our main goals that we want to achieve in every order that you will do. We do offer these factors in the transactions so you can be relaxed while our service is giving you what you asked</p>
                    </div>
                    <div class="column right">
                        <div class="bars">
                            <div class="info">
                                <span>Security</span>
                                <span>100%</span>
                            </div>
                            <div class="line security"></div>
                        </div>
                        <div class="bars">
                            <div class="info">
                                <span>Accessibility</span>
                                <span>100%</span>
                            </div>
                            <div class="line accessibility"></div>
                        </div>
                        <div class="bars">
                            <div class="info">
                                <span>Velocity</span>
                                <span>100%</span>
                            </div>
                            <div class="line velocity"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="products" id="products">
            <div class="max-width">
                <h2 class="title">SOFTWARE WE SELL</h2>
                <div class="carousel owl-carousel">
                    <?php
                        $softwareconn=new mysqli("localhost","pertile4465","","my_pertile4465");
                        $softwareconn->query('SET NAMES utf8');
                        $software=$softwareconn->query("SELECT * from software ORDER BY name ASC");
                            if($software->num_rows>0){
                                while($row=$software->fetch_assoc()){
                                    echo "<div class='card'>";
                                    echo "<div class='box'>";
                                    echo "<img src='software/".str_replace(' ', '', $row["name"]).".webp' alt='".$row["name"]."'>";
                                    echo "<div class='text'>".$row["name"]."</div>";
                                    echo "<p>".substr($row["description"],0,75)."<br>...<a href='Shop.php#".str_replace(' ', '', $row["name"])."' class='readmore'>Read More</a></p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        $softwareconn->close();                             
                    ?>
                </div>
            </div>
        </section>

        <section class="contact" id="contact">
            <div class="max-width">
                <h2 class="title">CONTACT ME</h2>
                <div class="contact-content">
                    <div class="column left">
                        <div class="text">Get in Touch</div>
                        <p>If you re having some troubles with orders or you have some offer, just contact us. We'll try to help you in the faster way so you can get the better experience we can offer. To do this, you can compile the form near there or you can simply use the mail in the bottom to contact us from where you prefere</p>
                        <div class="icons">
                            <div class="row">
                                <i class="fas fa-user"></i>
                                <div class="info">
                                    <div class="head">Name</div>
                                    <div class="sub-title">Pertile Davide</div>
                                </div>
                            </div>
                            <div class="row">
                                <i class="fas fa-clock"></i>
                                <div class="info">
                                    <div class="head">When to contact</div>
                                    <div class="sub-title">24/7</div>
                                </div>
                            </div>
                            <div class="row">
                                <i class="fas fa-envelope"></i>
                                <div class="info">
                                    <div class="head">Email</div>
                                    <div class="sub-title">official.techsoftware@gmail.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column right">
                        <div class="text">Message me</div>
                        <form method="post" action="emailSend.php">
                            <div class="fields">
                                <div class="field name">
                                    <input type="text" name="name" placeholder="Username" required>
                                </div>
                                <div class="field email">
                                    <input type="email" name="fromEmail" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="field">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="field textarea">
                                <textarea cols="30" rows="10" name="text" placeholder="Message..(Don't share your personal data)" required></textarea>
                            </div>
                            <div class="button">
                                <button type="submit" name="inviaEmail">Send message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <span>Created By <span class="red">Pertile Davide</span> | <span class="far fa-copyright"></span> 2021 All rights reserved.</span>
        </footer>
        
        <script src="Form.js"></script>
        <script src="script.js"></script>
    </body>
</html>
