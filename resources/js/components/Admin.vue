<template>
  <loading v-if="!logged"></loading>
  <div
    v-if="logged"
    id="sidebar"
    class="sidebar f"
    :class="{
      'bg-gray-800 border-gray-700': $store.getters.theme,
      'bg-white border-gray-200': !$store.getters.theme,
    }"
  >
    <NavigationBar
      v-if="pages.length > 0"
      :toggle-profile="toggleProfile"
      :page="pages"
    >
    </NavigationBar>
    <div class="p-4 sm:ml-64">
      <div
        class="p-4 mt-14"
        :class="{ 'border-gray-700': this.$store.getters.theme }"
      >
        <div class="container ps-5">
          <div class="mb-10">
            <h1
              class="text-2xl font-bold p-4 rounded-lg shadow-md transition-all duration-300 ease-in-out"
              :class="{
                'bg-gray-800 text-white border-l-2 border-gray-500':
                  $store.getters.theme,
                'bg-white text-gray-800 border-l-2 border-gray-500':
                  !$store.getters.theme,
              }"
            >
              <span class="flex items-center">
                <svg
                  class="w-6 h-6 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                  ></path>
                </svg>
                {{ $store.state.CurrentActiveTitleNavigation }}
              </span>
            </h1>
          </div>
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>

  <adminprofile
    v-if="!closeProfile"
    :toggle-profile="toggleProfile"
    :close-profile="closeProfile"
  ></adminprofile>
  <transition
    enter-active-class="animate-fade-in-down"
    leave-active-class="animate-fade-out-up"
  >
    <div
      v-if="emergency"
      class="fixed top-2 right-64 z-50 flex items-center bg-red-600 text-white rounded-lg shadow-lg overflow-hidden"
    >
      <div class="bg-red-700 p-3">
        <svg
          class="h-6 w-6 animate-pulse"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path
            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
          />
          <line x1="12" y1="9" x2="12" y2="13" />
          <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
      </div>
      <div class="px-4 py-2 font-semibold">
        {{ "Emergency Report" }}
      </div>
    </div>
  </transition>
  <div
    v-if="emergency && currentIncident"
    class="fixed inset-0 bg-black bg-opacity-50 transition-opacity z-50 flex items-center justify-center backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="emergency-modal-title"
  >
    <div
      class="bg-white rounded-xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-2xl transform transition-all max-w-md w-full mx-4"
    >
      <div class="flex flex-col items-center">
        <div
          class="flex items-center justify-center h-16 w-16 rounded-full bg-red-100 animate-pulse"
        >
          <svg
            class="h-8 w-8 text-red-600"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
          </svg>
        </div>

        <div class="mt-4 text-center">
          <h2
            id="emergency-modal-title"
            class="text-2xl font-bold text-gray-900 mb-2"
          >
            {{
              cred.user_level == 1
                ? "Emergency Report Detected"
                : "New Assignment"
            }}
          </h2>

          <p class="text-gray-600">
            {{
              cred.user_level == 1
                ? "A new emergency report has been filed. Immediate attention is required."
                : "You have been assigned to a new incident. Please check your assignments for details."
            }}
          </p>

          <div class="bg-gray-50 rounded-lg p-4 space-y-2">
            <div class="flex items-center justify-center space-x-2">
              <svg
                class="h-5 w-5 text-red-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              <p class="font-semibold text-gray-900">
                STATION {{ currentIncident.station }}
              </p>
            </div>

            <div class="flex items-center justify-center space-x-2">
              <svg
                class="h-5 w-5 text-gray-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <p class="text-gray-700">{{ currentIncident.time_reported }}</p>
            </div>

            <div class="flex items-center justify-center space-x-2">
              <p class="text-gray-700">{{ currentIncident.location }}</p>
            </div>
          </div>

          <button
            @click="addSeen"
            type="button"
            class="mt-6 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
          >
            Acknowledge
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes blink {
  0%,
  100% {
    border-color: blue;
    color: rgb(21, 0, 255);
  }
  50% {
    border-color: transparent;
    color: white;
  }
}

@keyframes blinkShadow {
  0% {
    box-shadow: 100vw 0 0px 0px rgba(255, 0, 0, 0.7);
  }
  50% {
    box-shadow: 100vw 0 0px 0px rgba(255, 0, 0, 0.2);
  }
  100% {
    box-shadow: 100vw 0 0px 0px rgba(255, 0, 0, 0);
  }
}

@keyframes slideInFromTop {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(0);
  }
}

.blink {
  animation: blink 1s infinite;
}

.blinking-shadow {
  animation: blinkShadow 2s infinite;
  width: 5px;
  height: 100vh;
  background-color: transparent;
  position: fixed;
  z-index: 50;
  left: -100vw;
  top: 0;
}

.animated-slide-in {
  animation: slideInFromTop 0.5s ease-out forwards;
}

.overlay {
  z-index: 50;
  position: fixed;
  background: rgba(
    75,
    85,
    99,
    0.35
  ); /* Equivalent to bg-gray-900 and bg-opacity-35 */
  top: 0;
  width: 100vw;
  height: 100vh;
}

