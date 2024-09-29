<template>
  <div class="flex items-center">
    <div class="flex items-center ms-3">
    <div>
        <button
          type="button"
          class="flex text-sm rounded-full focus:ring-4"
          :class="{
            'focus:ring-gray-600 bg-gray-800 ': $store.getters.theme,
            'focus:ring-gray-300': !$store.getters.theme,
          }"
          @click="profile = !profile"
          aria-expanded="false"
        >
          <span class="sr-only">Open user menu</span>

          <svg v-if="info.profile == ''" class="h-8 w-8" fill="none" viewBox="0 0 24 24" :stroke="prof">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <img v-if="info.profile != ''" class="h-10 rounded-full border w-10 text-gray-500 my-auto" :src="info.profile" alt="">
          
        </button>
      </div>
      <div
        v-if="profile"
        class="fixed top-8 right-3 lg:right-5 my-4 text-base list-none rounded shadow z-50"
        :class="{
          'bg-gray-700 divide-gray-600': $store.getters.theme,
          'bg-white divide-y divide-gray-100 ': !$store.getters.theme,
        }"
        style="z-index: 999; display: relative"
      >
        <div class="px-4 py-3" role="none">
          <p
            class="text-sm"
            :class="{
              'text-white': $store.getters.theme,
              'text-gray-900': !$store.getters.theme,
            }"
            role="none"
          >
            {{ info.user_name }}
          </p>
          <p
            class="text-sm font-medium truncate"
            :class="{
              'text-gray-300': $store.getters.theme,
              'text-gray-900': !$store.getters.theme,
            }"
            role="none"
          >
            <!--  dark: -->
           {{ info.email }}
          </p>
        </div>
        <ul class="py-1" role="none">
          <li>
            <button
              class="block px-4 py-2 text-sm"
              role="menuitem"
              @click="
                toggleProfile();
                profile = !profile;
              "
              :class="{
                'text-gray-300 hover:bg-gray-600 hover:text-white':
                  $store.getters.theme,
                'text-gray-700 hover:bg-gray-100': !$store.getters.theme,
              }"
            >
              My Account
            </button>
            <!--  -->
          </li>
          <li>
            <button
              class="block px-4 py-2 text-sm"
              role="menuitem"
              :class="{
                'text-gray-300 hover:bg-gray-600 hover:text-white':
                  $store.getters.theme,
                'text-gray-700 hover:bg-gray-100': !$store.getters.theme,
              }"
              @click="
                logout = !logout;
                profile = !profile;
              "
            >
              Log out
            </button>
            <!--  -->
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div
    v-if="logout"
    class="fixed z-50 bg-gray-800 bg-opacity-20 top-0 left-0 flex justify-center align-middle"
    style="height: 100vh; width: 100vw"
  >
    <div class="w-1/4 rounded-xl mt-44 bg-white shadow h-1/4 animate-popup">
      <div class="w-full flex justify-end pt-2 pe-2">
        <button
          type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
          @click="logout = !logout"
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
      <div class="p-4 md:p-5 text-center">
        <svg
          class="mx-auto mb-4 text-gray-400 w-12 h-12"
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
        <h3 class="mb-5 text-lg font-normal text-gray-500">
          Are you sure you want to logout?
        </h3>
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
          class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
        >
          Yes, I'm sure
        </button>
        <button
          @click="logout = !logout"
          type="button"
          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
        >
          No, cancel
        </button>
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
