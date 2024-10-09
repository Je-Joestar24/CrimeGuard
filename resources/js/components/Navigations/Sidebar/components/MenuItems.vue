<template>
  <div class="h-full px-4 py-6 overflow-y-auto bg-white border-r border-gray-200" style="width: 280px;">
    <div class="flex flex-col items-center justify-center mb-10">
      <img class="w-24 h-24 mb-3" src="./img/PoliceLogo.png" alt="Police Logo" />
      <div class="text-center">
        <h2 class="text-xl font-bold text-gray-800">Police Station 1</h2>
        <p class="text-sm text-gray-600">Serving and Protecting</p>
      </div>
    </div>
    <ul v-if="page.length > 0" class="space-y-1" id="sideItems">
      <li v-for="(heads, i) in page" :key="i">
        <NonSubMen 
          v-if="heads.type == 0 && heads.id != 'settings'" 
          :sub-elems="heads"
        />
        <subMenElems 
          v-if="heads.type == 1 && 
            ((heads.id != 'accounts' || userAdmin) && 
            (heads.id != 'officeMonitoring' || userAdmin) && 
            (heads.id != 'archivedData' || userAdmin))" 
          :sub-elem="heads"
        />
      </li>
    </ul>
  </div>
</template>

<script>
import NonSubMen from "./nonSubMen.vue";
import subMenElems from "./subMenElems.vue";

export default {
  props: ["page"],
  components: { subMenElems, NonSubMen },
  computed: {
    userAdmin() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      return credentials ? credentials.user_level == 1 : false;
    }
  }
};
</script>