<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete responsive covid-19 website design tutorial</title>

    <!-- bootstrap cdn link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<!-- header section starts -->

<header class="fixed-top py-3">

    <div class="container d-flex align-items-center justify-content-between">

        <a href="#" class="logo">c<span class="fas fa-virus"></span>vid-19</a>

        <div id="menu-bar" class="fas fa-bars d-inline-block d-md-none"></div>

        <nav class="nav">
            <a href="index.php" class="active">home</a>
            <a href="#blogs">Blogs</a>
			<a href="logout.php"><?php echo $user_data['user_name']; ?></a>
			
        </nav>

    </div>

</header>

<!-- header section end-->
<!-- about section starts  -->

<section class="about" id="about">

    <div class="container">

        <div class="row align-items-center flex-wrap-reverse">

            <div class="col-md-6 content">
                <h3>What is novel coronavirus?</h3>
                <p>Coronaviruses (CoV) are a large family of viruses that cause illness ranging from the common cold to more severe diseases such as Middle East Respiratory Syndrome (MERS-CoV) and Severe Acute Respiratory Syndrome (SARS-CoV)</p>
				<p>Most people who fall sick with COVID-19 will experience mild to moderate symptoms and recover without special treatment. However, some will become seriously ill and require medical attention.</p>
                <a href="#blogs" class="link-btn">learn more</a>
            </div>

            <div class="col-md-6">
                <img src="images/about.svg" class="w-100" alt="">
            </div>

        </div>

    </div>

</section>

<!-- about section ends -->
<!-- prevent section starts  -->

<section class="prevent" id="prevent">

    <h1 class="heading"> how to <span>prevent</span>? </h1>

    <div class="container">

        <div class="d-flex flex-wrap justify-content-center">

            <div class="box p-4 m-2">
                <img src="images/01.png" alt="">
                <h3>wear a mask</h3>
                <p>Wear a mask in public, especially indoors or when physical distancing is not possible.</p>
            </div>

            <div class="box p-4 m-2">
                <img src="images/02.png" alt="">
                <h3>wash your hand</h3>
                <p>Clean your hands often. Use soap and water, or an alcohol-based hand rub.</p>
            </div>

            <div class="box p-4 m-2">
                <img src="images/03.png" alt="">
                <h3>consult doctor</h3>
                <p>If you have a fever, cough and difficulty breathing, seek medical attention</p>
            </div>

            <div class="box p-4 m-2">
                <img src="images/04.png" alt="">
                <h3>avoid touching</h3>
                <p>Avoid touching your eyes, nose and mouth. Hands touch many surfaces and can pick up viruses</p>
            </div>

            <div class="box p-4 m-2">
                <img src="images/05.png" alt="">
                <h3>avoid contact</h3>
                <p>Maintain a safe distance from others,<br> even if they don’t appear to be sick.</p>
            </div>

            <div class="box p-4 m-2">
                <img src="images/06.png" alt="">
                <h3>clean everyday</h3>
                <p>Clean and disinfect surfaces frequently especially <br> those which are regularly touched</p>
            </div>

        </div>

    </div>

</section>

<!-- prevent section ends -->
<!-- blogs section starts  -->

<section class="blogs" id="blogs">

<h1 class="heading"> our latest <span>blogs</span> </h1>

    <div class="container">

        <div class="d-flex justify-content-center flex-wrap">

            <div class="box p-3 m-2">
                <div class="image">
                    <img src="images/blog-1.svg" class="w-100 h-100"  alt="">
                </div>
                <div class="content p-2">
                    <h3>Covid 19 Timeline</h3>
                    <a href="blog1.php" class="link-btn">read more</a>
                    <div class="icons">
                        <a href="contact.php"><i class="fas fa-user"></i>by Krishna</a>
                        <a href="#"><i class="fas fa-calendar"></i>01 aug, 2021</a>
                    </div>
                </div>
            </div>

            <div class="box p-3 m-2">
                <div class="image">
                    <img src="images/blog-2.svg" class="w-100 h-100"  alt="">
                </div>
                <div class="content p-2">
                    <h3>Covid 19 Vaccine</h3>
                    <a href="blog2.php" class="link-btn">read more</a>
                    <div class="icons">
                        <a href="contact.php"><i class="fas fa-user"></i>by Virti</a>
                        <a href="#"><i class="fas fa-calendar"></i>01 aug, 2021</a>
                    </div>
                </div>
            </div>

            <div class="box p-3 m-2">
                <div class="image">
                    <img src="images/blog-3.svg" class="w-100 h-100"  alt="">
                </div>
                <div class="content p-2">
                    <h3>Novel corona virus?</h3>
                    <a href="blog3.php" class="link-btn">read more</a>
                    <div class="icons">
                        <a href="contact.php"><i class="fas fa-user"></i>by Virti</a>
                        <a href="#"><i class="fas fa-calendar"></i>01 aug, 2021</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- blogs section ends -->
<!-- js file link  -->
<script src="js/script.js"></script>

</body>
</html>