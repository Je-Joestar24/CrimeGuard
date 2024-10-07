<template>
  <div id="dashboardMonitoringMap" class="absolute inset-0 bg-gray-300"></div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        markers: [
          /* 
          {
            pos: {
              lat: 11.0059,
              lng: 124.6276,
            },
            message: "Nag away",
            location: "Can-adieng, Ormoc City, Leyte",
            name: "Jejomar",
            con_no: "09073010472",
          }, */
          /*  ,
          {
            pos: {
              lat: 11.0136,
              lng: 124.6031,
            },
            message: "Nag away",
            location: "Orwasa, Ormoc City, Leyte",
            name: "Jejomar Parrilla",
            con_no: "09073010472",
          }, */
        ],
      },
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
        document.getElementById("dashboardMonitoringMap"),
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
          layer.classList.add(mark.report_type == 1 ? "pulse" : "pulse2");

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

      /*       var marker = new google.maps.Marker({
        position: location,
        map: map,
      });


      var infoWindow = new google.maps.InfoWindow({
        content: `
          <div class="p-4 bg-white rounded-lg shadow-lg max-w-xs">
            <h1 class="font-bold text-lg mb-2">Incident Information:</h1>
            <p><span class="font-semibold">Message:</span> Nag away</p>
            <p><span class="font-semibold">Location:</span> Bonifacio Street, Ormoc City</p>
            <p><span class="font-semibold">Reported by:</span> Jejomar Parrilla</p>
            <p><span class="font-semibold">Contact no:</span>09073010472</p>
          </div>
          `,
      });

      marker.addListener("click", function () {
        infoWindow.open(map, marker);
      }); */
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
            report_type: data[i]['report_type']
          });
          //console.log(data[i]["message"],data[i]["location"],data[i]["name"],data[i]["contact"])
        }
      } else {
        alert("Error!");
      }
    },
  },
};
</script>

<style scoped>
.blinking-dot-red {
  height: 20px;
  width: 20px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;
  animation: blink 1s infinite;
}

.blinking-dot-yellow {
  height: 20px;
  width: 20px;
  background-color: yellow;
  border-radius: 50%;
  display: inline-block;
  animation: blink 1s infinite;
}

@keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
</style>
