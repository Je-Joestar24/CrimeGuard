<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
    :class="{ 'hidden': isHidden }"
  >
    <div class="relative w-full max-w-6xl p-6 bg-white rounded-lg shadow-xl">
      <button
        @click="hiddenT('view')"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200"
      >
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      
      <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b">View Person Details</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
          <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center">
            <div class="w-48 h-48 bg-gray-300 rounded-full overflow-hidden mb-4">
              <img v-if="profile" :src="profile" alt="Profile" class="w-full h-full object-cover">
              <svg v-else class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">{{ data.first_name }} {{ data.last_name }}</h3>
            <p class="text-gray-600">{{ data.nick_name || 'No nickname' }}</p>
          </div>
        </div>
        
        <div class="md:col-span-2">
          <basic :setProf="setProf" :suspectIdRequest="suspectId" />
        </div>
      </div>
      
      <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Other Information</h3>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
          <div class="flex border-b border-gray-200">
            <button
              v-for="nav in viewOtherNav.options"
              :key="nav"
              @click="changeViewNav(nav)"
              class="px-4 py-2 text-sm font-medium"
              :class="{
                'bg-blue-50 text-blue-600': nav === viewOtherNav.active,
                'text-gray-500 hover:text-gray-700': nav !== viewOtherNav.active
              }"
            >
              {{ nav }}
            </button>
          </div>
          
          <div class="p-4">
            <component
              :is="activeComponent"
              :suspectIdRequest="suspectId"
            ></component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import addresses from "./viewModalComponents/person/addressess.vue";
import background from "./viewModalComponents/person/background.vue";
import physical from "./viewModalComponents/person/physical.vue";
import records from "./viewModalComponents/person/records.vue";
import victims from "./viewModalComponents/person/victims.vue";
import basic from "./viewModalComponents/person/basic.vue";

export default {
  components: {
    addresses,
    background,
    physical,
    records,
    victims,
    basic,
  },
  props: ["isHidden", "hiddenT", "suspectId"],
  data() {
    return {
      profile: '',
      data: {},
      viewOtherNav: {
        active: "ADDRESSES",
        options: [],
      },
    };
  },
  computed: {
    activeComponent() {
      const componentMap = {
        "ADDRESSES": addresses,
        "PHYSICAL CHARACTERISTICS": physical,
        "BACKGROUND INFORMATION": background,
        "PREVIOUS RECORDS": records,
        "VICTIMS": victims,
      };
      return componentMap[this.viewOtherNav.active];
    },
  },
  created() {
    if (this.$store.getters.getActive === "innerSuspects" || this.$store.getters.getActive === "innerSuspectsArchive") {
      this.viewOtherNav.options = [
        "ADDRESSES",
        "PHYSICAL CHARACTERISTICS",
        "BACKGROUND INFORMATION",
        "PREVIOUS RECORDS",
        "VICTIMS",
      ];
    } else {
      this.viewOtherNav.options = ["ADDRESSES", "PREVIOUS RECORDS"];
    }
  },
  methods: {
    changeViewNav(param) {
      this.viewOtherNav.active = param;
    },
    setProf(param) {
      this.profile = param;
    },
  },
};
</script>