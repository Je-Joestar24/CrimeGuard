<template>
  <div
    class="fixed z-50 top-0 left-0 h-full w-full bg-opacity-30 bg-gray-900 flex items-center justify-center"
  >
    <div class="flex flex-col items-center justify-center">
      <div
        class="fixed top-20 z-50 py-3 flex justify-between bg-white"
        style="width: 1200px"
      >
        <span class="w-full flex justify-center font-bold text-gray-700"
          >SELECT LOCATION HERE</span
        >
        <button
          type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 mx-4 inline-flex justify-center items-center"
          @click="toggleIt"
        >
          <!--  @click.prevent="toggle()" -->
          <svg
            class="w-3 h-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      <div
        id="dashboardMonitoringMap"
        class="bg-gray-300 absolute"
        style="height: 700px; width: 1200px"
      ></div>
      <div
        class="fixed bottom-20 z-50 py-2 flex justify-between gap-2 bg-white px-3"
        style="width: 1200px"
      >
        <div class="flex text-sm gap-1">
          <button
            @click="enableMapClick"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg"
          >
            SELECT LOCATION
          </button>
          <!-- <button @click="activateBorderCreator" class=" px-4 py-2 bg-blue-500 text-white rounded-lg">SELECT BRGY</button> -->
        </div>
        <div
          v-if="
            !(
              locationData.latitude &&
              locationData.longitude &&
              locationData.address
            )
          "
          class=""
        >
          -
        </div>
        <div
          v-if="
            locationData.latitude &&
            locationData.longitude &&
            locationData.address
          "
          class="flex mt-1"
        >
          <span>
            <span class="font-semibold">LONGITUDE:</span>
            {{ locationData.latitude }}</span
          >,
          <span>
            <span class="font-semibold">LATITUDE:</span>
            {{ locationData.longitude }}</span
          >,
          <span>
            <span class="font-semibold">ADDRESS:</span>
            {{ locationData.address }}</span
          >
        </div>
        <button
          @click="sendIt(locationData)"
          class="px-4 py-2 bg-green-500 text-white rounded-lg"
        >
          OK
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      map: null,
      isClickEnabled: false,
      barangayPolygon: null,
      geojsonLayer: null,
      borderPolygon: null,
      borderCreatorMode: false,
      data: {
        markers: [],
      },
      locationData: {
        latitude: null,
        longitude: null,
        address: null,
        barangay: null,
      },
    };
  },
  mounted() {
    (async () => {
      await this.generateData();
      await this.loadGoogleMapsScript();
      await this.initializeMap();
    })();
  },
  methods: {
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
    initializeMap(param) {
      const location = param
        ? { lat: param["lat"], lng: param["lng"] }
        : { lat: 11.005, lng: 124.6077 };
      this.map = new google.maps.Map(
        document.getElementById("dashboardMonitoringMap"),
        {
          zoom: 15,
          center: location,
        }
      );

      this.map.addListener("click", (event) => {
        if (this.isClickEnabled) {
          this.handleMapClick(event.latLng);
        }
      });
    },
    async generateData() {
      const dt = await this.$store.dispatch(
        "generateTableData",
        "api/incidents/report/marker/Display"
      );

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
            report_type: data[i["report_type"]],
          });
        }
      } else {
        alert("Error!");
      }
    },
    enableMapClick() {
      this.isClickEnabled = true;
      alert("You can now click on the map to select a location.");
    },
    async handleMapClick(latLng) {
      const geocoder = new google.maps.Geocoder();
      try {
        const results = await new Promise((resolve, reject) => {
          geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === "OK" && results[0]) {
              resolve(results);
            } else {
              reject(`Geocoder failed due to: ${status}`);
            }
          });
        });

        if (results[0]) {
          this.locationData.latitude = latLng.lat();
          this.locationData.longitude = latLng.lng();
          this.locationData.address = results[0].formatted_address;

          // Extracting the barangay (sublocality level 1)
          //console.log(results[3]['address_components'][0]['short_name'])
          /* const barangay = results[0].address_components.find((component) =>
            component.types.includes("sublocality_level_1")
          ); */

          const barangay = results[3]["address_components"][0]["short_name"];
          console.log(barangay);
          const send = await {
            data: {
              barangay: barangay,
            },
            url: "api/check/address",
          };

          const data = await this.$store.dispatch("sendData", send);
          this.locationData.barangay = data['response'] == 'Success' ? barangay : null;
          console.log(this.locationData)
          // Initialize the map and place the marker
          await this.initializeMap({
            lat: this.locationData.latitude,
            lng: this.locationData.longitude,
          });
          this.placeMarker(
            this.locationData.latitude,
            this.locationData.longitude
          );

          // Disable further clicks if needed
          this.isClickEnabled = false;
        }
      } catch (error) {
        alert(error);
      }
    },

    placeMarker(lat, lng) {
      new google.maps.Marker({
        position: { lat, lng },
        map: this.map,
      });
    },

    async getAddress(lat, long) {
      try {
        const response = await axios.get(
          `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${long}&key=AIzaSyCKwTfAEpVXgkBBrCcLkHGNzwy9sf4WkWM`
        );

        if (response.data.status === "OK") {
          const results = response.data.results[0];
          const addressComponents = results.address_components;

          // Extracting the barangay (sublocality level 1)
          const barangay = addressComponents.find((component) =>
            component.types.includes("sublocality_level_1")
          );
          this.locationData.barangay = barangay
            ? barangay.long_name
            : "Barangay not found";
        } else {
          console.error("Geocode error:", response.data.status);
        }
      } catch (err) {
        console.error("An error occurred:", err);
      }
    },

    activateBorderCreator() {
      this.borderCreatorMode = true;
      alert("Click on the map to display the boundary of the barangay.");
    },
    async getAndDrawBoundary(latLng) {
      // Disable border creator mode after a click
      this.borderCreatorMode = false;

      // Use the Geocoding API to get the address information
      const geocoder = new google.maps.Geocoder();
      geocoder.geocode({ location: latLng }, (results, status) => {
        if (status === "OK" && results[0]) {
          const addressComponents = results[0].address_components;
          let barangay = null;

          // Find the barangay or equivalent administrative area from the results
          addressComponents.forEach((component) => {
            if (component.types.includes("administrative_area_level_3")) {
              barangay = component.long_name;
            }
          });

          if (barangay) {
            // If the barangay is found, draw its boundary
            this.drawBarangayBoundary(barangay);
          } else {
            alert("Barangay not found in the clicked location.");
          }
        } else {
          alert("Geocoder failed due to: " + status);
        }
      });
    },
    drawBarangayBoundary(barangay) {
      // Replace this with real boundary data
      const boundaryCoords = this.getBarangayBoundaryCoordinates(barangay);

      if (this.borderPolygon) {
        this.borderPolygon.setMap(null); // Clear any previous polygon
      }

      this.borderPolygon = new google.maps.Polygon({
        paths: boundaryCoords,
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
      });

      this.borderPolygon.setMap(this.map);

      // Optionally, adjust the map to fit the boundary
      const bounds = new google.maps.LatLngBounds();
      boundaryCoords.forEach((coord) => bounds.extend(coord));
      this.map.fitBounds(bounds);
    },
    getBarangayBoundaryCoordinates(barangay) {
      // Here you would fetch the boundary coordinates for the barangay
      // This is just an example and needs to be replaced with actual data
      const exampleBoundaryCoords = {
        Ipil: [
          { lat: 11.006, lng: 124.607 },
          { lat: 11.007, lng: 124.609 },
          { lat: 11.005, lng: 124.61 },
          { lat: 11.004, lng: 124.608 },
          { lat: 11.006, lng: 124.607 },
        ],
        // Add more barangays here
      };

      return exampleBoundaryCoords[barangay] || [];
    },
  },
  props: ["toggleIt", "sendIt"],
};
</script>

<style scoped>
/* Your existing styles */
</style>
