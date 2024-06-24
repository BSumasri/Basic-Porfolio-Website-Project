<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/Users/sumas/Downloads/PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'C:/Users/sumas/Downloads/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'C:/Users/sumas/Downloads/PHPMailer-master/PHPMailer-master/src/SMTP.php';

// Initialize variables for form inputs and errors
$nameErr = $emailErr = $mobileErr = $genderErr = $websiteErr = $agreeErr = "";
$name = $email = $mobileno = $gender = $website = $agree = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $mobileno = test_input($_POST["mobileno"]);
    $website = test_input($_POST["website"]);
    $gender = test_input($_POST["gender"]);
    if (isset($_POST['agree'])) {
        $agree = test_input($_POST["agree"]);
    }

    // Validate name
    if (empty($name)) {
        $nameErr = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    }

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Validate mobile number
    if (empty($mobileno)) {
        $mobileErr = "Mobile number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobileno)) {
        $mobileErr = "Invalid mobile number format";
    }

    // Validate website (optional)
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $websiteErr = "Invalid website URL";
    }

    // Validate gender
    if (empty($gender)) {
        $genderErr = "Gender is required";
    }

    // Validate agreement
    if (empty($agree)) {
        $agreeErr = "Please agree to the terms and conditions";
    }

    // If there are no errors, send email
    if (empty($nameErr) && empty($emailErr) && empty($mobileErr) && empty($genderErr) && empty($agreeErr)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bharatvikas04062004@gmail.com';
            $mail->Password = 'vbhi uebj hyte ccnp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient details
            $mail->setFrom('bharatvikas04062004@gmail.com', 'Your Name');
            $mail->addAddress('sumasribasava@gmail.com', 'Recipient Name');

            // Email content
            $mail->isHTML(false);
            $mail->Subject = 'New Registration';
            $mail->Body = "Name: $name \n"
                            . "Email: $email \n"
                            . "Mobile Number: $mobileno \n"
                            . "Website: $website \n"
                            . "Gender: $gender \n";

            // Send email
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        // Redirect after sending email
        // header("Location: thank-you.php");
        // exit();
    }
}

// Function to sanitize form inputs
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <link rel="Stylesheet" href="Registrationstyle.css">
   <div>
    <nav class="navi">
    <h2>Contact Form</h2>   
    <button><a href="Index.html" style="color: aliceblue">Home</a></button>
</nav>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <ul id ="text" type="none">
        <lable>Name:</lable> 
        <li><input type="text" name="name"></li>
        <span class="error">* <?php echo $nameErr;?></span>
        <br/><br/>
        <lable>  Email:</lable>
        <li><input type="text" name="email"></li>
        <span class="error">* <?php echo $emailErr;?></span>
        <br/><br/>
        <lable>Mobile Number:</lable> 
        <li><input type="text" name="mobileno"></li>
        <span class="error">* <?php echo $mobileErr;?></span>
        <br/><br/>
        <lable>Website: </lable>
        <li><input type="text" name="website"></li>
        <span class="error"><?php echo $websiteErr;?></span>
        <br/><br/>
        </ul>
       <ul id ="Radio" type="none">
        <lable>Gender: </lable>
        <li><input type="radio" name="gender" value="female">Female</li>
        <li><input type="radio" name="gender" value="male">Male</li>
        <li><input type="radio" name="gender" value="other">Other</li>
      </ul>
        <span class="error">* <?php echo $genderErr;?></span>
        <br/><br/>
        <ul id="check" type="none">
       <li> <input type="checkbox" name="agree"> </li>
        <lable>Agree to Terms and Conditions: </lable>
        <span class="error">* <?php echo $agreeErr;?></span>
      </ul>
        <br/><br/>
        <button>Submit</button>
    </form>
</div>
</body>
</html>