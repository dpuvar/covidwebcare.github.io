<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="IMG/favicon1/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="IMG/favicon1/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="IMG/favicon1/favicon-16x16.png"
		/>
		<link rel="manifest" href="IMG/favicon1/site.webmanifest" />
		<link
			rel="stylesheet"
			href="https://unpkg.com/flickity@2/dist/flickity.min.css"
		/>
		<link rel="stylesheet" href="css/donation.css" />
		<title>COVID WEB CARE</title>
	</head>
	<body>
		<header>
			<div class="banner"></div>
		</header>
		<main>
			<nav>
				<a class="menu" href="index.php">Home</a>
				<a class="menu" href="https://saviorvoluntarybloodbankresearchcenter.business.site/">Donate Blood</a>
				<a class="menu" href="https://covid.giveindia.org/oxygen/?utm_source=google&utm_medium=cpc&utm_campaign=SB_GI_Generic_India_DSA_May2021&utm_adgroup=124047209978&utm_term=&utm_matchtype=b&utm_device=c&gclid=CjwKCAiA1aiMBhAUEiwACw25MfwwbeS_rr5V84V1Vu-hPLDMtCGi2VUuTVT36nYKRahm6mTo5NcKpxoCdZsQAvD_BwE">Donate Oxygen</a>
				<a class="menu" href="https://www.pmcares.gov.in/en/">Donate Money</a>
				<a class="login menu" href="logout.php">login/sign up</a>
			</nav>

			<section>
				<h2><span>Vaccinate Yourself</span></h2>
				<br />
				<br />
				<br />
				<div
					class="carousel"
					data-flickity='{ "autoPlay": true , "wrapAround": true }'
				>
					<div class="carousel-cell">
						<img src="./IMG/vacination/1.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/vacination/2.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/vacination/3.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/vacination/4.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/vacination/5.jpg" alt="this is image" />
					</div>
				</div>
				<br />
				<br />
				<br />
				<div>
					<p>
						FOR THE VACCINATION REGISTRATION,CLICK HERE
						<a target="_blank" href="https://www.cowin.gov.in/"
							><span class="register">REGISTER</span></a
						>
					</p>
				</div>
			</section>
			<section>
				<h2><span>Donate Blood</span></h2>

				<div class="blood b1">
					<div><img src="./IMG/blood/1.jpeg" alt="this is image" /></div>
					<ul class="ul1">
						<li>We’ll sign you in and go over basic eligibility.</li>
						<li>You’ll be asked to show ID, such as your driver’s license.</li>
						<li>We’ll ask you for your complete address.</li>
						<li>
							Your address needs to be complete (including PO Box,
							street/apartment number) and the place where you will receive your
							mail 8 weeks from donation.
						</li>
					</ul>
				</div>

				<div class="blood b2">
					<div><img src="./IMG/blood/2.jpg" alt="this is image" /></div>
					<ul class="ul2">
						<li>
							You’ll answer a few questions about your health history and places
							you’ve traveled, during a private and confidential interview.
						</li>

						<li>
							You’ll tell us about any prescription and/or over the counter
							medications that may be in your system.
						</li>
						<li>
							We’ll check your temperature, pulse, blood pressure and hemoglobin
							level.
						</li>
					</ul>
				</div>

				<div class="blood b3">
					<div><img src="./IMG/blood/3.jpg" alt="this is image" /></div>
					<ul class="ul3">
						<li>
							If you’re donating whole blood, we’ll cleanse an area on your arm
							and insert a brand new sterile needle for the blood draw. (This
							feels like a quick pinch and is over in seconds.)
						</li>

						<li>
							Other types of donations, such as platelets, are made using an
							apheresis machine which will be connected to both arms.
						</li>
						<li>
							A whole blood donation takes about 8-10 minutes, during which
							you’ll be seated comfortably or lying down.
						</li>
						<li>
							When approximately a pint of whole blood has been collected, the
							donation is complete and a staff person will place a bandage on
							your arm.
						</li>
						<li>
							For platelets, the apheresis machine will collect a small amount
							of blood, remove the platelets, and return the rest of the blood
							through your other arm; this cycle will be repeated several times
							over about 2 hours.
						</li>
					</ul>
				</div>

				<div class="blood b5">
					<div><img src="./IMG/blood/5.jpeg" alt="this is image" /></div>
					<ul class="ul5">
						<li>
							After donating blood, you’ll have a snack and something to drink
							in the refreshment area.
						</li>

						<li>
							You’ll leave after 10-15 minutes and continue your normal routine.
						</li>
						<li>
							Enjoy the feeling of accomplishment knowing you are helping to
							save lives.
						</li>
						<li>
							Take a selfie, or simply share your good deed with friends. It may
							inspire them to become blood donors.
						</li>
					</ul>
				</div>
				<br />
				<br />
				<br />
				<div>
					<p>
						FOR THE BLOOD DONATION,CLICK HERE
						<a target="_blank"href="https://saviorvoluntarybloodbankresearchcenter.business.site/"><span class="register">DONATE</span></a>
					</p>
				</div>
			</section>
			<section>
				<h2><span>Donate Beds</span></h2>
				<div
				class="carousel iframe-container"
				data-flickity='{ "autoPlay": true , "wrapAround": true }'
			>
				<div class="carousel-cell">
					<iframe
						src="https://www.youtube.com/embed/3YydV0L5q6A"
						title="YouTube video player"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowfullscreen
					></iframe>
				</div>
				<div class="carousel-cell">
					<iframe
						src="https://www.youtube.com/embed/40QG17QtTdg"
						title="YouTube video player"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowfullscreen
					></iframe>
				</div>

				<div class="carousel-cell">
					<iframe
						src="https://www.youtube.com/embed/qVXFBlQ3Az8"
						title="YouTube video player"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowfullscreen
					></iframe>
				</div>
		</div>

				<div class="carousel image" data-flickity='{ "autoPlay": true , "wrapAround": true}'>
					<div class="carousel-cell">
						<img src="./IMG/bed/1.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/bed/2.jpg" alt="this is image" />
					</div>
					<div class="carousel-cell">
						<img src="./IMG/bed/3.jpg" alt="this is image" />
					</div>
				</div>

			

			<div class="beds">
	<h1>COVID Beds in CSPIT</h1>
	<p>
		At the peak in May 2021, CSPIT had up to 1,150 inpatient beds for COVID patients (as well as patients being monitored at home).
	<ul class="cspit">
		<li>The total number of beds for COVID are slowly going down.</li>
		<li>BUT, ICU beds are still needed for very sick patients</li>
	</ul>
	</p>
