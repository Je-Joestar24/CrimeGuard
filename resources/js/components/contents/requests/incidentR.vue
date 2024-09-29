<template>
  <div class="flex justify-end">
    <div class="relative mt-1 my-2 inline">
      <div
        class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
      >
        <svg
          class="w-4 h-4 text-gray-500"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 20 20"
        >
          <!-- dark:text-gray-400 -->
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
          />
        </svg>
      </div>
      <input
       v-model="search" 
        type="text"
        class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
        placeholder="Search"
      />
      <!--  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
    </div>
  </div>
  <div
    class="font-semibold px-3 pt-2 shadow-md border-b-2 border-gray-400 rounded-t-sm"
  >
    INCIDENT REPORT LIST
  </div>
  <ul
    class="mt-2 overflow-auto w-full divide-y divide-gray-200 dark:divide-gray-700 bg-gray-100 px-1 rounded"
    style="height: 30vh"
  >
    <li
      v-if="arr.length > 0"
      v-for="el in arr"
      class="py-3 mb-1 border-b px-2"
      :class="{
        'bg-green-300': el['status'] != 'reject' && el['status'] != 'report',
        'bg-red-300': el['status'] == 'reject',
      }"
    >
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <div class="flex-shrink-0">
          <svg
            v-if="el.profile == ''"
            class="h-10 w-10 text-gray-500 my-auto"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <img
            v-if="el.profile != ''"
            class="h-10 rounded-full border w-10 text-gray-500 my-auto"
            :src="el.profile"
            alt=""
          />
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900">
            <!--truncate  dark:text-white -->
            {{ el["user_name"] }}
          </p>
          <p class="text-sm text-gray-500">
            <!-- truncate  dark:text-gray-400 -->
            {{ el["email"] }}
          </p>
        </div>
        <p>
          <span>{{ el["message"] }}</span> at
          <span> {{ el["location"] }} </span>, <span>{{ el["time"] }}</span>
        </p>
        ,
        <div
          class="inline-flex items-center text-base font-semibold text-gray-900"
        >
          <!--  dark:text-white -->
          <span class="capitalize">{{ month[el["month"] - 1] }}</span
          >, {{ el["date"] }}
        </div>
        <span v-if="el['assigned_to'] != NULL && cred.user_level == 1"
          >, assigned to, <b>{{ el["assigned_to"] }}</b></span
        >
        <div class="flex gap-1">
          <!-- for Adding file -->
          <button
            type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            @click="sendId(el.id)"
          >
            <svg
              class="h-5 w-5 text-green-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="white"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
              />
            </svg>
          </button>
          <!-- for responding incidents -->
          <button
            type="button"
            v-if="el['status'] == 'report' && cred.user_level == 2"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            @click="toggleRespondModal({ id: el['id'], edited_by: cred.id })"
          >
            <svg
              class="h-5 w-5 text-green-600"
              viewBox="0 0 24 24"
              fill="none"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <line x1="22" y1="2" x2="11" y2="13" />
              <polygon points="22 2 15 22 11 13 2 9 22 2" />
            </svg>
          </button>
          <span
            v-if="el['status'] != 'reject' && el['status'] != 'report'"
            class="text-xs font-semibold bg-green-600 border rounded-full my-1 text-white border-green-600 px-1 py-0"
            >RESPONDED</span
          >
          <span
            v-if="
              el['status'] != 'reject' &&
              el['status'] != 'report' &&
              el['status'] != 'respond'
            "
            class="text-xs font-semibold bg-blue-600 border rounded-full my-1 text-white border-green-600 px-1 py-0"
            >ADDED</span
          >
          <!-- for assigning -->
          <button
            type="button"
            v-if="
              el['status'] == 'report' &&
              cred.user_level == 1 &&
              !el['assigned_to']
            "
            @click="toggleAssignModal({ id: el['id'] })"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
          >
            <svg
              class="h-5 w-5"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path
                d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
              />
            </svg>
          </button>
          <span
            v-if="el['assigned_to'] != NULL && cred.user_level == 1"
            class="text-xs font-semibold bg-green-600 border rounded-full my-1 text-white border-green-600 px-1 py-0"
            >ASSIGNED</span
          >
          <!-- for rejecting incident -->
          <span
            v-if="el['status'] == 'reject'"
            class="text-xs font-semibold bg-red-600 border rounded-full my-1 text-white border-red-600 px-2.5 py-0"
            >REJECTED</span
          >
          <button
            type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 px-2 py-1 text-xs font-thin text-center rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
            @click="toggleRejectModal({ id: el['id'], edited_by: cred.id })"
            v-if="el['status'] == 'report' && cred.user_level == 2"
          >
            <svg
              class="h-5 w-5 text-green-600"
              viewBox="0 0 24 24"
              fill="none"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>
      </div>
    </li>
    <li
      v-if="arr.length == 0"
      class="border-t shadow-inner border-gray-800 pt-2 text-center font-semibold text-gray-600"
    >
      No Incident Reports
    </li>
  </ul>
  <div
    v-if="cred && cred['user_level'] == 1"
    class="flex gap-3 mt-1 bg-green-50"
  >
    <rejected></rejected>
    <responded></responded>
  </div>
  <respondIncident
    :sendData="respondData"
    :toggle="toggleRespondModal"
    v-if="modal.respondIsOpen"
  ></respondIncident
  ><!-- 
    :sendData="respondData" -->
  <assign-to
    v-if="modal.assingIsOpen"
    :toggle="toggleAssignModal"
    :sendData="assignData"
  ></assign-to>
  <rejectIncident
    :sendData="rejectData"
    :toggle="toggleRejectModal"
    v-if="modal.rejectIsOpen"
  ></rejectIncident>
  <incidentEditForm
    :reloadTab="getTData"
    :rId="requestId"
    :toggle="sendId"
    v-if="incidentAdd"
  ></incidentEditForm>
