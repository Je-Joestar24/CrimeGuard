<template>
  <tr
    class="border-b"
    :class="{
      'bg-gray-800 border-gray-700 hover:bg-gray-600': $store.getters.theme,
      'bg-white text-gray-700 hover:bg-gray-50': !$store.getters.theme,
    }"
    v-for="dataSets in tabData"
  >
    <!-- bg-gray-800 border-gray-700 *  hover:bg-gray-600-->
    <td class="w-4 p-4">
      <div class="flex items-center">
        <input
          :id="dataSets.id"
          class="w-4 h-4 rounded"
          :class="{
            'focus:ring-blue-600 ring-offset-gray-800 focus:ring-offset-gray-800 focus:ring-2bg-gray-700 border-gray-600':
              $store.getters.theme,
            ' focus:ring-blue-500 text-blue-600 bg-gray-100 border-gray-300':
              !$store.getters.theme,
          }"
          type="checkbox"
        />
      </div>
    </td>
    <td class="px-6 py-4" v-for="datas in dataSets">{{ datas }}</td>
    <td class="px-6 py-4 flex gap-1">
      <button
      v-if="$store.getters.getActive != 'innerNameIncidents'"
        @click.prevent="viewItem(dataSets['id'])"
        type="button"
        class="text-gray-600 hover:bg-gray-700 bg-gray-600 px-2 py-1 rounded-lg"
        :class="{
          'text-gray-500': $store.getters.theme,
          'text-gray-600': !$store.getters.theme,
        }"
        data-modal-target="incident-modal"
        data-modal-toggle="incident-modal"
      >
        <svg
          class="h-5 w-5 text-gray-100"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" />
          <circle cx="12" cy="12" r="2" />
          <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />
          <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" /></svg
      ></button>
      <button
        v-if="$store.getters.getActive == 'innerIncident'"
        @click.prevent="editIncident(dataSets['id'])"
        type="button"
        class="text-gray-600 hover:bg-blue-700 bg-blue-600 px-1 py-1 rounded-md"
        :class="{
          'text-blue-500': $store.getters.theme,
          'text-blue-600': !$store.getters.theme,
        }"
        data-modal-target="incident-modal"
        data-modal-toggle="incident-modal"
      >
        <svg
          class="h-5 w-5 text-gray-900"
          fill="none"
          viewBox="0 0 24 24"
          stroke="white"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
          />
        </svg>
      </button>
      <button
        v-if="$store.getters.getActive != 'innerIncident'"
        @click.prevent="editItem(dataSets['id'])"
        type="button"
        class="text-gray-600 hover:bg-blue-700 bg-blue-600 px-1 py-1 rounded-md"
        :class="{
          'text-blue-500': $store.getters.theme,
          'text-blue-600': !$store.getters.theme,
        }"
        data-modal-target="incident-modal"
        data-modal-toggle="incident-modal"
      >
        <svg
          class="h-5 w-5 text-gray-900"
          fill="none"
          viewBox="0 0 24 24"
          stroke="white"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
          />
        </svg>
      </button>
      <button
        @click.prevent="
          deleteIt(dataSets['id'], )
        "
        v-if="type == 1"
        type="button"
        class="text-gray-600 hover:bg-red-700 bg-red-600 px-1 py-1 rounded-md"
        :class="{
          'text-blue-500': $store.getters.theme,
          'text-blue-600': !$store.getters.theme,
        }"
        data-modal-target="incident-modal"
        data-modal-toggle="incident-modal"
      >
        <svg
          class="h-5 w-5 text-gray-900"
          viewBox="0 0 24 24"
          fill="none"
          stroke="white"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="3 6 5 6 21 6" />
          <path
            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
          />
          <line x1="10" y1="11" x2="10" y2="17" />
          <line x1="14" y1="11" x2="14" y2="17" />
        </svg>
      </button>
      <button
        v-if="type == 0"
        @click="restoreItem({id: dataSets['id'],user_id: users_id})"
        type="button"
        class="text-gray-600 hover:bg-green-700 bg-green-600 px-1 py-1 rounded-md"
        :class="{
          'text-blue-500': $store.getters.theme,
          'text-blue-600': !$store.getters.theme,
        }"
        data-modal-target="incident-modal"
        data-modal-toggle="incident-modal"
      >
        <svg
          class="h-5 w-5 text-gray-900"
          viewBox="0 0 24 24"
          fill="none"
          stroke="white"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="1 4 1 10 7 10" />
          <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
        </svg>
      </button>
    </td>
  </tr>
  <tr
    class="border-b text-center"
    :class="{
      'bg-gray-800 border-gray-700 hover:bg-gray-600': $store.getters.theme,
      'bg-white text-gray-700 hover:bg-gray-50': !$store.getters.theme,
    }"
  ></tr>
  <incidentEditForm :reloadTab="getTData" :rId="viewRequestId" :toggle="editIncident" v-if="!editIncidentModal && ($store.getters.getActive == 'innerIncident')"></incidentEditForm>
  <dynamicEditForm :reloadTab="getTData" :rId="viewRequestId" :toggle="editItem" v-if="!editModal && ($store.getters.getActive != 'innerIncident')"></dynamicEditForm>
  <deleteM :isHidden="deleteModal" :sendData="sendData" :hiddenT="hiddenTogggle"></deleteM>
  <suspectView  :suspectId="viewRequestId" v-if="($store.getters.getActive == 'innerSuspects' || $store.getters.getActive == 'innerVictims' || $store.getters.getActive == 'innerWitnesses' || $store.getters.getActive == 'innerWitnessesArchive' ||  $store.getters.getActive == 'innerSuspectsArchive' || $store.getters.getActive == 'innerVictimsArchive') && !viewModal " :isHidden="viewModal"  :hiddenT="hiddenTogggle"></suspectView>
  <incidentModal :toggle="viewModalToggle" :incidentId="viewRequestId" v-if="($store.getters.getActive == 'innerIncident' || $store.getters.getActive == 'innerIncidentArchive') && !viewModal " :isHidden="viewModal"  :hiddenT="hiddenTogggle"></incidentModal>
  <accountProfile :toggle="viewModalToggle" v-if="(!viewModal) && ($store.getters.getActive == 'innerCitizenAccounts' || $store.getters.getActive == 'innerOfficerAccounts' || $store.getters.getActive == 'innerAccountsArchive')" :suspectId="viewRequestId"></accountProfile>
  <restoreModal :sendData="restoreArchivedData" :toggle="restoreModalToggle" v-if="modal.restoreArchiveOpen"></restoreModal>
