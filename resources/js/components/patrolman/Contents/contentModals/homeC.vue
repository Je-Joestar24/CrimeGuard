
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
  <div class="relative w-full h-[55vh] rounded-lg shadow-xl overflow-hidden">
    <section class="absolute inset-0">
      <div id="patrolmanMap" class="w-full h-full bg-gray-100"></div>
    </section>
    <div
      class="pointer-events-none absolute top-0 left-0 right-0 z-10 p-4 bg-gradient-to-b from-black/50 to-transparent"
    >
      <h2 class="text-2xl font-bold text-white text-center">Tracker</h2>
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
  <div class="bg-black m-2 rounded-sm">
    <div class="flex p-2 gap-2">
      <button
        type="button"
        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
      >
        Incident</button
      ><button
        type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full"
      >
        Ally</button
      ><button
        type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full"
      >
        Citizen
      </button>
    </div>
    <div class="p-1 bg-gray-600">
      <div class="h-[25vh] p-1 bg-violet-50 rounded-lg overflow-auto">
        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
           <li class="pb-3 sm:pb-4">
              <div class="flex items-center space-x-4 rtl:space-x-reverse">
                 <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                       Neil Sims
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                       email@flowbite.com
                    </p>
                 </div>
                 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    $320
                 </div>
              </div>
           </li>
           <li class="py-3 sm:py-4">
              <div class="flex items-center space-x-4 rtl:space-x-reverse">
                 <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Neil image">
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                       Bonnie Green
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                       email@flowbite.com
                    </p>
                 </div>
                 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    $3467
                 </div>
              </div>
           </li>
           <li class="py-3 sm:py-4">
              <div class="flex items-center space-x-4 rtl:space-x-reverse">
                 <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-2.jpg" alt="Neil image">
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                       Michael Gough
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                       email@flowbite.com
                    </p>
                 </div>
                 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    $67
                 </div>
              </div>
           </li>
           <li class="py-3 sm:py-4">
              <div class="flex items-center space-x-4 rtl:space-x-reverse">
                 <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="Neil image">
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                       Thomas Lean
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                       email@flowbite.com
                    </p>
                 </div>
                 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    $2367
                 </div>
              </div>
           </li>
           <li class="pt-3 pb-0 sm:pt-4">
              <div class="flex items-center space-x-4 rtl:space-x-reverse">
                 <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-4.jpg" alt="Neil image">
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                       Lana Byrd
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                       email@flowbite.com
                    </p>
                 </div>
                 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    $367
                 </div>
              </div>
           </li>
        </ul>
        
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  components: {},
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
      const map = new google.maps.Map(document.getElementById("patrolmanMap"), {
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
            <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-sm border-l-4 ${
              bg === "border-red-600 bg-red-100"
                ? "border-red-600"
                : "border-yellow-600"
            }">
              <div class="bg-gradient-to-r ${
                bg === "border-red-600 bg-red-100"
                  ? "from-red-500 to-red-600"
                  : "from-yellow-500 to-yellow-600"
              } px-4 py-3">
                <h2 class="text-xl font-bold text-white">Incident Details</h2>
              </div>
              <div class="p-4 space-y-3">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                  <span class="text-sm font-medium text-gray-500">Incident</span>
                  <span class="text-sm font-semibold text-gray-800">${
                    mark.name
                  }</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                  <span class="text-sm font-medium text-gray-500">Date</span>
                  <span class="text-sm font-semibold text-gray-800">${
                    mark.date
                  }</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                  <span class="text-sm font-medium text-gray-500">Suspects</span>
                  <span class="text-sm font-semibold text-gray-800">${
                    mark.suspects
                  }</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                  <span class="text-sm font-medium text-gray-500">Victims</span>
                  <span class="text-sm font-semibold text-gray-800">${
                    mark.victims
                  }</span>
                </div>
                <div>
                  <span class="text-sm font-medium text-gray-500">Location</span>
                  <p class="text-sm text-gray-800 mt-1">${mark.location}</p>
                </div>
              </div>
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
