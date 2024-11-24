<template>
  <tr
    v-for="dataSets in tabData"
    :key="dataSets.id"
    class="hover:bg-gray-100 transition duration-150 ease-in-out"
    :class="{
      'bg-gray-800 border-gray-700 hover:bg-gray-600': $store.getters.theme,
      'bg-white border-b border-gray-200': !$store.getters.theme,
    }"
  >
    <td v-for="(value, key) in dataSets" :key="key" class="px-6 py-4">
      <template v-if="key === 'profile'">
        <div v-if="value" class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg overflow-hidden">
          <img v-if="value" :src="value" alt="Profile" class="h-full w-full object-cover">
          <span v-else>{{ dataSets.first_name ? dataSets.first_name.charAt(0).toUpperCase() : 'U' }}</span>
        </div>
        <div v-else class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg">
          {{ dataSets.first_name ? dataSets.first_name.charAt(0).toUpperCase() : 'U' }}
        </div>
      </template>
      <span v-else>{{ value }}</span>
    </td>
    <td class="px-6 py-4">
      <div class="flex space-x-2">
        <button
          v-if="$store.getters.getActive !== 'innerNameIncidents'"
          @click.prevent="viewItem(dataSets.id)"
          class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
        >
          View
        </button>
        <button
          v-if="$store.getters.getActive === 'innerIncident' && $route.path !== '/Admin/Archive'"
          @click.prevent="editIncident(dataSets.id)"
          class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
        >
          Edit
        </button>
        <button
          v-if="$store.getters.getActive !== 'innerIncident' && $route.path !== '/Admin/Archive'"
          @click.prevent="editItem(dataSets.id)"
          class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
        >
          Edit
        </button>
        <button
          v-if="type === 1"
          @click.prevent="deleteIt(dataSets.id)"
          class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
        >
          Delete
        </button>
        <button
          v-if="type === 0"
          @click="restoreItem({id: dataSets.id, user_id: users_id})"
          class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
        >
          Restore
        </button>
      </div>
    </td>
  </tr>
  
  <deleteLoading  v-if="loading.delete"></deleteLoading>
  <restoreLoading v-if="loading.restore"></restoreLoading>
  <incidentEditForm :reloadTab="getTData" :rId="viewRequestId" :toggle="editIncident" v-if="!editIncidentModal && ($store.getters.getActive == 'innerIncident')"></incidentEditForm>
  <dynamicEditForm :reloadTab="getTData" :rId="viewRequestId" :toggle="editItem" v-if="!editModal && ($store.getters.getActive != 'innerIncident')"></dynamicEditForm>
  <deleteM v-show="!loading.delete" :isHidden="deleteModal" :sendData="sendData" :hiddenT="hiddenTogggle" v-if="!deleteModal"></deleteM>
  <suspectView  :suspectId="viewRequestId" v-if="($store.getters.getActive == 'innerSuspects' || $store.getters.getActive == 'innerVictims' || $store.getters.getActive == 'innerWitnesses' || $store.getters.getActive == 'innerWitnessesArchive' ||  $store.getters.getActive == 'innerSuspectsArchive' || $store.getters.getActive == 'innerVictimsArchive') && !viewModal " :isHidden="viewModal"  :hiddenT="hiddenTogggle"></suspectView>
  <incidentModal :toggle="viewModalToggle" :incidentId="viewRequestId" v-if="($store.getters.getActive == 'innerIncident' || $store.getters.getActive == 'innerIncidentArchive') && !viewModal " :isHidden="viewModal"  :hiddenT="hiddenTogggle"></incidentModal>
  <accountProfile :toggle="viewModalToggle" v-if="(!viewModal) && ($store.getters.getActive == 'innerCitizenAccounts' || $store.getters.getActive == 'innerOfficerAccounts' || $store.getters.getActive == 'innerAccountsArchive')" :suspectId="viewRequestId"></accountProfile>
  <restoreModal v-show="!loading.restore" :sendData="restoreArchivedData" :toggle="restoreModalToggle" v-if="modal.restoreArchiveOpen"></restoreModal>
</template>

<script>
import deleteM from './tableModals/deleteModal.vue';
import suspectView from './tableModals/personView.vue';
import restoreModal from './tableModals/restoreModal.vue';
import accountProfile from './tableModals/accountProfile.vue';
import incidentModal from './tableModals/incidentModal.vue';
import dynamicEditForm from './tableModals/modalForms/dynamicEditForm.vue';
import incidentEditForm from './tableModals/modalForms/incidentEditForm.vue';
import deleteLoading from './tableModals/loading/deleteLoading.vue';
import restoreLoading from './tableModals/loading/restoreLoading.vue';
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
      users_id: -1,
      loading: {
        delete: false,
        restore: false,
      }
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
    incidentEditForm,
    deleteLoading,
    restoreLoading
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
      this.loading.delete = true;
      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      
      if (res == "Success") {
        this.hiddenTogggle('delete');
        this.loading.delete = false;
        /* Use to reload the api data */
        this.getTData({}, this.$store.getters.api);
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async restoreArchivedData() {
      this.loading.restore = true;
      const send = await this.restoreData;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      
      if (res == "Success") {
        this.loading.restore = false;
        this.restoreModalToggle();
        this.getTData({}, this.$store.getters.api);
      } else {
        await alert("An error occured, please try again.");
        this.loading.restore = false;
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