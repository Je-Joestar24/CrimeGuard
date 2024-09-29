<template>
  <div
    class="fixed flex top-0 bg-gray-800 bg-opacity-60 w-full z-50"
    style="height: 100vh"
  >
    <div
      class="flex flex-col w-96 md:w-1/4 lg:w-1/4 xl:w-1/4 my-auto mx-auto bg-white p-4 rounded-md relative"
      v-if="!(trackMe && reported)"
    >
      <span
        class="w-full text-center text-lg text-gray-800 font-semibold pb-2 mb-2"
        >REPORT INCIDENT</span
      >
      <form class=" ">
        <div class="px-2 pb-2 pt-5 rounded-md border my-2">
          <p
            class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50"
            v-show="reported"
          >
            <svg
              class="h-6 w-6 text-green-600 me-2"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" />
              <circle cx="12" cy="12" r="9" />
              <path d="M9 12l2 2l4 -4" />
            </svg>
            Report sent, waiting for police station to respond...
          </p>
          <div
            class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r"
          >
            <div class="flex items-center px-3 border justify-between mb-2">
              <input
                v-model="trackMe"
                type="checkbox"
                value=""
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
              />
              <label class="py-3 text-sm font-medium text-gray-900"
                >TRACK ME</label
              >
              <svg
                class="h-8 w-8 text-blue-500"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path stroke="none" d="M0 0h24v24H0z" />
                <line x1="18" y1="6" x2="18" y2="6.01" />
                <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />
                <polyline
                  points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15"
                />
                <line x1="9" y1="4" x2="9" y2="17" />
                <line x1="15" y1="15" x2="15" y2="20" />
              </svg>
            </div>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="text"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.message"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >Message</label
            >
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="text"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.landmark"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >Land Mark</label
            >
          </div>
          <div class="relative z-0 w-full mb-5 group pt-2">
            <select
              v-model="signUpForm.report_type"
              class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
            >
              <option value="0" disabled>SELECT TYPE</option>
              <option value="1">EMERGENCY</option>
              <option value="2">NON-EMERGENCY</option>
            </select>
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 pt-2"
              >REPORT TYPE</label
            >
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="text"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.address.barangay"
              @click="generateAddress(signUpForm.address.barangay)"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >Barangay</label
            >

            <div
              v-if="places.length > 0"
              class="absolute bg-white w-full rounded-md pt-1 border"
            >
              <div class="max-h-24 overflow-auto flex flex-col rounded-md">
                <div
                  class="px-4 hover:bg-gray-50 py-1 border-b"
                  v-for="place in places"
                  @click.prevent="setAddress(place + '')"
                >
                  {{ place }}
                </div>
              </div>
            </div>
          </div>
          <div></div>
          <span class="my-3 flex gap-3 p-2 border rounded-md"
            ><svg
              class="h-6 w-6 text-red-400 my-auto"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              /></svg
            ><span class="border-s px-2">{{
              signUpForm.location != "" ? signUpForm.location : "LOCATION"
            }}</span>
          </span>
        </div>
        <button
          v-if="signUpForm.location != ''"
          type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
          :class="{ 'cursor-not-allowed': signUpForm.location == '' }"
          :disabled="signUpForm.location == ''"
          @click.prevent="rqSend()"
        >
          <!-- @click="sendData()/*sendData()*/" -->
          REPORT
        </button>
        <button
          v-if="signUpForm.location == ''"
          type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
          :class="{ 'cursor-not-allowed': signUpForm.location == '' }"
          :disabled="signUpForm.location == ''"
        >
          <!-- @click="sendData()/*sendData()*/" -->
          REPORT
        </button>
      </form>
      <svg
        class="hover:border hover:bg-gray-100 absolute top-3 right-3 h-8 w-8 p-1 active:text-gray-100 active:bg-gray-200 rounded-md text-gray-400"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        stroke-width="2"
        stroke="currentColor"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        @click="toggle()"
      >
        <path stroke="none" d="M0 0h24v24H0z" />
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </div>

    <div
      v-if="trackMe && reported"
      class="my-auto mx-auto flex flex-col justify-center gap-y-20"
    >
      <span
        class="my-auto px-10 py-3 rounded-sm font-thin text-lg text-white bg-gradient-to-b from-blue-500 to-blue-400"
        >YOU'RE BEING TRACK</span
      >
      <div class="mx-auto flex relative h-28 w-28">
        <div
          class="h-28 w-28 rounded-full animate-ping bg-red-500 absolute top-0"
        ></div>
        <div
          class="absolute top-2 left-2 m-auto h-24 w-24 text-white opacity-95 p-5 bg-gradient-to-b from-white to-transparent rounded-full animate-spin"
        ></div>
        <svg
          class="absolute top-2 left-2 m-auto h-24 w-24 text-white opacity-95 p-5 rounded-full animate-bounce"
          fill="red"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1"
            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1"
            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
          />
        </svg>
      </div>
      <button
        @click="toggle"
        class="flex mx-auto px-6 rounded-full py-1 bg-red-600 text-white"
      >
        CANCEL
        <svg
          class="h-4 w-4 my-auto ms-1"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      signUpForm: {
        id: -1, //Temporary
        message: "",
        landmark: "",
        latitude: 0.0,
        longitude: 0.0,
        location: "",
        address: {
          village: "",
          street: "",
          barangay: "",
          city: "",
          province: "",
        },
        report_type: 1,
      },
      user_track: {
        user: -1,
        latitude: 0.0,
        longitude: 0.0,
      },
      res: "",
      reported: false,
      toggler: false,
      places: [],
      trackMe: true,
      intervalId: null,
      reported: false,
      counter: 0,
    };
  },
  methods: {
    setAddress(value) {
      this.signUpForm.address.barangay = value;
      this.places = [];
      this.toggler = false;
    },
    async sendData() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          async (position) => {
            this.signUpForm.latitude = position.coords.latitude;
            this.signUpForm.longitude = position.coords.longitude;
            this.getAddress(
              this.signUpForm.latitude,
              this.signUpForm.longitude
            );
          },
          (error) => {
            alert("Error");
          }
        );
      } else {
        alert("Error!");
      }

      //console.log(data);
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

      //console.log(send)
      let data;
      data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        
      } else {
        await alert("An error occured, please try again.");
        console.log(data);
      }
    },
    async generateAddress(search) {
      this.toggler = true;
      const data = {
        search: search,
      };

      const send = {
        url: "api/barangay/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
      } else {
        alert("Error");
      }
    },
    reportRequest() {},
    async rqSend() {
      const send = await {
        data: this.signUpForm,
        url: "api/incidents/report/request",
      };

      //console.log(send)
      let data;
      if (this.signUpForm.report_type != 0)
        data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        await this.clearForm();
        this.reported = true;
        if (!this.trackMe) {
          setTimeout(() => {
            this.toggle();
          }, 2000);
        } else if (this.trackMe) {
          this.startLogging();
          this.reported = true;
        }
      } else {
        await alert("An error occured, please try again.");
        console.log(data);
      }
    },
    clearForm() {
      this.signUpForm.message = "";
      this.signUpForm.landmark = "";
      this.signUpForm.latitude = "";
      this.signUpForm.longitude = "";
      this.signUpForm.location = "";
      this.signUpForm.address.village = "";
      this.signUpForm.address.barangay = "";
      this.signUpForm.address.city = "";
      this.signUpForm.address.province = "";
      this.signUpForm.address.street = "";
      this.signUpForm.report_type = 0;
    },
    async getAddress(lat, long) {
      try {
        let req = await axios.get(
          `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${long}&key=AIzaSyCKwTfAEpVXgkBBrCcLkHGNzwy9sf4WkWM`
        );
        let results = req.data.results[0];

        let addressComponents = results.address_components;
        this.signUpForm.location = results.formatted_address + "";

        await addressComponents.forEach((component) => {
          if (component.types.includes("neighborhood")) {
            this.signUpForm.address.village = component.long_name;
          }
          if (component.types.includes("route")) {
            this.signUpForm.address.street = component.long_name;
          }
          if (component.types.includes("sublocality_level_1")) {
            this.signUpForm.address.barangay = component.long_name;
          }
          if (component.types.includes("locality")) {
            this.signUpForm.address.city = component.long_name;
          }
          if (component.types.includes("administrative_area_level_2")) {
            this.signUpForm.address.province = component.long_name;
          }
        });
        //console.log(this.signUpForm.address, this.signUpForm.longitude, this.signUpForm.latitude, this.signUpForm.location);
      } catch (err) {
        console.error("An error occurred:", err);
      }
    },
    startLogging() {
      this.track_me();
      this.intervalId = setInterval(() => {
        /* if (this.counter == 10) {
          this.toggle();
        } */
        this.track_me();
        // this.counter++;
      }, 10000);
    },
    stopLogging() {
      // Clear the interval if it exists
      if (this.intervalId) {
        clearInterval(this.intervalId);
        this.intervalId = null;
      }
    },
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.signUpForm.id = credentials.id;
    this.user_track.user= credentials.id;
    this.sendData();
  },
  beforeDestroy() {
    this.stopLogging();
  },
  beforeUnmount() {
    this.stopLogging();
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
  props: ["toggle"],
  watch: {
    "signUpForm.address.barangay": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.generateAddress(newVal);
      }
    },
    "user_track.data": function (newVal, oldVal) {
      const nv = JSON.stringify(newVal);
      const ov = JSON.stringify(oldVal);
      console.log(nv, ov);

      if (nv !== ov) {
        console.log(nv, ov);
      }
    },

    /* ,trackMe(newValue) {
      if (newValue) {
        // If checked (true), start the interval
        this.startLogging();
      } else {
        // If unchecked (false), clear the interval
        this.stopLogging();
      }
    } */
  },
};
</script>