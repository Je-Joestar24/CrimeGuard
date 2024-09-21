<template>
  <div class="mb-4 transparent">
    <addNew v-if="!($store.getters.getActive == 'innerIncidentArchive' || $store.getters.getActive == 'innerSuspectsArchive' || $store.getters.getActive == 'innerVictimsArchive' || $store.getters.getActive == 'innerWitnessesArchive' || $store.getters.getActive == 'innerAccountsArchive')" class="block my-3" @click.prevent="changeForm('Add')"></addNew>
    <actions></actions>
    <div class="float-end my-3 flex gap-3">
      <searchBar class=""></searchBar>
    </div>

    <div
      data-accordion="collapse"
      data-active-classes="bg-blue-100 border dark:bg-gray-800 text-blue-600 dark:text-white"
    >
      <filterDropDown></filterDropDown>
    </div>
  </div>
</template>

<script>
import searchBar from "./tableFuntions/searchBar.vue";
import actions from "./tableFuntions/actions.vue";
import addNew from "./tableFuntions/addNew.vue";
import filterDropDown from "./tableModals/modalForms/filterDropDown.vue";

export default {
  components: {
    searchBar,
    actions,
    addNew,
    filterDropDown,
  },
  props: ["changeForm"],
};
</script>

