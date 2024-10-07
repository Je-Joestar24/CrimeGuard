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
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
          <line x1="12" y1="9" x2="12" y2="13" />
          <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
      </div>
      <div class="px-4 py-2 font-semibold">
        {{ cred.user_level == 1 ? "Emergency Report" : "New Assignment" }}
      </div>
    </div>
  </transition>
<!--   <transition
    enter-active-class="transform ease-out duration-300 transition"
    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
    leave-active-class="transition ease-in duration-100"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div v-if="emergency" class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
      <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900">
                {{ cred.user_level == 1 ? "Emergency Report" : "New Assignment" }}
              </p>
              <p class="mt-1 text-sm text-gray-500">
                {{ cred.user_level == 1 ? "A new emergency report has been filed. Immediate attention required." : "You have been assigned to a new incident. Please check your assignments." }}
              </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button @click="emergency = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition> -->
  <div
    v-if="emergency && seenIncidents.length != incidents.length"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 flex items-center justify-center"
  >
    <div class="bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:max-w-sm sm:w-full sm:p-6">
      <div>
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
          <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
        <div class="mt-3 text-center sm:mt-5">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ cred.user_level == 1 ? "Emergency Report Detected" : "New Assignment" }}
          </h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              {{ cred.user_level == 1 ? "A new emergency report has been filed. Immediate attention is required." : "You have been assigned to a new incident. Please check your assignments for details." }}
            </p>
          </div>
        </div>
      </div>
      <div class="mt-5 sm:mt-6">
        <button
          @click="addSeen"
          type="button"
          class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
        >
          Acknowledge
        </button>
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