<?php

session_start();
include('./dbConnect.php');
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
 



$value = empty($_GET['isupdated'])?'':$_GET['isupdated'];

$viewcount = 0;
$save = 0;

if (isset($_SESSION['cid'])) {
    $isLogin = true;
    $cid = $_SESSION['cid'];
    $select = "SELECT * from Customer where CustomerID='$cid'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_array($query);

        $fname = $data['FirstName'];
        $sname = $data['Surname'];
        $email = $data['Email'];
        $phone = $data['Phone'];
        $address = $data['Address'];
        $city = $data['City'];
        $country = $data['Country'];
        $viewcount = $data['ViewCount'];
        $password = $data['Password'];
    }
}
else{
    header('Location: CustomerLogin.php');
}
// $isupdated = false;
if (isset($_POST['btnsave'])) {
    $Nfname = $_POST['txtCfname'];
    $Nsname = $_POST['txtCsname'];
    $Nemail = $_POST['txtCemail'];
    $Nphone = $_POST['txtCphone'];
    $Naddress = $_POST['txtCaddress'];
    $Ncity = $_POST['txtCcity'];
    $Ncountry = $_POST['txtCcountry'];


    $update = "UPDATE Customer Set FirstName='$Nfname', Surname='$Nsname', Email='$Nemail', Phone='$Nphone', Address='$Naddress', City='$Ncity', Country='$Ncountry'
            where CustomerID='$cid'";
    $save = mysqli_query($connect, $update);

    if($save){
        $_SESSION['profileupdated'] = true;
        echo "<script>window.location='CustomerProfile.php?isupdated=true'</script>";
    }
    else {
        echo "Error occurred!";
    }        
}

$queryUpdate = 0;
$ispasswordtrue = true;
if(isset($_POST['btnupdate'])){
    $oldpassword = $_POST['txtoldpassword'];
    $newpassword = $_POST['txtnewpassword'];

    if($oldpassword == $password){
        $updatepassword = "UPDATE Customer Set Password='$newpassword' where CustomerID='$cid'";
        $queryUpdate = mysqli_query($connect, $updatepassword);

        if($queryUpdate == 0){
            echo "Error occurred!";
        }
    }
    else{
        $ispasswordtrue = false;
        
    }
}
$logout = 0;
if(isset($_POST['btnlogout'])){
    unset($_SESSION['cid']);
    echo "<script>window.location='index.php?logout=true'</script>";
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
                        <a class='nav-login' href='CustomerProfile.php' title='Profile'>
                            <i class='fa-solid fa-user'></i>
                        </a>
                        
                </div>
            </nav>
        </header>

        <div class="search-container col-sm-12">
            <form method="POST">
                <input type="text" name="searchbar" class="searchtext" placeholder="Search..." id="search">
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
            if($value){
                echo "<script>showAlert(successBackground, successColor, 'Your information has updated successfully!')</script>";
            }
            
            if($queryUpdate > 0){
                echo "<script>showAlert(successBackground, successColor, 'Your password has changed successfully!')</script>";
            }
            if(!$ispasswordtrue){
                echo "<script>showAlert(dangerBackground, dangerColor, 'Your current password is incorrect!')</script>";
            }
            
        ?>

        <div class="profile-container">
            <div class="profile-section">
                <div class="profile-content col-sm-11 col-10 col-lg-8">
                    
                    <h1 class="profile-title">Profile</h1>
                    <p>Manage your account on this page.</p>
                    <div class="profile-detail">
                    <h2>Personal Infomation</h2>
                    <form  method="POST">
                    <div class="profile-name-box">
                        <div class="field first-half col-sm-6">
                            <label class="profile-label">First Name</label>
                            <input type="text" class="profile-input" name="txtCfname" value="<?php echo $fname;?>" required autocomplete="off">
                        </div>

                        <div class="field second-half  col-sm-6">
                            <label class="profile-label">Last Name</label>
                            <input type="text" class="profile-input" name="txtCsname" value="<?php echo $sname;?>" placeholder=" " required autocomplete="off">
                        </div>
                    </div>

                    <div class="field">
                        <label class="profile-label">Email</label>
                        <input type="email" class="profile-input" name="txtCemail" value="<?php echo $email;?>" placeholder=" " required>
                    </div>

                    <div class="field">
                        <label class="profile-label">Phone</label>
                        <input type="text" class="profile-input" name="txtCphone" placeholder=" " value="<?php echo $phone;?>" required autocomplete="off">
                    </div>

                    <div class="field">
                        <label class="profile-label">Address</label>
                        <input type="text" class="profile-input" name="txtCaddress" placeholder=" " value="<?php echo $address;?>" required autocomplete="off">
                    </div>

                    <div class="profile-name-box">
                        <div class="field first-half col-sm-6">
                            <label class="profile-label">City</label>
                            <input type="text" class="profile-input" name="txtCcity" placeholder=" " value="<?php echo $city;?>" required autocomplete="off">
                        </div>

                        <div class="field second-half col-sm-6">
                            <label class="profile-label">Country</label>
                            <input type="text" class="profile-input" name="txtCcountry" placeholder=" " value="<?php echo $country;?>" required autocomplete="off">
                        </div>
                    </div>
                    <input type="submit" class="profile-button save" name="btnsave" value="Save">
                    </form>                
                </div>

                <div class="profile-detail">
                    <h2>Password Change</h2>
                    <form action="" method="POST" onsubmit="return checkPassword('newpassword')">
                    <div class="field">
                        <label class="profile-label">Current Password</label>
                        <input type="password" class="profile-input" id="oldpassword" name="txtoldpassword" placeholder="Enter Current Password" required autocomplete="off">
                        <span class="password-show" onclick="showPassword('oldpassword', 'password-icon1')"><i class="fa-regular fa-eye-slash password-icon1"></i></span>
                    </div>
                    <div class="field">
                        <label class="profile-label">New Password</label>
                        <input type="password" class="profile-input" id="newpassword" name="txtnewpassword" placeholder="Enter New Password" required autocomplete="off">
                        <span class="password-show" onclick="showPassword('newpassword', 'password-icon2')"><i class="fa-regular fa-eye-slash password-icon2"></i></span>
                        <p class="password-error"></p>
                    </div>

                    <input type="submit" class="profile-button update" name="btnupdate" value="Update">
                    </form>
                </div>

                <div class="profile-detail">
                    <form action="" method="POST">
                    <h2>Logout Account</h2>
                    <p>This action will log you out from your current account.</p>
                    <input type="submit" class="profile-button logout" name="btnlogout" value="Logout">
                    </form>
                </div>

                <!-- <div class="profile-detail">
                    <h2>Delete Account</h2>
                    <p>This action will delete your account permanently.</p>
                    <input type="submit" class="profile-button delete" name="btndelete" value="Delete">
                </div> -->
                </div>
            </div>
            </div>
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
                <p>You are currently in the <a href="CustomerProfile.php"><u>Profile Page</u></a>. 
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

        function showPassword(id, classname) {
            let password = document.getElementById(id);
            let icon = document.getElementsByClassName(classname)[0];
            if(password.type == 'password'){
                password.type = 'text';
                icon.className = 'fa-regular fa-eye '+ classname;
            }
            else{
                password.type = 'password';
                icon.className = 'fa-regular fa-eye-slash '+ classname;
            }
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
    if($value){
        echo "<script>window.location='CustomerProfile.php'</script>";
    }
  }
?>
    </body>
    </html>