<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Covid 19 Timeline</title>
</head>
<body>
<!-- partial:index.partial.html -->
<div id="main">
  <div class="default-background"></div>
  <transition :name="transition">
    <div class='background-image' :key="`image${current_index}`">
      <img :srcset="currentPanel.src">
    </div>
  </transition>
  <div id="wrapper" @wheel='handleScroll' :style="wrapperStyle">

    <div class="intro">
      <h1> Covid 19 Timeline </h1>
      <div> 31 Dec 2019 - {{endDate}} </div>
			<a target="_blank" class="credit-link" href="https://www.nytimes.com/article/coronavirus-timeline.html">
				<img src="https://i.ya-webdesign.com/images/new-york-times-logo-white-png-4.png">
			</a>
			<div class='scroll-down'>
			<span>«</span>
			</div>
    </div>
    <div class="inner-wrapper">
      <div id='timeline'>
        <div class="line" v-for="(p, i) in panels" :class='getLineClass(i)' @mouseenter="current_index = i"></div>
        <div class="time" :style="time_position" ref='time'>{{display_day}} {{display_month}}</div>
      </div>
      <div id='panel-wrapper'>
        <transition :name='transition' mode="out-in">
          <div class="panel" :key="`index-${current_index}`">
            <h1>{{currentPanel.title}}</h1>
            <div class='desc' v-html='currentPanel.desc'></div>
          </div>
        </transition>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/gsap.min.js'></script>
<script>
new Vue({
  el: "#main",
  data: {
    panels: panels(),
    current_index: -1,
    time_height: 0,
    time_position: {
      top: 0
    },
    transition: "in",
    current_month: [0, 0, 0],
    current_date: [0, 0],
    numbers: "0123456789".split(""),
    letters: "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split(""),
    display_day: "00",
    display_month: "JAN"
  },
  methods: {
    handleScroll: function(e) {
      let delta = e.deltaY;
			
      if (delta < 0 && this.current_index >= 0) {
        this.transition = "out";
        this.current_index--;
      }

      if (delta > 0 && this.current_index < (this.panels.length - 1)) {
        this.current_index++;
        this.transition = "in";
      }
			
    },
    getLineClass: function(index) {
      return {
        active: this.current_index == index,
        "pre-1": this.current_index - 1 == index,
        "post-1": this.current_index + 1 == index,
        "pre-2": this.current_index - 2 == index,
        "post-2": this.current_index + 2 == index,
        "pre-3": this.current_index - 3 == index,
        "post-3": this.current_index + 3 == index
      }
    },
    onUpdateDays: function() {
      let days = [];

      for (var i = 0; i < this.current_date.length; i++) {
        const rand = this.numbers[Math.round(this.current_date[i]) % this.numbersLength];
        days.push(rand);
      }
      this.display_day = days.join("");
    },
    onUpdateMonth: function() {
      let month = [];

      for (var i = 0; i < this.current_month.length; i++) {
        const rand = this.letters[Math.round(this.current_month[i]) % this.lettersLength];
        month.push(rand);
      }
      this.display_month = month.join("");
    }
  },
	beforeMount: function(){
		var images = [];
		this.panels.forEach((p, i) => {
			if(p.hasOwnProperty("src"))
			{
				images[i] = new Image();
				images[i].srcset = p.src;
				}
			}
		)
	},
  mounted: function() {
    const timeEl = this.$refs.time;
    this.time_height = timeEl.getBoundingClientRect().height;

  },
  computed: {
		endDate: function(){
			const date = this.panels[this.panels.length - 1];
			return `${date.date} 2020`;
		},
    getPosition: function() {
      let top = this.current_panel * -100;
      return {
        transform: `translateY(${top}vh)`
      }
    },
    currentPanel: function() {
			if(this.current_index < 0)
				return {};
				
      return this.panels[this.current_index];
    },
    numbersLength: function() {
      return this.numbers.length;
    },
    lettersLength: function() {
      return this.letters.length;
    },
		wrapperStyle: function(){
			const top = (this.current_index == -1) ? 0 : "-100%";
			return {
				transform: `translateY(${top})`
			}
		}
  },
  watch: {
    current_index: {
      handler: function(newVal) {
        this.$nextTick(function() {
          const currentLine = this.$el.querySelector(`.line:nth-child(${newVal + 1})`);

          if (currentLine == null)
            return {}

          const dim = currentLine.offsetTop;
          const top = dim - this.time_height - (this.time_height / 2);
				
          this.time_position = {
            top: `${top}px`
          }
					
          let newDay = this.panels[this.current_index];
          this.current_date = [0, 0];
          this.current_month = [0, 0, 0];
          const splitDate = newDay.date.split(" ");
          const days = splitDate[0].split("");
					
          let month = splitDate[1].split("");
          month = month.map(m => this.letters.indexOf(m.toUpperCase()));

          gsap.to(this.$data.current_date, {
            duration: 0.3,
            ease: Linear.easeNone,
            "0": this.numbersLength * 20 + days[0],
            "1": this.numbersLength * 60 + days[1],
            onUpdate: this.onUpdateDays
          });


          gsap.to(this.$data.current_month, {
            duration: 0.3,
            ease: Linear.easeNone,
            "0": this.lettersLength * 20 + month[0],
            "1": this.lettersLength * 20 + month[1],
            "2": this.lettersLength * 20 + month[2],
            onUpdate: this.onUpdateMonth
          });
        });
      },
    }
  }
});

