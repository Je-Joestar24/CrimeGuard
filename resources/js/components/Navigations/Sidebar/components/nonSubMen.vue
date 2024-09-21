<template>
  <router-link
    @click.prevent="changes(subElems.api, [subElems.id, subElems.titlePage, subElems.id]); "
    class="flex items-center p-2 text-gray-900 rounded-lg "
    :to="subElems.nm"
    :class="{
      'text-white active:bg-gray-600 hover:bg-gray-700 ':$store.getters.theme,'text-gray-900 active:bg-gray-200 hover:bg-gray-100':!$store.getters.theme,
      'bg-gray-200': subElems.id == $store.state.CurrentActiveSideBar && !$store.getters.theme,
      'bg-gray-600': subElems.id == $store.state.CurrentActiveSideBar && $store.getters.theme,
    }"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="w-5 h-5 transition duration-75"
    >
      <path
        v-for="pt in subElems.pth"
        :stroke-linecap="pt['stroke-linecap']"
        :stroke-linejoin="pt['stroke-linejoin']"
        :d="pt.d"
      />
    </svg>
    <span class="ms-3"></span>
    {{ subElems.nm }}
  </router-link>
</template>

<script>
export default {
  props: ["subElems"],
  methods:{
    changes(param1, param2){
      this.$store.dispatch('changeAPI', param1);
      this.$store.commit('changeActivePage', param2);
    }
  }
};
</script>