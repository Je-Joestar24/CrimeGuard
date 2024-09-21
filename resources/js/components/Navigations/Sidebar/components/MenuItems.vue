<template>
  <ul v-if="page.length > 0" class="space-y-2 font-medium" id="sideItems">
    <!-- Display Menu here -->
    <div>
      <div
        class="max-w-sm text-center mb-10 align-middle border  rounded-lg shadow"
        :class="{'bg-gray-800 border-gray-700 text-gray-100':$store.getters.theme,'bg-white border-gray-200':!$store.getters.theme,}"
      >
        <!-- dark: -->
        <div class=" py-10">
          <img
            class="w-20 inline-block"
            src="./img/PoliceLogo.png"
            alt="CrimeGuard Logo"
          />
          <p class="mt-3">POLICE STATION 1</p>
        </div>
        
      </div>
    </div>

    <li v-for="(heads, i) in page">
      <NonSubMen v-if="heads.type == 0 && ( heads.id != 'settings')" :sub-elems="heads"></NonSubMen>
      <subMenElems v-if="heads.type == 1 && (
        (heads.id != 'accounts' || userAdmin) 
      && (heads.id != 'officeMonitoring' || userAdmin) 
      && (heads.id != 'archivedData' || userAdmin))" :sub-elem="heads"></subMenElems>
    </li>
  </ul>
</template>

<script>
import NonSubMen from "./nonSubMen.vue";
import subMenElems from "./subMenElems.vue";

export default {
  props: ["page"],
  components: { subMenElems, NonSubMen },
  methods:{
  },
  computed:{
    userAdmin(){
      
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return (
          credentials.user_level == 1
        );
      }
    }
  }
};
</script>