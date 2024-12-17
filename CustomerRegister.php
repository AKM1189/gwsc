<?php
session_start();

include('./dbConnect.php');
include('./AutoIDIncrement.php');


function getCode(){
    $characters = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomCode = '';
    for($i=0; $i<5; $i++){
        $index = rand(0, strlen($characters)-1);
        $randomCode .= $characters[$index];
    }
    return $randomCode;
}

if (isset($_POST['btnCRegister'])) {
    $userInput = $_POST['captcha'];
    $actualCode = $_SESSION['captchaCode'];

    if ($userInput == $actualCode) {
        $id = autoIDIncrement('C', "`Customer`", "`CustomerID`");
        $fname = $_POST["txtCfname"];
        $sname = $_POST["txtCsname"];
        $email = $_POST['txtCemail'];
        $password = $_POST['txtCpassword'];
        $phone = $_POST['txtCphone'];
        $address = $_POST['txtCaddress'];
        $city = $_POST['txtCcity'];
        $country = $_POST['txtCcountry'];
        $address = mysqli_real_escape_string($connect, $address);
    
        $checkemail = "SELECT * from customer
        Where Email='$email'";
    
        $result = mysqli_query($connect, $checkemail);
        $count = mysqli_num_rows($result);
    
        if ($count > 0) {
            echo "<script>window.alert('This Email already exists!')</script>";
            echo "<script>window.location='CustomerRegister.php'</script>";
        } else {
            $insert = "INSERT INTO Customer (CustomerID, FirstName, SurName, Email, Password, Phone, Address, City, Country, ViewCount)
            values ('$id', '$fname', '$sname', '$email', '$password', '$phone', '$address', '$city', '$country', 1)";
            $save = mysqli_query($connect, $insert);
    
            if ($save) {
                echo "<script>window.location='CustomerLogin.php?registered=true'</script>";
            } else {
                echo "Registered Failed!";
            }
        }
    } else {
        echo "<script>window.alert('You are robot')</script>";
    }
    // Clear the CAPTCHA code from the session
    unset($_SESSION['captchaCode']);


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

</head>

<body>
    <div class="container">
        <div class="customer-form">
            <div class="register-form-container col-12 col-lg-9">
                <div class="register-image col-6">
                    <img src="./Images/camping/register-image.jpg" alt="">
                </div>
                <div class="register-form col-6">
                    <div class="register-form-detail col-10">
                        <form action="CustomerRegister.php" method="POST" onsubmit="return checkPassword('password')">
                            <h2>Create an Account</h2>
                            <div class="cus-name">
                                <div class="field">
                                    <input type="text" class="site-input cus-input" name="txtCfname" placeholder=" " required autocomplete="off">
                                    <span class="site-label cus-label">First Name</span>
                                </div>

                                <div class="field">
                                    <input type="text" class="site-input cus-input" name="txtCsname" placeholder=" " required autocomplete="off">
                                    <span class="site-label cus-label">Last Name</span>
                                </div>
                            </div>

                            <div class="field">
                                <input type="email" class="site-input cus-input" name="txtCemail" placeholder=" " required>
                                <span class="site-label cus-label">Email</span>
                            </div>

                            <div class="field">
                                <input type="password" class="site-input cus-input" id="password" name="txtCpassword" placeholder=" " required autocomplete="off">
                                <span class="site-label cus-label">Password</span>
                                <span class="password-show" onclick="showPassword()"><i class="fa-regular fa-eye-slash password-icon"></i></span>
                                <p class="password-error"></p>
                            </div>

                            <div class="field">
                                <input type="text" class="site-input cus-input" name="txtCphone" placeholder=" " required autocomplete="off">
                                <span class="site-label cus-label">Phone</span>
                            </div>

                            <div class="field">
                                <input type="text" class="site-input cus-input" name="txtCaddress" placeholder=" " required autocomplete="off">
                                <span class="site-label cus-label">Address</span>
                            </div>

                            <div class="cus-name second">
                                <div class="field">
                                    <input type="text" class="site-input cus-input" name="txtCcity" placeholder=" " required autocomplete="off">
                                    <span class="site-label cus-label">City</span>
                                </div>

                                <div class="field">
                                    <input type="text" class="site-input cus-input" name="txtCcountry" placeholder=" " required autocomplete="off">
                                    <span class="site-label cus-label">Country</span>
                                </div>
                            </div>

                            <?php 
                                $string = getCode();
                                $_SESSION['captchaCode'] = $string;
                            ?>
                            <div class="field">
                                <div class="captcha">
                                    <input type="checkbox" name="" id="captcha" required autocomplete="off">
                                    <label for="captcha">
                                        <p>I am not a robot.</p>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/RecaptchaLogo.svg/800px-RecaptchaLogo.svg.png" onclick="checkCaptcha()" alt="">

                                    </label>
                                </div>
                                <img class="captcha-image" src="./Images/captcha/c1.png" alt="">
                                <h2 class="captcha-code"><?php echo $string; ?></h2>
                                    <div class="field">
                                    <input type="text" class="site-input cus-input captcha-input" name="captcha" placeholder=" " required autocomplete="off">
                                    <span class="site-label cus-label">Captcha Code</span>
                                </div>
                                </div>
                            <input type="submit" class="cus-register" name="btnCRegister" value="Register">
                        </form>

                        <p class="login-navigation">Already have an account? <a href="CustomerLogin.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
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
    </script>
</body>

</html>