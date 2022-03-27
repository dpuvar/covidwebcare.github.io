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
    <title>Covid 19 Vaccine</title>
    <style>
        body{
        
            width: 98%;
            background: url('https://www.eztexting.com/sites/default/files/styles/social_media/public/blog_images/corona%20image.jpg?itok=kugkXt_P');
            background-repeat: no-repeat;
            background-size: 1800px 900px;
            font-size: 0.5cm;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode',Verdana, sans-serif;
            color:white

            
        }
        
        div.background{
        
            padding-top: 7%;
            padding-right: 35%;
        }
        .left{
            display: inline-block;
            position: absolute;
            left: 250px;
            top: 20px;
            text-align: center;
            
            border-radius: 3cm;
        }
        .left img{
            width: 136px;
        }
        

        .mid{
            display: block;
            width: 40%;
            margin: 29px auto;
            text-align: center;
            
            border-radius: 3cm;

        }
        .right{
            display: inline-block;
            position: absolute;
            right: 34px;
            top: 20px;
            text-align: center;
        
            border-radius: 3cm;

        }
        .navbar{
            display: inline-block;
        }
        .navbar li{
            display: inline-block;
            font-size: 25px;
        }
        .navbar li a{
            color: white;
            text-decoration: none;
            padding: 34px 23px;
        }
        .navbar li a:hover, .navbar li a:active{
            text-decoration: underline;
            color: yellowgreen;
        }
        .btn{
            margin: 0px 9px;
            background-color: black;
            color: blanchedalmond;
            padding: 4px 14px;
            border: 2px solid grey;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        .btn:hover{
            background-color: rgb(88, 81, 81);
        }
    </style>
</head>
<body class="body1">
    <header>
        <div class="left">
            <img src="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/image_data/file/97664/s960_Coronavirus_govuk.jpg" alt="">
            <div>COVID WEB CARE</div>
        </div>
        <div class="background">
            <div class="transbox">
                
              <h1 class="heading">Covid 19 Vaccine:-</h1>
                <p class="para">A COVID‑19 vaccine is a vaccine intended to provide acquired immunity against severe acute respiratory syndrome coronavirus 2 (SARS‑CoV‑2), the virus that causes coronavirus disease 2019 (COVID‑19). Prior to the COVID‑19 pandemic, an established body of knowledge existed about the structure and function of coronaviruses causing diseases like severe acute respiratory syndrome (SARS) and Middle East respiratory syndrome (MERS). This knowledge accelerated the development of various vaccine platforms during early 2020.[1] The initial focus of SARS-CoV-2 vaccines was on preventing symptomatic, often severe illness.[2] On 10 January 2020, the SARS-CoV-2 genetic sequence data was shared through GISAID, and by 19 March, the global pharmaceutical industry announced a major commitment to address COVID-19.[3] The COVID‑19 vaccines are widely credited for their role in reducing the spread, severity, and death caused by COVID-19.[4]

                    Many countries have implemented phased distribution plans that prioritize those at highest risk of complications, such as the elderly, and those at high risk of exposure and transmission, such as healthcare workers.[5] Single dose interim use is under consideration to extend vaccination to as many people as possible until vaccine availability improves.[6][7][8][9]
                    
                    As of 8 November 2021, 7.28 billion doses of COVID‑19 vaccines have been administered worldwide based on official reports from national public health agencies.[10] AstraZeneca anticipates producing 3 billion doses in 2021, Pfizer–BioNTech 2.5 billion doses,[11] and Sputnik V, Sinopharm, Sinovac, and Janssen 1 billion doses each. Moderna targets producing 600 million doses and Convidecia 500 million doses in 2021.[12][13] By December 2020, more than 10 billion vaccine doses had been preordered by countries,[14] with about half of the doses purchased by high-income countries comprising 14% of the world's population </p>
            </div>
        </div>
        <div class="right">
            <button class="btn">Call Us</button>
            <button class="btn">E-mail Us</button>
        </div>
    </header>
</body>
</html>