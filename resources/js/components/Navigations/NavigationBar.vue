<template>
  <nav 
  class="fixed top-0 z-50 w-full  border-b"
  :class="{' bg-gray-800 border-gray-700':$store.getters.theme, 'bg-white border-gray-200 ': !$store.getters.theme}"
  >
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <!-- Upper -->
      <div class="flex items-center justify-between">
        <Navi :toggle-profile="toggleProf2"></Navi>
      </div>
    </div>
  </nav>

  <aside
    id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r  sm:translate-x-0"
    :class="{'bg-gray-800 border-gray-700':$store.getters.theme, 'bg-white border-gray-200': !$store.getters.theme}"
    aria-label="Sidebar"
  >
    <div class="h-full px-3 pb-4 overflow-y-auto"
    :class="{'bg-gray-800':$store.getters.theme,'bg-white':!$store.getters.theme}"
    >

      <!-- SideBar -->
      <SideB 
      v-if="page.length > 0"
      :page="page" 
      ></SideB>
    </div>
  </aside>
</template>

<script>
import Navi from "./Navi/Navi.vue";
import SideB from "./Sidebar/SideB.vue";

export default {
  components: {
    Navi,
    SideB,
  },
  props: ["page", "toggleProfile"],
  methods:{
    toggleProf2(){
      this.toggleProfile();
    }
  }
};
</script>