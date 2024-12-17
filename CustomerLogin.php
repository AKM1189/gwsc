<?php
session_start();
include("./dbConnect.php");

$registered = false;
if(isset($_GET['registered'])){
    $registered = $_GET['registered'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="javascript.js"></script>

<script>
    const successBackground = '#bfffa8';
    const successColor = '#007d19';
    const dangerBackground = '#ffa69c';
    const dangerColor = '#9c1000'; 

</script>
</head>

<body>
    <div class="container">
        <div class="customer-login-background col-12">
            <div class="customer-login-container col-sm-12 col-10 col-lg-8">
                <div class="login-image customer-login col-6 col-lg-6">
                    <img src="./Images/camping/login6.jpg" alt="">
                </div>
                <div class="login-form customer-login-form col-6 col-lg-6">
                    <form action="CustomerLogin.php" method="POST">
                        <h1>Login</h1>
                        <p>Welcome! Please login to your account.</p>

                        <div class="field">
                            <input type="email" class="cus-input cus-login-input" name="txtemail" placeholder=" " autofocus required>
                            <span class="cus-label cus-login-label">Email</span>
                        </div>

                        <div class="field">
                            <input type="password" class="cus-input cus-login-input" id="password" name="txtpassword" placeholder=" " required autocomplete="off">
                            <span class="cus-label cus-login-label">Password</span>
                            <span class="login-password-show" onclick="showPassword()"><i class="fa-regular fa-eye-slash password-icon"></i></span>
                            <p class="password-error"></p>
                        </div>
                        <div class="incorrect-login">
                            <p>Your Email or Password is incorrect.</p>
                            <p>Failed Attempt - <span id='errorcount'></span></p>
                        </div>

                        <button type="submit" class="btnLogin customer-login-btn" name="btnLogin">Login</button>
                    </form>
                    <p class="register-navigation login-navigation">Doesn't have an account? <a href="CustomerRegister.php">Register Here</a></p>
                </div>

                <div class="alert-box">
                    <div class="alert-box-content">
                        <span class="message"></span>
                        <span onclick="closeAlert()"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                </div>
                <?php
                    if($registered){
                        echo "<script>showAlert(successBackground, successColor, 'Your have registered successfully!')</script>";
                    }
                ?>

                <div class="login-failed-container col-sm-8 col-lg-6">
                    <h1>Login Failed</h1>
                    <p>Your account has been locked due to too many failed login attempts. Please try login again after <b class="waiting-time">Ten minutes</b>.</p>
                    <div class="timer-container">
                        <div class="timer">
                            <span class="show-minute"></span> :
                            <span class="show-second"></span>
                        </div>
                    </div>
                    <form action="CustomerLogin.php" method="POST">
                    <div class="back-container">
                        <button type='submit' name='btnback' class="back" onclick="stopTimer()" disabled>Continue</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        const loginFailContainer = document.getElementsByClassName('login-failed-container')[0];
        const showMinute = document.getElementsByClassName('show-minute')[0];
        const showSecond = document.getElementsByClassName('show-second')[0];
        const btnLogin = document.querySelector('.btnLogin');
        const back = document.querySelector('.back');
        const incorrectmsg = document.querySelector('.incorrect-login');
        let errorcount = document.getElementById('errorcount');
        errorcount.value = 1;

        function showPassword() {
            let password = document.getElementById('password');
            let icon = document.getElementsByClassName('password-icon')[0];
            if(password.type == 'password'){
                password.type = 'text';
                icon.className = 'fa-regular fa-eye password-icon';
            }
            else{
                password.type = 'password';
                icon.className = 'fa-regular fa-eye-slash password-icon';
            }
        }

        function handleattempt(){
            if(incorrectmsg.style.display == 'block'){
                errorcount.innerHTML = errorcount.value;
            }
        }

        function setTimer() {
            btnLogin.disabled = true;
            back.style.backgroundColor = 'grey';
            back.style.cursor = 'not-allowed';
            btnLogin.style.cursor = 'not-allowed';


            loginFailContainer.style.display = 'block';
            showMinute.innerHTML = '10';
            showSecond.innerHTML = '00';
            let minute = 9;
            let second = 60;
            let interval;
            clearInterval(interval);

            interval = setInterval(() => {
                second--;
                showSecond.innerHTML = second;
                showMinute.innerHTML = '0' + minute;

                if (second < 10) {
                    showSecond.innerHTML = '0' + second;
                }

                if (second == 0) {
                    second = 60;
                    minute--;
                    showMinute.innerHTML = '0' + minute;
                    if (minute == 0) {
                        clearInterval(interval);
                        btnLogin.disabled = false;
                        back.disabled = false;
                        back.style.backgroundColor = '#fa8f04';
                        back.style.cursor = 'pointer';
                        btnLogin.style.cursor = 'pointer';
                    }
                }
            }, 1000)
        }


        function stopTimer() {
            loginFailContainer.style.display = 'none';
        }
    </script>

    <?php

    if (isset($_POST['btnLogin'])) {
        $counterError = 1;


        $email = $_POST['txtemail'];
        $password = $_POST['txtpassword'];

        $check = "SELECT * FROM Customer WHERE Binary Email = Binary '$email' 
        AND Binary Password = Binary '$password'";

        $result = mysqli_query($connect, $check);

        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $updateViewCount = "UPDATE Customer Set ViewCount=ViewCount+1 
            WHERE Email = '$email' 
            AND Password = '$password'";
            mysqli_query($connect, $updateViewCount);

            $data = mysqli_fetch_array($result);
            $cid = $data['CustomerID'];
            $cfname = $data['FirstName'];
            $csname = $data['Surname'];

            $_SESSION['cid'] = $cid;
            $_SESSION['cfname'] = $cfname;
            $_SESSION['csname'] = $csname;

            echo "<script>window.location='index.php'</script>";
        } else {
            if (isset($_SESSION['loginError'])) {
                $_SESSION['loginError']++;
                if($_SESSION['loginError'] > 3){
                    $_SESSION['loginError'] = 1;
                    $counterError = 1;
                }
                $counterError = $_SESSION['loginError'];

                echo "<script>incorrectmsg.style.display = 'block'</script>";
                if ($counterError == 3) {
                    echo "<script>setTimer();</script>";
                }
                echo "<script>errorcount.value = $counterError</script>";
                echo "<script>handleattempt()</script>";

            } else {
                $_SESSION['loginError'] = 1;
                $counterError = $_SESSION['loginError'];
                echo "<script>incorrectmsg.style.display = 'block'</script>";
                echo "<script>handleattempt()</script>";
            }
            echo $counterError;
        }
    }

    if(isset($_POST['btnback'])){
        unset($_SESSION['loginError']);
    }
    
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    if($pageWasRefreshed ) {
        if(isset($_SESSION['loginError'])){
            $counterError = $_SESSION['loginError'];
            if($counterError == 3){
                echo "<script>setTimer();</script>";
            }
        }
    };

    ?>

</body>

</html>