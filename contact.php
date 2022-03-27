<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);
$insert = false;
if(isset($_POST['name'])){
    // Set connection variables
    $server = "localhost";
    $username = "root";
    $password = "";

    // Create a database connection
    $con = mysqli_connect($server, $username, $password);

    // Check for connection success
    if(!$con){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success connecting to the db";

    // Collect post variables
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];
    $sql = "INSERT INTO `hospital_inquiry`.`inquiry` (`name`, `age`, `gender`, `email`, `phone`, `other`, `date`) VALUES ('$name', '$age', '$gender', '$email', '$phone', '$desc', current_timestamp());";
    // echo $sql;

    // Execute the query
    if($con->query($sql) == true){
        // echo "Successfully inserted";

        // Flag for successful insertion
        $insert = true;
    }
    else{
        echo "ERROR: $sql <br> $con->error";
    }

    // Close the database connection
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- bootstrap cdn link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="fixed-top py-3">

    <div class="container d-flex align-items-center justify-content-between">

        <a href="#" class="logo">c<span class="fas fa-virus"></span>vid-19</a>

        <div id="menu-bar" class="fas fa-bars d-inline-block d-md-none"></div>

        <nav class="nav">
            <a href="index.php" class="active">Home</a>
            <a href="logout.php"><?php echo $user_data['user_name']; ?></a>
			<a href="logout.php">Logout</a>
        </nav>

    </div>

</header>
<!-- experts section starts  -->

<section class="experts" id="experts">

<h1 class="heading"> meet our <span>experts</span> </h1>

    <div class="container">

        <div class="d-flex justify-content-center flex-wrap">
			
			<div class="box">
                <img src="images/exp-1.png" alt="">
                <h3>Achyut</h3>
                <span>virus expert</span>
                <div class="share">
                    <a href="https://www.facebook.com/achyut.krishna.9s" class="fab fa-facebook-f"></a>
                    <a href="https://twitter.com/AchyutK17305643" class="fab fa-twitter"></a>
                    <a href="https://www.instagram.com/krishna_achyut/" class="fab fa-instagram"></a>
                    <a href="https://www.linkedin.com/in/achyut-krishna-a36308203/" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="images/exp-2.png" alt="">
                <h3>Harvi</h3>
                <span>virus expert</span>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="images/exp-3.png" alt="">
                <h3>Dhruv</h3>
                <span>virus expert</span>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="images/exp-4.png" alt="">
                <h3>Virti</h3>
                <span>virus expert</span>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <div class="box">
                <img src="images/exp-5.png" alt="">
                <h3>Shail</h3>
                <span>virus expert</span>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- experts section ends -->

<!-- contact section starts  -->

<section class="contact" id="contact">

<h1 class="heading"> <span>contact</span> for assistance </h1>

    <div class="container">

        <div class="row flex-wrap-reverse">

            <div class="col-md-7 p-2">
                <form action="contact.php" method="post">
				<input type="text" name="name" id="name" placeholder="Enter your name"class="box"><br>
				<input type="text" name="age" id="age" placeholder="Enter your Age"class="box"><br>
				<input type="text" name="gender" id="gender" placeholder="Enter your gender"class="box"><br>
				<input type="email" name="email" id="email" placeholder="Enter your email"class="box"><br>
				<input type="phone" name="phone" id="phone" placeholder="Enter your phone"class="box"><br>
				<textarea name="desc" id="desc" cols="30" rows="10" placeholder="Enter any other information here"></textarea><br>
                <input type="submit" class="link-btn" value="send message" name="" id="">
                </form>
            </div>

            <div class="col-md-5 p-2">
				<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1841.7195728946283!2d72.81817075872192!3d22.6000707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e50c43cdea6c7%3A0x5074fe9e0c1c8bd!2sCharotar%20University%20of%20Science%20and%20Technology%20(CHARUSAT)!5e0!3m2!1sen!2sin!4v1636443379917!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

        </div>

    </div>

</section>

<!-- contact section ends -->

<!-- js file link  -->
<script src="js/script.js"></script>

</body>
</html>