
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
  <h1
    v-if="!loggedIn && !isPhone"
    class="bg-gradient-to-r from-blue-600 to-red-600 bg-gray-200 text-2xl md:text-3xl text-center text-white py-4 mt-6"
  >
    Incident Heatmap: Yearly Overview of Crime Locations in Ormoc City
  </h1>

  <div
    class="rounded shadow-lg w-full relative"
    style="height: 85vh"
    :class="{ '': $store.getters.theme, '': !$store.getters.theme }"
  >
    <section class="text-gray-600 body-font relative w-full h-full">
      <div id="residentMap" class="absolute inset-0 bg-gray-100"></div>
    </section>
    <div
      class="mb-2 py-2 top-3 crimeHeatMap md:hidden sm:hidden absolute w-3/4 grid-cols-3 bg-gray-50 text-center rounded-md border-2 border-gray-600"
      style="right: 10%"
    >
      <span class="font-serif font-semibold text-center text-red-600 underline"
        >CRIME HEAT MAP</span
      >
    </div>
  </div>

  <h1
    v-if="loggedIn && !isPhone"
    class="bg-gray-200 text-2xl md:text-3xl text-center text-black py-5 border-b border-black"
  >
    Incident Heatmap: Yearly Overview of Crime Locations in Ormoc City
  </h1>
  <span class="px-10 pt-10 text-center flex bg-blue-300 py-2">
    <h1
      class="text-3xl bg-white w-full py-2 border md:text-4xl text-center text-gray-700 uppercase"
    >
      Graphical Insights
    </h1>
  </span>

  <div
    v-if="!loggedIn"
    class="bg-gradient-to-b from-blue-300 to to-blue-100 shadow border-gray-400 w-full 2xl:px-32 md:px-0"
    style="height: 250vh"
  >
    <!-- graphs -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="p-6">
        <!-- Line Chart -->
        <div class="w-full mb-4">
          <line-charts v-motion-slide-visible-top></line-charts>
        </div>
        <!-- Description -->
        <div class="text-center">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">
            30-Day Incident Overview
          </h2>
          <p class="text-gray-600">
            This chart visualizes crime incidents reported over the last 30
            days, giving a real-time view of the city's safety trends.
          </p>
        </div>
      </div>
    </div>

    <bar-graphs v-motion-slide-visible-top></bar-graphs>
    <div class="w-full bg-white rounded-md">
      <h1
        class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
        v-motion-slide-visible-top
      >
        VICTIMS
      </h1>
      <div
        class="xl:flex 2xl:flex md:grid md:grid-cols-1 xl:flex-row 2xl:flex-row md:flex-col gap-2 px-2"
      >
        <pc-gender-victim
          class="w-full border"
          :ids="'victimGenderPie'"
          v-motion-slide-visible-top
        ></pc-gender-victim>
        <pc-victim-age
          class="w-full border"
          :ids="'victimAgePie'"
          v-motion-slide-visible-top
        ></pc-victim-age>
      </div>
    </div>
    <div class="w-full bg-white rounded-md mt-3">
      <h1
        class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
        v-motion-slide-visible-top
      >
        SUSPECTS
      </h1>
      <div
        class="xl:flex 2xl:flex md:grid md:grid-cols-1 xl:flex-row 2xl:flex-row md:flex-col gap-2 px-2"
      >
        <pc-gender-suspect
          class="w-full border"
          :ids="'suspectGenderPie'"
          v-motion-slide-visible-top
        ></pc-gender-suspect>
        <pc-suspect-age
          class="w-full border"
          :ids="'suspectAgePie'"
          v-motion-slide-visible-top
        ></pc-suspect-age>
      </div>
    </div>
    <!-- <div class="h-60"></div> -->

    <researchers v-if="!loggedIn && !isPhone"></researchers>
    <researchers-phone v-if="!loggedIn && isPhone" />
  </div>
  <div
    v-if="loggedIn"
    class="bg-gradient-to-b from-blue-300 to to-blue-100 shadow border-gray-400 w-full 2xl:px-32 md:px-0"
    style="height: 200vh"
  >
    <!-- graphs -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="p-6">
        <!-- Line Chart -->
        <div class="w-full mb-4">
          <line-charts v-motion-slide-visible-top></line-charts>
        </div>
        <!-- Description -->
        <div class="text-center">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">
            30-Day Incident Overview
          </h2>
          <p class="text-gray-600">
            This chart visualizes crime incidents reported over the last 30
            days, giving a real-time view of the city's safety trends.
          </p>
        </div>
      </div>
    </div>

    <bar-graphs v-motion-slide-visible-top></bar-graphs>
    <div class="w-full bg-white rounded-md">
      <h1
        class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
        v-motion-slide-visible-top
      >
        VICTIMS
      </h1>
      <div
        class="xl:flex 2xl:flex md:grid md:grid-cols-1 xl:flex-row 2xl:flex-row md:flex-col gap-2 px-2"
      >
        <pc-gender-victim
          class="w-full border"
          :ids="'victimGenderPie'"
          v-motion-slide-visible-top
        ></pc-gender-victim>
        <pc-victim-age
          class="w-full border"
          :ids="'victimAgePie'"
          v-motion-slide-visible-top
        ></pc-victim-age>
      </div>
    </div>
    <div class="w-full bg-white rounded-md mt-3">
      <h1
        class="bg-white p-4 text-xl text-center border-b-2 font-bold rounded-t-md"
        v-motion-slide-visible-top
      >
        SUSPECTS
      </h1>
      <div
        class="xl:flex 2xl:flex md:grid md:grid-cols-1 xl:flex-row 2xl:flex-row md:flex-col gap-2 px-2"
      >
        <pc-gender-suspect
          class="w-full border"
          :ids="'suspectGenderPie'"
          v-motion-slide-visible-top
        ></pc-gender-suspect>
        <pc-suspect-age
          class="w-full border"
          :ids="'suspectAgePie'"
          v-motion-slide-visible-top
        ></pc-suspect-age>
      </div>
    </div>
    <!-- <div class="h-60"></div> -->

    <researchers v-if="!loggedIn && !isPhone"></researchers>
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
