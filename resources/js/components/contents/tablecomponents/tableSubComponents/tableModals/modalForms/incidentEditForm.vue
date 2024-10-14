<template>
  <div
    v-show="!loading"
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
  <div class="relative w-full max-w-6xl p-6 bg-white rounded-lg shadow-xl">
    <div class="flex justify-between items-center mb-6 border-b pb-3">
      <h2 class="text-2xl font-bold text-gray-800">Edit Incident</h2>
      <button
        @click="toggle"
        class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
      >
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    
    <form class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
          <label for="irf-entry" class="block text-sm font-medium text-gray-700">IRF Entry Number</label>
          <input
            id="irf-entry"
            v-model="data.incident.IRF_Entry_no"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          />
        </div>
        
        <div class="space-y-2">
          <label for="incident-type" class="block text-sm font-medium text-gray-700">Type of Incident</label>
          <div class="relative">
            <input
              id="incident-type"
              v-model="data.incident_types.incident_name"
              type="text"
              @click.prevent="disableWatcher = false; search('incidentT', data.incident_types.incident_name);"
              @focusout="clearIt()"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
            <div v-if="incidentT.list.length > 0" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-60 overflow-auto">
              <ul class="py-1 text-sm text-gray-700">
                <li v-for="inc in incidentT.list" :key="inc.id" @click.prevent="selectIncident(inc.incident_name, inc.id)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                  {{ inc.incident_name }}
                  <span v-if="inc.sub_type" class="text-xs text-gray-500">({{ inc.sub_type }})</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="space-y-2">
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select
            id="status"
            v-model="data.incident.status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          >
            <option value="">Select Status</option>
            <option value="respond">Responded</option>
            <option value="reject">Rejected</option>
            <option value="pending">Pending</option>
            <option value="under investigation">Under Investigation</option>
            <option value="clear">Cleared</option>
            <option value="solve">Solved</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-2">
            <label for="date-reported" class="block text-sm font-medium text-gray-700">Date Reported</label>
            <input
              id="date-reported"
              v-model="data.incident.date_reported"
              type="date"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
          </div>
          <div class="space-y-2">
            <label for="time-reported" class="block text-sm font-medium text-gray-700">Time Reported</label>
            <input
              id="time-reported"
              v-model="data.incident.time_reported"
              type="time"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
          </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-2">
            <label for="date-of-incident" class="block text-sm font-medium text-gray-700">Date of Incident</label>
            <input
              id="date-of-incident"
              v-model="data.incident.date_of_incident"
              type="date"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
          </div>
          <div class="space-y-2">
            <label for="time-of-incident" class="block text-sm font-medium text-gray-700">Time of Incident</label>
            <input
              id="time-of-incident"
              v-model="data.incident.time_of_incident"
              type="time"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
          <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
          <div class="relative">
            <input
              id="barangay"
              v-model="data.incident.barangay"
              type="text"
              @click="generateAddress(data.incident.barangay)"
              @focusout="clearIt2"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              required
            />
            <div v-if="places.length > 0" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-60 overflow-auto">
              <ul class="py-1 text-sm text-gray-700">
                <li v-for="place in places" :key="place" @click.prevent="setAddress(place)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                  {{ place }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-span-2 space-y-2 relative">
          <label for="location" class="block text-sm font-medium text-gray-700">Place of Incident</label>
          <input
            id="location"
            v-model="data.incident.location"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            required
          />
            <button
              @click="toggleLocation"
              type="button"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            >
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </button>
        </div>
      </div>

      <div class="space-y-4">
        <h3 class="text-lg font-semibold text-gray-900">Involved Personalities</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h4 class="text-md font-semibold text-gray-800 mb-2">Witness</h4>
            <div v-if="!addWitnessClicked" class="flex justify-between items-center">
              <span>{{ data.witness.length }} witness(es)</span>
              <button
                @click="addWitnessClicked = true"
                type="button"
                class="text-blue-600 hover:text-blue-800 font-medium text-sm"
              >
                + Add
              </button>
            </div>
            <form v-else class="space-y-2">
              <div class="flex">
                <input
                  v-model="witness.search"
                  type="search"
                  class="flex-grow rounded-l-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  placeholder="Search Witness..."
                />
                <button
                  @click.prevent="toggleEnvolved('Witness')"
                  type="button"
                  class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                  New
                </button>
              </div>
              <div v-if="witness.list.length > 0 && witness.search !== ''" class="bg-white rounded-md shadow-md max-h-40 overflow-y-auto">
                <div
                  v-for="person in witness.list"
                  :key="person.id"
                  @click="addSearched('witness', {'witness':person})"
                  class="p-2 hover:bg-gray-100 cursor-pointer"
                >
                  <div class="font-medium">{{ person.firstname }} {{ person.lastname }}</div>
                  <div class="text-sm text-gray-600">{{ person.mobile_phone }}</div>
                </div>
              </div>
            </form>
            <ul class="mt-2 space-y-1 max-h-40 overflow-y-auto">
              <li v-for="(wtnss, i) in data.witness" :key="i" class="flex justify-between items-center text-sm">
                <span>{{ wtnss.witness.firstname }} {{ wtnss.witness.lastname }}</span>
                <button @click="removeItem('witness', i)" class="text-red-600 hover:text-red-800">
                  Remove
                </button>
              </li>
            </ul>
          </div>

          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h4 class="text-md font-semibold text-gray-800 mb-2">Suspects</h4>
            <div v-if="!addSuspectClicked" class="flex justify-between items-center">
              <span>{{ data.suspects.length }} suspect(s)</span>
              <button
                @click="addSuspectClicked = true"
                type="button"
                class="text-blue-600 hover:text-blue-800 font-medium text-sm"
              >
                + Add
              </button>
            </div>
            <form v-else class="space-y-2">
              <div class="flex">
                <input
                  v-model="suspects.search"
                  type="search"
                  class="flex-grow rounded-l-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  placeholder="Search Suspects..."
                />
                <button
                  @click.prevent="toggleEnvolved('Suspects')"
                  type="button"
                  class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                  New
                </button>
              </div>
              <div v-if="suspects.list.length > 0 && suspects.search !== ''" class="bg-white rounded-md shadow-md max-h-40 overflow-y-auto">
                <div
                  v-for="spct in suspects.list"
                  :key="spct.id"
                  @click="addSearched('suspects', {'suspect':spct})"
                  class="p-2 hover:bg-gray-100 cursor-pointer"
                >
                  <div class="font-medium">{{ spct.firstname }} {{ spct.lastname }}</div>
                  <div class="text-sm text-gray-600">{{ spct.mobile_phone }}</div>
                </div>
              </div>
            </form>
            <ul class="mt-2 space-y-1 max-h-40 overflow-y-auto">
              <li v-for="(spct, i) in data.suspects" :key="i" class="flex justify-between items-center text-sm">
                <span>{{ spct.suspect.firstname }} {{ spct.suspect.lastname }}</span>
                <button @click="removeItem('suspects', i)" class="text-red-600 hover:text-red-800">
                  Remove
                </button>
              </li>
            </ul>
          </div>

          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h4 class="text-md font-semibold text-gray-800 mb-2">Victims</h4>
            <div v-if="!addVictimClicked" class="flex justify-between items-center">
              <span>{{ data.victims.length }} victim(s)</span>
              <button
                @click="addVictimClicked = true"
                type="button"
                class="text-blue-600 hover:text-blue-800 font-medium text-sm"
              >
                + Add
              </button>
            </div>
            <form v-else class="space-y-2">
              <div class="flex">
                <input
                  v-model="victims.search"
                  type="search"
                  class="flex-grow rounded-l-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  placeholder="Search Victims..."
                />
                <button
                  @click.prevent="toggleEnvolved('Victims')"
                  type="button"
                  class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                  New
                </button>
              </div>
              <div v-if="victims.list.length > 0 && victims.search !== ''" class="bg-white rounded-md shadow-md max-h-40 overflow-y-auto">
                <div
                  v-for="person in victims.list"
                  :key="person.id"
                  @click="addSearched('victims', {'victim':person})"
                  class="p-2 hover:bg-gray-100 cursor-pointer"
                >
                  <div class="font-medium">{{ person.firstname }} {{ person.lastname }}</div>
                  <div class="text-sm text-gray-600">{{ person.mobile_phone }}</div>
                </div>
              </div>
            </form>
            <ul class="mt-2 space-y-1 max-h-40 overflow-y-auto">
              <li v-for="(victim, i) in data.victims" :key="i" class="flex justify-between items-center text-sm">
                <span>{{ victim.victim.firstname }} {{ victim.victim.lastname }}</span>
                <button @click="removeItem('victims', i)" class="text-red-600 hover:text-red-800">
                  Remove
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="space-y-2">
        <label for="narrative" class="block text-sm font-medium text-gray-700">Narrative of the Incident</label>
        <textarea
          id="narrative"
          v-model="data.incident_narrative.details"
          rows="4"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          placeholder="Write the Narrative here..."
        ></textarea>
      </div>

      <div class="flex justify-end space-x-3 pt-5">
        <button
          @click="toggle"
          type="button"
          class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Cancel
        </button>
        <button
          @click="sendData"
          type="button"
          class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Save Incident
        </button>
      </div>
    </form>
  </div>
    <!-- search incident -->
    
    <div v-show="envolvedOpen" class="w-full flex bg-black fixed bg-opacity-20" style="height: 100vh">
      <div class="w-1/2 bg-transparent"></div>
      <div class="bg-white w-full flex-col rounded-s-lg">
        <div class="flex justify-end p-3 border-b">
          <span class="w-full text-start px-3 text-2xl font-bold text-gray-800"
            >{{ formId }}</span
          >
          <button
            type="button"
            @click.prevent="toggleEnvolved('')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
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
        </div>
        <div class="h-full">
          <envolvePersons :toggle="toggleEnvolved" :sendPerson="addData" :envolvePerson="formId"></envolvePersons>
        </div>
      </div>
    </div>
  </div>

  
  <selector v-if="locSelectorOpen" :toggleIt="toggleLocation" :sendIt="setLocation"></selector>
    
  <editLoading v-if="loading"/>
