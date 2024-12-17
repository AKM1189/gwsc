  <?php
    include('./dbConnect.php');
    session_start();
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

    $pid = $_GET['PID'];

    $select = "SELECT * from Pitch where PitchID = '$pid'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        $data = mysqli_fetch_array($query);
        $pid = $data["PitchID"];
        $pname = $data["PitchName"];
        $pdesc = $data["Description"];
        $guest = $data['MaxGuest'];
        $size = $data['Size'];
        $price = $data['Price'];
        $image1 = $data['Image1'];
        $image2 = $data['Image2'];
        $image3 = $data['Image3'];
        $location = $data['Location'];
        $localattraction1 = $data['LocalAttraction1'];
        $localattraction2 = $data['LocalAttraction2'];
        $localattraction3 = $data['LocalAttraction3'];
        $attractionimage1 = $data['AttractionImage1'];
        $attractionimage2 = $data['AttractionImage2'];
        $attractionimage3 = $data['AttractionImage3'];

        $typeid = $data["TypeID"];
        $typequery = "SELECT * from PitchType where TypeID = '$typeid'";
        $typequeryrun = mysqli_query($connect, $typequery);
        $typedata = mysqli_fetch_array($typequeryrun);
        $typename = $typedata["TypeName"];

        $pitchfeatureselect = "SELECT * from PitchFeature where PitchID = '$pid'";
        $pitchfeaturequery = mysqli_query($connect, $pitchfeatureselect);
        $pitchfeaturedata = mysqli_fetch_all($pitchfeaturequery);
        $featureid = [];
        for ($i = 0; $i < count($pitchfeaturedata); $i++) {
            array_push($featureid, $pitchfeaturedata[$i][1]);
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
                  <div class="nav-background" onclick="closenav()"></div>
              </header>

              <section class="image-slider">
                  <div class="slideshow-container">
                      <div class="mySlides fade">
                          <img src="./<?php echo $image1; ?>" alt="">
                          <div class="z-index"></div>
                      </div>

                      <div class="mySlides fade">
                          <img src="./<?php echo $image2; ?>" alt="">

                      </div>

                      <div class="mySlides fade">
                          <img src="./<?php echo $image3; ?>" alt="">

                      </div>

                  </div>
                  <br>

                  <span class="left" onclick="changeSlide(-1)"><i class="fa-solid fa-chevron-left"></i></span>
                  <span class="right" onclick="changeSlide(1)"><i class="fa-solid fa-chevron-right"></i></span>

                  <div class="dash-container">
                      <span class="dash" onclick="currentSlide(1)"><i class="fa-solid fa-minus"></i></span>
                      <span class="dash" onclick="currentSlide(2)"><i class="fa-solid fa-minus"></i></span>
                      <span class="dash" onclick="currentSlide(3)"><i class="fa-solid fa-minus"></i></span>
                  </div>

              </section>

              <section class="detail-section">
                  <div class="pitch-detail-cotainer">

                      <div class="pitch-detail-content">
                          <div class="pitch-detail-title">
                              <h1><?php echo $pname; ?></h1>
                          </div>
                          <div class="pitch-detail-info">
                              <span><?php echo $typename ?></span>
                              <span>1-<?php echo $guest; ?> persons</span>
                              <span><?php echo $size; ?></span>
                              <span>starting from $<?php echo $price; ?></span>

                          </div>
                          <div class="pitch-detail-description col-8">
                              <p><?php echo $pdesc; ?></p>
                          </div>
                          <div class="pitch-detail-features">
                              <h2>Camping Facilities & Amenities</h2>
                              <div class="pitch-feature-container col-sm-8 col-3">
                                  <?php
                                    for ($i = 0; $i < count($featureid); $i++) {
                                        $featureselect = "SELECT * from Feature where FeatureID='$featureid[$i]'";
                                        $featurequery = mysqli_query($connect, $featureselect);
                                        $featuredata = mysqli_fetch_array($featurequery);
                                        $featurename = $featuredata["FeatureName"];
                                        $featureicon = $featuredata["FeatureIcon"];

                                        echo "<div class='pitch-feature'><span><i class='fa-solid fa-$featureicon'></i></span>$featurename</div>";
                        
                                    }
                                    ?>
                              </div>
                          </div>

                          <div class="booking-btn">
                            <a href="Booking.php?PID=<?php echo $pid?>">Book Now</a>
                          </div>
                          <div class="pitch-location">
                              <h2>Pitch Location On Google Maps</h2>
                              <iframe src="<?php echo $location; ?>"></iframe>
                          </div>
                          <div class="pitch-local-attraction col-sm-8 col-12">
                            <h2>Local Attractions</h2>
                            <div class="local-attraction-details">
                                <span class="col-3">
                                    <img src="./<?php echo $attractionimage1?>" alt="">
                                    <h3><?php echo $localattraction1;?></h3>
                                </span>
                                <span class="col-3">
                                    <img src="./<?php echo $attractionimage2?>" alt="">
                                    <h3><?php echo $localattraction2;?></h3>
                                </span>
                                <span class="col-3">
                                    <img src="./<?php echo $attractionimage3?>" alt="">
                                    <h3><?php echo $localattraction3;?></h3>
                                </span>
                            </div>
                          </div>
                      </div>
                  <?php
                }
                    ?> 
                  </div>
              </section>

              <div class="search-container">
                  <form action="POST">
                      <input type="text" class="searchtext" autofocus>
                      <input type="submit" class="fa-solid fa-magnifying-glass searchbtn searchbtn-icon" name="btnsearch" value="&#xf002">
                  </form>
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
                <p>You are currently in the <a href="Details.php"><u>Detail Page</u></a>. 
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
      </body>

      </html>