function panels() {
  return [
  {
    "date": "31 Dec",
    "title": "Chinese authorities treated dozens of cases of pneumonia of unknown cause.",
    "desc": "<p>On Dec. 31, the government in <a class=\"\" href=\"https://www.nytimes.com/2021/01/10/world/asia/wuhan-china-coronavirus.html\" title=\"\" target=\"blank\">Wuhan</a>, China, confirmed that health authorities were treating dozens of cases. Days later, researchers in China <a class=\"\" href=\"https://www.nytimes.com/2020/01/08/health/china-pneumonia-outbreak-virus.html\" title=\"\" target=\"blank\">identified a new virus</a> that had infected dozens of people in Asia. At the time, there was no evidence that the virus was readily spread by humans. Health officials in China said they were monitoring it to prevent the outbreak from developing into something more severe.</p>"
  },
  {
    "date": "11 Jan",
    "title": "China reported its first death.",
    "desc": "<p>On Jan. 11, Chinese state media reported the <a class=\"\" href=\"https://www.nytimes.com/2020/01/10/world/asia/china-virus-wuhan-death.html\" title=\"\" target=\"blank\">first known death</a> from an illness caused by the virus, which had infected dozens of people. The 61-year-old man who died was a regular customer at the market in Wuhan. The report of his death came just before one of China’s biggest holidays, when hundreds of millions of people travel across the country.</p>"
  },
  {
    "date": "20 Jan",
    "title": "Other countries, including the United States, confirmed cases.",
    "desc": "<p>The first confirmed cases outside mainland China occurred in Japan, South Korea and Thailand, according to the W.H.O.’s first <a class=\"\" href=\"https://www.who.int/docs/default-source/coronaviruse/situation-reports/20200121-sitrep-1-2019-ncov.pdf?sfvrsn=20a99c10_4\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">situation report</a>. The first confirmed case in the United States came the next day in Washington State, where <a class=\"\" href=\"https://www.nytimes.com/2020/01/21/health/cdc-coronavirus.html\" title=\"\" target=\"blank\">a man in his 30s developed symptoms</a> after returning from a trip to Wuhan.</p>"
  },
  {
    "date": "23 Jan",
    "title": "Wuhan, a city of more than 11 million, was cut off by the Chinese authorities.",
    "src": "https://static01.nyt.com/images/2020/02/11/multimedia/00xp-virustimeline4/merlin_168335142_4eca1f21-e21b-4b97-8b87-dad2489ee05b-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/02/11/multimedia/00xp-virustimeline4/merlin_168335142_4eca1f21-e21b-4b97-8b87-dad2489ee05b-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/02/11/multimedia/00xp-virustimeline4/merlin_168335142_4eca1f21-e21b-4b97-8b87-dad2489ee05b-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The Chinese authorities <a class=\"\" href=\"https://www.nytimes.com/2020/01/22/world/asia/china-coronavirus-travel.html\" title=\"\" target=\"blank\">closed off Wuhan</a> by canceling planes and trains leaving the city, and suspending buses, subways and ferries within it. At this point, at least 17 people had died and more than 570 others had been infected, including in Taiwan, Japan, Thailand, South Korea and the United States.</p>"
  },
  {
    "date": "30 Jan",
    "title": "The W.H.O. declared a global health emergency.",
    "desc": "<p>Amid thousands of new cases in China, a “public health emergency of international concern” was officially <a class=\"\" href=\"https://www.nytimes.com/2020/01/30/health/coronavirus-world-health-organization.html\" title=\"\" target=\"blank\">declared </a>by the W.H.O. China’s Foreign Ministry spokeswoman said that it would continue to work with the W.H.O. and other countries to protect public health, and the U.S. <a class=\"\" href=\"https://www.nytimes.com/2020/01/30/world/asia/Coronavirus-travel-advisory-.html\" title=\"\" target=\"blank\">State Department warned</a> travelers to avoid China.</p>"
  },
  {
    "date": "31 Jan",
    "title": "The Trump administration restricted travel from China",
    "desc": "<p>The Trump administration <a class=\"\" href=\"https://www.nytimes.com/2020/01/31/business/china-travel-coronavirus.html\" title=\"\" target=\"blank\">suspended entry</a> into the United States by any foreign nationals who had traveled to China in the past 14 days, excluding the immediate family members of American citizens or permanent residents. By this date, <a class=\"\" href=\"https://www.nytimes.com/2020/01/30/world/asia/coronavirus-china.html#link-6a63a9b7\" title=\"\" target=\"blank\">213 people had died</a> and nearly 9,800 had been infected worldwide.</p>"
  },
  {
    "date": "02 Feb",
    "title": "The first coronavirus death was reported outside China.",
    "desc": "<p>A 44-year-old man in the Philippines <a class=\"\" href=\"https://www.nytimes.com/2020/02/02/world/asia/philippines-coronavirus-china.html\" title=\"\" target=\"blank\">died after being infected</a>, officials said, the first death reported outside China. By this point, more than 360 people had died.</p>"
  },
  {
    "date": "07 Feb",
    "title": "A Chinese doctor who tried to raise the alarm died.",
    "src": "https://static01.nyt.com/images/2020/02/12/multimedia/00xp-virustimeline5/merlin_168524808_e05e8362-bed5-446e-87ad-d3f03a5cd726-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/02/12/multimedia/00xp-virustimeline5/merlin_168524808_e05e8362-bed5-446e-87ad-d3f03a5cd726-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/02/12/multimedia/00xp-virustimeline5/merlin_168524808_e05e8362-bed5-446e-87ad-d3f03a5cd726-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>When <a class=\"\" href=\"https://www.nytimes.com/2020/02/06/world/asia/chinese-doctor-Li-Wenliang-coronavirus.html\" title=\"\" target=\"blank\">Dr. Li Wenliang</a>, a Chinese doctor, <a class=\"\" href=\"https://www.nytimes.com/2020/02/06/world/asia/chinese-doctor-Li-Wenliang-coronavirus.html\" title=\"\" target=\"blank\">died </a>after contracting the coronavirus, he was hailed as a hero by many for trying to ring early alarms that infections could spin out of control.</p><p>In early January, the authorities reprimanded him, and he was forced to sign a statement denouncing his warning Dr. Li’s death <a class=\"\" href=\"https://www.nytimes.com/2020/02/07/business/china-coronavirus-doctor-death.html\" title=\"\" target=\"blank\">provoked anger and frustration</a> at how the Chinese government mishandled the situation.</p>"
  },
  {
    "date": "11 Feb",
    "title": "The disease the virus causes was named.",
    "desc": "<p>The W.H.O. proposed an official name for the disease the virus causes: <a class=\"\" href=\"https://www.nytimes.com/2020/02/11/world/asia/coronavirus-china.html?action=click&amp;module=Top%20Stories&amp;pgtype=Homepage\" title=\"\" target=\"blank\">Covid-19</a>, an acronym that stands for coronavirus disease 2019. The name makes no reference to any of the people, places, or animals associated with the coronavirus, given the goal to avoid stigma.</p>"
  },
  {
    "date": "14 Feb",
    "title": "France announced the first coronavirus death in Europe.",
    "src": "https://static01.nyt.com/images/2020/03/31/world/31xp-virustimeline1/31xp-virustimeline1-articleLarge-v2.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/03/31/world/31xp-virustimeline1/31xp-virustimeline1-jumbo-v2.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/03/31/world/31xp-virustimeline1/31xp-virustimeline1-superJumbo-v2.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>An 80-year-old Chinese tourist <a class=\"\" href=\"https://www.nytimes.com/2020/02/15/world/asia/coronavirus-china-live-updates.html?action=click&amp;module=Top%20Stories&amp;pgtype=Homepage#link-313a84de\" title=\"\" target=\"blank\">died on Feb. 14</a> at a hospital in Paris, in what was the first coronavirus death outside Asia, the authorities said. It was the fourth death from the virus outside mainland China, where about 1,500 people had died, most of them in Hubei Province.</p>"
  },
  {
    "date": "23 Feb",
    "title": "Italy saw a major surge in cases.",
    "src": "https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline4/31xpvirustimeline4-articleLarge-v2.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline4/31xpvirustimeline4-jumbo-v2.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline4/31xpvirustimeline4-superJumbo-v2.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Europe faced its <a class=\"\" href=\"https://www.nytimes.com/2020/02/23/world/europe/italy-coronavirus.html\" title=\"\" target=\"blank\">first major outbreak</a> as the number of reported cases in Italy grew from fewer than five to more than 150. In the Lombardy region, officials locked down 10 towns after a cluster of cases suddenly emerged in Codogno, southeast of Milan. Schools closed and sporting and cultural events were canceled.</p>"
  },
  {
    "date": "24 Feb",
    "title": "Iran emerged as a second focus point.",
    "src": "https://static01.nyt.com/images/2020/02/24/business/00xp-virustimeline11/24china-briefing13-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/02/24/business/00xp-virustimeline11/24china-briefing13-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/02/24/business/00xp-virustimeline11/24china-briefing13-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Iran announced its first two coronavirus cases on Feb. 19. Less than a week later, the country said it had <a class=\"\" href=\"https://www.nytimes.com/2020/02/24/world/asia/china-coronavirus.html#link-755cef26\" title=\"\" target=\"blank\">61 coronavirus cases</a> and 12 deaths, more than any other country at the time but China.</p>"
  },
  {
    "date": "26 Feb",
    "title": "Latin America reported its first case.",
    "desc": "<p>Brazilian <a class=\"\" href=\"https://www.nytimes.com/2020/02/26/world/americas/brazil-italy-coronavirus.html\" title=\"\" target=\"blank\">health officials</a> said that a 61-year-old São Paulo man, who had returned recently from a business trip to Italy, tested positive for the coronavirus. It was the first known case in Latin America. </p>"
  },
  {
    "date": "01 Mar",
    "title": "The United States reported a death.",
    "desc": "<p>On Feb. 29, the authorities announced that a patient near Seattle had died from the coronavirus, in what was believed to be the <a class=\"\" href=\"https://www.nytimes.com/2020/02/29/us/coronavirus-washington-death.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">first coronavirus death</a> in the United States at the time. In fact, two people had died earlier, though their Covid-19 diagnoses were not discovered until months later.</p>"
  },
  {
    "date": "15 Mar",
    "title": "The C.D.C. recommended no gatherings of 50 or more people in the U.S.",
    "src": "https://static01.nyt.com/images/2020/04/13/us/politics/13xp-timeline-5/merlin_170701089_4f652274-b6d3-4b0e-9c96-0b016a11ec87-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/04/13/us/politics/13xp-timeline-5/merlin_170701089_4f652274-b6d3-4b0e-9c96-0b016a11ec87-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/04/13/us/politics/13xp-timeline-5/merlin_170701089_4f652274-b6d3-4b0e-9c96-0b016a11ec87-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The Centers for Disease Control and Prevention <a class=\"\" href=\"https://www.nytimes.com/2020/03/15/world/coronavirus-live.html\" title=\"\" target=\"blank\">advised no gatherings</a> of 50 or more people in the United States over the next eight weeks. The recommendation included weddings, festivals, parades, concerts, sporting events and conferences. The following day, Mr. Trump advised citizens to <a class=\"\" href=\"https://www.nytimes.com/2020/03/16/world/live-coronavirus-news-updates.html\" title=\"\" target=\"blank\">avoid groups</a> of more than 10. New York City’s public schools system, the nation’s largest with 1.1 million students, <a class=\"\" href=\"https://www.nytimes.com/2020/03/15/nyregion/nyc-schools-closed.html\" title=\"\" target=\"blank\">announced that it would close</a>.</p>"
  },
  {
    "date": "16 Mar",
    "title": "Latin America began to feel the effects.",
    "desc": "<p>Several countries across Latin America <a class=\"\" href=\"https://www.nytimes.com/2020/03/16/world/live-coronavirus-news-updates.html\" title=\"\" target=\"blank\">imposed restrictions</a> on their citizens to slow the spread of the virus. Venezuela announced a nationwide quarantine that began on March 17. Ecuador and Peru implemented countrywide lockdowns, while Colombia and Costa Rica closed their borders. </p>"
  },
  {
    "date": "17 Mar",
    "title": "The E.U. barred most travelers from outside the bloc.",
    "src": "https://static01.nyt.com/images/2020/04/13/us/politics/13xp-virus-timeline-7/merlin_170722023_f98890be-c166-4ce2-8d3b-c30f2ecf9a2f-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/04/13/us/politics/13xp-virus-timeline-7/merlin_170722023_f98890be-c166-4ce2-8d3b-c30f2ecf9a2f-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/04/13/us/politics/13xp-virus-timeline-7/merlin_170722023_f98890be-c166-4ce2-8d3b-c30f2ecf9a2f-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>European leaders <a class=\"\" href=\"https://www.nytimes.com/2020/03/17/world/europe/EU-closes-borders-virus.html\" title=\"\" target=\"blank\">voted to close off at least 26 countries</a> to nearly all visitors from the rest of the world for at least 30 days. The ban on nonessential travel from outside the bloc was the first coordinated response to the epidemic by the European Union.</p>"
  },
  {
    "date": "24 Mar",
    "title": "India announced a 21-day lockdown.",
    "src": "https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline6/31xpvirustimeline6-articleLarge-v2.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline6/31xpvirustimeline6-jumbo-v2.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/03/31/world/31xpvirustimeline6/31xpvirustimeline6-superJumbo-v2.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>One day after the authorities halted all domestic flights, Narendra Modi, India’s prime minister, <a class=\"\" href=\"https://www.nytimes.com/2020/03/24/world/asia/india-coronavirus-lockdown.html\" title=\"\" target=\"blank\">declared a 21-day lockdown</a>. While the number of reported cases in India was about 500, the prime minister pledged to spend about $2 billion on medical supplies, isolation rooms, ventilators and training for medical professionals.</p>"
  },
  {
    "date": "26 Mar",
    "title": "The United States led the world in confirmed cases.",
    "desc": "<p>The United States officially became the country <a class=\"\" href=\"https://www.nytimes.com/2020/03/26/health/usa-coronavirus-cases.html\" title=\"\" target=\"blank\">hardest hit by the pandemic</a>, with at least 81,321 confirmed infections and more than 1,000 deaths. This was more reported cases than in China, Italy or any other country at the time.</p>"
  },
  {
    "date": "02 Apr",
    "title": "Cases topped a million, and millions lost their jobs.",
    "desc": "<p>By April 2, the pandemic had sickened more than one million people in 171 countries across six continents, killing at least 51,000.</p><p>In just a few weeks, the pandemic put nearly <a class=\"\" href=\"https://www.nytimes.com/2020/04/02/business/economy/coronavirus-unemployment-claims.html\" title=\"\" target=\"blank\">10 million Americans out of work</a>, including a staggering 6.6 million people who applied for unemployment benefits in the last week of March. The speed and scale of the job losses was without precedent: Until March, the worst week for unemployment filings was 695,000 in 1982.</p>"
  },
  {
    "date": "06 Apr",
    "title": "Prime Minister Boris Johnson moved into intensive care.",
    "desc": "<p>Ten days <a class=\"\" href=\"https://twitter.com/BorisJohnson/status/1243496858095411200\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">after going public</a> with his coronavirus diagnosis, Prime Minister Boris Johnson of Britain was <a class=\"\" href=\"https://www.nytimes.com/2020/04/06/world/europe/boris-johnson-coronavirus-hospital-intensive-care.html\" title=\"\" target=\"blank\">moved into intensive care</a>. The decision was a precaution, according to the British government, who also said he had been in good spirits. Mr. Johnson had also asked the foreign secretary, Dominic Raab, to deputize for him “where necessary.” He was released on April 12.</p>"
  },
  {
    "date": "10 Apr",
    "title": "Cases surged in Russia.",
    "src": "https://static01.nyt.com/images/2020/04/10/world/10virus-moscow-copy/merlin_171261144_da859ea1-d1e2-4f58-998e-ad284405c998-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/04/10/world/10virus-moscow-copy/merlin_171261144_da859ea1-d1e2-4f58-998e-ad284405c998-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/04/10/world/10virus-moscow-copy/merlin_171261144_da859ea1-d1e2-4f58-998e-ad284405c998-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The number of people hospitalized in Moscow with Covid-19 <a class=\"\" href=\"https://www.nytimes.com/2020/04/10/world/europe/coronavirus-russia-moscow-putin.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">doubled from the previous week</a>, with two-thirds of the country’s 12,000 reported cases in Moscow. The increase in cases pushed Moscow’s health care system to its limit, well before an expected peak.</p>"
  },
  {
    "date": "21 Apr",
    "title": "Officials discovered earlier known U.S. coronavirus deaths in California.",
    "desc": "<p>Officials in Santa Clara County, Calif., announced that two residents there died of the coronavirus on Feb. 6 and Feb. 17, making them <a class=\"\" href=\"https://www.nytimes.com/2020/04/22/us/coronavirus-first-united-states-death.html\" title=\"\" target=\"blank\">the earliest known</a><a class=\"\" href=\"https://www.nytimes.com/2020/02/29/us/coronavirus-washington-death.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\"> victims</a> of the pandemic in the United States. The new information, gained from autopsies of the residents, moved the timeline of the virus’s spread in country weeks earlier than previously understood. .</p>"
  },
  {
    "date": "24 Apr",
    "title": "The European Union, pressured by China, watered down a report on disinformation.",
    "desc": "<p>The E.U. appeared to succumb to pressure from Beijing and softened criticism of China <a class=\"\" href=\"https://www.nytimes.com/2020/04/24/world/europe/disinformation-china-eu-coronavirus.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">in a report on disinformation </a>about the coronavirus pandemic. While the initial report was not particularly harsh, European officials delayed and then rewrote the document to dilute the focus on China, a vital trading partner.</p>"
  },
  {
    "date": "26 Apr",
    "title": "The global death toll surpassed 200,000.",
    "src": "https://static01.nyt.com/images/2020/06/13/us/13xp-virustimeline-death/merlin_171993099_5540e16f-b69f-4b3d-bc92-71bb5fff4de7-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/06/13/us/13xp-virustimeline-death/merlin_171993099_5540e16f-b69f-4b3d-bc92-71bb5fff4de7-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/06/13/us/13xp-virustimeline-death/merlin_171993099_5540e16f-b69f-4b3d-bc92-71bb5fff4de7-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>By April 26, the coronavirus pandemic had killed more than 200,000 people and sickened more than 2.8 million worldwide, according to data <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/world/coronavirus-maps.html\" title=\"\" target=\"blank\">collected by The New York Times</a>. The actual toll is higher by an unknown degree, and will remain so for some time.</p>"
  },
  {
    "date": "30 Apr",
    "title": "Airlines announced rules requiring face masks.",
    "src": "https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-mask/merlin_172209270_51e33667-edaa-4e73-8ba7-8677dce93320-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-mask/merlin_172209270_51e33667-edaa-4e73-8ba7-8677dce93320-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-mask/merlin_172209270_51e33667-edaa-4e73-8ba7-8677dce93320-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>American Airlines and Delta Air Lines said they would require all passengers and flight attendants <a class=\"\" href=\"https://www.nytimes.com/2020/04/30/business/airlines-masks-coronavirus-passengers.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">to wear a face covering</a>. Lufthansa Group — which owns Lufthansa, Swiss International Air Lines and Austrian Airlines — as well as JetBlue and Frontier Airlines had made similar announcements.</p>"
  },
  {
    "date": "05 May",
    "title": "The coronavirus reached France in December, doctors said, rewriting the epidemic’s timeline.",
    "src": "https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-france/13xp-virustimeline-france-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-france/13xp-virustimeline-france-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-france/13xp-virustimeline-france-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>French doctors said that they had discovered that a patient treated for pneumonia in late December had the coronavirus. If the diagnosis is verified, it would suggest that the virus <a class=\"\" href=\"https://www.nytimes.com/2020/05/05/world/europe/france-coronavirus-timeline.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">appeared in Europe nearly a month earlier</a> than previously understood and days before Chinese authorities first reported the new illness to the World Health Organization. The first report of an infection in Europe was on Jan. 24 in France.</p>"
  },
  {
    "date": "17 May",
    "title": "Japan and Germany, two of the world’s largest economies, entered recessions.",
    "src": "https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-germany/13xp-virustimeline-germany-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-germany/13xp-virustimeline-germany-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-germany/13xp-virustimeline-germany-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Japan, the world’s third-largest economy after the United States and China, <a class=\"\" href=\"https://www.nytimes.com/2020/05/17/business/japan-recession-coronavirus.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">fell into a recession</a> for the first time since 2015. Its economy shrank by an annualized rate of 3.4 percent in the first three months of the year.</p><p>Germany, Europe’s largest economy, <a class=\"\" href=\"https://www.nytimes.com/2020/05/15/business/stock-market-today-coronavirus.html?module=STYLN_live_tabs&amp;variant=1_menu&amp;region=header&amp;context=menu&amp;state=default&amp;pgtype=Article\" title=\"\" target=\"blank\">also fell into a recession</a>. Its economy suffered its worst contraction since the 2008 global financial crisis, shrinking by 2.2 percent in the January-March period from the previous quarter.</p>"
  },
  {
    "date": "22 May",
    "title": "Infections in Latin America continued to rise.",
    "src": "https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-latin-america/merlin_172837227_62535589-cc2e-46d6-b704-ee40b964ef5b-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-latin-america/merlin_172837227_62535589-cc2e-46d6-b704-ee40b964ef5b-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/06/13/multimedia/13xp-virustimeline-latin-america/merlin_172837227_62535589-cc2e-46d6-b704-ee40b964ef5b-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>On May 22, Brazil overtook Russia in reporting the second-highest count of infections worldwide, reaching more than 330,000. Peru and Chile ranked among the hardest-hit countries in the world in terms of infections per capita, around 1 in 300. Data from Ecuador indicated that it was suffering <a class=\"\" href=\"https://www.nytimes.com/2020/04/23/world/americas/ecuador-deaths-coronavirus.html\" title=\"\" target=\"blank\">one of the worst outbreaks in the world</a>. The United States remained the global epicenter, with more than 1.6 million cases and the number of deaths nearing 100,000.</p>"
  },
  {
    "date": "27 May",
    "title": "Coronavirus deaths in the U.S. passed 100,000.",
    "desc": "<p>Four months after the government confirmed the first known case, <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/05/24/us/us-coronavirus-deaths-100000.html\" title=\"\" target=\"blank\">more than 100,000 people</a> who had the coronavirus were recorded dead in the United States. The death toll was far higher than in any other nation around the world.</p><p><span class=\"css-8l6xbc evw5hdy0\">  </span></p>"
  },
  {
    "date": "04 Jun",
    "title": "Coronavirus tore into regions previously spared.",
    "desc": "<p>The number of known cases across the globe grew faster than ever, <a class=\"\" href=\"https://www.nytimes.com/2020/06/04/world/middleeast/coronavirus-egypt-america-africa-asia.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">with more than 100,000 new infections a day</a>. Densely populated, low- and middle-income countries across the Middle East, Latin America, Africa and South Asia were hit the hardest, suggesting bad news for strongmen and populists who once reaped political points by vaunting low infection rates as evidence of their leadership’s virtues.</p><p> </p>"
  },
  {
    "date": "11 Jun",
    "title": "Coronavirus cases in Africa topped 200,000.",
    "desc": "<p>The W.H.O. said that it took Africa 98 days to reach 100,000 coronavirus cases, but only <a class=\"\" href=\"https://news.un.org/en/story/2020/06/1066142\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">18 days for that figure to double</a>. While the sharp rise in cases could be explained by an increase in testing, the agency said, more than half of the 54 countries on the continent were experiencing community transmissions. Ten countries were driving the rise in numbers and accounted for nearly 80 percent of all cases. South Africa has a quarter of the total cases.</p>"
  },
  {
    "date": "20 Jun",
    "title": "Southern U.S. states saw sharp rise in cases.",
    "src": "https://static01.nyt.com/images/2020/07/13/multimedia/13xp-virus-timeline-miami/merlin_173679186_7f178475-6ba0-4cc4-9dcd-441137d065bd-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/07/13/multimedia/13xp-virus-timeline-miami/merlin_173679186_7f178475-6ba0-4cc4-9dcd-441137d065bd-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/07/13/multimedia/13xp-virus-timeline-miami/merlin_173679186_7f178475-6ba0-4cc4-9dcd-441137d065bd-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>On June 20, for the third straight day, Florida and South Carolina broke their single-day records for new cases. The news came as infection levels for Missouri and Nevada also reached new highs. On June 19, the United States reported more than 30,000 new infections, its highest since May 1, with cases rising in 19 states across the South, West and Midwest.</p><p> </p>"
  },
  {
    "date": "30 Jun",
    "title": "The E.U. said it would reopen borders.",
    "desc": "<p>The European Union <a class=\"\" href=\"https://www.nytimes.com/2020/06/30/world/europe/eu-reopening-blocks-us-travelers.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">prepared to open to visitors</a> from 15 countries on July 1, but not to travelers from the United States, Brazil or Russia. The move puts into effect a complex policy that seeks to balance health concerns with politics, diplomacy and the desperate need for tourism revenue. Australia, Canada and New Zealand were among the approved list of countries. Travelers from China will be permitted if China reciprocates.</p>"
  },
  {
    "date": "01 Jul",
    "title": "Iran announced new lockdown measures.",
    "src": "https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-iran/merlin_174312450_9edb3115-7605-4e99-82be-ce2e65405ab8-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-iran/merlin_174312450_9edb3115-7605-4e99-82be-ce2e65405ab8-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-iran/merlin_174312450_9edb3115-7605-4e99-82be-ce2e65405ab8-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>As hospitals in Iran filled and the death toll climbed, officials announced new shutdown measures in cities across 11 provinces. Eight provinces, including Tehran, the capital, were among the areas considered red zones. The partial shutdown in Tehran restricted movement, cut work hours and banned large gatherings like weddings and funerals.</p>"
  },
  {
    "date": "07 Jul",
    "title": "Brazil’s president tested positive.",
    "desc": "<p>President Jair Bolsonaro of Brazil <a class=\"\" href=\"https://www.nytimes.com/2020/07/07/world/americas/brazil-bolsonaro-coronavirus.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">disclosed on July 7</a> that he had been infected with the virus, saying that he was tested after experiencing fatigue, muscle pain and a fever. The news came after months of denying the seriousness of the pandemic and brushing aside protective measures, and after more than 65,000 Brazilians had died.</p>"
  },
  {
    "date": "10 Jul",
    "title": "U.S. set seven records in 11 days.",
    "src": "https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-nc/merlin_174392388_13e28638-4b18-4a4e-800b-f5da294ac1d0-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-nc/merlin_174392388_13e28638-4b18-4a4e-800b-f5da294ac1d0-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-nc/merlin_174392388_13e28638-4b18-4a4e-800b-f5da294ac1d0-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>On July 10, the United States reached 68,000 new cases for the first time, setting a single-day record for the seventh time in 11 days. The infection rate was underscored by alarming growth in the South and West. At least six states had also reported single-day records for new cases: Georgia, Utah, Montana, North Carolina, Iowa and Ohio.</p>"
  },
  {
    "date": "10 Jul",
    "title": "Hong Kong shut down schools amid a third wave.",
    "desc": "<p>Hong Kong, a city of seven million, has reported more than 1,400 cases and seven deaths. But on July 10, it shut down its school system as it worked to contain a third wave of infections, which official reports included 38 new cases.</p><p>The third wave, which comes after <a class=\"\" href=\"https://www.nytimes.com/2020/03/31/world/asia/coronavirus-china-hong-kong-singapore-south-korea.html\" title=\"\" target=\"blank\">infections surged in March</a> and were contained by May, was a setback for a city that had <a class=\"\" href=\"https://www.nytimes.com/2020/05/19/world/asia/coronavirus-hong-kong.html\" title=\"\" target=\"blank\">largely returned to normal</a>, with restaurants enjoying packed crowds and workers returning to offices.</p>"
  },
  {
    "date": "13 Jul",
    "title": "More than five million Americans lost health insurance.",
    "desc": "<p>The coronavirus pandemic stripped an estimated 5.4 million Americans of their health insurance between February and May, a period in which more adults became uninsured because of job losses than have ever lost coverage in a single year, <a class=\"\" href=\"https://www.nytimes.com/2020/07/13/us/politics/coronavirus-health-insurance-trump.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">according to a study</a>.</p>"
  },
  {
    "date": "15 Jul",
    "title": "Tokyo raised its pandemic alert level.",
    "src": "https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-tokyo/merlin_174618894_b114ae56-eb4e-4aa0-b382-833fc9ed21cc-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-tokyo/merlin_174618894_b114ae56-eb4e-4aa0-b382-833fc9ed21cc-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-tokyo/merlin_174618894_b114ae56-eb4e-4aa0-b382-833fc9ed21cc-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Days after new cases hit record highs, Tokyo raised its alert level to “red,” its highest. In the week before, Tokyo recorded two consecutive daily records with a peak of 243 cases on July 10. Since February, the sprawling metropolis of 14 million had reported a total of just under 8,200 cases and 325 deaths.</p>"
  },
  {
    "date": "16 Jul",
    "title": "A study in South Korea found that older children spread the virus comparably to adults.",
    "desc": "<p>While school districts around the United States struggle with reopening plans, <a class=\"\" href=\"https://wwwnc.cdc.gov/eid/article/26/10/20-1315_article\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">a study from South Korea</a> offered a note of caution. It found that children between the ages of 10 and 19 can spread the virus at least as well as adults do, suggesting that middle and high schools in particular may seed new clusters of infection. Children younger than 10 transmit to others much less often, according to the study, although the risk is not zero.</p>"
  },
  {
    "date": "17 Jul",
    "title": "India reached a million coronavirus cases, and lockdowns were reimposed.",
    "src": "https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-india/21xp-virus-timeline-india-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-india/21xp-virus-timeline-india-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2020/07/21/multimedia/21xp-virus-timeline-india/21xp-virus-timeline-india-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>India on July 17 surpassed <a class=\"\" href=\"https://www.nytimes.com/2020/07/16/world/asia/coronavirus-india-million-cases.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">one million confirmed infections</a> and 25,000 deaths. The milestones came as several states and cities had reimposed total and partial lockdowns and as the country ranked third in the world in infections behind the United States and Brazil. While India’s caseloads continued to climb, researchers at the <a class=\"\" href=\"https://papers.ssrn.com/sol3/papers.cfm?abstract_id=3635047\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">Massachusetts Institute of Technology</a> estimated that by the end of next year, India would have the worst outbreak in the world.</p>"
  },
  {
    "date": "21 Jul",
    "title": "European leaders agreed on a $857 billion stimulus package.",
    "desc": "<p>European Union leaders on July 21 <a class=\"\" href=\"https://www.nytimes.com/2020/07/20/world/europe/eu-stimulus-coronavirus.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">agreed on a large spending package</a> to rescue their economies from the ruins caused by the pandemic. The $857 billion stimulus agreement will benefit nations hit hardest by the pandemic.</p>"
  },
  {
    "date": "01 Aug",
    "title": "The U.S. saw July cases more than double the total of any other month.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimelineAug2/merlin_174873531_a764dc5c-fc95-428e-a879-40cd1da60269-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimelineAug2/merlin_174873531_a764dc5c-fc95-428e-a879-40cd1da60269-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimelineAug2/merlin_174873531_a764dc5c-fc95-428e-a879-40cd1da60269-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The United States recorded more than 1.9 million new infections in July, nearly 42 percent of the more than 4.5 million cases reported nationwide since the pandemic began and more than double the number documented in any other month, according to data compiled by The New York Times. The previous monthly high to this point came in April, when more than 880,000 new cases were recorded.</p>"
  },
  {
    "date": "03 Aug",
    "title": "Trump addressed the death toll: ‘It is what it is.’",
    "desc": "<p>One day before the United States surpassed 150,000 deaths from the coronavirus, Mr. Trump appeared resigned to the toll, saying in an interview with Axios, “It is what it is.” </p>"
  },
  {
    "date": "11 Aug",
    "title": "The Big Ten and Pac-12 announced they would not play football in the fall.",
    "desc": "<p>College football split as the Big Ten and the Pac-12, two of the sport’s wealthiest and most powerful conferences, abandoned their plans to play in the fall during the coronavirus pandemic. The decision came as other top leagues stayed publicly poised to begin games in September. The Big Ten <a class=\"\" href=\"https://www.nytimes.com/2020/09/16/sports/ncaafootball/covid-big-ten-football-season.html\" title=\"\" target=\"blank\">reversed its decision</a> a month later, <a class=\"\" href=\"https://www.nytimes.com/2020/09/24/sports/ncaafootball/coronavirus-pac-12-restart.html\" title=\"\" target=\"blank\">followed by the Pac 12</a>.</p>"
  },
  {
    "date": "16 Aug",
    "title": "The C.D.C. began developing a plan to distribute a coronavirus vaccine.",
    "desc": "<p>The C.D.C. began consulting with California, Florida, Minnesota and North Dakota as well as Philadelphia to develop plans for distributing a coronavirus vaccine. The agency chose the communities for a pilot program because they represent different kinds of challenges as the U.S. government prepared to begin the largest such campaign ever undertaken.</p>"
  },
  {
    "date": "18 Aug",
    "title": "Universities that reopened soon began moving classes online.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ND/merlin_175872702_6aeab784-a158-49c9-af4d-570ac97cbbda-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ND/merlin_175872702_6aeab784-a158-49c9-af4d-570ac97cbbda-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ND/merlin_175872702_6aeab784-a158-49c9-af4d-570ac97cbbda-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The <a class=\"\" href=\"https://www.nytimes.com/2020/08/18/us/notre-dame-coronavirus.html\" title=\"\" target=\"blank\">University of Notre Dame </a>announced that it would move to online instruction for at least two weeks in an attempt curb a growing coronavirus outbreak. The day before, the University of North Carolina at Chapel Hill <a class=\"\" href=\"https://www.nytimes.com/2020/08/17/us/unc-chapel-hill-covid.html\" title=\"\" target=\"blank\">became the first large university</a> in the country to shut down classes after students had returned. Ithaca College in upstate New York extended remote learning through the fall semester and Michigan State told undergraduate students who had planned to live in campus housing to stay home.</p>"
  },
  {
    "date": "22 Aug",
    "title": "Global virus deaths surpassed 800,000.",
    "desc": "<p>The global death toll from the coronavirus <a class=\"\" href=\"https://www.nytimes.com/2020/08/22/world/covid-19-coronavirus.html#link-f35c214\" title=\"\" target=\"blank\">surpassed 800,000</a> on Aug. 22. The tally rose as new infections flared in Europe and high numbers of deaths were recorded in the United States, India, South Africa and most of Latin America.</p>"
  },
  {
    "date": "03 Sep",
    "title": "The virus surged at U.S. colleges, totaling more than 51,000 cases.",
    "desc": "<p>More than 51,000 cases of the coronavirus had been identified at American colleges and universities over the course of the pandemic, including thousands that had recently emerged as students returned to campus for the fall. The New York Times <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/us/covid-college-cases-tracker.html\" title=\"\" target=\"blank\">surveyed more than 1,500 colleges</a>, and found that over two-thirds had reported at least one case.</p>"
  },
  {
    "date": "06 Sep",
    "title": "India became the country with the second-highest number of cases with more than 4 million.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-INDIA/merlin_176685096_5c0affe8-416d-4039-9a80-2e9ccfd22b0f-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-INDIA/merlin_176685096_5c0affe8-416d-4039-9a80-2e9ccfd22b0f-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-INDIA/merlin_176685096_5c0affe8-416d-4039-9a80-2e9ccfd22b0f-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>India, home to the world’s fastest growing coronavirus outbreak, surpassed Brazil to become the country with the second-highest number of cases. The total number of cases in the country on Sept. 6 was more than 4.2 million. Brazil was then ranked third with more than 4.1 million cases.</p>"
  },
  {
    "date": "13 Sep",
    "title": "The Midwest saw a surge of new cases.",
    "desc": "<p>As cases began to fall in most parts of the United States, the <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/09/13/us/coronavirus-cases-midwest.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">rate of infection in the Midwest rose</a>, prompting alarm in places that had largely avoided the worst of the pandemic.</p>"
  },
  {
    "date": "18 Sep",
    "title": "Israel imposed a second national lockdown.",
    "desc": "<p>On Sept. 18, the eve of the Jewish New Year holiday, <a class=\"\" href=\"https://www.nytimes.com/2020/09/13/world/middleeast/israel-second-lockdown.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">Israel began a national lockdown</a> that extended for three weeks. It was a sign of the government’s failure to contain the spread of the coronavirus. The second lockdown came nearly four months after Israel’s first lockdown.</p>"
  },
  {
    "date": "22 Sep",
    "title": "The U.S. death toll surpassed 200,000.",
    "desc": "<p>The death toll in the United States from the coronavirus pandemic passed 200,000 on Sept. 22. More deaths had been announced in the United States than in any other country.</p>"
  },
  {
    "date": "28 Sep",
    "title": "Global deaths reached 1 million.",
    "desc": "<p>In the 10 months since a mysterious pneumonia began striking residents of Wuhan, China, Covid-19 had killed more than one million people worldwide — an agonizing toll compiled from official counts, yet one that far understates how many had really died.</p>"
  },
  {
    "date": "01 Oct",
    "title": "N.Y.C. was the first major U.S. city to reopen all its public schools for in-person learning.",
    "desc": "<p>New York City <a class=\"\" href=\"https://www.nytimes.com/2020/10/01/nyregion/nyc-coronavirus-schools-reopen.html\" title=\"\" target=\"blank\">reopened all of its public schools</a> on Oct. 1, a major step in its recovery from having been the global epicenter of the pandemic. (They <a class=\"\" href=\"https://www.nytimes.com/2020/11/18/nyregion/nyc-schools-covid.html\" title=\"\" target=\"blank\">would later close in November</a>.)</p>"
  },
  {
    "date": "02 Oct",
    "title": "President Trump tested positive for the virus.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Trump/13xp-virustimeline-Trump-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Trump/13xp-virustimeline-Trump-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Trump/13xp-virustimeline-Trump-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>President Trump said early on Oct. 2 that he and the first lady had <a class=\"\" href=\"https://www.nytimes.com/2020/10/02/us/politics/trump-covid.html\" title=\"\" target=\"blank\">tested positive for the coronavirus</a>, throwing the nation’s leadership into uncertainty and escalating the crisis posed by a pandemic that had already killed more than 207,000 Americans and devastated the economy.</p><p>Mr. Trump had a fever, congestion and a cough and was <a class=\"\" href=\"https://www.nytimes.com/2020/10/02/us/politics/trump-hospitalized-with-coronavirus.html\" title=\"\" target=\"blank\">hospitalized at Walter Reed National Military Medical Center</a>. He <a class=\"\" href=\"https://www.nytimes.com/2020/10/05/us/politics/trump-leaves-hospital-coronavirus.html\" title=\"\" target=\"blank\">returned to the White house</a> on Oct. 5.</p>"
  },
  {
    "date": "11 Oct",
    "title": "The world recorded more than 1 million new cases in three days.",
    "desc": "<p>The world recorded more than 1 million new cases of the coronavirus in just the last three days, the highest total ever in such a short span, a reflection of resurgences in Europe and the United States and uninterrupted outbreaks in India, Brazil and other countries.</p>"
  },
  {
    "date": "19 Oct",
    "title": "Belgium closed restaurants and imposed a curfew to halt a spike in cases.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Belgium/13xp-virustimeline-Belgium-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Belgium/13xp-virustimeline-Belgium-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-Belgium/13xp-virustimeline-Belgium-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Belgium imposed a nationwide curfew and shut all cafes, bars and restaurants for a month. The restrictions came while Europe faced a resurgence in cases and as Belgium had recorded more than 48,000 cases over the past seven days.</p>"
  },
  {
    "date": "24 Oct",
    "title": "Poland’s president tested positive.",
    "desc": "<p>President Andrzej Duda of Poland <a class=\"\" href=\"https://www.nytimes.com/2020/10/24/world/europe/covid-poland-president-duda.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">tested positive for the coronavirus</a> and went into isolation, officials said on Oct. 24. The announcement came amid a moment of crisis for Poland, which has been combating one of the most severe outbreaks in Europe, with hospital beds filling at an alarming rate.</p>"
  },
  {
    "date": "05 Nov",
    "title": "England entered a national lockdown.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UK/13xp-virustimeline-UK-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UK/13xp-virustimeline-UK-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UK/13xp-virustimeline-UK-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>Prime Minister Boris Johnson of Britain <a class=\"\" href=\"https://www.nytimes.com/2020/10/31/world/great-britain-coronavirus-lockdown.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">announced new restrictions</a> that went into effect on Nov. 5 and ended Dec. 2, including the closing of pubs, restaurants and most retail stores in England. The government’s scientific advisory panel, known as SAGE, estimated in a report dated Oct. 14 that there were between 43,000 and 75,000 new infections a day in England, a rate above the worst-case scenarios calculated only weeks before that.</p>"
  },
  {
    "date": "05 Nov",
    "title": "Coronavirus cases at U.S. colleges hit a quarter million.",
    "desc": "<p>A quarter of a million coronavirus infections were reported at colleges and universities across the United States, <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/us/covid-college-cases-tracker.html\" title=\"\" target=\"blank\">according to a New York Times survey</a>, as schools across the nation struggled to keep outbreaks in check. The bulk of the cases had occurred since students returned for the fall semester, but the numbers were most certainly an undercount.</p>"
  },
  {
    "date": "08 Nov",
    "title": "The U.S. surpassed 10 million infections.",
    "desc": "<p>The United States reached 10 million coronavirus cases on Nov. 8, with the last million added in 10 days time. The grim benchmark arrived as the country struggled to contain outbreaks in the third and most widespread wave of infection since the pandemic began.</p>"
  },
  {
    "date": "13 Nov",
    "title": "The C.D.C. said children’s visits to the emergency room for mental health had risen.",
    "desc": "<p>As states locked down to prevent the spread of the coronavirus and schools turned to remote learning, the number of emergency room visits for mental health reasons rose 31 percent among children ages 12 to 17, from March through October, compared with the same period last year, <a class=\"\" href=\"https://www.cdc.gov/mmwr/volumes/69/wr/mm6945a3.htm?s_cid=mm6945a3_w\" title=\"\" rel=\"noopener noreferrer\" target=\"blank\">according to a C.D.C. study</a>.</p>"
  },
  {
    "date": "17 Nov",
    "title": "F.D.A. authorized the first at-home coronavirus test.",
    "desc": "<p>The Food and Drug Administration green lit <a class=\"\" href=\"https://www.nytimes.com/2020/11/18/health/coronavirus-testing-home.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">the first rapid coronavirus test that could be completed at home</a>, without the need of a lab. The test, which was developed by Lucira Health, requires a prescription from a health care provider and can return results in about 30 minutes.</p>"
  },
  {
    "date": "18 Nov",
    "title": "The U.S. death toll hit 250,000.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ElPaso/merlin_180108651_1bd53c15-8eb9-49a1-b975-02a261a7a362-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ElPaso/merlin_180108651_1bd53c15-8eb9-49a1-b975-02a261a7a362-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-ElPaso/merlin_180108651_1bd53c15-8eb9-49a1-b975-02a261a7a362-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The United States on Nov. 18 reached yet another grim milestone, 250,000 coronavirus-related deaths. That number was expected to sharply increase as infections surged nationwide, particularly in the Midwest and Mountain States.</p>"
  },
  {
    "date": "21 Nov",
    "title": "The F.D.A. granted emergency authorization of the coronavirus antibody treatment given to President Trump.",
    "desc": "<p>The F.D.A. granted emergency authorization for the experimental antibody treatment, made by biotech company Regeneron and consisting of a cocktail of two powerful antibodies, given to President Trump shortly after he tested positive for the coronavirus. The approval gave doctors another option to treat patients as cases across the country continued to rise.</p>"
  },
  {
    "date": "02 Dec",
    "title": "The U.K. approved Pfizer’s coronavirus vaccine.",
    "desc": "<p>Britain <a class=\"\" href=\"https://www.nytimes.com/2020/12/02/world/europe/pfizer-coronavirus-vaccine-approved-uk.html\" title=\"\" target=\"blank\">gave emergency authorization on Dec. 2</a> to Pfizer’s coronavirus vaccine, leaping ahead of the United States to become the first Western country to allow mass inoculations.</p>"
  },
  {
    "date": "03 Dec",
    "title": "Biden said he will ask Americans to wear masks for 100 days.",
    "desc": "<p>President-elect Joseph R. Biden Jr. said that on his first day as president, he would ask Americans to wear masks for 100 days. “Just 100 days to mask,” Mr. Biden said in an interview on CNN. “Not forever. 100 days. And I think we’ll see a significant reduction.”</p>"
  },
  {
    "date": "08 Dec",
    "title": "The U.K. began vaccinations.",
    "src": "https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UKVax/merlin_180976803_c2e46e49-58a7-4223-abaf-fec6c24e2ec8-articleLarge.jpg?quality=90&auto=webp 600w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UKVax/merlin_180976803_c2e46e49-58a7-4223-abaf-fec6c24e2ec8-jumbo.jpg?quality=90&auto=webp 1024w,https://static01.nyt.com/images/2021/01/13/multimedia/13xp-virustimeline-UKVax/merlin_180976803_c2e46e49-58a7-4223-abaf-fec6c24e2ec8-superJumbo.jpg?quality=90&auto=webp 2048w",
    "desc": "<p>The first person <a class=\"\" href=\"https://www.nytimes.com/2020/12/08/world/europe/uk-vaccination-covid-virus.html\" title=\"\" target=\"blank\">to receive a coronavirus vaccination</a> in the U.K. was Margaret Keenan, a 90-year-old former jewelry shop assistant, followed by an 81-year-old man, William Shakespeare.</p>"
  },
  {
    "date": "11 Dec",
    "title": "The F.D.A. approved a vaccine by Pfizer.",
    "desc": "<p>The F.D.A. <a class=\"\" href=\"https://www.nytimes.com/2020/12/11/health/pfizer-vaccine-authorized.html?action=click&amp;module=RelatedLinks&amp;pgtype=Articlele=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">authorized Pfizer’s Covid-19 vaccine</a> for emergency use on Dec. 11, clearing the way for millions of highly vulnerable people to begin receiving the vaccine within days. The authorization was a historic turning point in a pandemic that had taken <a class=\"\" href=\"https://www.nytimes.com/interactive/2020/us/coronavirus-us-cases.html\" title=\"\" target=\"blank\">more than 290,000 lives</a> in the United States. The same vaccine was also approved by Mexico, Canada, Saudi Arabia and other countries.</p>"
  },
  {
    "date": "14 Dec",
    "title": "The U.S. death toll surpassed 300,000.",
    "desc": "<p>The coronavirus death toll in the United States <a class=\"\" href=\"https://www.nytimes.com/2020/12/14/us/covid-us-deaths.html\" title=\"\" target=\"blank\">surpassed 300,000 on Dec. 14</a>. It was another wrenching record that came less than four weeks after the nation’s virus deaths reached a quarter of a million. Covid-19 surpassed heart disease as the leading cause of death in the United States, the Centers for Disease Control and Prevention director Robert Redfield said.</p>"
  },
  {
    "date": "18 Dec",
    "title": "The F.D.A. approved Moderna’s Covid vaccine.",
    "desc": "<p>The F.D.A. authorized the Covid-19 vaccine <a class=\"\" href=\"https://www.nytimes.com/2020/12/18/health/covid-vaccine-fda-moderna.html?action=click&amp;module=RelatedLinks&amp;pgtype=Article\" title=\"\" target=\"blank\">made by Moderna</a> for emergency use, allowing the shipment of millions more doses across the nation.</p>"
  },
  {
    "date": "20 Dec",
    "title": "London entered a severe lockdown, ordered by Boris Johnson.",
    "desc": "<p>Alarmed by a new, <a class=\"\" href=\"https://www.nytimes.com/2020/12/19/world/europe/coronavirus-uk-new-variant.html\" title=\"\" target=\"blank\">faster-spreading variant of the coronavirus</a>, Prime Minister Boris Johnson abruptly imposed a wholesale lockdown on London and most of England’s southeast that began Dec. 20. Countries across Europe and beyond began closing their borders to travelers from the U.K.</p>"
  }
]}
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto&display=swap");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css");
html {
  font-size: 62.5%;
}

