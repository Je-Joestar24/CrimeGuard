<template>
  <div
    class="w-full flex top-0 fixed bg-gray-800 bg-opacity-50"
    style="height: 100vh"
  >
    <div class="w-1/2 bg-transparent" @click="tog_ol"></div>
    <div
      class="w-full max-w-xs flex flex-col bg-white shadow-lg relative p-6 sideItBar slide-enter-active rounded-l-lg "
      :class="{ 'slide-leave-active': isVisible }"
    >
      <div class="flex justify-between items-center border-b pb-4 mb-6">
        <h2 class="text-xl font-bold text-gray-800">Profile</h2>
        <button @click="tog_ol" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex items-center space-x-4 mb-6">
        <div class="flex-shrink-0">
          <img v-if="info.profile" :src="info.profile" 
            class="h-16 w-16 rounded-full object-cover border-2 border-blue-500" alt="Profile">
          <div v-else class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900">
            {{ info.user_name ? info.user_name : 'No Name' }}
          </h3>
          <p class="text-sm text-gray-500">{{ info.email ? info.email : 'No Email' }}</p>
        </div>
      </div>
      <nav class="space-y-3">
        <button @click="$emit('changeActive', 'Home'); tog_ol();" 
          class="w-full flex items-center px-4 py-3 text-base font-medium text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 transform hover:scale-105">
          <svg class="mr-4 h-6 w-6 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
          </svg>
          <span class="transition-all duration-300 group-hover:pl-2">Home</span>
        </button>
        <button @click="$emit('changeActive', 'myAccount'); tog_ol();" 
          class="w-full flex items-center px-4 py-3 text-base font-medium text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-all duration-300 transform hover:scale-105">
          <svg class="mr-4 h-6 w-6 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
          </svg>
          <span class="transition-all duration-300 group-hover:pl-2">My Account</span>
        </button>
        <button @click="$emit('changeActive', 'Recent Incidents'); tog_ol();" 
          class="w-full flex items-center px-4 py-3 text-base font-medium text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-600 transition-all duration-300 transform hover:scale-105">
          <svg class="mr-4 h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
          </svg>
          <span class="transition-all duration-300 group-hover:pl-2">Recent Incidents</span>
        </button>
      </nav>
      <div class="mt-auto pt-6 border-t">
        <button
          @click="logout"
          class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
        >
          Logout
        </button>
      </div>
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
    async logout() {
      
      const res = await this.$store.dispatch('logout');
      if(res){
        window.location.reload();
      }
      /* 
      this.$emit('reload') */
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
