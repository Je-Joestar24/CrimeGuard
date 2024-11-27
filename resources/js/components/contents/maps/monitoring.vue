<template>
  <div class="flex justify-center">
    <div
      class="m-5 max-w-screen-2xl w-11/12 px-6 py-6 rounded-lg border shadow-xl bg-white"
    >
      <div class="flex space-x-6" style="width: 70vw; height: 70vh">
        <section
          class="text-gray-600 body-font relative w-3/5 h-full rounded-lg overflow-hidden shadow-md"
        >
          <div
            id="innerMonitoringMap"
            class="absolute inset-0 bg-gray-200"
          ></div>
        </section>
        <div class="w-2/5 flex flex-col rounded-lg shadow-md overflow-hidden">
          <!-- Reporting Persons Section -->
          <div class="flex-1 flex flex-col">
            <h2
              class="text-xl font-bold text-gray-800 px-6 py-4 bg-gray-50 border-b"
            >
              Reporting Persons
            </h2>
            <div class="overflow-auto flex-1 bg-white">
              <template v-if="users.length">
                <div
                  v-for="(marker, index) in users"
                  :key="index"
                  @click="focusOnMarker(marker)"
                  class="flex items-center px-6 py-4 border-b hover:bg-gray-50 transition duration-300 ease-in-out cursor-pointer"
                  :class="{ 'bg-blue-50': active == marker.ctr }"
                >
                  <div class="flex-shrink-0">
                    <img
                      v-if="marker.profile"
                      :src="marker.profile"
                      :alt="marker.name"
                      class="h-12 w-12 rounded-full object-cover shadow-sm"
                      :class="{ 'ring-2 ring-blue-500': active == marker.ctr }"
                    />
                    <div
                      v-else
                      class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center shadow-sm"
                    >
                      <svg
                        class="h-6 w-6 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-semibold text-gray-900">
                      {{ marker.name }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                      {{ marker.con_no }}
                    </p>
                  </div>
                </div>
              </template>
              <div v-else class="flex items-center justify-center h-full">
                <p class="text-gray-500 text-sm">
                  No reporting persons at the moment
                </p>
              </div>
            </div>
          </div>

          <!-- Reported Incidents Section -->
          <div class="flex-1 flex flex-col">
            <h2
              class="text-xl font-bold text-gray-800 px-6 py-4 bg-gray-50 border-b"
            >
              Reported Incidents
            </h2>
            <div class="overflow-auto flex-1 bg-white">
              <template v-if="data.markers.length">
                <div
                  v-for="(marker, index) in data.markers"
                  :key="index"
                  @click="focusOnMarker(marker)"
                  class="px-6 py-4 border-b hover:bg-gray-50 transition duration-300 ease-in-out cursor-pointer"
                  :class="{ 'bg-blue-50': active == marker.ctr }"
                >
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <p class="text-sm font-semibold text-gray-900">
                        {{ marker.message }}
                      </p>
                      <p class="text-xs text-gray-500 mt-2">
                        {{ marker.location }}
                      </p>
                    </div>
                    <div class="text-right">
                      <p class="text-xs text-gray-500">
                        {{ convertToNormalTime(marker.time) }}
                      </p>
                      <p class="text-xs font-medium text-gray-900 mt-1">
                        {{ marker.month }} {{ marker.date }}
                      </p>
                    </div>
                  </div>
                </div>
              </template>
              <div v-else class="flex items-center justify-center h-full">
                <p class="text-gray-500 text-sm">
                  No reported incidents at the moment
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: { markers: [] },
      data2: { markers: [] },
      users: [],
      map: null,
      markers: [],
      active: -1,
      ctr: 1,
      intervalId: null,
      cred: {},
    };
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.cred = credentials;
    (async () => {
      await this.generateData();
      await this.generateData2();
      await this.initializeMap();
      await this.startLogging();
    })();
  },
  methods: {
    async generateData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/incidents/report/marker/Display",
        data: { id: this.cred["id"] },
      });
      if (dt["response"] === "Success") {
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
            time: data[i]["time"],
            month: data[i]["month"],
            date: data[i]["date"],
            profile: data[i]["profile"],
            secured: data[i]["secured"],
            ctr: this.ctr,
          });
          this.ctr++;
        }
      } else {
        alert("Error loading data!");
      }
    },
    containsUser(citizen) {
      const cit = citizen;
      cit["ctr"] = this.ctr;
      this.ctr++;
      for (let i = 0; i < this.users.length; i++) {
        if (
          citizen["user_name"] == this.users[i]["user_name"] ||
          citizen["email"] == this.users[i]["email"]
        ) {
          this.users[i] = citizen;
          return;
        }
      }
      this.users.push(citizen);
      return;
    },
    convertToNormalTime(militaryTime) {
      if (!militaryTime) return "";

      const [hours, minutes] = militaryTime.split(":").map(Number);

      if (
        hours === undefined ||
        minutes === undefined ||
        hours > 23 ||
        minutes > 59
      ) {
        return "Invalid time format";
      }

      const period = hours >= 12 ? "PM" : "AM";
      const normalHours = hours % 12 || 12; // Convert to 12-hour format, ensuring 0 becomes 12
      return `${normalHours}:${String(minutes).padStart(2, "0")} ${period}`;
    },
    initializeMap() {
      const defaultLocation = { lat: 11.005, lng: 124.6077 };
      this.map = new google.maps.Map(
        document.getElementById("innerMonitoringMap"),
        {
          zoom: 12,
          center: defaultLocation,
        }
      );
      this.loadMarkers();
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
        data: { id: this.cred["id"] },
      });
      if (dt["response"] === "Success") {
        let data = dt["data"];
        console.log(data);
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
          layer.classList.add(mark.secured ? "secured-dot" : mark.report_type == 1 ? "pulse" : "pulse2");

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

    focusOnMarker(marker) {
      const position = new google.maps.LatLng(marker.pos.lat, marker.pos.lng);
      this.active = marker.ctr;
      this.map.setCenter(position);
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
    async startLogging() {
      this.intervalId = await setInterval(async () => {
        /* if (this.counter == 10) {
          this.toggle();
        } */
        await this.generateData2();
        await this.loadMarkers2();
        // this.counter++;
      }, 60000);
    },
    stopLogging() {
      // Clear the interval if it exists
      if (this.intervalId) {
        clearInterval(this.intervalId);
        this.intervalId = null;
      }
    },
  },
  beforeDestroy() {
    this.stopLogging();
  },
  beforeUnmount() {
    this.stopLogging();
  },
};
</script>

<style >
.pulse {
  position: absolute;
  width: 30px;
  height: 30px;
  background-color: red;
  border-radius: 50%;
  animation: pulse 2s infinite, blink 1s infinite;
  cursor: pointer;
}

.pulse2 {
  position: absolute;
  width: 30px;
  height: 30px;
  background-color: yellow;
  border-radius: 50%;
  animation: pulse 2s infinite, blink 1s infinite;
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