<template>
  <div class="relative">
    <button
      type="button"
      class="flex items-center space-x-3 focus:outline-none"
      @click="profile = !profile"
      aria-expanded="false"
    >
      <div class="relative w-10 h-10 overflow-hidden rounded-full border-2 border-blue-500 transition-all duration-300 hover:border-blue-600">
        <img 
          v-if="info.profile" 
          :src="info.profile" 
          alt="User profile"
          class="w-full h-full object-cover"
        >
        <svg 
          v-else 
          class="absolute w-full h-full text-gray-300" 
          fill="currentColor" 
          viewBox="0 0 24 24"
        >
          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>
      <div class="hidden md:block text-left">
        <p class="text-sm font-medium" :class="{'text-white': $store.getters.theme, 'text-gray-900': !$store.getters.theme}">
          {{ info.user_name }}
        </p>
        <p class="text-xs" :class="{'text-gray-300': $store.getters.theme, 'text-gray-500': !$store.getters.theme}">
          {{ info.email }}
        </p>
      </div>
      <svg class="w-4 h-4 ml-1" :class="{'text-white': $store.getters.theme, 'text-gray-400': !$store.getters.theme}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-if="profile"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none grid"
        :class="{'bg-gray-800': $store.getters.theme}"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        tabindex="-1"
      >
        <button
          class="block px-4 py-2 text-sm" 
          :class="{'text-gray-300 hover:bg-gray-700': $store.getters.theme, 'text-gray-700 hover:bg-gray-100': !$store.getters.theme}"
          role="menuitem" 
          tabindex="-1" 
          @click="toggleProfile(); profile = false;"
        >
          My Account
        </button>
        <button
          class="block px-4 py-2 text-sm" 
          :class="{'text-gray-300 hover:bg-gray-700': $store.getters.theme, 'text-gray-700 hover:bg-gray-100': !$store.getters.theme}"
          role="menuitem" 
          tabindex="-1" 
          @click="logout = true; profile = false;"
        >
          Log out
        </button>
      </div>
    </transition>
  </div>
  <div
    v-if="logout"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Confirm Logout
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Are you sure you want to log out? You will be redirected to the login page.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button
            @click.prevent="
              sendData();
              $store.commit('changeActivePage', [
                'dashboard',
                'DASHBOARD',
                'dashboard',
              ]);
            "
            type="button"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
          >
            Logout
          </button>
          <button
            @click="logout = false"
            type="button"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {},
      prof: "darkgray",
      logout: false,
      profile: false,
      info: {
        user_name: "",
        email: "",
        contact: "",
        profile: "",
        rank: "",
      },
      id: -1,
    };
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
    this.generateData(this.id);
  },
  created() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
    this.generateData(this.id);
  },
  methods: {
    sendData() {
      localStorage.removeItem("credentials");
      this.$router.push("/");
    },
    changeProf() {
      this.prof = "lightgray";
    },
    async generateData(rID) {
      const send = await {
        data: { id: rID },
        url: "api/officer/basic/myaccount/view/request",
      };

      //console.log(send)
      const data = await this.$store.dispatch("sendData", send);

      if (data.response == "Success") {
        this.info = data.data;
        console.log(data.data)
      } else {
        alert();
      }
    },
  },
  props: ["toggleProfile"],
};
</script>