</div>

	<div>
		<p>
			FOR THE BED DONATION,CLICK HERE
			<a
				target="_blank"
				href="https://my.care.org/site/Donation2?df_id=29863&mfc_pref=T&29863.donation=form1"><span class="register">DONATE</span></a>
		</p>
	</div>
	</section>

			<section>
				<h2>
					<span>Donate O<sub>2</sub> Cylinders</span>
				</h2>
				<div class="oxygen">
					<p class="O2">Why is oxygen so important for treating COVID-19?</p>
					<p class="O1">
						The SARS CoV-2 virus causes COVID-19 pneumonia and hypoxaemia.
						Hypoxaemia is a lack of oxygen in the blood – the most important
						complication of COVID-19 pneumonia and a major cause of death.
					</p>
					<div class="wrap1">
						<div class="div1">
							<img width="100%" src="./IMG/o2 cylinder/1.jpg" alt="this is image " />
							<h1>What are the challenges getting oxygen to patients?</h1>
						
							<p>
								Low and middle income countries face huge hurdles in getting oxygen to patients. In many countries proper systems to supply oxygen have been neglected for decades, despite pneumonia being the single biggest cause of hospital admission in low and middle income countries, even before the pandemic.
                                 </p>
                                <p>	The neglect of  oxygen systems has been partly market failure, partly lack of knowledge and anticipation, partly inertia.
                               </p>
                        <p>	
						In health care settings, with no effective oxygen systems, there is also usually been an under-resourcing of other essential services required to make a hospital run safely – such as power, water supply, sanitation and infection control.
                      </p>							
								
							<p>	
								Until the pandemic, some governments may not have fully appreciated that oxygen is lifesaving. Or they may have been unprepared to invest in a properly functioning oxygen system.
							</p>
		
							<h2>READ MORE</h2>
						</div>
						<div class="div2">
							<img src="./IMG/o2 cylinder/2.jpg" width="100%" alt="this is image " />
					<h1>What can be done to improve the situation?</h1>
							<p>
								Each situation will be different. For an oxygen system to be developed there must be a good understanding of the local context. This includes the systems that are already in use, the local providers, biomedical technician capacity, reliability of power supplies (often power supplies are erratic and power surges can damage concentrators, solar power is more stable), and the size of local populations and projected oxygen needs.
                           </p> 
	                          <p>
									For instance, a medium sized district hospital (treating 15 to 20 patients with oxygen daily) will need upwards of 40,000 litres per day. To meet these needs, the provision of oxygen should be done using oxygen concentrators and oxygen generators, using some cylinders for immediate emergency use, such as transport in an ambulance.	
			                  </p>
					<p>Your immune system guards your body against dangerous invaders (like viruses and bacteria). Oxygen fuels the cells of this system, keeping it strong and healthy. Breathing oxygen purified through something like an air sanitizer makes it easier for your immune system to use the oxygen. Low oxygen levels suppress parts of the immune system, but there’s evidence that suggests low oxygen might also activate other functions. This could be useful when investigating cancer therapies.</p>
						
					<p>Oxygen plays several roles in the human body. One has to do with the transformation of the food we eat into energy. This process is known as cellular respiration. During this process, the mitochondria in your body’s cells use oxygen to help break down glucose (sugar) into a usable fuel source. This provides the energy you need to live.</p>  <h2>READ MORE</h2>
						</div>
						<div class="div3">
							<img src="./IMG/o2 cylinder/3.jpg" alt="this is image " width="100%" />
							<h1>Can any immediate steps be taken?</h1>
							<p>For now, governments and health services should invest in bedside oxygen concentrators and generators to supply whole hospital or district needs. Global agencies should support this in a similar way that vaccines are being scaled up through global partnerships like COVAX.
                            </p>
                            <p>	
								There are many global manufacturers of oxygen concentrators and oxygen generators, and there are specifications from the WHO for this equipment. Supply is tight at present, but production is being scaled up. India recently announced the importation of 10,000 oxygen concentrators.
							</p>
									<h2>READ MORE</h2>
						</div>
					</div>
			
					</div>
				</div>
				<div>
					<p>
						FOR THE OXYGEN-CYLINDER DONATION,CLICK HERE
						<a
							target="_blank"
							href="https://covid.giveindia.org/oxygen/?utm_source=google&utm_medium=cpc&utm_campaign=SB_GI_Generic_India_DSA_May2021&utm_adgroup=124047209978&utm_term=&utm_matchtype=b&utm_device=c&gclid=CjwKCAiA1aiMBhAUEiwACw25MfwwbeS_rr5V84V1Vu-hPLDMtCGi2VUuTVT36nYKRahm6mTo5NcKpxoCdZsQAvD_BwE"
							><span class="register">DONATE</span></a
						>
					</p>
				</div>
			</section>
 			<section>
				<h2><span>Donate Money</span></h2>
		<div>
			<h2>Donate For Covid-19 (CoronaVirus) Relief Fund</h2>
			<p>
				<ul class="money">
			<li>
					The world is facing an unprecedented challenge with communities and economies everywhere affected by the growing COVID-19 pandemic. The world is coming together to combat the COVID-19 pandemic bringing governments, organizations from across industries and sectors and individuals together to help respond to this global outbreak. The outpouring of global solidarity and support sparked by this shared challenge has been phenomenal.
			</li>
			<li>
					The World Health Organization (WHO) is leading and coordinating the global effort, supporting countries to prevent, detect, and respond to the pandemic.
			</li>
		     <li>
            	Everyone can now support directly the response coordinated by WHO. People and organizations who want to help fight the pandemic and support WHO and partners can now donate through the COVID-Solidarity Response Fund for WHO, powered by the WHO Foundation in collaboration with the UN Foundation and a global network of partners at www.COVID19ResponseFund.org.
			</li>
			<li>
				The work in 2021 builds on the progress achieved in 2020, continues to support the response in countries towards suppressing transmission, reducing exposure, countering misinformation and disinformation, protecting the vulnerable, reducing mortality and morbidity rates and increasing equitable access of diagnostics and vaccines for all.
			</li>
		</ul>
			</p>
		</div>
		

		<div>
			<p>
				FOR THE MONEY DONATION,CLICK HERE
				<a
					target="_blank"
					href="https://www.pmcares.gov.in/en/"
					><span class="register">DONATE</span></a
				>
			</p>
		</div>


			</section>
		</main>
		<footer>
			<a href="#" target="_blank">FAQ</a>
			<a href="#" target="_blank">Terms and Policy</a>
			<a href="#" target="_blank">About us</a>
			<a href="#" target="_blank">Contact us</a>
			<a href="#" class="copy" target="_blank"> &#169;|Dhruv 2021</a>
		</footer>
		<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	</body>
</html>
