<?php
session_start();
include('./dbConnect.php');
include('./AutoIDIncrement.php');
date_default_timezone_set('Asia/Yangon');
$viewcount = "";

$isLogin = false;
if(isset($_SESSION['cid'])){
    $isLogin = true;
    $cid = $_SESSION['cid'];
    $select = "SELECT * from Customer where CustomerID='$cid'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_array($query);
        $viewcount = $data['ViewCount'];
    }
}
$run = false;

if(isset($_POST['btncontact'])){
    $id = autoIDIncrement('CT', "`Contact`", "`ContactID`");
    $message = $_POST['txtdescription'];
    $name = $_POST['txtname'];
    $name = mysqli_real_escape_string($connect, $name);
    $email = $_POST['txtemail'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $insert = "INSERT INTO Contact (ContactID, ContactDate, ContactTime, Message, Username, Email)
    Values ('$id', '$date', '$time', '$message', '$name', '$email')";
    $run = mysqli_query($connect, $insert);
}

if(isset($_POST['btnsearch'])){
    $searchvalue = $_POST['searchbar'];
    echo "<script>window.location='Type&Availability.php?Value=$searchvalue'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="javascript.js"></script>

    <script>
        const successBackground = '#bfffa8';
        const successColor = '#007d19';
        const dangerBackground = '#ffa69c';
        const dangerColor = '#9c1000'; 

    </script>
</head>

<body onresize="changeClassName()">
    <div class="container">
        <header>
            <nav class="nav">
                <div class="logo">
                    <img src="./Images/icons/logo2.png" alt="">
                </div>
                <div class="navbar">
                    <div class="close" onclick="closenav()">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <a href="index.php">Home</a>
                    <a href="Information.php?data=all">Information</a>
                    <a href="Type&Availability.php?Value=">Availability</a>
                    <a href="Review.php">Reviews</a>
                    <a href="Features.php">Features</a>
                    <a href="Contact.php" class="active">Contact</a>
                    <a href="LocalAttractions.php">Local Attractions</a>
                    <?php
                        if($isLogin){
                            echo "<a href='CustomerProfile.php'>Profile</a>";
                        }
                        else{
                            echo "<a href='CustomerLogin.php'>Login</a>";
                        }
                    ?>

                </div>
                <div class="nav-background" onclick="closenav()"></div>

                <div class="buttons">
                    <button class="search-icon" onclick="openSearch()"><i class="fa-solid fa-magnifying-glass"></i></button>

                    <div class="burger" onclick="shownav()">
                        <div class="icon"></div>
                        <div class="icon"></div>
                        <div class="icon"></div>
                    </div>

                    <form method="POST">
                        <input type="text" name="searchbar" class="nav-searchbar" placeholder="Search..." id="">
                        <div class="searchbar-container col-1">
                            <input type="submit" class="fa-solid fa-magnifying-glass searchbar-icon nav-search" name="btnsearch" value="&#xf002">
                        </div>
                    </form>
                    <?php
                        if($isLogin){
                            echo "<a class='nav-login' href='CustomerProfile.php'>";
                            echo "<i class='fa-solid fa-user'></i>";
                            echo "</a>";
                        }
                        else{
                            echo "<a class='nav-login' href='CustomerLogin.php'>";
                            echo "<i class='fa-solid fa-right-to-bracket'></i>";
                            echo "</a>";
                        }
                    ?>
                </div>
            </nav>
        </header>
        <div class="search-container">
            <form method="POST">
                <input type="text" name="searchbar" class="searchtext" placeholder="Search..." id="">
                <input type="submit" class="fa-solid fa-magnifying-glass searchbtn searchbtn-icon" name="btnsearch" value="&#xf002">
            </form>
        </div>

        <div class="alert-box">
            <div class="alert-box-content">
            <span class="message"></span>
            <span onclick="closeAlert()"><i class="fa-solid fa-xmark"></i></span>
            </div>
        </div>

        <?php
        if($run){
            echo "<script>showAlert(successBackground, successColor, 'Your message has been sent successfully!')</script>";
        }
        ?>

        <div class="searchpage-title">
            <div class="searchpage-image">
                <img src="./Images/swimming/s25.jpg" alt="">
            </div>
            <h1>Contact Us</h1>
        </div>

        
        <div class="contact-title-container">
        <div class="contact-title col-10">
            <h1>Contact Us</h1>
        </div>
        </div>
        <div class="contact-content-container">
        <div class="contact-container col-lg-6">
            <div class="contact-content">
                <!-- <h2>Contact Information</h2> -->
                <div class="contact-content-details">
                    <div class="icon-background">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="contact-info">
                        <h3>Phone</h3>
                        <p>234-9876-8900</p>
                    </div>
                </div>
                <div class="contact-content-details">
                    <div class="icon-background">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="contact-info">
                        <h3>Email</h3>
                        <p>gwsc@gmail.com</p>
                    </div>
                </div>
                <div class="contact-content-details">
                <div class="icon-background">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-info">
                    <h3>Address</h3>
                    <p>25th Street, UK City, Middlesex, Kingdom</p>
                </div>
                </div>
            </div>
        </div>
        
        <div class="contact-form-container col-8 col-lg-6">
            <div class="contact-form-content col-sm-8 col-10">
                <h2>Send a message</h2>
                <form action="Contact.php" method="POST">
                    <div class="field">
                        <input type="text" class="site-input cus-input" name="txtname" placeholder=" " required autocomplete="off">
                        <span class="site-label cus-label">Name</span>
                    </div>
                    <div class="field">
                        <input type="text" class="site-input cus-input" name="txtemail" placeholder=" " required autocomplete="off">
                        <span class="site-label cus-label">Email</span>
                    </div>
                    <div class="field">
                        <textarea name="txtdescription" class="site-input input-textarea cus-input" id="description" cols="30" rows="10" placeholder=" " required></textarea>
                        <span for="description" class="site-label textarea cus-label">Description</span>
                     </div>
                     <input type="submit" class="cus-register" name="btncontact" value="Send Message">
                     
                </form>
            </div>
        </div>
        </div>

    

        <div class="policy-button">
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="RSSFeed.php">RSS Feed</a>
              </div>



        <div class="scrollup" onclick="handleScroll()" title="Scroll To Top"><i class="fa-solid fa-arrow-up scrolltop"></i></div>
        <footer id="footer">
            <div class="footer-container col-sm-12">
                <div class="footer-title">
                    <h1>GWSC</h1>
                    <h1>Global Wild Swimming and Camping</h1>
                </div>
                <div class="footer-content-container">
                <div class="footer-content cols-sm-10 col-lg-12">
                <div class="page-text col-sm-6 col-4">
                    <div class="footer-navbar">
                        <h2>Pages</h2>
                        <div class="footer-nav-container">
                        <div class="footer-nav1">
                        <a href="index.php">Home</a>
                        <a href="Information.php?data=all">Information</a>
                        <a href="Type&Availability.php?Value=">Availability</a>
                        <a href="Review.php">Reviews</a>
                        </div>
                        <div class="footer-nav2">
                        <a href="Features.php">Features</a>
                        <a href="Contact.php">Contact</a>
                        <a href="LocalAttractions.php">Local Attractions</a>
                        </div>
                        </div>
                    </div>
                    
                </div>
                <div class="page-text col-sm-6 col-4">
                    <div class="footer-contact">
                    <h2>Contact Information</h2>
                    <p>Phone: 234-9876-8900</p>
                    <p>Email: gwsc@gmail.com</p>
                    <p>Address: 25th Street, UK City, Middlesex, Kingdom</p>
                    </div>
                </div>
                <div class="social-media-icons col-sm-6 col-4">
                    <h2>Follow us</h2>
                    <div class="footer-icons">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-youtube"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                    </div>
                </div>
                
                </div>
                </div>
                <div class="footer-last">
                <div class="footer-here">
                <p>You are currently in the <a href="Contact.php"><u>Contact Page</u></a>. 
                <?php 
                    if($viewcount){
                        echo ' Your Visit Count - '.$viewcount;
                    }
                    ?></p>
                </div>
                    <div class="footer-copyright">
                    <p>Copyright @ 2023 GWSC. All rights reserved.</p>
                    <div>
                    <a href="PrivacyPolicy.php">Privacy Policy</a> |
                    <a href="TermsofService.php">Terms of Service</a>
                    </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>

        if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
        }

        let burger = document.getElementsByClassName('burger')[0];
        let navBackground = document.getElementsByClassName('nav-background')[0];
        let searchContainer = document.getElementsByClassName('search-container')[0];
        let scrollup = document.getElementsByClassName('scrollup')[0];
        let navbar = document.getElementsByClassName('navbar')[0];
        let isNavOpen = false;
        let isSearchBarOpen = false;

        function shownav() {
            navbar.className += ' responsive';
            // searchContainer.className = 'search-container';
            navBackground.style.display = 'block';
            isNavOpen = true;
        }

        function closenav() {
            navbar.className = 'navbar';
            navBackground.style.display = 'none';
            isNavOpen = false;
            searchContainer.className = 'search-container';
            // searchBackground.style.display = 'none';
            isSearchBarOpen = false;

        }

        function changeClassName() {
            if (screen.width > 1200) {
                navbar.className = 'navbar';
                searchContainer.className = 'search-container';
                navBackground.style.display = 'none';
            } else {
                if (isNavOpen === true) {
                    navbar.className += ' responsive';
                    navBackground.style.display = 'block';
                }
                if (isSearchBarOpen === true) {
                    searchContainer.className += ' responsive';
                    navBackground.style.display = 'block';
                }
            }
        }


        function openSearch() {
            searchContainer.className += ' responsive';
            navBackground.style.display = 'block';
            isSearchBarOpen = true;
        }

        // sticky navbar
        window.onscroll = function() {
            stickynavbar();
            scrollFunction();
            // updateScrollToTopPosition();
        };

        var nav = document.getElementsByClassName('nav')[0];
        var sticky = 200;

        function stickynavbar() {
            if (window.pageYOffset >= sticky) {
                nav.className = 'nav sticky';
            } else {
                nav.className = 'nav';
            }
        }

        function scrollFunction() {
            if (document.documentElement.scrollTop > 200) {
                scrollup.style.display = 'block';
            } else {
                scrollup.style.display = 'none';
            }
        }

        function handleScroll() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>