
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
  <div class="m-2 rounded-sm bg-white shadow-lg">
    <div class="flex p-t-2 gap-2">
      <button
        type="button"
        class="w-full focus:ring-4font-mediumtext-sm px-5 py-2.5 transition-all duration-200"
        @click="open = 'incident'"
        :class="{
          'text-gray-50 bg-gray-500 rounded-t-full': open == 'incident',
          ' focus:ring-red-300 hover:bg-red-600 text-white bg-red-500 rounded-full ':
            open != 'incident',
        }"
      >
        Incident
      </button>
      <button
        type="button"
        class="w-full font-medium text-sm px-5 py-2.5 transition-all duration-200"
        @click="open = 'patrolman'"
        :class="{
          'text-gray-50 bg-gray-500 rounded-t-full': open == 'patrolman',
          ' text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 rounded-full ':
            open != 'patrolman',
        }"
      >
        Ally
      </button>
      <button
        type="button"
        class="w-full font-medium text-sm px-5 py-2.5 transition-all duration-200"
        @click="open = 'citizen'"
        :class="{
          'text-gray-50 bg-gray-500 rounded-t-full': open == 'citizen',
          ' text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300  rounded-full ':
            open != 'citizen',
        }"
      >
        Citizen
      </button>
    </div>
    <div
      class="p-3 bg-gray-500 shadow-sm"
      :class="{
        ' rounded-r-lg': open == 'incident',
        ' rounded-lg': open == 'patrolman',
        'rounded-none rounded-s-lg': open == 'citizen',
      }"
    >
      <div class="h-[28vh] p-2 bg-white rounded-lg overflow-auto shadow-inner">
        <ul class="max-w-md divide-y divide-gray-300">
          <li
            v-if="open == 'citizen'"
            v-for="user of accounts.citizen"
            @click="focusOnMarker(user)"
            class="py-4 hover:bg-gray-50 rounded-lg transition-all duration-200"
          >
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <img
                  class="w-10 h-10 rounded-full border-2 border-blue-500"
                  :src="user['profile']"
                  alt="Neil image"
                />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                  {{ user["name"] }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                  {{ user["con_no"] }}
                </p>
              </div>
              <div
                class="inline-flex items-center text-base font-semibold text-gray-700"
              >
                Citizen
              </div>
            </div>
          </li>
          <li
            v-if="open == 'patrolman'"
            v-for="user of accounts.patrolman"
            @click="focusOnMarker(user)"
            class="py-4 hover:bg-gray-50 rounded-lg transition-all duration-200"
          >
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <img
                  class="w-10 h-10 rounded-full border-2 border-blue-500"
                  :src="user['profile']"
                  alt="Neil image"
                />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                  {{ user["name"] }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                  {{ user["con_no"] }}
                </p>
              </div>
              <div
                class="inline-flex items-center text-base font-semibold text-gray-700"
              >
                Ally
              </div>
            </div>
          </li>
          <li
            v-if="open == 'incident'"
            v-for="incident of data.markers"
            class="p-4 bg-white shadow-md rounded-lg mb-4 transition-all duration-200 hover:shadow-lg"
            @click="focusOnMarker(incident)"
          >
            <div class="flex justify-between items-center">
              <div class="text-sm font-semibold text-gray-800">
                {{ incident["message"] }}
              </div>
              <span
                class="px-2 py-1 text-xs font-medium rounded-full"
                :class="
                  incident['report_type'] == 1
                    ? 'bg-red-100 text-red-600'
                    : 'bg-orange-100 text-orange-600'
                "
              >
                {{
                  incident["report_type"] == 1 ? "Emergency" : "Non-Emergency"
                }}
              </span>
            </div>
            <p class="text-gray-600 text-xs mt-1">{{ incident["location"] }}</p>
            <p class="text-gray-500 text-xs mt-1">
              {{ `${incident["month"]}, ${incident["date"]}` }}
            </p>

            <div class="mt-3 flex items-center space-x-4">
              <div class="flex-shrink-0">
                <img
                  class="w-8 h-8 rounded-full border-2 border-blue-500"
                  :src="incident['profile']"
                  alt="Reporter profile image"
                />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                  {{ incident["name"] }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                  {{ incident["contact"] }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                  {{ incident["email"] }}
                </p>
              </div>
              <button
                v-if="!incident['secured']"
                @click="toggleSecureModal({ incident: incident['id'], officer: cred.id, citizen: incident['user_id']})"
                class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition duration-150 ease-in-out text-sm flex items-center gap-1"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
                Secure
              </button>
              <span
                v-if="incident['secured']"
                class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
              >SECURED</span>
            </div>
          </li>

          <!-- Repeat for other items with similar structure -->
        </ul>
      </div>
    </div>
  </div>

  <secureModal v-if="secureModal" :toggle="toggleSecureModal" :sendData="secureData" />
  <secureLoading v-if="secureLoading" />
</template>
<script>
import axios from "axios";
import { map } from "highcharts";
import secureLoading from "../../../contents/requests/requestComponents/loading/secureLoading.vue";
import secureModal from "../../../contents/requests/requestComponents/secureIncident.vue";

export default {
  components: {
    secureLoading,
    secureModal,
  },
  data() {
    return {
      data: { markers: [] },
      secureLoading: false,
      secureModal: false,
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
      user_track: {
        user: -1,
        latitude: 0.0,
        longitude: 0.0,
      },
      secured: {
        data: {},
        url: "api/incident/secure/add/item/request",
      },
      intervalId: null,
      map: null,
      data2: { markers: [] },
      users: [],
      markers: [],
      accounts: {
        citizen: [],
        patrolman: [],
      },
      active: -1,
      open: "incident",
      cred: {
        user_level: 4, // This should be set dynamically based on the user's actual level
        id: null,
      },
    };
  },
  created() {
    (async () => {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      this.user_track.user = credentials.id;
      this.cred.id = credentials.id;
      this.cred.user_level = credentials.user_level;
      await this.startLogging();
      await this.generateData();
      await this.generateData2();
      await this.initializeMap();
    })();
  },
  beforeDestroy() {
    this.stopLogging();
    this.user_track.latitude = 0.0;
    this.user_track.longitude = 0.0;
    this.userTrack();
  },
  beforeUnmount() {
    this.stopLogging();
    this.user_track.latitude = 0.0;
    this.user_track.longitude = 0.0;
    this.userTrack();
  },
  methods: {
    toggleSecureModal(param) {
      this.secured.data = param;
      this.secureModal = !this.secureModal;
    },
    async secureData() {
      this.secureLoading = true;
      const send = this.secured;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        this.secureLoading = false;
        this.toggleSecureModal("");
        await this.generateData();
      } else {
        this.secureLoading = false;
        await alert("An error occured, please try again.");
      }
    },
    async track_me() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          async (position) => {
            const lati = position.coords.latitude;
            const longi = position.coords.longitude;

            if (
              this.user_track.latitude != lati ||
              this.user_track.longitude != longi
            ) {
              this.user_track.latitude = position.coords.latitude;
              this.user_track.longitude = position.coords.longitude;

              this.userTrack();
            }
          },
          (error) => {
            alert("Error");
          }
        );
      } else {
        alert("Error!");
      }
    },
    async userTrack() {
      const send = await {
        data: { data: this.user_track },
        url: "api/track/my/location/req",
      };

      let data;
      data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
      } else {
        await alert("An error occured, please try again.");
        console.log(data);
      }
    },
    initializeMap() {
      const location =
        this.user_track.latitude == 0.0 || this.user_track.longitude == 0.0
          ? { lat: 11.005, lng: 124.6077 }
          : { lat: this.user_track.latitude, lng: this.user_track.longitude };
      this.map = new google.maps.Map(document.getElementById("patrolmanMap"), {
        zoom: 18,
        center: location,
      });

      this.loadMarkers();
    },
    async generateData() {
      const dt = await this.$store.dispatch(
        "sendData",
        {url: "api/incidents/report/marker/Display", data: {}}
      );
      if (dt["response"] === "Success") {
        let data = dt["data"];
        this.data.markers = [];
        for (let i = 0; i < data.length; i++) {
          this.data.markers.push({
            id: data[i]["id"],
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
            message: data[i]["message"],
            location: data[i]["location"],
            name: data[i]["name"],
            con_no: data[i]["contact"],
            report_type: data[i]["report_type"],
            time: data[i]["time"],
            month: data[i]["month"],
            date: data[i]["date"],
            profile: data[i]["profile"],
            secured: data[i]["secured"],
            user_id: data[i]["user_id"],
            ctr: this.ctr,
          });
          this.ctr++;
        }
      } else {
        alert("Error loading data!");
      }
    },
    async createRoundedIcon(profileUrl, level, size = 50, borderWidth = 5) {
      let borderColor = level == 3 ? "green" : "blue";
      return new Promise((resolve) => {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        const image = new Image();

        // Set canvas size to accommodate the border and the image size
        canvas.width = size + 2 * borderWidth;
        canvas.height = size + 2 * borderWidth;

        image.onload = () => {
          // Draw the border (circle around the image)
          context.beginPath();
          context.arc(
            canvas.width / 2,
            canvas.height / 2,
            size / 2 + borderWidth,
            0,
            2 * Math.PI
          );
          context.fillStyle = borderColor;
          context.fill();

          // Clip to create a circular area for the image
          context.beginPath();
          context.arc(
            canvas.width / 2,
            canvas.height / 2,
            size / 2,
            0,
            2 * Math.PI
          );
          context.closePath();
          context.clip();

          // Draw the profile image inside the clipped circle
          context.drawImage(image, borderWidth, borderWidth, size, size);

          // Convert canvas to a data URL and resolve the promise
          resolve(canvas.toDataURL());
        };

        // Handle errors in loading the image
        image.onerror = () => {
          console.error("Failed to load image:", profileUrl);
          resolve(null); // You can handle fallback logic here if needed
        };

        // Set the image source to start loading
        image.src = profileUrl;
      });
    },
    async generateData2() {
      if (this.users.length > 0) this.removeAllMarkers();
      const dt = await this.$store.dispatch("sendData", {
        url: "api/track/location/map/req",
        data: {},
      });
      if (dt["response"] === "Success") {
        let data = dt["data"];
        this.users = [];
        this.accounts.citizen = [];
        this.accounts.patrolman = [];
        for (let i = 0; i < data.length; i++) {

          let tmp = {
            pos: {
              lat: parseFloat(data[i]["pos"]["lat"]),
              lng: parseFloat(data[i]["pos"]["lng"]),
            },
            name: data[i]["name"],
            con_no: data[i]["contact"],
            time: data[i]["time"],
            month: data[i]["month"],
            date: data[i]["date"],
            profile: data[i]["profile"],
            user_level: data[i]["user_level"],
          };
          this.data2.markers.push(tmp);
          this.users.push(tmp);
          if(tmp.user_level == 3)this.accounts.citizen.push(tmp)
          if(tmp.user_level == 4)this.accounts.patrolman.push(tmp)
        }
      } else {
        alert("Error loading data!");
      }
    },
    loadMarkers() {
      this.loadMarkers2();
      this.data.markers.forEach((mark) => {
        const markerIcon = new google.maps.OverlayView();
        markerIcon.onAdd = function () {
          const layer = document.createElement("div");
          layer.classList.add(mark.report_type == 1 ? "pulse" : "pulse2");

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
            <h2 class="text-xl font-bold text-white">Reported Incident Information</h2>
          </div>
          <div class="p-4 space-y-3">
            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
              <span class="text-sm font-medium text-gray-500">Reported by</span>
              <span class="text-sm font-semibold text-gray-800">${
                mark.name
              }</span>
            </div>
            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
              <span class="text-sm font-medium text-gray-500">Contact</span>
              <span class="text-sm font-semibold text-gray-800">${
                mark.con_no
              }</span>
            </div>
              <div class="border-b border-gray-200 pb-2">
                <span class="text-sm font-medium text-gray-500">Location</span>
                <p class="text-sm text-gray-800 mt-1">${mark.location}</p>
              </div>
            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
              <span class="text-sm font-medium text-gray-500">Report Type</span>
              <span class="text-sm font-semibold ${
                mark.report_type == 1 ? "text-red-600" : "text-yellow-600"
              }">
                ${mark.report_type == 1 ? "Emergency" : "Non-Emergency"}
              </span>
            </div>
            ${
              mark.message
                ? `
              <div>
                <span class="text-sm font-medium text-gray-500">Message</span>
                <p class="text-sm text-gray-800 mt-1">${mark.message}</p>
              </div>
            `
                : ""
            }
          </div>
        </div>
      `,
        });

        marker.addListener("click", () => {
          infoWindow.open(this.map, marker);
        });
      });
    },
    loadMarkers2() {
      console.log(this.users);
      this.users.forEach(async (mark) => {
        const roundedIconUrl = await this.createRoundedIcon(
          mark.profile,
          mark.user_level
        );

        // Add the marker with the rounded icon
        const markerIcon = new google.maps.Marker({
          position: mark.pos,
          map: this.map,
          icon: {
            url: roundedIconUrl, // Use the generated rounded icon URL
            scaledSize: new google.maps.Size(40, 40), // Adjust marker size to include border
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(20, 20), // Set anchor point to center
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
            <h2 class="text-xl font-bold text-white">Citizen Information</h2>
          </div>
          <div class="p-4 space-y-3">
            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
              <span class="text-sm font-medium text-gray-500">Name</span>
              <span class="text-sm font-semibold text-gray-800">${
                mark.name
              }</span>
            </div>
            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
              <span class="text-sm font-medium text-gray-500">Contact</span>
              <span class="text-sm font-semibold text-gray-800">${
                mark.con_no
              }</span>
            </div>
            ${
              mark.message
                ? `
              <div>
                <span class="text-sm font-medium text-gray-500">Message</span>
                <p class="text-sm text-gray-800 mt-1">${mark.message}</p>
              </div>
            `
                : ""
            }
          </div>
        </div>
      `,
        });

        markerIcon.addListener("click", () => {
          infoWindow.open(this.map, markerIcon);
        });
      });
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
    focusOnMarker(marker) {
      const position = new google.maps.LatLng(marker.pos.lat, marker.pos.lng);
      //this.active = marker.ctr;
      this.map.setCenter(position);
    },
    startLogging() {
      this.track_me();
      this.intervalId = setInterval(async () => {
        await this.track_me();
        await this.generateData2();
        await this.loadMarkers2();
      }, 10000);
    },
    stopLogging() {
      if (this.intervalId) {
        clearInterval(this.intervalId);
        this.intervalId = null;
      }
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
