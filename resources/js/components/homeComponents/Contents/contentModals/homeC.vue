
<style>
.redM {
  position: absolute;
  width: 15px;
  height: 15px;
  background-color: red;
  border-radius: 50%;
  cursor: pointer;
}

.yellowM {
  position: absolute;
  width: 15px;
  height: 15px;
  background-color: rgb(255, 132, 0);
  border-radius: 50%;
  cursor: pointer;
}
@keyframes pulse {
  0% {
    transform: scale(0.5);
    opacity: 0.8;
  }
  50% {
    transform: scale(1.5);
    opacity: 0;
  }
  100% {
    transform: scale(0.5);
    opacity: 0.8;
  }
}
@keyframes blink {
  0% {
    opacity: 0.8;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 0.8;
  }
}

.crimeHeatMap {
  display: none;
}

@media (min-width: 769px) {
  .crimeHeatMap {
    display: block;
  }
}
</style>
<template>
  <title-phone v-if="!loggedIn && isPhone" />
  <used-tech-phone  v-if="!loggedIn && isPhone" />
  <title-e v-if="!loggedIn && !isPhone"></title-e>
  <used-tech v-if="!loggedIn && !isPhone"></used-tech>


  <div class="relative w-full h-[85vh] rounded-lg shadow-xl overflow-hidden">
    <section class="absolute inset-0">
      <div id="residentMap" class="w-full h-full bg-gray-100"></div>
    </section>
    <div class="pointer-events-none absolute top-0 left-0 right-0 z-10 p-4 bg-gradient-to-b from-black/50 to-transparent">
      <h2 class="text-2xl font-bold text-white text-center">
        Crime Heat Map
      </h2>
    </div>
    <div class="absolute bottom-4 right-4 z-10">
      <div class="bg-white rounded-lg shadow-md p-3">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Legend</h3>
        <div class="flex items-center space-x-2">
          <span class="w-4 h-4 rounded-full bg-red-500"></span>
          <span class="text-xs text-gray-600">Emeregency Reports</span>
        </div>
        <div class="flex items-center space-x-2 mt-1">
          <span class="w-4 h-4 rounded-full bg-yellow-500"></span>
          <span class="text-xs text-gray-600">None Emergency Reports</span>
        </div>
      </div>
    </div>
  </div>
  <div
    v-if="loggedIn && !isPhone"
    class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8 px-4 shadow-lg rounded-b-lg"
  >
    <h1 class="text-3xl md:text-4xl font-bold text-center mb-2">
      Incident Heatmap
    </h1>
    <p class="text-lg md:text-xl text-center text-blue-100">
      Yearly Overview of Crime Locations in Ormoc City
    </p>
  </div>
  <section v-if="!loggedIn" class="py-t bg-gradient-to-b from-blue-100/70 to-white/70 ">
    <div class="container mx-auto px-4">
      <div class="bg-gradient-to-r from-blue-100 to-blue-200 py-16 mt-12 rounded-lg shadow-md">
        <h2 class="text-4xl md:text-5xl font-bold text-center text-blue-800 mb-6 animate-fade-in-down">
          Dynamic Crime Analytics Dashboard
        </h2>
        <p class="text-xl text-center text-blue-600 mb-8 animate-fade-in-up">
          Explore real-time visualizations of crime data to gain actionable insights
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Line Chart -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <div class="p-6">
            <line-charts v-motion-slide-visible-left></line-charts>
            <div class="mt-6 text-center">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                30-Day Incident Overview
              </h3>
              <p class="text-gray-600">
                Visualizing crime incidents over the last 30 days, providing real-time insights into our city's safety trends.
              </p>
            </div>
          </div>
        </div>

        <!-- Bar Graphs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <div class="p-6">
            <bar-graphs v-motion-slide-visible-right></bar-graphs>
            <div class="mt-6 text-center">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Crime Type Distribution
              </h3>
              <p class="text-gray-600">
                Breakdown of various crime types, helping identify patterns and focus areas for law enforcement.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Victims Section -->
      <div class="mt-16 bg-white rounded-lg shadow-lg overflow-hidden ">
        <h2 class="bg-blue-600 text-white p-4 text-2xl font-bold text-center">
          Victim Demographics
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <div v-motion-slide-visible-left>
            <pc-gender-victim class="w-full" :ids="'victimGenderPie'"></pc-gender-victim>
            <div class="mt-4 text-center">
              <svg class="w-6 h-6 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <p class="text-gray-700 font-semibold">Gender Distribution</p>
              <p class="text-sm text-gray-600">Analyzing the gender breakdown of reported victims to identify potential vulnerabilities and tailor prevention strategies.</p>
            </div>
          </div>
          <div v-motion-slide-visible-right>
            <pc-victim-age class="w-full" :ids="'victimAgePie'"></pc-victim-age>
            <div class="mt-4 text-center">
              <svg class="w-6 h-6 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <p class="text-gray-700 font-semibold">Age Group Analysis</p>
              <p class="text-sm text-gray-600">Examining the age distribution of victims to understand which groups are most at risk and focus community outreach efforts.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Suspects Section -->
      <div class="mt-16 bg-white rounded-lg shadow-lg overflow-hidden">
        <h2 class="bg-red-600 text-white p-4 text-2xl font-bold text-center">
          Suspect Demographics
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <div v-motion-slide-visible-left>
            <pc-gender-suspect class="w-full" :ids="'suspectGenderPie'"></pc-gender-suspect>
            <p class="mt-4 text-center text-gray-600">Gender breakdown of reported suspects</p>
          </div>
          <div v-motion-slide-visible-right>
            <pc-suspect-age class="w-full" :ids="'suspectAgePie'"></pc-suspect-age>
            <p class="mt-4 text-center text-gray-600">Age distribution analysis of suspects</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-16">
      <researchers v-if="!loggedIn && !isPhone" v-motion-slide-visible-bottom></researchers>
      <researchers-phone v-if="!loggedIn && isPhone" v-motion-slide-visible-bottom />
    </div>
  </section>
  <div v-if="loggedIn" class="bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-extrabold text-center text-blue-900 mb-16 animate-fade-in-down">
        Graphical Insights
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:mb-12 lg:mb-12">
        <!-- Line Chart -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <div class="p-6">
            <line-charts v-motion-slide-visible-left></line-charts>
            <div class="mt-6 text-center">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                30-Day Incident Overview
              </h3>
              <p class="text-gray-600">
                Visualizing crime incidents over the last 30 days, providing real-time insights into our city's safety trends.
              </p>
            </div>
          </div>
        </div>

        <!-- Bar Graphs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <div class="p-6">
            <bar-graphs v-motion-slide-visible-right></bar-graphs>
            <div class="mt-6 text-center">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Crime Type Distribution
              </h3>
              <p class="text-gray-600">
                Breakdown of various crime types, helping identify patterns and focus areas for law enforcement.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Victims Section -->
      <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-12">
        <h2 class="bg-blue-600 text-white p-5 text-2xl font-bold text-center">
          Victim Demographics
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="transform hover:scale-105 transition-all duration-300" v-motion-slide-visible-left>
            <pc-gender-victim class="w-full" :ids="'victimGenderPie'"></pc-gender-victim>
            <p class="mt-4 text-center text-gray-600 font-medium">Gender Distribution of Reported Victims</p>
          </div>
          <div class="transform hover:scale-105 transition-all duration-300" v-motion-slide-visible-right>
            <pc-victim-age class="w-full" :ids="'victimAgePie'"></pc-victim-age>
            <p class="mt-4 text-center text-gray-600 font-medium">Age Group Analysis of Victims</p>
          </div>
        </div>
      </div>

      <!-- Suspects Section -->
      <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <h2 class="bg-red-600 text-white p-5 text-2xl font-bold text-center">
          Suspect Demographics
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="transform hover:scale-105 transition-all duration-300" v-motion-slide-visible-left>
            <pc-gender-suspect class="w-full" :ids="'suspectGenderPie'"></pc-gender-suspect>
            <p class="mt-4 text-center text-gray-600 font-medium">Gender Breakdown of Reported Suspects</p>
          </div>
          <div class="transform hover:scale-105 transition-all duration-300" v-motion-slide-visible-right>
            <pc-suspect-age class="w-full" :ids="'suspectAgePie'"></pc-suspect-age>
            <p class="mt-4 text-center text-gray-600 font-medium">Age Distribution Analysis of Suspects</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import lineCharts from "./homeC/lineCharts.vue";
