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
    <title>Virti</title>
    <style>
        body{
        
            width: 98%;
            background: url('https://th.bing.com/th/id/OIP.X1IWwkBxkoTf7UcA89WqUQHaD2?pid=ImgDet&w=1440&h=750&rs=1');
            background-repeat: no-repeat;
            background-size: 1800px 900px;
            
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode',Verdana, sans-serif;
            color:white

            
        }
        
        div.background{
        
            padding-top: 7%;
            
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
                
              <h1 class="heading">What is novel corona virus?</h1>
                <p class="para">Coronavirus disease 2019 (COVID-19) is a contagious disease caused by severe acute respiratory syndrome coronavirus 2 (SARS-CoV-2). The first known case was identified in Wuhan, China, in December 2019.[7] The disease has since spread worldwide, leading to an ongoing pandemic.[8]
    
               Symptoms of COVID-19 are variable, but often include fever,[9] cough, headache,[10] fatigue, breathing difficulties, and loss of smell and taste.[11][12][13] Symptoms may begin one to fourteen days after exposure to the virus. At least a third of people who are infected do not develop noticeable symptoms.[14] Of those people who develop symptoms noticeable enough to be classed as patients, most (81%) develop mild to moderate symptoms (up to mild pneumonia), while 14% develop severe symptoms (dyspnea, hypoxia, or more than 50% lung involvement on imaging), and 5% suffer critical symptoms (respiratory failure, shock, or multiorgan dysfunction).[15] Older people are at a higher risk of developing severe symptoms. Some people continue to experience a range of effects (long COVID) for months after recovery, and damage to organs has been observed.[16] Multi-year studies are underway to further investigate the long-term effects of the disease.[16]
            
               COVID-19 transmits when people breathe in air contaminated by droplets and small airborne particles containing the virus. The risk of breathing these in is highest when people are in close proximity, but they can be inhaled over longer distances, particularly indoors. Transmission can also occur if splashed or sprayed with contaminated fluids in the eyes, nose or mouth, and, rarely, via contaminated surfaces. People remain contagious for up to 20 days, and can spread the virus even if they do not develop symptoms.[17][18]
            
               Several testing methods have been developed to diagnose the disease. The standard diagnostic method is by detection of the virus' nucleic acid by real-time reverse transcription polymerase chain reaction (rRT-PCR), transcription-mediated amplification (TMA), or by reverse transcription loop-mediated isothermal amplification (RT-LAMP) from a nasopharyngeal swab.
            
               Several COVID-19 vaccines have been approved and distributed in various countries, which have initiated mass vaccination campaigns. Other preventive measures include physical or social distancing, quarantining, ventilation of indoor spaces, covering coughs and sneezes, hand washing, and keeping unwashed hands away from the face. The use of face masks or coverings has been recommended in public settings to minimize the risk of transmissions. While work is underway to develop drugs that inhibit the virus, the primary treatment is symptomatic. Management involves the treatment of symptoms, supportive care, isolation, and experimental measures. </p>
            </div>
        </div>
        <div class="right">
            <button class="btn">Call Us</button>
            <button class="btn">E-mail Us</button>
        </div>
    </header>
</body>
</html>