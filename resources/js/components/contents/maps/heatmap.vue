
<style>
.redM {
  position: absolute;
  width: 15px;
  height: 15px;
  background-color: red;
  border-radius: 50%;
  cursor: pointer;
}

.mark__against-person, .mark__against-property, .mark__non-index-crimes, .mark__special-laws, .mark__traffic-incidents{

  width: 25px;
  height: 25px;
}

.mark__against-person {
  position: absolute;
  background-color: red; /* Color for 'AGAINST PERSON' incidents */
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke-width='2' stroke='white' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Ccircle cx='9' cy='7' r='4' /%3E%3Cpath d='M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2'/%3E%3Cline x1='19' y1='7' x2='19' y2='10' /%3E%3Cline x1='19' y1='14' x2='19' y2='14.01' /%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 1.5em;
  background-position: center; /* Center the SVG */
  cursor: pointer;
}

.mark__against-property {
  position: absolute;
  background-color: rgb(255, 132, 0); /* Color for 'AGAINST PROPERTY' incidents */
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M19.69 14a6.9 6.9 0 0 0 .31-2V5l-8-3-3.16 1.18'/%3E%3Cpath d='M4.73 4.73L4 5v7c0 6 8 10 8 10a20.29 20.29 0 0 0 5.62-4.38'/%3E%3Cline x1='1' y1='1' x2='23' y2='23' /%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 1.5em;
  background-position: center;
  cursor: pointer;
}

.mark__non-index-crimes {
  position: absolute;
  background-color: yellow; /* Color for 'NON-INDEX CRIMES' incidents */
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke-width='2' stroke='white' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3'/%3E%3Ccircle cx='16' cy='8' r='3' /%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 1.5em;
  background-position: center;
  cursor: pointer;
}

.mark__traffic-incidents {
  position: absolute;
  background-color: blue; /* Color for 'TRAFFIC INCIDENTS' */
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke-width='2' stroke='white' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Ccircle cx='7' cy='17' r='2' /%3E%3Ccircle cx='17' cy='17' r='2' /%3E%3Cpath d='M5 17h-2v-11a1 1 0 0 1 1 -1h9v6h-5l2 2m0 -4l-2 2'/%3E%3Cpath d='M9 17h6'/%3E%3Cpath d='M13 6h5l3 5v6h-2'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 1.5em;
  background-position: center;
  cursor: pointer;
}

.mark__special-laws {
  position: absolute;
  background-color: green; /* Color for 'SPECIAL LAWS' */
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z'/%3E%3Cpath d='M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z'/%3E%3Cpath d='M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z'/%3E%3Cpath d='M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z'/%3E%3Cpath d='M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z'/%3E%3Cpath d='M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z'/%3E%3Cpath d='M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z'/%3E%3Cpath d='M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 1.5em;
  background-position: center;
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
      this.data.markers.forEach((mark) => {
        const markerIcon = new google.maps.OverlayView();
        markerIcon.onAdd = function () {
          const layer = document.createElement("div");
          layer.classList.add(mark.secured ? "secured-dot" : mark.category == "AGAINST PERSONS" ? "mark__against-person" : mark.category == "AGAINST PROPERTY" ? "mark__against-property" : mark.category == "NON-INDEX CRIMES" ? "mark__non-index-crimes" : mark.category == "TRAFFIC INCIDENTS" ? "mark__traffic-incidents" : mark.category == "SPECIAL LAWS" ? "mark__special-laws" : "pulsing2");

          layer.addEventListener("click", () => {
            infoWindow.open(this.map, marker);
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

        markerIcon.setMap(this.map);

        const marker = new google.maps.Marker({
          position: mark.pos,
          map: this.map,
          visible: false,
        });

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

        marker.addListener("click", () => {
          infoWindow.open(this.map, marker);
        });
      });
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
            category: data[i]["category"]
          });
          //console.log(data[i]["message"],data[i]["location"],data[i]["name"],data[i]["contact"])
        }
      } else {
        alert("Error!");
      }
    },
    toggleI(){
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