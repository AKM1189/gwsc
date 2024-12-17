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
                        <h1>Website Terms and Conditions of Use</h1>
                    </div>

                    <div class="privacy-field">
                        <h2>1. Terms</h2>
                        <p>By accessing this Website, accessible from gwsc.almir.info, you are agreeing to be bound by these Website Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials contained in this Website are protected by copyright and trade mark law.</p>
                    </div>

                    <div class="privacy-field">
                        <h2>2. Use License</h2>
                        <p>Permission is granted to temporarily download one copy of the materials on Global Wild Swimming and Camping's Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
                        <ul>
                            <li>modify or copy the materials;</li>
                            <li>use the materials for any commercial purpose or for any public display;</li>
                            <li>attempt to reverse engineer any software contained on Global Wild Swimming and Camping's Website;</li>
                            <li>remove any copyright or other proprietary notations from the materials; or</li>
                            <li>transferring the materials to another person or "mirror" the materials on any other server.</li>
                        </ul>
                    </div>

                    <div class="privacy-field">
                        <h2>3. Disclaimer</h2>
                        <p>All the materials on Global Wild Swimming and Camping’s Website are provided "as is". Global Wild Swimming and Camping makes no warranties, may it be expressed or implied, therefore negates all other warranties. Furthermore, Global Wild Swimming and Camping does not make any representations concerning the accuracy or reliability of the use of the materials on its Website or otherwise relating to such materials or any sites linked to this Website.</p>
                    </div>

                    <div class="privacy-field">
                        <h2>4. Limitations</h2>
                        <p>Global Wild Swimming and Camping or its suppliers will not be hold accountable for any damages that will arise with the use or inability to use the materials on Global Wild Swimming and Camping’s Website, even if Global Wild Swimming and Camping or an authorize representative of this Website has been notified, orally or written, of the possibility of such damage. Some jurisdiction does not allow limitations on implied warranties or limitations of liability for incidental damages, these limitations may not apply to you.</p>
                    </div>

                    <div class="privacy-field">
                        <h2>5. Revisions and Errata</h2>
                        <p>The materials appearing on Global Wild Swimming and Camping’s Website may include technical, typographical, or photographic errors. Global Wild Swimming and Camping will not promise that any of the materials in this Website are accurate, complete, or current. Global Wild Swimming and Camping may change the materials contained on its Website at any time without notice. Global Wild Swimming and Camping does not make any commitment to update the materials.</p>
                    </div>

                    <div class="privacy-field">
                        <h2>6. Links</h2>
                        <p>Global Wild Swimming and Camping has not reviewed all of the sites linked to its Website and is not responsible for the contents of any such linked site. The presence of any link does not imply endorsement by Global Wild Swimming and Camping of the site. The use of any linked website is at the user’s own risk.</p>
                    </div>

                    <div class="privacy-field">
                        <h2>7. Your Privacy</h2>
                        <p>Please read our <a href="PrivacyPolicy.php">Privacy Policy</a></p>
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
                <p>You are currently in the <a href="TermsofService.php"><u>Terms of Service Page</u></a>. 
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