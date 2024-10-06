<template>
  <loading v-if="!logged"></loading>
  <div
    v-if="logged"
    id="sidebar"
    class="sidebar"
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
        id="DisplayContentArea"
        class="p-4 mt-14"
        :class="{ 'border-gray-700': this.$store.getters.theme }"
      >
        <div class="container">
          <h1
            @click="playAudio"
            class="text-xl bg-gray-200 font-bold p-3 border rounded shadow-lg mb-10"
            :class="{
              'text-gray-100 border-gray-700': $store.getters.theme,
              ' bg-gray-50': !$store.getters.theme,
            }"
          >
            {{ $store.state.CurrentActiveTitleNavigation }}
          </h1>
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>

  <!-- 
    THe off canvas
   -->
  <adminprofile
    v-if="!closeProfile"
    :toggle-profile="toggleProfile"
    :close-profile="closeProfile"
  ></adminprofile>
  <!-- <div v-if="emergency" class="blinking-shadow"></div> 
  <div
    v-if="emergency"
    class="z-50 bg-red-700 fixed flex justify-center h-60 w-60 bg-transparent"
    style="top: 30vh; right: 45vw"
  >
    <svg
      class="blink h-60 w-60 text-red-300"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="solid"
    >
      <polygon
        points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"
      />
      <line x1="12" y1="8" x2="12" y2="12" />
      <line x1="12" y1="16" x2="12.01" y2="16" />
    </svg>
  </div>-->
  <div
    class="bg-red-600 font-bold px-8 fixed top-0 z-50 p-3 right-32 text-white border-4 border-red-400 blink flex gap-2"
    v-if="emergency"
  >
    <svg
      class="h-6 w-6"
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
    {{ cred.user_level == 1 ? "EMERGENCY REPORT" : "ASSIGNED" }}
  </div>
  <div
    v-if="emergency && seenIncidents.length != incidents.length"
    class="z-50 fixed bg-gray-900 top-0 bg-opacity-35"
    style="width: 100vw; height: 100vh"
  >
    <div class="w-full flex justify-center">
      <div
        class="bg-white rounded-lg modal animated-slide-in relative shadow-[16px_16px_20px_#0000008c] before:absolute before:top-[-50%] before:left-[-50%] before:right-[-50%] before:bottom-[-50%] before:bg-[conic-gradient(transparent,transparent,#03045e)] overflow-hidden before:animate-spin"
        style="width: 25vw; padding: 2px"
      >
        <div class="bg-white relative rounded-md">
          <div class="p-4 md:p-5 text-center">
            <svg
              class="mx-auto mb-4 text-red-400 w-12 h-12"
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
                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              />
            </svg>
            <h3
              class="mb-5 text-lg font-semibold text-gray-500 border-b-2 border-red-900"
            >
              {{
                cred.user_level == 1
                  ? "EMERGENCY REPORT DETECTED"
                  : "YOU'VE BEEN ASSIGNED"
              }}
            </h3>
            <button
              @click="addSeen"
              type="button"
              class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
            >
              OK
            </button>
          </div>
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
  components: {
    NavigationBar,
    loading,
    adminprofile,
  },
  mounted() {
    this.pages = this.$store.getters.pages;
    this.soundA = new Audio("/storage/files/emergency.mp3");
    this.soundA.addEventListener("ended", () => {
      this.stopAudio();
      this.playAudio();
    });
    this.checkIncidents();
    (async () => {
      await setTimeout(() => {
        this.logged = true;
      }, 500);
      await this.startPolling();

      const credentials = JSON.parse(localStorage.getItem("credentials"));
      this.cred = credentials;

      if (
        !credentials ||
        !(credentials.user_level == 2 || credentials.user_level == 1)
      ) {
        this.$router.push("/");
      }
      document.body.style.backgroundImage = "";
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
      cred: {},
    };
  },
  methods: {
    toggleProfile() {
      this.closeProfile = !this.closeProfile;
    },
    playAudio() {
      if (this.soundA) {
        this.soundA.play();
      }
    },
    addSeen() {
      for (let i = 0; i < this.incidents.length; i++) {
        if (!this.isSeen(this.incidents[i]))
          this.seenIncidents.push(this.incidents[i]);
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
    stopAudio() {
      if (this.soundA) {
        this.soundA.pause();
        this.soundA.currentTime = 0; // Reset playback position
      }
    },
    startPolling() {
      this.interval = setInterval(() => {
        this.checkIncidents();
      }, 300000); // Poll every 2 seconds
    },
    async checkIncidents() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      try {
        const data = credentials.user_level == 2 ? { id: credentials.id } : {};
        const response = await this.$store.dispatch("sendData", {
          url: "api/dashboard/generate/emergency/reports",
          data: data,
        });
        this.incidents = response.data["reportedIncidents"];
        this.handleNewIncidents();
      } catch (error) {
        alert("Error fetching incidents:", error);
      }
    },
    handleNewIncidents() {
      // Handle new incidents (e.g., show notifications, update UI, etc.)
      //console.log("New incidents:", this.incidents);

      this.emergency = this.incidents.length > 0 ? true : false;
      if (this.incidents.length <= 0) this.stopAudio();
      if (this.incidents.length != this.seenIncidents.length)
        this.seenIncidents = [];
    },
  },
  unmounted() {
    clearInterval(this.interval);
  },
  watch: {
    emergency: {
      handler(newVal, oldVal) {
        if (newVal === true && newVal !== oldVal) {
          console.log(newVal);
          this.playAudio();
        }
      },
    },
    incidents: {
      handler(newVal, oldVal) {
        if (newVal.length < oldVal.length) {
          this.seenIncidents = newVal;
        }
      },
    },
  },
};
</script>