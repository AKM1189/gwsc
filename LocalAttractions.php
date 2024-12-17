<?php
session_start();
include('./dbConnect.php');

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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                    <a href="Contact.php">Contact</a>
                    <a href="LocalAttractions.php"  class="active">Local Attractions</a>
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
                        <input type="text" name="searchbar" class="nav-searchbar" placeholder='Search...' id="">
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

        <div class="searchpage-title">
            <div class="searchpage-image">
                <img src="./Images/localattraction/16.jpg" alt="">
            </div>
            <h1>Local Attractions</h1>
        </div>

        <section>
            <div class="attraction-container">
                <div class="attraction-content">
                <div class="attraction-title">
                    <h1>Local Attractions</h1>
                    <p>Discover new attractions and experiences to match your interests and travel style</p>
                </div>
                <div class="attraction-list">
                    <?php
                    $select = "SELECT * from Pitch";
                    $query = mysqli_query($connect, $select);
                    $count = mysqli_num_rows($query);

                    if($count > 0){
                        for($i = 0; $i < $count; $i += 3){
                            $select1 = "SELECT * from Pitch LIMIT $i,3";
                            $query1 = mysqli_query($connect, $select1);
                            $count1 = mysqli_num_rows($query1);

                            for($j = 0; $j < $count1; $j++){
                                $data = mysqli_fetch_array($query1);
                                $pname = $data['PitchName'];
                                $aname1 = $data['LocalAttraction1'];
                                $aname2 = $data['LocalAttraction2'];
                                $aname3 = $data['LocalAttraction3'];
                                $aimage1 = $data['AttractionImage1'];
                                $aimage2 = $data['AttractionImage2'];
                                $aimage3 = $data['AttractionImage3'];
                                
                                echo "<h2>$pname</h2>";
                                echo "<div class='attraction col-sm-12'>";
                                
                                echo "<div class='attraction-field col-6 col-lg-4'>";
                                echo "<img class='local-attraction-img' src='./".$aimage1."'>";
                                echo "<h4 class='local-attraction-name'>$aname1</h4>";
                                echo "</div>";

                                echo "<div class='attraction-field col-6 col-lg-4'>";
                                echo "<img class='local-attraction-img' src='./".$aimage2."'>";
                                echo "<h4 class='local-attraction-name'>$aname2</h4>";
                                echo "</div>";

                                echo "<div class='attraction-field col-6 col-lg-4'>";
                                echo "<img class='local-attraction-img' src='./".$aimage3."'>";
                                echo "<h4 class='local-attraction-name'>$aname3</h4>";
                                echo "</div>";

                                echo "</div>";
                            }

                        }                     
                    }
                    ?>
                </div>
                </div>
            </div>
        </section>

        <div class="scrollup" onclick="handleScroll()"><i class="fa-solid fa-arrow-up scrolltop"></i></div>
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
                <p>You are currently in the <a href="LocalAttractions.php"><u>Local Attractions Page</u></a>. 
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
        let burger = document.getElementsByClassName('burger')[0];
        let navBackground = document.getElementsByClassName('nav-background')[0];
        let searchContainer = document.getElementsByClassName('search-container')[0];
        let scrollup = document.getElementsByClassName('scrollup')[0];
        let navbar = document.getElementsByClassName('navbar')[0];
        let isNavOpen = false;
        let isSearchBarOpen = false;

        function shownav() {
            navbar.className += ' responsive';
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
                searchContainer.className = 'search-container'
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
                nav.className += ' sticky';
                // nav.style.backgroundColor = 'black';
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