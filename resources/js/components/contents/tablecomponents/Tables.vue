

<template>
  <div class="relative overflow-x-auto">
    <div class="mb-4 transparent">
      <div class="my-3 flex mb-6 px-2">
        <div class="flex w-full">
          <button
            v-if="
              !(
                $store.getters.getActive == 'innerIncidentArchive' ||
                $store.getters.getActive == 'innerSuspectsArchive' ||
                $store.getters.getActive == 'innerVictimsArchive' ||
                $store.getters.getActive == 'innerWitnessesArchive' ||
                $store.getters.getActive == 'innerAccountsArchive'
              )
            "
            @click="toggleIncident"
            type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-md text-xs px-3 py-1.5 block my-2"
          >
            <!--  dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 -->ADD
          </button>
        </div>
        <div class="relative mt-1 my-2 inline">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <!-- dark:text-gray-400 -->  
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text"class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" v-model="search1"  placeholder="Search">
            <!--  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
        </div>
      </div>

      <div
        data-accordion="collapse"
        data-active-classes="bg-blue-100 border dark:bg-gray-800 text-blue-600 dark:text-white"
      >
        <!-- <filterDropDown></filterDropDown> -->
      </div>
    </div>
    <table
      class="w-full text-sm text-left rtl:text-right"
      :class="{
        'text-gray-400': $store.getters.theme,
        ' text-gray-500 ': !$store.getters.theme,
      }"
    >
      <!-- dark:text-gray-400 -->
      <thead
        class="text-xs uppercase"
        :class="{
          'text-gray-400 bg-gray-700': $store.getters.theme,
          ' bg-gray-50': !$store.getters.theme,
        }"
      >
        <!-- dark:bg-gray-700 dark:text-gray-400 -->
        <TableHeaders v-if="header.length > 0" :headers="header"></TableHeaders>
      </thead>
      <tbody>
        <TableBody
          v-if="data.length > 0"
          :tab-data="data"
          :type="type"
          :getTData="getTableData"
        ></TableBody>
        <td
          v-if="data.length == 0"
          class="text-center font-semibold text-gray-600 h-20 bg-gray-50 rounded-b-md"
          :colspan="header.length + 2"
        >
          No table data
        </td>
      </tbody>
    </table>
    <Modals
      :reloadTab="getTableData"
      :toggle="toggleIncident"
      v-show="incidentAddOpen"
      v-if="$store.getters.getActive != 'innerIncident'"
    ></Modals>

    <incidentAddFrom
      :toggle="toggleIncident"
      v-if="$store.getters.getActive == 'innerIncident' && incidentAddOpen"
      :reloadTab="getTableData"
    ></incidentAddFrom><!-- 
      v-show="incidentAddOpen" -->
  </div>
</template>

<script>
import actions from "./tableSubComponents/tableFuntions/actions.vue";
import addNew from "./tableSubComponents/tableFuntions/addNew.vue";
import filterDropDown from "./tableSubComponents/tableModals/modalForms/filterDropDown.vue";
import TableTopComponents from "./tableSubComponents/TableTopComponents.vue";
import TableHeaders from "./tableSubComponents/TableHeaders.vue";
import TableBody from "./tableSubComponents/TableBody.vue";
import Modals from "./tableSubComponents/tableModals/Modals.vue";
import incidentAddFrom from "./tableSubComponents/tableModals/modalForms/incidentAddform.vue";

export default {
  components: {
    TableTopComponents,
    TableHeaders,
    TableBody,
    Modals,
    actions,
    addNew,
    filterDropDown,
    incidentAddFrom,
  },
  data() {
    return {
      modalIsOpen: false,
      currentOpenForm: "Add",
      header: [],
      data: [],
      type: 1,
      incidentAddOpen: false,
      search1: '',
    };
  },
  mounted() {
    this.getTableData('',this.$store.getters.api);
  },
  watch: {
    "$store.getters.api": {
      handler(newVal, oldVal) {
        /* console.log("API getter changed:", newVal, oldVal); */
        this.getTableData('',newVal);
        this.search1 = '';
      }
    },'search1': function(newVal, oldVal){
        const data = {'search': newVal};
        this.getTableData(data, this.$store.getters.api);

      }
  },
  methods: {
    initializeDataTable() {
      /* $(document).ready(() => {
        $("#tableUsed").dataTable({
          searching: false,
          lengthMenu: [5],
          lengthChange: false,
          pagingType: "simple_numbers",
        });

        $(".dataTables_paginate").css("float", "right");
        $(".dataTables_paginate").css("height", "1px");
        $(".dataTables_paginate .paginate_button").css("font-size", "12px");
      }); */
    },
    toggleAddModal() {
      this.modalIsOpen = !this.modalIsOpen;
      this.changeCurrentForm("Add");
    },
    toggleIncident() {
      this.incidentAddOpen = !this.incidentAddOpen;
    },
    changeCurrentForm(newForm) {
      this.currentOpenForm = newForm;
    },
    async getTableData(param, url) {
      this.header = [];
      this.data = [];
      
      const send = await {
        data: param,
        url: url,
      };

      await console.log(send);
      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];
      
      if (data.response == "Success") {
        this.header = await data["table"]["headers"];
        this.data = await data["table"]["data"];
        this.type = await data["table"]["type"];
        console.log(this.data);
      }
    },
  },
};
</script>