</template>


<script>
import envolvePersons from "./incidentAddForm/envolvePersons.vue";
import editLoading from "../loading/editLoading.vue";

import selector from "./modComps/selector.vue";
export default {
  data() {
    return {
      loading: false,
      envolvedOpen: false,
      addSuspectClicked: false,
      addWitnessClicked: false,
      addVictimClicked: false,
      disableWatcher: false,
      locSelectorOpen: false,
      formId: "",
      data: {
        incident: {
          IRF_Entry_no: "",
          copy_for: "",
          date_reported: "",
          time_reported: "",
          date_of_incident: "",
          time_of_incident: "",
          location: "",
          incident_type: 1,
          status: "",
          barangay: ""
        },
        suspects: [],
        witness: [],
        victims: [],
        incident_types: {
          incident_name: "",
        },
        incident_narrative: {
          details: "",
        },
      },
      suspects: {
        search: "",
        list: [],
      },
      victims: {
        search: "",
        list: [],
      },
      witness: {
        search: "",
        list: [],
      },
      incidentT: {
        search: "",
        list: [],
      },
      searchUrl: {
        witness: "api/witness/search/Display",
        suspects: "api/suspect/search/Display",
        victims: "api/victims/search/Display",
        incidentT: "api/incidentNames/search/Display",
      },
      id: -1,
      places: []
    };
  },
  created() {
    this.extractData();
    this.disableWatcher = true;

    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.id = credential.id;
  },
  components: {
    envolvePersons,
    selector,
    editLoading
  },
  methods: {
    toggleEnvolved(param) {
      this.envolvedOpen = !this.envolvedOpen;
      this.formId = param;
    },
    toggleLocation() {
      this.locSelectorOpen = !this.locSelectorOpen;
    },
    setLocation(param) {
      this.data.incident.location = param["address"];
      this.data.incident["latitude"] = param["latitude"];
      this.data.incident["longitude"] = param["longitude"];

      this.data.incident["barangay"] = param["barangay"];
      console.log(this.data.incident);
      //console.log(this.data.incident)
      this.toggleLocation();
    },
    async extractData() {
      const send = {
        url: "api/incidents/edit/item/request",
        data: { id: parseInt(this.rId) },
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.data.incident = data["data"]["incident"];
        this.data.incident['barangay'] = data["data"]["incident"]['barangay'] ? data["data"]["incident"]['barangay'] : "";
        this.data.incident["id"] = parseInt(this.rId);
        this.data.incident["status"] = this.data.incident["status"].toLowerCase();

        this.data.incident_types = data["data"]["incident_types"];
        this.data.suspects = this.wrapByKey("suspect", data.data.suspects);
        this.data.victims = this.wrapByKey("victim", data.data.victims);
        this.data.witness = this.wrapByKey("witness", data.data.witness);
        this.data.incident_narrative = data.data.incident_narrative;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async clearIt() {
      await this.sleep(500);
      this.incidentT.list = [];
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    addData(param) {
      this.data[param.key].push(param.data);
    },
    removeItem(keys, param) {
      this.data[keys].splice(param, 1);
    },
    async sendData() {
      const data1 = this.data;
      data1.incident["edited_by"] = this.id;
      data1["id"] = this.id;
      this.loading = true;
      const send = await {
        data: data1,
        url: "api/incidents/update/item/request",
      };

      console.log(this.data);
      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {/* 
        await alert("Successfully updated Incident."); */
        this.reloadTab("", this.$store.getters.api);
        await this.toggle();
      } else {
        await alert("An error occured, please try again.");
      }
    },
    wrapByKey(key, arr) {
      let temp = [];
      if (key == "suspect") for (const c of arr) temp.push({ suspect: c });
      if (key == "witness") for (const c of arr) temp.push({ witness: c });
      if (key == "victim") for (const c of arr) temp.push({ victim: c });
      return temp;
    },
    /* search functions */
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: this.searchUrl[key],
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    addSearched(key, item) {
      this.addData({ key: key, data: item });
      this[key].list = [];
    },
    clearForm() {
      this.data = {
        incident: {
          IRF_Entry_no: "",
          copy_for: "",
          date_reported: "",
          time_reported: "",
          date_of_incident: "",
          time_of_incident: "",
          location: "",
          added_by: this.id,
          edited_by: this.id,
          incident_type: 1,
          barangay: ""
        },
        suspects: [],
        witness: [],
        victims: [],
        incident_types: {
          incident_name: "",
        },
        incident_narrative: {
          details: "",
        },
      };
      this.reloadTab("", "api/incidents/table/Display");
    },
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: this.searchUrl[key],
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    selectIncident(item, tId) {
      this.data.incident_types.incident_name = item;
      this.incidentT.list = [];
      this.data.incident.incident_type = tId;
      this.disableWatcher = true;
    },
    setAddress(value) {
      this.data.incident.barangay = value;
      this.places = [];
    },
    async generateAddress(search) {
      const data = {
        search: search,
      };

      const send = {
        url: "api/barangay/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
      } else {
        alert("Error");
      }
    },

    async clearIt2() {
      await this.sleep(500);
      this.places = [];
    },
  },
  props: ["toggle", "reloadTab", "rId"],
  watch: {
    "suspects.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("suspects", newVal);
      }
    },
    "victims.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("victims", newVal);
      }
    },
    "witness.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("witness", newVal);
      }
    },
    "data.incident_types.incident_name": function (newVal, oldVal) {
      if (newVal != oldVal && !this.disableWatcher) {
        this.search("incidentT", newVal);
      }
    },
    "data.incident.barangay": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.generateAddress(newVal);
      }
    },
  },
};
</script>