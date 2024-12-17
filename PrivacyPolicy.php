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
</head>
<body>
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
              <div class="search-container">
                  <form action="">
                      <input type="text" class="searchtext" autofocus>
                      <input type="submit" class="fa-solid fa-magnifying-glass searchbtn searchbtn-icon" name="btnsearch" value="&#xf002">
                  </form>
              </div>

              <div class="privacy-container">
                <div class="privacy-content col-8">
                    <div class="privacy-field">
                        <h1>Privacy Policy for Global Wild Swimming and Camping</h1>
                        <p>At GWSC, accessible from gwsc.almir.info, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by GWSC and how we use it.

If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.

This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in GWSC. This policy is not applicable to any information collected offline or via channels other than this website.</p>
                    </div>

                    <div class="privacy-field">
                        <h1>Consent</h1>
                        <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>
                    </div>

                    <div class="privacy-field">
                        <h1>Information we collect</h1>
                        <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.

If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.

When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>
                    </div>

                    <div class="privacy-field">
                        <h1>How we use your information</h1>
                        <p>We use the information we collect in various ways, including to:</p>

<ul>
    <li>Provide, operate, and maintain our website</li>
    <li>Improve, personalize, and expand our website</li>
    <li>Understand and analyze how you use our website</li>
    <li>Develop new products, services, features, and functionality</li>
    <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
    <li>Send you emails</li>
    <li>Find and prevent fraud</li>
</ul>





                    </div>

                    <div class="privacy-field">
                        <h1>Advertising Partners Privacy Policies</h1>
                        <p>You may consult this list to find the Privacy Policy for each of the advertising partners of GWSC.

Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on GWSC, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.

Note that GWSC has no access to or control over these cookies that are used by third-party advertisers.</p>
                    </div>

                    <div class="privacy-field">
                        <h1>Changes to this Privacy Policy</h1>
                        <p>We may update our Privacy Policy from time to time. Thus, we advise you to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately, after they are posted on this page.</p>
                    </div>

                    <div class="privacy-field">
                        <h1>Contact Us</h1>
                        <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to <a href="Contact.php">contact us</a>.</p>
                    </div>
                </div>
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
                <p>You are currently in the <a href="PrivacyPolicy.php"><u>Privacy Policy Page</u></a>. 
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