import BarGraphs from "./homeC/barGraphs.vue";
import pcGenderVictim from "./homeC/victims/pieChartsMF.vue";
import pcVictimAge from "./homeC/victims/pieChartsAge.vue";
import pcGenderSuspect from "./homeC/Suspects/sPieChartsMF.vue";
import pcSuspectAge from "./homeC/Suspects/sPieChartsAge.vue";
import titleE from "./homeC/title.vue";
import UsedTech from "./homeC/usedTech.vue";
import researchers from "./homeC/researchers.vue";
import titlePhone from "./homeC/titlePhone.vue";
import usedTechPhone from "./homeC/usedTechPhone.vue";
import researchersPhone from "./homeC/researchersPhone.vue";

export default {
  components: {
    lineCharts,
    BarGraphs,
    pcGenderVictim,
    pcVictimAge,
    pcSuspectAge,
    pcGenderSuspect,
    titleE,
    UsedTech,
    researchers,
    titlePhone,
    usedTechPhone,
    researchersPhone
  },
  data() {
    return {
      data: { markers: [] },
      months: [
        "JAN",
        "FEB",
        "MAR",
        "APR",
        "MAY",
        "JUN",
        "JUL",
        "AUG",
        "SEP",
        "OCT",
        "NOV",
        "DEC",
      ],
    };
  },
  mounted() {
    //this.initializeMap()
    //console.log(document.head)
    (async () => {
      await this.generateData();
      await this.loadGoogleMapsScript();
      await this.initializeMap();
    })();
  },
  methods: {
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/citizen/heat/map/marker/Display",
        data: {},
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.markers.push({
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
            location: data[i]["location"],
            suspects: data[i]["suspects"],
            victims: data[i]["victims"],
            name: data[i]["name"],
            report_type: data[i]["report_type"],
            date:
              this.months[parseInt(data[i]["month"]) - 1] +
              ", " +
              data[i]["date"],
          });
          //console.log(data[i]["message"],data[i]["location"],data[i]["name"],data[i]["contact"])
        }
      } else {
        alert("Error!");
      }
    },
    async loadGoogleMapsScript() {
      return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src =
          "https://maps.googleapis.com/maps/api/js?key=AIzaSyCKwTfAEpVXgkBBrCcLkHGNzwy9sf4WkWM";
        script.async = true;
        script.defer = true;
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
      });
    },
    initializeMap() {
      const location = { lat: 11.005, lng: 124.6077 };
      const map = new google.maps.Map(document.getElementById("residentMap"), {
        zoom: 12,
        center: location,
      });

      this.data.markers.forEach((mark) => {
        // Custom Overlay for animated marker
        const markerIcon = new google.maps.OverlayView();
        markerIcon.onAdd = function () {
          const layer = document.createElement("div");
          layer.classList.add(mark.report_type == 1 ? "redM" : "yellowM");

          // Marker info
          let bg =
            mark.report_type == 1
              ? "border-red-600 bg-red-100"
              : "border-yellow-600 bg-yellow-100";
          let infoWindow = new google.maps.InfoWindow({
            content: `
            <div class="p-4 rounded-lg shadow-lg max-w-xs border-2 ${bg}">
              <h1 class="font-bold text-lg mb-2">Incident Information:</h1>
              <p><span class="font-semibold">INCIDENT: </span> ${mark.name}</p>
              <p><span class="font-semibold">LOCATION: </span> ${mark.location}</p>
              <p><span class="font-semibold">DATE: </span> ${mark.date}</p>
              <p><span class="font-semibold">NO. OF SUSPECTS: </span> ${mark.suspects}</p>
              <p><span class="font-semibold">NO. OF VICTIMS: </span> ${mark.victims}</p>
            </div>
            `,
          });

          layer.addEventListener("click", () => {
            infoWindow.open(map, marker);
          });

          const panes = this.getPanes();
          panes.overlayMouseTarget.appendChild(layer);

          this.div = layer;
        };
        markerIcon.draw = function () {
          const projection = this.getProjection();
          const position = projection.fromLatLngToDivPixel(
            new google.maps.LatLng(mark.pos.lat, mark.pos.lng)
          );
          const div = this.div;
          div.style.left = position.x + "px";
          div.style.top = position.y + "px";
        };
        markerIcon.setMap(map);

        // Dummy marker to keep the InfoWindow functionality
        const marker = new google.maps.Marker({
          position: mark.pos,
          map: map,
          visible: false,
        });

        marker.addListener("click", function () {
          infoWindow.open(map, marker);
        });
      });
    },
    checkIfLogged() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return credentials.user_level == 3;
      }
    },
  },
  computed: {
    loggedIn() {
      const logged = this.checkIfLogged();

      return logged;
    },
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>