</template>

<script>
import deleteM from './tableModals/deleteModal.vue';
import suspectView from './tableModals/personView.vue';
import restoreModal from './tableModals/restoreModal.vue';
import accountProfile from './tableModals/accountProfile.vue';
import incidentModal from './tableModals/incidentModal.vue';
import dynamicEditForm from './tableModals/modalForms/dynamicEditForm.vue';
import incidentEditForm from './tableModals/modalForms/incidentEditForm.vue';

export default {
  data() {
    return {
      deleteApis: {
        innerIncident: "api/incidents/delete/item/request",
        innerSuspects: "api/suspects/delete/item/request",
        innerVictims: "api/victims/delete/item/request",
        innerWitnesses: "api/witness/delete/item/request",
        innerNameIncidents: "api/incidentNames/delete/item/request",
        innerCitizenAccounts: "api/users/delete/item/request",
        innerOfficerAccounts: "api/users/delete/item/request"
      },
      restoreApis: {
        innerIncidentArchive: "api/incidents/restore/item/request",
        innerSuspectsArchive: "api/suspects/restore/item/request",
        innerVictimsArchive: "api/victims/restore/item/request",
        innerWitnessesArchive: "api/witness/restore/item/request",
        innerAccountsArchive: "api/users/restore/item/request"
      },deleteR:{
        data: {},
        url: '',
      },restoreData:{
        data: {},
        url: '',
      },
      deleteModal:true,
      viewModal:true,
      editModal:true,
      editIncidentModal: true,
      viewRequestId: -1,
      modal:{
        restoreArchiveOpen: false,
      },
      id: -1,
      users_id: -1
    };
  },
  props: ["tabData", "type", "getTData"],
  computed: {
    retLen() {
      return "" + this.tabData.length;
    },
  },
  components:{
    deleteM,
    suspectView,
    restoreModal,
    accountProfile,
    incidentModal,
    dynamicEditForm,
    incidentEditForm
  },
  methods: {
    restoreModalToggle(){
      this.modal.restoreArchiveOpen = !this.modal.restoreArchiveOpen;
    },
    viewModalToggle(){
      this.viewModal = !this.viewModal;
    },deleteIt(param){

      this.deleteItem({ id: param, 
          deleted_by: this.id//Temporary
          , archived_by: this.id// Temporary
         })
    },
    deleteItem(param) {
      const api = this.deleteApis[this.$store.getters.getActive];
      this.deleteR['data'] =  param;
      this.deleteR['url'] = api;
      this.hiddenTogggle('delete');
    },
    restoreItem(param){
      const api = this.restoreApis[this.$store.getters.getActive];
      this.restoreData['data'] =  param;
      this.restoreData['url'] = api;
      this.restoreModalToggle();
    },
    viewItem(param){
      this.viewRequestId = param;
      this.hiddenTogggle('view');
    },editItem(param){
      this.viewRequestId = param;
      this.editModal = !this.editModal;
    },editIncident(param){
      this.viewRequestId = param;
      this.editIncidentModal = !this.editIncidentModal;
    },
    hiddenTogggle(param){
      if(param == 'delete') this.deleteModal = !this.deleteModal;
      else if(param == 'view') this.viewModalToggle();
    },
    async sendData() {
      const send = await this.deleteR;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      
      if (res == "Success") {
        await alert("Data Deleted.");
        this.hiddenTogggle('delete');
        /* Use to reload the api data */
        this.getTData('', this.$store.getters.api);
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async restoreArchivedData() {
      const send = await this.restoreData;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      
      if (res == "Success") {
        await alert("Data restored.");
        this.restoreModalToggle();
        this.getTData('', this.$store.getters.api);
      } else {
        await alert("An error occured, please try again.");
      }
    }
  },mounted(){
    const credential = JSON.parse(localStorage.getItem('credentials'));
    this.id = credential.id;
    this.users_id = this.id;
  },created(){
    const credential = JSON.parse(localStorage.getItem('credentials'));
    this.id = credential.id;
  }
};
</script>