body,
html {
  padding: 0;
  margin: 0;
  min-height: 100vh;
  font-family: "Roboto", sans-serif;
}

* {
  box-sizing: border-box;
}

#main {
  display: flex;
  justify-content: center;
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  position: relative;
}
#main .background-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}
#main .background-image img {
  opacity: 0.2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
#main .default-background {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/funky-lines.png");
  opacity: 0.3;
}
#main #wrapper {
  transition: all 0.3s ease-in-out;
}
#main #wrapper .intro {
  height: 100vh;
  width: 100vw;
  display: flex;
  background-image: linear-gradient(0deg, #06beb6, #48b1bf);
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 3rem;
  color: #024240;
}
#main #wrapper .intro .credit-link {
  position: absolute;
  right: 1%;
  bottom: 1%;
  width: 15rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  opacity: 0.5;
  transition: all 0.3s ease-in-out;
}
#main #wrapper .intro .credit-link:hover {
  opacity: 0.8;
}
#main #wrapper .intro .credit-link::before {
  content: "SOURCE";
  font-size: 1.3rem;
  color: white;
}
#main #wrapper .intro .credit-link img {
  max-width: 100%;
}
#main #wrapper .intro .scroll-down {
  position: absolute;
  bottom: 1%;
  left: 50%;
  transform: translateX(-50%);
  animation: scroll-down 1s infinite linear;
}
#main #wrapper .intro .scroll-down span {
  transform: rotate(-90deg);
  display: block;
  color: white;
}
@keyframes scroll-down {
  0%, 100% {
    bottom: 3%;
  }
  50% {
    bottom: 1%;
  }
}
#main #wrapper .inner-wrapper {
  display: flex;
  justify-content: space-around;
  align-items: center;
  height: 100vh;
  width: 100vw;
  max-width: 1000px;
  overflow: hidden;
  margin: 0 auto;
}
#main #timeline {
  display: flex;
  height: 100%;
  position: relative;
  flex-direction: column;
  justify-content: center;
  align-items: flex-end;
  width: 15rem;
  flex-shrink: 0;
  margin: 0 2rem;
  z-index: 1;
}
#main #timeline .time {
  position: absolute;
  top: 0;
  left: 0;
  transition: all 0.3s ease-in-out;
  font-size: 2rem;
}
#main #timeline .line {
  background-color: #e74c3c;
  height: 0.3rem;
  width: 1.3rem;
  opacity: 0.3;
  transition: all 0.3s ease-in-out;
  margin: 0.2em 0;
}
#main #timeline .line.active {
  opacity: 1;
  width: 100%;
}
#main #timeline .line.pre-1, #main #timeline .line.post-1 {
  opacity: 1;
  width: 35%;
}
#main #timeline .line.pre-2, #main #timeline .line.post-2 {
  opacity: 1;
  width: 25%;
}
#main #timeline .line.pre-3, #main #timeline .line.post-3 {
  opacity: 1;
  width: 15%;
}
#main #timeline .line.active, #main #timeline .line.pre-1, #main #timeline .line.post-1, #main #timeline .line.pre-2, #main #timeline .line.post-2, #main #timeline .line.pre-3, #main #timeline .line.post-3 {
  margin: 0.1em 0;
}
#main #panel-wrapper {
  padding: 10rem;
  max-width: 100rem;
  z-index: 1;
}
#main #panel-wrapper .panel {
  flex-direction: column;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  font-size: 3rem;
}
#main #panel-wrapper .panel h1 {
  font-size: 3rem;
  margin-bottom: 0.8em;
  line-height: 1.7;
  text-align: left;
  display: flex;
  flex-direction: column;
}
#main #panel-wrapper .panel h1::after {
  width: 4rem;
  height: 0.3rem;
  border-radius: 0.3rem;
  background-color: black;
  content: "";
  margin: 2rem 0;
}
#main #panel-wrapper .panel .desc {
  font-size: 2rem;
  line-height: 1.7;
}
#main #panel-wrapper .panel .desc a {
  text-decoration: none;
  color: #3498db;
  position: relative;
  transition: all 0.2s;
}
#main #panel-wrapper .panel .desc a:hover {
  background-color: #a2dffb;
  color: black;
}

.in-enter-active,
.in-leave-active,
.out-enter-active,
.out-leave-active {
  transition: all 0.3s ease-in-out -0.1s;
}

.in-leave-to,
.out-enter {
  opacity: 0;
  transform: scale(0.7);
}

.in-enter,
.out-leave-to {
  transform: scale(1.3);
  opacity: 0;
}

.in-enter-to,
.out-enter-to {
  transform: scale(1);
  opacity: 1;
}
</style>
</body>
</html>
