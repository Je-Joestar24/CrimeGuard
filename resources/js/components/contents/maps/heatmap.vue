
<style>
    .redM {
      position: absolute;
      width: 15px;
      height: 15px;
      background-color: red;
      border-radius: 50%;
      cursor: pointer;
    }

    .yellowM{
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
  <div class="flex justify-center">
  <div class="m-5 max-w-screen-xl px-3 py-3 rounded border shadow-lg"
    :class="{'border-gray-500':$store.getters.theme,'border-gray-200':!$store.getters.theme}"
  >
<!--     <div class="grid mb-2 grid-cols-3">
      <div class="col-span-3">
        <form>
          <div class="flex">
            <button
              class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
              type="button"
            >
              Filter
            </button>
            <div class="relative w-full">
              <input
                type="search"
                id="search-dropdown"
                class="block p-2.5 w-full z-20 text-sm   rounded-e-lg border-s-gray-50 border-s-2 border"
                :class="{' bg-gray-700 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white focus:border-blue-500':$store.getters.theme,'bg-gray-50 border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-900':!$store.getters.theme}"
      
                placeholder="Search Location"
                required
              />
              <button
                type="submit"
                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                <svg
                  class="w-4 h-4"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 20 20"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                  />
                </svg>
                <span class="sr-only">Search</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div> -->
    <div class="" style="width: 65vw; height: 65vh">
      
      <section class="text-gray-600 body-font relative w-full h-full">
        <div id="heatMap" class="absolute inset-0 bg-gray-300">
          
        </div>
      </section>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      data: { markers: [] },
    };
  },
  mounted() {
    //this.initializeMap()
    (async () => {
      await this.generateData();
      await this.loadGoogleMapsScript();
      await this.initializeMap();
    })();
    //console.log(document.head)
  },
  methods: {
    async generateData() {
      const dt = await this.$store.dispatch(
        "sendData",{
        url: "api/incidents/heat/map/marker/Display",data: {}}
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
            report_type: data[i]["report_type"],
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
      const map = new google.maps.Map(
        document.getElementById("heatMap"),
        {
          zoom: 12,
          center: location,
        }
      );

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
              <p><span class="font-semibold">Message:</span> ${mark.message}</p>
              <p><span class="font-semibold">Location:</span> ${mark.location}</p>
              <p><span class="font-semibold">Reported by:</span> ${mark.name}</p>
              <p><span class="font-semibold">Contact no:</span>${mark.con_no}</p>
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
  },
};
</script>