.center-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

#requests .incident-marker {
  opacity: 1;
}

.modal {
  background-color: white;
  border-radius: 0.375rem; /* Equivalent to rounded-lg */
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05); /* Equivalent to shadow */
  width: 25vw;
  animation: slideInFromTop 0.5s ease-out;
}
</style>

<script>
import NavigationBar from "./Navigations/NavigationBar.vue";
import loading from "./loading.vue";
import adminprofile from "./contents/profile/adminProfile.vue";

export default {
  methods: {
    async checkIncidents() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      try {
        const data = { id: credentials.id, ind: false };
        const response = await this.$store.dispatch("sendData", {
          url: "api/dashboard/generate/emergency/reports",
          data: data,
        });

        // Assuming the API response structure contains reported incidents
        const fetchedIncidents = response.data["reportedIncidents"];

        // Push new incidents if they do not exist
        this.pushIfDoesnotExists(fetchedIncidents);

        // Handle the newly updated incidents list
        this.handleNewIncidents();
      } catch (error) {
        //alert("Error fetching incidents:", error);
      }
    },
    pushIfDoesnotExists(arr) {
      let added = false;
      arr.forEach((item) => {
        const exists = this.incidents.some(
          (incident) => incident.id === item.id
        );
        if (!exists) {
          this.incidents.push({ ...item, seen: false });
          added = true;
        }
      });

      if (added) {
        this.handleNewIncidents(); // Re-evaluate current incident
      }
    },

    handleNewIncidents() {
      this.emergency = this.incidents.length > 0;
      this.$store.state.incidentmarker = this.emergency;

      // Find the first unseen incident
      const unseenIncident = this.incidents.find((incident) => !incident.seen);

      // Set it as the current incident
      if (unseenIncident) {
        this.currentIncident = unseenIncident;
      } else {
        this.currentIncident = null;
      }

      // Stop audio if no emergencies
      if (!this.emergency) {
        this.stopAudio();
      }
    },
    // Example dialog box trigger (not given, assuming a placeholder)
    triggerDialogBox() {
      if (this.incidents.length > 0) {
        // Mark the latest incident as seen
        this.incidents[this.incidents.length - 1].seen = true;
      }
    },
    addSeen() {
      if (this.currentIncident) {
        this.currentIncident.seen = true; // Mark the current incident as seen

        // Move to the next unseen incident
        this.handleNewIncidents();
      }
    },
    isSeen(param) {
      this.seenIncidents.forEach((element) => {
        if (param == element) {
          return true;
        }
      });
      return false;
    },
    startPolling() {
      this.interval = setInterval(() => {
        this.checkIncidents();
      }, 1000000); // Poll every 2 seconds
    },
    toggleProfile() {
      this.closeProfile = !this.closeProfile;
    },
    playAudio() {
      if (this.soundA) {
        this.soundA.play();
      }
    },
    stopAudio() {
      if (this.soundA) {
        this.soundA.pause();
        this.soundA.currentTime = 0; // Reset playback position
      }
    },
    async generateData(rID) {
      const send = await {
        data: { id: rID },
        url: "api/officer/basic/myaccount/view/request",
      };

      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
        this.cred.rank = data.data.rank;
        this.cred.station = data.data.station ? data.data.station : "";
      }
    },
  },
  components: {
    NavigationBar,
    loading,
    adminprofile,
  },
  mounted() {
    this.pages = this.$store.getters.pages;
    this.soundA = new Audio("images/system/notif.mp3");
    this.playAudio();
    this.checkIncidents();
    (async () => {
      await setTimeout(() => {
        this.logged = true;
      }, 500);

      const isValid = await this.$store.dispatch(
        "checkUserAccess",
        "api/check-level-1"
      );

      if (!isValid) {
        this.$store.dispatch("logout");
        this.$router.push("/");
      } else {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.cred = credentials;

        if (!credentials || !(credentials.user_level == 1)) {
          this.$router.push("/");
        }
        await this.startPolling();
      }
      document.body.style.backgroundImage = "";
      await this.generateData(this.cred.id);
    })();
  },
  data() {
    return {
      pages: [],
      logged: false,
      closeProfile: true,
      incidents: [],
      interval: null,
      soundA: null,
      emergency: false,
      seenIncidents: [],
      cred: {
        id: -1,
        station: "",
        rank: "",
      },
      markers: [],
      currentIncident: null,
      emergency: false,
    };
  },
  unmounted() {
    clearInterval(this.interval);
  },
  watch: {
    emergency: {
      handler(newVal, oldVal) {
        if (newVal === true && newVal !== oldVal) {
          this.playAudio();
        }
      },
    },
    incidents: {
      handler(newVal, oldVal) {
        if (newVal.length < oldVal.length) {
          this.seenIncidents = newVal;
        }
        if(newVal.length != 0){
          if(this.markers.length > 0){
            this.markers.forEach(mark =>{
                mark.style.opacity = 1;
            });
          }
        }
      },
    },
  },
};
</script>