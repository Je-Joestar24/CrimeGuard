<template>
  <div
    class="w-full flex top-0 fixed bg-gray-800 bg-opacity-50"
    style="height: 100vh"
  >
    <div class="w-1/2 bg-transparent"
    @click="tog_ol"></div>
    <div
      class="w-full bg-white relative p-3 sideItBar slide-enter-active rounded-s-md"
      :class="{ 'slide-leave-active': isVisible }"
    >
      <div class="w-full flex justify-between border-b mb-2 py-1">
        <span class=" py-1 font-semibold  text-gray-700">PROFILE</span>
        <svg
          @click="tog_ol"
          class="h-8 w-8 active:border active:bg-gray-300 rounded-md p-2 text-gray-800"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M14 5l7 7m0 0l-7 7m7-7H3"
          />
        </svg>
      </div>
      <div class="mb-2 px-3 py-1 pb-2  flex  gap-3">
        <img v-if="info.profile" :src="info.profile" 
        class="h-14 w-14 border-2 border-blue-500 rounded-full text-gray-900 p-0.5" alt=" PROFILE">
        <svg
          v-if="!info.profile"
          class="h-14 w-14 border rounded-md text-gray-900"
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
        <div class="w-40 flex flex-col px-2 my-auto">
          <p
            class=" text-base font-semibold leading-none text-gray-900 border-b pb-1"
          >
            {{ info.user_name ? info.user_name : 'NO DATA' }}
          </p>
          <p class="text-xs text-wrap font-normal text-gray-400">{{ info.email ? info.email : 'NO DATA' }}</p>
        </div>
      </div>
      <div class="w-full grid grid-cols-1 border-t gap-y-2">
        <div
          class="flex items-center p-2 text-gray-900 rounded-sm border-b hover:bg-gray-100 group"
          @click="
            $emit('changeActive', 'myAccount');
            tog_ol();
          "
        >
          <svg
            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
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
            <path
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
            />
            <circle cx="12" cy="12" r="3" />
          </svg>
          <span class="flex-1 ms-3 whitespace-nowrap font-semibold"
            >MY ACCOUNT</span
          >
        </div>
        <div
          class="flex items-center p-2 text-gray-900 rounded-sm border-b hover:bg-gray-100 group"
          @click="
            $emit('changeActive', 'Recent Incidents');
            tog_ol();
          "
        >
          <svg
            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
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
            <path
              d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11"
            />
            <line x1="9" y1="7" x2="13" y2="7" />
            <line x1="9" y1="11" x2="13" y2="11" />
          </svg>
          <span class="flex-1 ms-3 whitespace-nowrap font-semibold"
            >RECENT INCIDENTS</span
          >
        </div>
        <div
          @click="
            $emit('changeActive', 'Reported Incidents');
            tog_ol();
          "
          class="flex items-center p-2 text-gray-900 rounded-sm border-b hover:bg-gray-100 group"
        >
          <svg
            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path
              d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
            />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <polyline points="10 9 9 9 8 9" />
          </svg>
          <span class="flex-1 ms-3 whitespace-nowrap font-semibold"
            >REPORTED INCIDENTS</span
          >
        </div>
      </div>
      <button
        type="button"
        class="py-2.5 px-24 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-400 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 absolute ms-2"
        :class="{ 'bottom-16': scrollUp, 'bottom-2': !scrollUp }"
        @click="logout"
      >
        LOGOUT
      </button>
    </div>
  </div>

  
<!--   <div
    v-if="logoutToggle"
    class="fixed z-50 bg-gray-800 bg-opacity-20 top-0 left-0 flex"
    style="height: 100vh; width: 100vw"
  >
    <div class="w-96 rounded-xl my-auto bg-white shadow animate-popup mx-auto p-2">
      <div class="w-full flex justify-end ">
        <button
          type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
          @click="logout"
        >
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
      <div class="p-0 text-center">
        <svg
          class="mx-auto mb-4 text-gray-400 w-8 h-8"
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
        <h3 class="mb-3 text-sm font-normal text-gray-500">
          Are you sure you want to logout?
        </h3>
        <button
          @click="sendData()"
          type="button"
          class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs inline-flex items-center px-5 py-2.5 text-center"
        >
          Yes, I'm sure
        </button>
        <button
          @click="logout"
          type="button"
          class="py-2.5 px-5 ms-3 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
        >
          No, cancel
        </button>
      </div>
    </div>
  </div> -->
</template>

<script>



export default {
  props: ["toggle", "changeActive"],
  data() {
    return {
      isVisible: false,
      scrollUp: true,
      logoutToggle: false,
      info: {
        profile: "",
        user_name: "",
        email: "",
        contact: "",
      },id: -1
    };
  },
  methods: {
    tog_ol() {
      this.isVisible = !this.isVisible;
      setTimeout(() => {
        this.toggle();
      }, 300);
    },
    sendData() {
      const formData = this.formData;
      localStorage.removeItem('credentials');
      this.logout();
      window.location.reload();
      /* 
      this.$emit('reload') */
    },
    handleScroll() {
      const scrollTop =
        window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > this.lastScrollTop) {
        // Scrolling down
        this.scrollUp = false;
      } else {
        // Scrolling up
        this.scrollUp = true;
      }

      this.lastScrollTop = scrollTop;
    },
    logout() {
      this.logoutToggle = !this.logoutToggle;
      localStorage.removeItem('credentials');
      window.location.reload();
    },
    async sendData() {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/basic/myaccount/view/request",
        data: {
          id: this.id,
        },
      });
      if (data["response"] == "Success") {
        this.info = await data["data"];
      }
    },
  },
  watch: {},
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
    
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
      })();
      await this.sendData();
    })();
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
</script>

<style scoped>
@keyframes slideIn {
  from {
    transform: translateX(100%);
  }
  to {
    transform: translateX(0);
  }
}

@keyframes slideOut {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(100%);
  }
}

.slide-enter-active {
  animation: slideIn 0.3s forwards;
}

.slide-leave-active {
  animation: slideOut 0.3s forwards;
}
</style>