</template>
  
  <script>
import respondIncident from "./requestComponents/respondIncident.vue";
import rejectIncident from "./requestComponents/rejectIncident.vue";
import assignTo from "./requestComponents/assignTo.vue";
import incidentEditForm from "../tablecomponents/tableSubComponents/tableModals/modalForms/incidentEditForm.vue";
import rejected from "./incidentRequests/rejected.vue";
import responded from "./incidentRequests/responded.vue";
import { watch } from "vue";

export default {
  components: {
    respondIncident,
    rejectIncident,
    incidentEditForm,
    assignTo,
    rejected,
    responded,
  },
  data() {
    return {
      requestId: -1,
      incidentAdd: false,
      arr: [],
      month: [
        "january",
        "february",
        "march",
        "april",
        "may",
        "june",
        "july",
        "august",
        "september",
        "october",
        "november",
        "december",
      ],
      modal: {
        respondIsOpen: false,
        rejectIsOpen: false,
        assingIsOpen: false,
      },
      respond: {
        data: {},
        url: "api/incidents/respond/item/request",
      },
      reject: {
        data: {},
        url: "api/incidents/reject/item/request",
      },
      assign: {
        data: {},
        url: "api/incidents/assign/item/request",
      },
      cred: null,
      search: "",
    };
  },
  mounted() {
    (async () => {
      await this.getData({url: "api/incidents/report/list/Display", data: {search: ""}});
      this.cred = JSON.parse(localStorage.getItem("credentials"));
    })();
  },
  methods: {
    toggleRespondModal(param) {
      this.modal.respondIsOpen = !this.modal.respondIsOpen;
      this.respond.data = param;
    },
    toggleAssignModal(param) {
      this.modal.assingIsOpen = !this.modal.assingIsOpen;
      this.assign.data = param;
    },
    toggleRejectModal(param) {
      this.modal.rejectIsOpen = !this.modal.rejectIsOpen;
      this.reject.data = param;
    },
    sendId(param) {
      this.requestId = param;
      this.incidentAdd = !this.incidentAdd;
    },
    getTData(param, param1) {
      this.getData({url: "api/incidents/report/list/Display", data: {search: ""}});
    },/* 
    async getData() {
      this.header = [];
      this.data = [];
      const cred = JSON.parse(localStorage.getItem("credentials"));
      const dt = cred.user_level == 2 ? { id: cred.id } : {};
      const data = await this.$store.dispatch("sendData", {
        url: "api/incidents/report/list/Display",
        data: dt,
      });

      if (data["response"] == "Success") {
        this.arr = await data["data"];
      }
    }, */
    async respondData() {
      const send = this.respond;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        await alert("Incident Responded.");
        this.toggleRespondModal("");
        await this.getData({url: "api/incidents/report/list/Display", data: {search: ""}});
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async rejectData(message) {
      const send = this.reject;
      send.data["rej_message"] = message;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        await alert("Incident Rejected.");
        this.toggleRejectModal("");
        await this.getData({url: "api/incidents/report/list/Display", data: {search: ""}});
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async assignData(param) {
      this.assign.data["assigned_to"] = param;
      console.log(this.assign);

      const send = this.assign;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        await alert("Incident Assigned.");
        this.toggleAssignModal("");
        await this.getData();
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async getData(param) {
      this.header = [];
      this.data = [];
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"];
      }
    },
  },
  watch: {
    'search':function(newVal, oldVal){
        this.getData({url: "api/incidents/report/list/Display", data: {search: newVal}});
      }
  },
};
</script>