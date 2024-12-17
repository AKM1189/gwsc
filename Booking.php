<?php

session_start();
include('./dbConnect.php');
include('./AutoIDIncrement.php');

$isLogin = false;

if (!isset($_SESSION['cid'])) {
    echo "<script>window.location='CustomerLogin.php'</script>";
}
else{
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


if (isset($_REQUEST['PID'])) {
    $pid = $_REQUEST['PID'];
    $select = "SELECT * from Pitch 
                Where PitchID = '$pid'";
    $query = mysqli_query($connect, $select);
    $data = mysqli_fetch_array($query);

}
else{
    echo "<script>window.location='Information.php'</script>";
}

if(isset($_POST['btnbooking'])){
    $bookingno = autoIDIncrement('B', "`Booking`", "`BookingNo`");
    $bookingdate = date('Y-m-d');
    $indate = $_POST['txtcheck-in-date'];
    $PID = $_POST['txtPID'];
    $CID = $_POST['txtCID'];
    $pname = $_POST['txtPname'];
    $price = $_POST['txtprice'];
    $guest = $_POST['txtguest'];
    $quantity = ceil($guest/$_POST['txtMaxGuest']);
    $subtotal = $price * $quantity;
    $phone = $_POST['txtphone'];
    $email = $_POST['txtemail'];
    $tax = $subtotal * 0.05;
    $totalamount = $subtotal + $tax;
    $paymenttype = $_POST['payment'];

    $insert = "INSERT into Booking (BookingNo, BookingDate, CheckinDate, NoOfGuest, Quantity, SubTotal, Tax, TotalAmount, PitchID, CustomerEmail, CustomerPhone, PaymentType, CustomerID, Status)
                values ('$bookingno', '$bookingdate', '$indate', '$guest', '$quantity', $subtotal, $tax, $totalamount, '$PID', '$email', '$phone', '$paymenttype', '$CID', 'Booked')"; 
    $run = mysqli_query($connect, $insert);
    if($run){
        echo "<script>window.alert('Booking Success!')</script>";
        echo "<script>window.location='Information.php?booked=true'</script>";
    }
    else{
        echo "<script>window.alert('Booking Failed!')</script>";
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

        <div class="booking-container col-sm-12">
            <div class="booking-form-container col-7">
                <form action="Booking.php" method="POST">
                    <h1>Booking Form</h1>
                    <div class="booking-details col-10">
                        <div class="booking-input">
                            <h3>Date</h3>
                            <input type="date" name="txtcheck-in-date" min="<?php echo date('Y-m-d')?>">
                        </div>

                            <input type="hidden" name="txtPID" value="<?php echo $data['PitchID'] ?>" readonly>
                            <input type="hidden" name="txtCID" value="<?php echo $_SESSION['cid'] ?>" readonly>
                            <input type="hidden" name="txtMaxGuest" id="maxGuest" value="<?php echo $data['MaxGuest'] ?>" readonly>

                        <div class="booking-input">
                            <h3>Camp Name</h3>
                            <input type="text" name="txtPname" value="<?php echo $data['PitchName']; ?>" readonly>
                        </div>

                        <div class="booking-input">
                            <h3>Guest</h3>
                            <input type="number" id="txtguest" name="txtguest" onchange="changequantity()" value="1" min="1" max="30">
                        </div>
                        <div class="booking-input">
                            <h3>Quantity</h3>
                            <input type="number" id="txtqty" name="txtqty" value="1" min="1" max="6" readonly>
                        </div>
                        <div class="booking-input">
                            <h3>Price</h3>
                            <input type="text" id="txtprice" name="txtprice" value="<?php echo $data['Price'] ?>" readonly>
                        </div>
                        <div class="booking-input">
                            <h3>Total</h3>
                            <input type="text" id="txttotal" name="txttotal" value="<?php echo $data['Price'] + ($data['Price'] * 0.05) ?>" readonly>
                        </div>

                        <div class="booking-input">
                            <h3>Name</h3>
                            <input type="text" value="<?php echo $_SESSION['cfname'].' '.$_SESSION['csname']?>" readonly>
                        </div>
                        
                        <div class="booking-input">
                            <h3>Phone</h3>
                            <input type="text" name="txtphone" placeholder="Enter Your Phone" required>
                        </div>
                        <div class="booking-input">
                            <h3>Email</h3>
                            <input type="email" name="txtemail" placeholder="Enter Your Email" required>
                        </div>
                        
                        <div class="booking-input">
                            <h3>Payment Method</h3>

                            <div class="payment-method">
                            <input type="radio" onclick="showCard()" name="payment" value="Cash" id="payment1" checked>
                            <label for="payment1" onclick="showCard()">Cash</label>
                            <input type="radio" onclick="showCard()" name="payment" value="Card" id="payment2">
                            <label for="payment2" onclick="showCard()">Card</label>
                            </div>

                        </div>
                        <div class="payment-card">
                            <h2>Card Details</h2>
                            <div class="booking-input">
                                <h3>Name on the Card</h3>
                                <input type="text" name="txtcardname" placeholder="Enter Full Name">
                            </div>
                            <div class="booking-input">
                                <h3>Card Number</h3>
                                <input type="number" class="card-number" name="txtcardnumber" placeholder="XXXX XXXX XXXX">
                            </div>
                            <div class="booking-input">
                                <h3>CVV</h3>
                                <input type="number" class="card-number" name="txtcardcvv" placeholder="XXX">
                            </div>
                            <div class="booking-input">
                                <h3>Expiry Date</h3>
                                <input type="month" name="txtexpdate" placeholder="">
                            </div>
                        </div>
                        <div class="booking-input">
                            <input type="submit" value="Book" name="btnbooking">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="scrollup" onclick="handleScroll()" title="Scroll To Top"><i class="fa-solid fa-arrow-up scrolltop"></i></div>
        <footer id="footer" class="booking-footer">
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
                <p>You are currently in the <a href="Booking.php"><u>Booking Page</u></a>. 
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
        let quantity = document.getElementById('txtqty');
        let guest = document.getElementById('txtguest');
        let price = document.getElementById('txtprice');
        let total = document.getElementById('txttotal');
        let unitprice = price.value;
        let maxGuest = document.getElementById('maxGuest').value;

        function showCard(){
            let payment = document.querySelector('input[name="payment"]:checked').value;
            let card = document.querySelector('.payment-card');
            if(payment == 'Card'){
                card.style.display = 'block';
            }
            else{
                card.style.display = 'none';
            }
        }
        

        function changequantity(){
            quantity.value = Math.ceil(guest.value/maxGuest);
            quantity.innerHTML = quantity.value;
            price.value = unitprice * quantity.value;
            price.innerHTML = price.value;
            console.log(price.value);

            tax = (price.value * 0.05).toFixed(2);
            total.value = Number(price.value) + Number(tax);
            total.innerHTML = total.value;
            console.log(total.value);
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
</body>
</html>