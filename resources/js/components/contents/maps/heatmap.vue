
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
</style>
<template>
  <div class="flex flex-col items-center">
    <div
      class="w-full max-w-screen-xl px-4 py-6 bg-white rounded-lg shadow-lg mb-6"
    >
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="w-full md:w-auto flex gap-4 mb-4 md:mb-0">
          <input
            type="date"
            v-model="filter.date_start"
            class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out hover:border-blue-400"
          />
          <input
            type="date"
            v-model="filter.date_end"
            class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out hover:border-blue-400"
          />
        </div>
        <div class="flex gap-4">
          <div class="relative">
            <button
              v-if="!(incidentToggle && !barangayToggle)"
              @click="toggleI"
              class="bg-white hover:bg-blue-100 text-gray-700 font-semibold py-2 px-4 border border-blue-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
              :disabled="barangayToggle"
            >
              SELECT INCIDENT
              <svg
                class="h-5 w-5 ml-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div
              v-else-if="incidentToggle && !barangayToggle"
              class="relative my-auto w-64 rounded-md"
            >
              <incident-lists :toggle="toggleI" :setIncident="selectIncident" />
            </div>
          </div>
          <div class="relative">
            <button
              v-if="!(barangayToggle && !incidentToggle) && cred['user_level'] == 1"
              @click="toggleB"
              class="bg-white hover:bg-blue-100 text-gray-700 font-semibold py-2 px-4 border border-blue-300 rounded-lg shadow transition duration-300 ease-in-out flex items-center"
              :disabled="incidentToggle"
            >
              SELECT BARANGAY
              <svg
                class="h-5 w-5 ml-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div
              v-else-if="barangayToggle && !incidentToggle"
              class="w-64 rounded-md relative"
            >
              <barangayLists :setAddress="setAddress2" :toggle="toggleB" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="w-full max-w-screen-xl bg-white rounded-lg shadow-lg overflow-hidden"
    >
      <div class="w-full h-[65vh]">
        <section class="relative w-full h-full">
          <div id="heatMap" class="absolute inset-0 bg-gray-300"></div>
        </section>
      </div>
    </div>
    <button @click="removeAllMarkers">test</button>
  </div>
</template>

<script>
import incidentLists from "../Analytics/Prescriptive/incidents/filters/incidentLists.vue";
import barangayLists from "../Analytics/Prescriptive/incidents/filters/barangaylists.vue";
export default {
  components: {
    incidentLists,
    barangayLists,
  },
  mounted() {

    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.cred = credentials;
    (async () => {
      await this.generateData();
      await this.loadGoogleMapsScript();
      await this.initializeMap();
    })();
  },
  data() {
    return {
      data: { markers: [] },
      filter: {
        date_start: "",
        date_end: "",
        barangay: "",
        incident: "",
      },
      map: null,
      markers: [],
      barangayToggle: false,
      incidentToggle: false,
      searchQuery: "",
      cred: {}
    };
  },
  methods: {
    initializeMap() {
      const location = { lat: 11.005, lng: 124.6077 };
      this.map = new google.maps.Map(document.getElementById("heatMap"), {
        zoom: 12,
        center: location,
      });

      this.loadMarkers();
    },
    removeAllMarkers() {
      if (this.markers.length > 0) {
        console.log(this.markers);
        this.markers.forEach((marker) => {
          marker.setVisible(false);
          setTimeout(() => {
            marker.setMap(null);
          }, 50);
        });

        this.markers = [];
      } else {
      }
      this.users = [];
    },
    loadMarkers() {
      this.removeAllMarkers(); // Clear existing markers before adding new ones
      this.data.markers.forEach((mark) => {
        const markerIcon = new google.maps.Marker({
          position: new google.maps.LatLng(mark.pos.lat, mark.pos.lng),
          map: this.map,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: mark.report_type == 1 ? "#ff0000" : "#ff8400",
            fillOpacity: 0.8,
            strokeWeight: 2,
            strokeColor: mark.report_type == 1 ? "#ff0000" : "#ff8400",
          },
        });

        this.markers.push(markerIcon);

        const bg =
          mark.report_type == 1
            ? "border-red-600 bg-red-100"
            : "border-yellow-600 bg-yellow-100";

        const infoWindow = new google.maps.InfoWindow({
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
                <span class="text-sm font-semibold text-gray-800">${
                  mark.incident_type
                }</span>
              </div>
              <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                <span class="text-sm font-medium text-gray-500">Status</span>
                <span class="text-sm font-semibold ${
                  mark.status === "under investigation"
                    ? "text-blue-600"
                    : "text-green-600"
                }">${mark.status}</span>
              </div>
              <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                <span class="text-sm font-medium text-gray-500">Date & Time</span>
                <span class="text-sm font-semibold text-gray-800">${
                  mark.month
                } ${mark.date}, ${mark.time}</span>
              </div>
              <div class="border-b border-gray-200 pb-2">
                <span class="text-sm font-medium text-gray-500">Location</span>
                <p class="text-sm text-gray-800 mt-1">${mark.location}</p>
              </div>
              <div>
                <span class="text-sm font-medium text-gray-500">Message</span>
                <p class="text-sm text-gray-800 mt-1">${
                  mark.message || "No message provided"
                }</p>
              </div>
            </div>
          </div>
        `,
        });

        markerIcon.addListener("click", () => {
          infoWindow.open(this.map, markerIcon);
        });
      });
    },toggleI(){
      this.incidentToggle = !this.incidentToggle;
    },
    selectIncident(param){
      this.filter.incident = param;
      this.toggleI();
    },toggleB(){
      this.barangayToggle = !this.barangayToggle;
    },
    setAddress2(param){
      this.filter.barangay = param;
      this.toggleB();
    },
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/heat/map/marker/Display",
        data: {id: this.cred['id'], filter: this.filter },
      });
      this.data.markers = [];

      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.markers.push({
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
            message: data[i]["message"],
            location: data[i]["location"],
            name: data[i]["name"],
            con_no: data[i]["contact"],
            report_type: data[i]["report_type"],
            incident_type: data[i]["incident_type"],
            status: data[i]["status"],
            time: data[i]["time"],
            month: data[i]["month"],
            date: data[i]["date"],
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
    async searchIncident() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/heat/map/marker/Display",
        data: {id: this.cred['id'], searchQuery: this.searchQuery },
      });
      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.markers.push({
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
          });
        }
      } else {
        alert("Error!");
      }
    },
    async sendFilter() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/heat/map/marker/Display",
        data: { id: this.cred['id'],filter: this.filter },
      });

      if (dt["response"] == "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data.markers.push({
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
            message: data[i]["message"],
            location: data[i]["location"],
            name: data[i]["name"],
            con_no: data[i]["contact"],
            report_type: data[i]["report_type"],
          });
        }
      } else {
        alert("Error!");
      }
    },
    focusOnMarker(marker) {
      const position = new google.maps.LatLng(marker.pos.lat, marker.pos.lng);
      this.active = marker.ctr;
      this.map.setCenter(position);
    },
  },
  watch: {
    searchQuery: function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.searchIncident();
      }
    },
    "filter.date_start": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.loadMarkers();
        })();
      }
    },
    "filter.date_end": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.loadMarkers();
        })();
      }
    },
    "filter.barangay": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.loadMarkers();
        })();
      }
    },
    "filter.incident": function (newVal, oldVal) {
      if (newVal != oldVal) {
        (async () => {
          await this.generateData();
          await this.loadMarkers();
        })();
      }
    },
  },
};
</script>