<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <button
          type="button"
          class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          @click.prevent="toggle()"
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
        <div class="p-4 md:p-5 text-center">
          <div class="flex text-black font-semibold justify-center">
            VIEW DETAILS
          </div>
          <div>
            <div class="flex p-1 gap-1" style="height: 35vh">
              <div
                class="p-5 flex flex-col justify-center items-center border rounded-lg border-gray-200 shadow-md bg-gray-100"
              >
              <svg
                v-if="!profile"
                class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
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
              <img v-if="profile" class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50 object-cover object-top" :src="profile" alt="">
                <span
                  class="font-bold mt-3 py-2 bg-gray-200 w-60 text-center rounded-md border border-gray-500"
                  >{{ user_name ? user_name : "NO DATA" }}</span
                >
              </div>
              <!-- Basic infos -->
              <basic :suspectIdRequest="suspectId" :set="set"></basic>
            </div>
            <h1
              class="text-md py-2 rounded-md border-b border-gray-400 mb-1 font-bold text-gray-900"
            >
              ADDRESS INFORMATION
            </h1>
            <div
              class="flex flex-col rounded-lg border border-gray-300 shadow-sm"
              style="height: 45vh"
            >
              <!-- NAVIGATION -->
              <h1
                class="text-start flex gap-0 bg-blue-200 rounded-t-lg text-sm font-bold text-gray-700"
              ></h1>
              <div>
                <addresses :suspectIdRequest="suspectId"></addresses>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import basic from './accountProfile/basic.vue';
import addresses from './accountProfile/address.vue';

export default {
  components: {
    basic,
    addresses
  },
  props: ["toggle", "suspectId"],
  data() {
    return {
      info: {},
      viewForm: {},
      profile: "",
      user_name: ""
    };
  },
  watch: {},
  created() {},
  methods: {
    set(profile, user){
      this.profile = profile;
      this.user_name = user;
    }
  },
};
</script>