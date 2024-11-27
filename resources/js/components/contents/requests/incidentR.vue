<template>
  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Incident Reports</h2>

      <div class="mb-4">
        <div class="relative">
          <input
            type="text"
            class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Search incidents..."
            v-model="search"
          />
          <div
            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
          >
            <svg
              class="h-5 w-5 text-gray-400"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg overflow-hidden">
        <ul class="divide-y divide-gray-200">
          <li
            v-if="paginatedArr.length > 0"
            v-for="el in paginatedArr"
            :key="el.id"
            class="hover:bg-gray-100 transition duration-150 ease-in-out"
          >
            <div
              class="p-4 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4"
            >
              <div class="flex-shrink-0">
                <div
                  v-if="
                    !el.profile && el.user_name != '' && el.user_name != NULL
                  "
                  class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg"
                >
                  {{ el.user_name[0].toUpperCase() }}
                </div>
                <img
                  v-else
                  :src="el.profile"
                  alt="Profile"
                  class="h-12 w-12 rounded-full object-cover"
                />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                  {{ el.user_name }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                  {{ el.email }}
                </p>
                <p class="text-sm text-gray-600 mt-1">
                  {{ el.message }} at {{ el.location }}, {{ el.time }}
                </p>
                <p class="text-sm font-semibold text-gray-700 mt-1">
                  {{
                    month[el.month - 1].charAt(0).toUpperCase() +
                    month[el.month - 1].slice(1)
                  }}
                  {{ el.date }}
                </p>
              </div>
              <div class="flex flex-wrap gap-2 mt-2 sm:mt-0">
                <!-- Add File button -->
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
                <button
                  v-if="el['status'] == 'report' && cred.user_level == 2"
                  @click="
                    toggleRespondModal({ id: el['id'], edited_by: cred.id })
                  "
                  class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out text-sm"
                >
                  Respond
                </button>
                <button
                  v-if="el['status'] == 'report' && cred.user_level == 2"
                  @click="
                    toggleRejectModal({ id: el['id'], edited_by: cred.id })
                  "
                  class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out text-sm"
                >
                  Reject
                </button>
                <button
                  v-if="
                    el['status'] == 'report' &&
                    cred.user_level == 1 &&
                    !el['assigned_to']
                  "
                  @click="toggleAssignModal({ id: el['id'] })"
                  class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out text-sm"
                >
                  Assign
                </button>
                <span
                  v-if="el['status'] != 'reject' && el['status'] != 'report'"
                  class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                >
                  {{ el["status"].toUpperCase() }}
                </span>
                <span
                  v-if="el['status'] == 'reject'"
                  class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full"
                >
                  REJECTED
                </span>
                <span
                  v-if="el['assigned_to'] != null && cred.user_level == 1"
                  class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full"
                >
                  ASSIGNED
                </span>
                <span
                  v-if="el['secured'] == true"
                  class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                  >SECURED</span
                >
                <button
                  v-if="el['secured'] == false"
                  @click="toggleSecureModal({ incident: el['id'], officer: cred.id, citizen: el['user_id']})"
                  class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition duration-150 ease-in-out text-sm flex items-center gap-1"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                  </svg>
                  Secure
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <div v-if="paginatedArr.length === 0" class="text-center py-8">
        <p class="text-gray-500 text-lg">No incident reports found</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center my-4 space-x-2">
      <button
        @click="changePage(1)"
        :disabled="pagination.currentPage === 1"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        <svg
          class="w-4 h-4 mr-1 inline-block"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"
          ></path>
        </svg>
        First
      </button>
      <button
        @click="changePage(pagination.currentPage - 1)"
        :disabled="pagination.currentPage === 1"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        <svg
          class="w-4 h-4 mr-1 inline-block"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          ></path>
        </svg>
        Previous
      </button>
      <span
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm"
      >
        Page {{ pagination.currentPage }} of {{ pagination.totalPages }}
      </span>
      <button
        @click="changePage(pagination.currentPage + 1)"
        :disabled="pagination.currentPage === pagination.totalPages"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        Next
        <svg
          class="w-4 h-4 ml-1 inline-block"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          ></path>
        </svg>
      </button>
      <button
        @click="changePage(pagination.totalPages)"
        :disabled="pagination.currentPage === pagination.totalPages"
        class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
      >
        Last
        <svg
          class="w-4 h-4 ml-1 inline-block"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 5l7 7-7 7M5 5l7 7-7 7"
          ></path>
        </svg>
      </button>
    </div>
  </div>

  <div v-if="cred.user_level == 1" class="flex">
    <rejectedComponent />
    <respondedComponent />
  </div>
  <!-- Modals -->
  <respondIncident
    v-show="!respondLoading"
    :toggle="toggleRespondModal"
    :sendData="respondData"
    v-if="modals.respondIsOpen"/>
  <rejectIncident
    v-show="!rejectLoading"
    :toggle="toggleRejectModal"
    :sendData="rejectData"
    v-if="modals.rejectIsOpen"/>
  <assignTo
    v-show="!assingLoading"
    :toggle="toggleAssignModal"
    :sendData="assignData"
    v-if="modals.assignIsOpen"
  />
  <incidentEditForm
    :reloadTab="getTData"
    :rId="requestId"
    :toggle="sendId"
    v-if="incidentAdd"
  />
  <secureIncident :sendData="secureData" :toggle="toggleSecureModal" v-if="modals.secureIsOpen"/>

  <!-- Loading -->
  <assignLoading v-if="assingLoading" />
  <rejectLoading v-if="rejectLoading" />
  <respondLoading v-if="respondLoading" />
</template>

<script>
import respondIncident from "./requestComponents/respondIncident.vue";
import rejectIncident from "./requestComponents/rejectIncident.vue";
import assignTo from "./requestComponents/assignTo.vue";
import incidentEditForm from "../tablecomponents/tableSubComponents/tableModals/modalForms/incidentEditForm.vue";
import rejectedComponent from "./incidentRequests/rejected.vue";
import respondedComponent from "./incidentRequests/responded.vue";
import assignLoading from "./requestComponents/loading/assignLoading.vue";
import rejectLoading from "./requestComponents/loading/rejectLoading.vue";
import respondLoading from "./requestComponents/loading/respondLoading.vue";
import secureIncident from "./requestComponents/secureIncident.vue";

export default {
  components: {
    respondIncident,
    rejectIncident,
    assignTo,
    incidentEditForm,
    rejectedComponent,
    respondedComponent,
    assignLoading,
    rejectLoading,
    respondLoading,
    secureIncident,
  },
  data() {
    return {
      arr: [],
      paginatedArr: [],
      assingLoading: false,
      rejectLoading: false,
      respondLoading: false,
      secureLoading: false,
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
      search: "",
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
      secured: {
        data: {},
        url: "api/incident/secure/add/item/request",
      },
      modals: {
        respondIsOpen: false,
        rejectIsOpen: false,
        assignIsOpen: false,
        secureIsOpen: false,
      },
      cred: {
        user_level: 2, // This should be set dynamically based on the user's actual level
        id: null,
      },
      incidentAdd: false,
      requestId: null,
      pagination: {
        currentPage: 1,
        itemsPerPage: 2,
        totalItems: 0,
        totalPages: 0,
      },
    };
  },
  mounted() {
    // Set the user's credentials
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.cred.id = credentials.id;
    this.cred.user_level = credentials.user_level;
    this.getData({ url: "api/incidents/report/list/Display", data: {} });
  },
  methods: {
    async getData(param) {
      const send = param;
      send.data["id"] = this.cred.id;
      const data = await this.$store.dispatch("sendData", send);
      if (data["response"] == "Success") {
        this.arr = await data["data"];
        this.createPaginatedData();
      }
    },
    toggleRespondModal(param) {
      this.modals.respondIsOpen = !this.modals.respondIsOpen;
      this.respond.data = param;
    },
    toggleAssignModal(param) {
      this.modals.assignIsOpen = !this.modals.assignIsOpen;
      this.assign.data = param;
    },
    toggleRejectModal(param) {
      this.modals.rejectIsOpen = !this.modals.rejectIsOpen;
      this.reject.data = param;
    },
    toggleSecureModal(param) {
      this.secured.data = param;
      this.modals.secureIsOpen = !this.modals.secureIsOpen;
      alert(this.secured.data['incident']);
    },
    sendId(param) {
      this.requestId = param;
      this.incidentAdd = !this.incidentAdd;
    },
    async respondData() {
      const send = this.respond;
      this.respondLoading = true;
      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        this.respondLoading = false;
        this.toggleRespondModal("");
        await this.getData({
          url: "api/incidents/report/list/Display",
          data: { search: "" },
        });
      } else {
        this.respondLoading = false;
        await alert("An error occured, please try again.");
      }
    },
    async rejectData(message) {
      const send = this.reject;
      this.reject.data["rej_message"] = message;
      this.rejectLoading = true;

      const data = await this.$store.dispatch("sendData", this.reject);
      const res = await data["response"];

      if (res == "Success") {
        this.rejectLoading = false;
        this.toggleRejectModal(this.reject.data);
        await this.getData({
          url: "api/incidents/report/list/Display",
          data: { search: "" },
        });
      } else {
        this.rejectLoading = false;
        await alert("An error occured, please try again.");
      }
    },
    async assignData(param) {
      this.assign.data["assigned_to"] = param;
      this.assingLoading = true;
      const send = this.assign;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        this.assingLoading = false;
        this.toggleAssignModal("");
        await this.getData({
          url: "api/incidents/report/list/Display",
          data: {},
        });
      } else {
        this.assingLoading = false;
        await alert("An error occured, please try again.");
      }
    },
    async secureData() {
      this.secureLoading = true;
      const send = this.secured;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];

      if (res == "Success") {
        this.secureLoading = false;
        this.toggleSecureModal("");
        await this.getData({
          url: "api/incidents/report/list/Display",
          data: {},
        });
      } else {
        this.secureLoading = false;
        await alert("An error occured, please try again.");
      }
    },
    sendId(id) {
      this.requestId = id;
      this.incidentAdd = !this.incidentAdd;
    },
    getTData() {
      this.getData({ url: "api/incidents/report/list/Display", data: {} });
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.totalPages) {
        this.pagination.currentPage = page;
        this.createPaginatedData();
      }
    },
    createPaginatedData() {
      const startIndex =
        (this.pagination.currentPage - 1) * this.pagination.itemsPerPage;
      const endIndex = startIndex + this.pagination.itemsPerPage;
      this.paginatedArr = this.arr.slice(startIndex, endIndex);
      this.pagination.totalItems = this.arr.length;
      this.pagination.totalPages = Math.ceil(
        this.pagination.totalItems / this.pagination.itemsPerPage
      );

      if (this.pagination.currentPage > this.pagination.totalPages) {
        this.changePage(this.pagination.totalPages);
      }
    },
  },
  watch: {
    search: function (newVal) {
      this.getData({
        url: "api/incidents/report/list/Display",
        data: { search: newVal },
      });
      this.pagination.currentPage = 1; // Reset to first page when searching
    },
  },
};
</script>