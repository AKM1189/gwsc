<?php

session_start();
include('./dbConnect.php');
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

$viewcount = "";
$isLogin = false;
$_SESSION['profileupdated'] = false;

if (isset($_SESSION['cid'])) {
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
if (isset($_POST['btnsearch'])) {
    $searchvalue = $_POST['searchbar'];
    echo "<script>window.location='Type&Availability.php?Value=$searchvalue'</script>";
}

$isLogout = empty($_GET['logout'])? header('index.php'):$_GET['logout'];
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
                    <a href="index.php" class="active">Home</a>
                    <a href="Information.php?data=all">Information</a>
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
                            echo "<a class='nav-login' href='CustomerProfile.php' title='Profile'>";
                            echo "<i class='fa-solid fa-user'></i>";
                            echo "</a>";
                        }
                        else{
                            echo "<a class='nav-login' href='CustomerLogin.php' title='Login'>";
                            echo "<i class='fa-solid fa-right-to-bracket'></i>";
                            echo "</a>";
                        }
                    ?>
                </div>
            </nav>
        </header>

        <div class="alert-box">
            <div class="alert-box-content">
            <span class="message"></span>
            <span onclick="closeAlert()"><i class="fa-solid fa-xmark"></i></span>
            </div>
        </div>
        <?php
        if($isLogout){
            echo "<script>showAlert(successBackground, successColor, 'Your have logout successfully!')</script>";
        }
        ?>

        <section class="image-slider">
            <div class="slideshow-container">
                <div class="mySlides fade">
                    <img src="./Images/swimming/s4.jpg">
                    <div class="z-index"></div>
                </div>

                <div class="mySlides fade">
                    <img src="./Images/camping/8.jpg">
                </div>

                <div class="mySlides fade">
                    <img src="./Images/swimming/s7.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./Images/camping/9.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./Images/camping/12.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./Images/camping/13.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./Images/swimming/s13.jpg">
                </div>
            </div>
            <br>

            <span class="left" onclick="changeSlide(-1)"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="right" onclick="changeSlide(1)"><i class="fa-solid fa-chevron-right"></i></span>

            <div class="dash-container">
                <span class="dash" onclick="currentSlide(1)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(2)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(3)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(4)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(5)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(6)"><i class="fa-solid fa-minus"></i></span>
                <span class="dash" onclick="currentSlide(7)"><i class="fa-solid fa-minus"></i></span>
            </div>

        </section>

        <div class="search-container col-sm-12">
            <form method="POST">
                <input type="text" name="searchbar" class="searchtext" placeholder="Search..." id="">
                <input type="submit" class="fa-solid fa-magnifying-glass searchbtn searchbtn-icon" name="btnsearch" value="&#xf002">
            </form>
        </div>

        <div class="welcome-text col-7">
            <h1>Welcome to Global Wild Swimming and Camping</h1>
            <p>The Global Wild Swimming and Camping Company, founded in 2008, offers eco-friendly outdoor adventures worldwide. Initially local, it expanded globally, promoting sustainable travel and environmental awareness. The company provides immersive wild swimming and camping experiences, emphasizing responsible tourism and supporting local communities. Through digital platforms, it fosters a global community of nature enthusiasts.</p>
        </div>

        <div class="pitch-type-container col-sm-12">
            <div class="pitchtype-content col-sm-12">
                <div class="pitchtype col-lg-4 col-4 col-sm-10">
                    <div class="pitchtype-image">
                        <img src="./Images/pitchtypes/6.jpg" alt="">
                    </div>
                    <div class="pitchtype-detail">
                        <h2>Tent Pitch</h2>
                        <p>Escape the ordinary and embrace the extraordinary with our exclusive tent pitches</p>
                    </div>
                </div>
                <div class="pitchtype col-lg-4 col-4 col-sm-10">
                    <div class="pitchtype-image">
                        <img src="./Images/pitchtypes/12.jpg" alt="">
                    </div>
                    <div class="pitchtype-detail">
                        <h2>Touring Caravan Pitch</h2>
                        <p>Experience our ultimate road trip adventure and thrill of wild camping with our touring caravan pitches.</p>
                    </div>
                </div>
                <div class="pitchtype col-lg-4 col-4 col-sm-10">
                    <div class="pitchtype-image">
                        <img src="./Images/pitchtypes/7.jpg" alt="">
                    </div>
                    <div class="pitchtype-detail">
                        <h2>Motorhome Pitch</h2>
                        <p>Wake up to the sounds of nature, chase the horizon, and let your motorhome be your ticket to uncharted territories.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="travel-container">
            <div class="travel-image">
                <img src="./Images/camping/25.jpg" alt="">
            </div>
            <div class="travel-title">
                <h1>Ready to Get Started your Travel Camping Us</h1>
            </div>
            <div class="travel-content col-10 col-sm-10">
                <div class="travel-details col-sm-3">
                    <img src="./Images/mycollection/png/1.png" alt="">
                    <h1>200K+</h1>
                    <p>Happy Traveler</p>
                </div>
                <div class="travel-details col-sm-3">
                    <img src="./Images/mycollection/png/3.png" alt="">
                    <h1>100+</h1>
                    <p>Camp Sites</p>
                </div>
                <div class="travel-details col-sm-3">
                    <img src="./Images/mycollection/png/6.png" alt="">
                    <h1>32+</h1>
                    <p>Global Branch</p>
                </div>
                <div class="travel-details col-sm-3">
                    <img class="views" src="./Images/mycollection/png/7.png" alt="">
                    <?php
                        $getViews = "SELECT * from Customer";
                        $queryViews = mysqli_query($connect, $getViews);
                        $rowcount = mysqli_num_rows($queryViews);
                        $views = 0;
                        for($i = 0; $i < $rowcount; $i++){
                            $viewsdata = mysqli_fetch_array($queryViews);
                            $views += $viewsdata['ViewCount'];

                        }
                        echo "<h1>$views</h1>";
                    ?>
                    <p>Views</p>
                </div>
            </div>
        </div>

        <div class="home-reviews-section">
            <div class="home-reviews-title">
                <h1>Our Customers Reviews</h1>
            </div>
            <div class="home-reivews-content">
                <?php
                $getReviews = "SELECT * from Review";
                $queryReviews = mysqli_query($connect, $getReviews);
                $reviewsCount = mysqli_num_rows($queryReviews);
                if($reviewsCount > 0){
                    for($i=0; $i < 3; $i+=3){
                        $reviewselect1 = "SELECT * from Review Order By Rating DESC LIMIT $i,3";
                        $reviewquery1 = mysqli_query($connect, $reviewselect1);
                        $reviewcount1 = mysqli_num_rows($reviewquery1);

                        echo "<div class='home-review-list'>";
                        if($reviewcount1 > 0){
                            for($j=0; $j < $reviewcount1; $j++){
                                $reviewdata = mysqli_fetch_array($reviewquery1);
                                $date = $reviewdata['ReviewDate'];
                                $feedback = $reviewdata['Feedback'];
                                $rating = $reviewdata['Rating'];
                                $customerid = $reviewdata['CustomerID'];
                                $newdate = date_create($date);
                                $newformat = date_format($newdate, 'F d, Y');


                                

                                $customerselect = "SELECT * from Customer where CustomerID = '$customerid'";
                                $customerquery = mysqli_query($connect, $customerselect);
                                $customerdata= mysqli_fetch_array($customerquery);
                                $firstname = $customerdata['FirstName'];
                                $surname = $customerdata['Surname'];
                                echo "<div class='home-review-box col-6 col-lg-4'>";

                                echo "<div class='home-review-details'>";
                                echo "<div class='rating-bar'>";
                                echo "<div class='user-profile'>";
                                    echo "<span class='user'><img src='./Images/icons/user1.png'></span>";
                                    echo "<h2>$firstname"." $surname</h2>";

                                echo "</div>";
                                    echo "<div class='ratings col-3 col-sm-3'>";
                                        echo "<div class='max-rating'>";
                                            echo "<i class='fa-solid fa-star'></i>";
                                            echo "<i class='fa-solid fa-star'></i>";
                                            echo "<i class='fa-solid fa-star'></i>";
                                            echo "<i class='fa-solid fa-star'></i>";
                                            echo "<i class='fa-solid fa-star'></i>";
                                        echo"</div>";

                                        echo "<div class='get-rating'>";
                                            for($k=1; $k<=$rating; $k++){
                                                echo "<i class='fa-solid fa-star fa-rating'></i>";
                                            }
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<p class='feedback home-feedback'>";
                                if(strlen($feedback) > 100){
                                    $reviewsplit = str_split($feedback);
                                            for ($i = 0; $i < 100; $i++) {
                                                echo $reviewsplit[$i];
                                            }
                                            echo "...";
                                }
                                else{
                                    echo $feedback;
                                }
                                echo "</p>";
                                echo "<p class='home-date'>$newformat</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>
            <div class="read-reviews">
                <a href="Review.php">Read More Reviews</a>
            </div>
        </div>


        <div class="pitch-container col-sm-12">
            <div class="pitch-title">
                <h1>Amazing Camping and Swimming Sites for Real Adventure.</h1>
            </div>
            <?php
            $query = "SELECT * from Pitch";
            $run = mysqli_query($connect, $query);
            $count = mysqli_num_rows($run);

            if ($count == 0) {
                echo "<p>Pitches cannot be focund</p>";
            } else {
                for ($i = 0; $i < 3; $i += 3) {
                    $query2 = "SELECT * from Pitch 
                            ORDER BY PitchID LIMIT $i,3";
                    $run2 = mysqli_query($connect, $query2);
                    $count2 = mysqli_num_rows($run2);

                    echo "<div class='pitch-list col-sm-12'>";

                    for ($j = 0; $j < $count2; $j++) { 
                        $data = mysqli_fetch_array($run2);
                        $PID = $data['PitchID'];
                        $Pname = $data['PitchName'];
                        $Price = $data['Price'];
                        $description = $data['Description'];
                        $Pimage1 = $data['Image1'];
                        $Pimage2 = $data['Image2'];
                        $location = $data['Location'];
                        $attraction1 = $data['LocalAttraction1'];
                        $attrimage1 = $data['AttractionImage1'];
                        $attrimage2 = $data['AttractionImage2'];
                        $attraction3 = $data['LocalAttraction3'];
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
                                <a href="Details.php?PID=<?php echo $PID ?>">
                                    <div class="pitch-details-image">

                                        <img class="info-image" src="<?php echo './' . $Pimage1 ?>" alt="">
                                    </div>
                                </a>
                                <div class="pitch-details-text">
                                    <h2>
                                        <a href="Details.php?PID=<?php echo $PID ?>">
                                            <?php echo $Pname ?>
                                        </a>
                                    </h2>
                                    <p class="pitch-details-type"><?php echo $typename ?></p>
                                    <p class="pitch-details-type">starting from <b>$<?php echo $Price ?></b></p>
                                    <p class="pitch-description" maxlength="10">
                                    <?php
                                        $split = str_split($description);
                                        for ($i = 0; $i < 100; $i++) {
                                            echo $split[$i];
                                        }
                                        echo "...";
                                    ?></p>
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
            <div class="read-reviews">
                <a href="Information.php">Check More Sites</a>
            </div>
        </div>


        <section>
            <div class="office-location">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d278505.9156686306!2d34.44213753911327!3d-13.664827294279212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18dffd0d62c84e77%3A0x5f48da1959487097!2sglobal%20wild%20swimming%20camp!5e0!3m2!1sen!2smm!4v1696034441123!5m2!1sen!2smm" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
        </section>

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
                <p>You are currently in the <a href="index.php"><u>Home Page</u></a>. 
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

        let slideIndex = 0;
        let timer;
        showSlides();

        function changeSlide(n) {
            slideIndex += n - 1
            if (slideIndex < 0) {
                slideIndex = 2;
            }
            clearTimeout(timer);
            showSlides();
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            clearTimeout(timer);
            showSlides();
        }

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dash = document.getElementsByClassName("dash");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dash.length; i++) {
                dash[i].className = dash[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dash[slideIndex - 1].className += " active";
            timer = setTimeout(showSlides, 5000); // Change image every 2 seconds
        }
    </script>


<?php
if($pageWasRefreshed ) {
    if($isLogout){
        echo "<script>window.location='index.php'</script>";
    }
  }
?>

</body>

</html>