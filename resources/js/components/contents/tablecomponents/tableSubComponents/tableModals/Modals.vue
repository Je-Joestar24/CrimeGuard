<template>
  <!-- Main modal -->
  <div
    v-show="!loading"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
    <div
      class="relative bg-white rounded-lg w-full shadow-zinc-900 shadow-2xl"
      :style="width"
      :class="{
        'max-w-7xl':
          ($store.getters.CurrentActiveSideBar != 'innerNameIncidents' && 
          $store.getters.CurrentActiveSideBar != 'innerSuspects') ,
        'max-w-xl':
          $store.getters.CurrentActiveSideBar == 'innerNameIncidents'
      }"
    >
      <!-- dark:bg-gray-700 -->
      <!-- Modal content -->
      <div class="p-4 md:p-5 border-b shadow rounded-t">
        <!-- Modal header -->
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">
            <!-- dark:text-white -->
            <span style="text-transform: capitalize">{{ title }}</span>
          </h3>
          <button
            type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
            @click="toggle"
          >
            <!--  @click.prevent="toggle()" -->
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
          <!-- Close button -->
        </div>
        <!-- Modal body -->
        <incidentForm
          v-if="
            ($store.getters.getActive == 'innerIncident' ||
              $store.getters.getActive == 'innerIncidentArchive') 
          "
          :loadinging="loadingT"
          :outLoading="outL"
        />
        <incidentTypeForm
        :toggle="toggle"
        :reloadTab1="reloadTab"
          v-if="
            !(
              $store.getters.getActive == 'innerIncident' ||
              $store.getters.getActive == 'innerIncidentArchive'
            )
          "
          :loadinging="loadingT"
          :outLoading="outL"
        />
      </div>
    </div>
  </div>

  <addLoading v-if="loading"></addLoading>
</template>


<script>
import incidentForm from "./modalForms/incidentsForm.vue";
import incidentTypeForm from "./modalForms/dynamicAddForm.vue";
import addLoading from "./loading/addLoading.vue";

export default {
  components: {
    incidentForm,
    incidentTypeForm,
    addLoading
  },
  data() {
    return {
      title: "",
      width: "",
      loading: false
    };
  },
  props: [ "toggle", "reloadTab"],
  computed: {},
  mounted() {
    this.getTitle();
    if(this.$store.getters.CurrentActiveSideBar == 'innerSuspects'){
      this.width = "width: 95vw;"
    }
  },
  methods: {
    getTitle() {
      this.title = this.$store.getters.currentActiveTitle;
      this.title = this.title.toString().toLowerCase();
    },loadingT(){
      this.loading = true
    },outL(){
      this.loading = false
    }
  },watch: {
    '$store.getters.currentActiveTitle': function(newVal, oldVal){
      if(newVal != oldVal){
        this.getTitle()
      }
    },

    '$store.getters.CurrentActiveSideBar':function(newVal, oldVal){
        if(newVal == 'innerSuspects'){
          this.width = "width: 95vw;"
        }
    }
  }
};
</script>