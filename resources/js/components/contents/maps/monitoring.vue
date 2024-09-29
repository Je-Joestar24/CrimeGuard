<template>
  <div class="flex justify-center">
    <div class="m-5 max-w-screen-xl px-3 py-3 rounded border shadow-lg">
      <div class="flex" style="width: 65vw; height: 65vh">
        <section class="text-gray-600 body-font relative w-full h-full">
          <div
            id="innerMonitoringMap"
            class="absolute inset-0 bg-gray-300"
          ></div>
        </section>
        <div class="border w-5/12 grid">
          <div class="border-b flex flex-col">
            <h1 class="mx-auto px-20 text-center py-2 mt-2 border-b">
              REPORTING PERSONS
            </h1>
            <div
              class="me-2 rounded-e mt-3 flex flex-col gap-y-1 overflow-auto"
              style="height: 24vh"
            >
              <div
                v-for="(marker, index) in users"
                :key="index"
                @click="focusOnMarker(marker)"
                class="bg-gradient-to-br flex px-5 w-full gap-5 shadow-sm py-2 hover:rounded-e-full hover:shadow-md hover:bg-gray-100 active:rounded-e-full active:shadow-sm"
                :class="{
                  'rounded-e-full shadow-sm bg-gray-50': active == marker.ctr,
                }"
              >
                <svg
                  v-if="marker.profile == ''"
                  class="h-10 w-10 text-gray-500 my-auto"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <img
                  v-if="marker.profile != ''"
                  class="h-10 rounded-full border w-10 text-gray-500 my-auto"
                  :class="{ 'border-2 border-green-400': active == marker.ctr }"
                  :src="marker.profile"
                  alt=""
                />
                <div class="flex flex-col my-auto">
                  <span class="text-base font-semibold">{{ marker.name }}</span>
                  <span class="text-sm text-gray-600">{{ marker.con_no }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="border-b flex flex-col">
            <h1 class="mx-auto px-20 text-center py-2 mt-2 border-b">
              REPORTED INCIDENTS
            </h1>
            <div
              class="me-2 rounded-e mt-3 flex flex-col gap-y-1 overflow-auto"
              style="height: 24vh"
            >
              <div
                v-for="(marker, index) in data.markers"
                :key="index"
                class="bg-gradient-to-br flex px-5 w-full gap-5 shadow-sm py-2 hover:rounded-e-full hover:shadow-md hover:bg-gray-100 active:rounded-e-full active:shadow-sm justify-between"
                @click="focusOnMarker(marker)"
                :class="{
                  'rounded-e-full shadow-sm bg-gray-50': active == marker.ctr,
                }"
              >
                <div class="flex flex-col my-auto text-sm w-full">
                  <span class="text-base font-semibold">{{
                    marker.message
                  }}</span>
                  <span class="text-sm text-gray-600">{{
                    marker.location
                  }}</span>
                </div>
                <span class="flex flex-col my-auto text-xs w-full justify-end"
                  >{{ convertToNormalTime(marker.time) }}, {{ marker.month }},
                  <span class="font-bold">{{ marker.date }}</span></span
                >
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
      intervalId: null
    };
  },
  mounted() {
    (async () => {
      await this.generateData();
      await this.generateData2();
      await console.log(this.users);
      await this.loadGoogleMapsScript();
      await this.initializeMap();
      await this.startLogging();
    })();
  },
  methods: {
    async generateData() {
      const dt = await this.$store.dispatch(
        "generateTableData",
        "api/incidents/report/marker/Display"
      );
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
    async loadGoogleMapsScript() {
      return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src =
          "https://maps.googleapis.com/maps/api/js?key=AIzaSyCKwTfAEpVXgkBBrCcLkHGNzwy9sf4WkWM"; // Insert your Google Maps API Key
        script.async = true;
        script.defer = true;
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
      });
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
    async createRoundedIcon(
      profileUrl,
      size = 50,
      borderColor = "green",
      borderWidth = 5
    ) {
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
      if(this.users.length > 0)this.removeAllMarkers();
      const dt = await this.$store.dispatch("sendData", {
        url: "api/track/location/map/req",
        data: {},
      });
      if (dt["response"] === "Success") {
        let data = dt["data"];
        for (let i = 0; i < data.length; i++) {
          this.data2.markers.push({
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
          });
        }
        for (let i = 0; i < this.data2.markers.length; i++)
          this.containsUser(this.data2.markers[i]);
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
        <div class="p-4 rounded-lg shadow-lg max-w-xs border-2 ${bg}">
          <h1 class="font-bold text-lg mb-2">Incident Information:</h1>
          <p><span class="font-semibold">Message:</span> ${mark.message}</p>
          <p><span class="font-semibold">Location:</span> ${mark.location}</p>
          <p><span class="font-semibold">Reported by:</span> ${mark.name}</p>
          <p><span class="font-semibold">Contact no:</span>${mark.con_no}</p>
        </div>
      `,
        });

        marker.addListener("click", () => {
          infoWindow.open(this.map, marker);
        });
      });
    },
    loadMarkers2() {
      this.users.forEach(async (mark) => {
        const roundedIconUrl = await this.createRoundedIcon(mark.profile);

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
        <div class="p-4 rounded-lg shadow-lg max-w-xs border-2 ${bg}">
          <h1 class="font-bold text-lg mb-2">Citizen Information:</h1>
          <p><span class="font-semibold">Reported by:</span> ${mark.name}</p>
          <p><span class="font-semibold">Contact no:</span>${mark.con_no}</p>
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
        alert();
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


