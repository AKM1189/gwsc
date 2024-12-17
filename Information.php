<?php

session_start();
include('./dbConnect.php');
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

$isLogin = false;
$viewcount = '';

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

$data = empty($_GET['data'])? 'all':$_GET['data'];
if(isset($_POST['btnsearch'])){
    $searchvalue = $_POST['searchbar'];
    echo "<script>window.location='Type&Availability.php?Value=$searchvalue'</script>";
}

$booked = empty($_GET['booked'])? header('Information.php?data=all'):$_GET['booked'];

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
                    <a href="Information.php?data=all" class="active">Information</a>
                    <a href="Type&Availability.php?Value=">Availability</a>
                    <a href="Review.php">Reviews</a>
                    <a href="Features.php">Features</a>
                    <a href="Contact.php">Contact</a>
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

        <div class="search-container col-sm-12">
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
            if($booked > 0){
                echo "<script>showAlert(successBackground, successColor, 'You have booked successfully!')</script>";
            }
        ?>

        <div class="searchpage-title">
            <div class="searchpage-image">
                <img src="./Images/camping/12.jpg" alt="">
            </div>
            <h1>Discover Wild Swimming and Camping Sites</h1>
        </div>

        
        <div class="filter-pitch">
            <a href="Information.php?data=all" class="<?php echo ($data=='all')?'selected': '' ?>">All</a>
            <a href="Information.php?data=camping" class="<?php echo ($data=='camping')?'selected': '' ?>">Camping</a>
            <a href="Information.php?data=swimming" class="<?php echo ($data=='swimming')?'selected': '' ?>">Swimming</a>
        </div>
        <div class="pitch-container col-sm-12">
        <?php
                    $query = "SELECT * from Pitch";
                    $run = mysqli_query($connect, $query);
                    $count = mysqli_num_rows($run);

                    if($count == 0){
                        echo "<p>Pitches cannot be focund</p>";
                    }
                    else{
                        for($i = 0; $i < $count; $i++){
                            if($data == 'all'){
                                $query2 = "SELECT * from Pitch 
                                ORDER BY PitchID";
                            }
                            else if($data == 'swimming'){
                                $query2 = "SELECT * from Pitch 
                                where SiteType='Swimming'";
                            }
                            else{
                                $query2 = "SELECT * from Pitch 
                                where SiteType='Camping'";
                            }
                            $run2 = mysqli_query($connect, $query2);
                            $count2 = mysqli_num_rows($run2);

                            echo "<div class='pitch-list col-sm-12'>";

                            for($j = 0; $j < $count2; $j++){ // column
                                $data = mysqli_fetch_array($run2);
                                $PID = $data['PitchID'];
                                $Pname = $data['PitchName'];
                                $Price = $data['Price'];
                                $description = $data['Description'];
                                $location = $data['Location'];
                                $Pimage1 = $data['Image1'];
                                $typeid = $data["TypeID"];
                                $typequery = "SELECT * from PitchType where TypeID = '$typeid'";
                                $typequeryrun = mysqli_query($connect, $typequery);
                                $typedata = mysqli_fetch_array($typequeryrun);
                                $typename = $typedata["TypeName"];
                                $featurequery = "SELECT f.FeatureName, f.FeatureIcon from Feature f, PitchFeature pf where f.FeatureID = pf.FeatureID
                                And pf.PitchID = '$PID'";
                                $featurerun = mysqli_query($connect, $featurequery);
                                $featurecount = mysqli_num_rows($featurerun);
                                ?>
   
                                    <div class="pitch-details-container col-lg-4 col-6 col-sm-10">
                                    <div class="pitch-details">
                                    <a href="Details.php?PID=<?php echo $PID?>">
                                    <div class="pitch-details-image">
                                    
                                    <img class="info-image" src="<?php echo './'.$Pimage1?>" alt="">
                                    </div>
                                    </a>
                                    <div class="pitch-details-text">
                                    <h2>
                                    <a href="Details.php?PID=<?php echo $PID?>">
                                    <?php echo $Pname?>
                                    </a></h2>
                                    <p class="pitch-details-type"><?php echo $typename?></p>
                                    <p class="pitch-details-type">starting from <b>$<?php echo $Price?></b></p>
                                    <p class="pitch-description" maxlength="10"><?php 
                                    if(strlen($description) > 150){
                                        $reviewsplit = str_split($description);
                                                for ($i = 0; $i < 150; $i++) {
                                                    echo $reviewsplit[$i];
                                                }
                                                echo "...";
                                    }
                                    else{
                                        echo $description;
                                    }
                                    ?></p>
                                    </div>
                                    <div class="site-location col-12">
                                    <iframe src="<?php echo $location ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                                    </div>                                    
                                    <div class="pitch-details-icons">
                                    <p class="feature-icon-details"><?php 
                                        if($featurecount > 0){
                                            $featuredata = mysqli_fetch_all($featurerun);
                                            for($k = 0; $k < $featurecount; $k++){
                                                echo "<i class='fa-solid fa-".$featuredata[$k][1]." feature-icon'></i>";
                                            }
                                        }
                                    ?></p>
                                    <a href="Details.php?PID=<?php echo $PID?>" class="pitch-details-right">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                    </div>
                                    
                                    </div>
                                    </div>
                              <?php  
                            }
                            echo "</div>";
                        }
                    }
                    ?>
        </div>
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
                <p>You are currently in the <a href="Information.php"><u>Information Page</u></a>. 
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

        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

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

    <?php
        if($pageWasRefreshed ) {
            if($booked){
                echo "<script>window.location='Information.php'</script>";
            }
          }
    ?>



</body>
</html>