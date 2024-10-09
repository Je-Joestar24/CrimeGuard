<template>
  <div class="bg-white p-6 rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="lastName">Last Name</label>
        <input
          id="lastName"
          :value="data['last_name'] || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="firstName">First Name</label>
        <input
          id="firstName"
          :value="data['first_name'] || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="middleName">Middle Name</label>
        <input
          id="middleName"
          :value="data['middle_name'] || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="email">Email</label>
        <input
          id="email"
          :value="data.email || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="contact">Contact</label>
        <input
          id="contact"
          :value="data['contact'] || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
    </div>
    
    <div v-if="$store.getters.getActive == 'innerCitizenAccounts'" class="mb-6">
      <div class="space-y-2">
        <label class="text-sm font-medium text-gray-600" for="facebook">Facebook</label>
        <input
          id="facebook"
          :value="data['fb_name'] || 'No Data'"
          class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          type="text"
          readonly
        />
      </div>
    </div>
    
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-center space-x-4">
        <div>
          <label class="text-sm font-medium text-gray-600 block mb-1">Sex</label>
          <div class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded-full">
            <svg v-if="data.gender == 'male'" class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor" d="M442 48h-90a22 22 0 0 0 0 44h36.89l-60.39 60.39c-68.19-52.86-167-48-229.54 14.57C31.12 234.81 31.12 345.19 99 413a174.21 174.21 0 0 0 246 0c62.57-62.58 67.43-161.35 14.57-229.54L420 123.11V160a22 22 0 0 0 44 0V70a22 22 0 0 0-22-22M313.92 381.92a130.13 130.13 0 0 1-183.84 0c-50.69-50.68-50.69-133.16 0-183.84s133.16-50.69 183.84 0s50.69 133.16 0 183.84"/>
            </svg>
            <svg v-else-if="data.gender == 'female'" class="w-8 h-8 text-pink-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M7 9.5a7.5 7.5 0 1 1 2.942 5.957l-1.788 1.787L9.58 18.67a1 1 0 1 1-1.414 1.414L6.74 18.659l-2.12 2.12a1 1 0 0 1-1.414-1.415l2.12-2.12l-1.403-1.403a1 1 0 1 1 1.414-1.414L6.74 15.83l1.79-1.79A7.467 7.467 0 0 1 7 9.5M14.5 4a5.5 5.5 0 1 0 0 11a5.5 5.5 0 0 0 0-11"/>
            </svg>
            <svg v-else class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div v-if="$store.getters.getActive == 'innerCitizenAccounts'">
          <label class="text-sm font-medium text-gray-600 block mb-1">User Type</label>
          <span class="px-3 py-1 text-sm font-semibold text-white bg-green-600 rounded-full">CITIZEN</span>
        </div>
        <div v-if="$store.getters.getActive == 'innerOfficerAccounts'">
          <label class="text-sm font-medium text-gray-600 block mb-1">User Type</label>
          <span class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded-full">OFFICER</span>
        </div>
        <div v-if="$store.getters.getActive == 'innerOfficerAccounts'">
          <label class="text-sm font-medium text-gray-600 block mb-1">Rank</label>
          <span class="px-3 py-1 text-sm font-semibold text-white bg-yellow-500 rounded-full">{{ data['rank'] }}</span>
        </div>
      </div>
      <div v-if="$store.getters.getActive == 'innerCitizenAccounts'">
        <button
          @click="toggle"
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
        >
          View Valid ID
        </button>
      </div>
    </div>
  </div>
  <div v-if="valid_id" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden">
      <div class="p-4 border-b flex justify-between items-center bg-gray-100">
        <h3 class="text-xl font-semibold text-gray-800">Valid ID</h3>
        <button
          @click="toggle"
          class="text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800 transition ease-in-out duration-150"
        >
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="p-6 bg-gray-200">
        <div class="w-full max-h-[80vh] overflow-auto">
          <img 
            :src="data['valid_id']" 
            alt="Valid ID" 
            class="w-full h-auto object-contain rounded-lg shadow-lg"
          >
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { watch } from "vue";

export default {
  data() {
    return {
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/basic/details/request",
        innerVictims: "api/victims/view/basic/details/request",
        innerWitnesses: "api/witness/view/basic/details/request",
        innerSuspectsArchive: "api/suspects/view/basic/details/request",
        innerVictimsArchive: "api/victims/view/basic/details/request",
        innerWitnessesArchive: "api/witness/view/basic/details/request",
        innerNameIncidents: "",
        regRequests: 'api/citizenUsers/view/basic/details/request',
        innerAccountsArchive: "api/citizenUsers/view/basic/details/request",
        innerCitizenAccounts: "api/citizenUsers/view/basic/details/request",
        innerOfficerAccounts: "api/citizenUsers/view/basic/details/request",
      },
      data: {},
      valid_id: false,
    };
  },

  created() {
    if (this.viewApis[this.$store.getters.getActive] != null) {
      (async () => {
        const send = await {
          url: this.viewApis[this.$store.getters.getActive],
          data: {
            id: this.suspectIdRequest,
          },
        };
        await this.sendData(send);
      })();
    }
    //console.log(sample);
  },
  props: ["suspectIdRequest", "sendUsername"],
  methods: {
    async sendData(param) {
      console.log(param);
      const data = await this.$store.dispatch("sendData", param);
      const res = await data["response"];

      if (res != "Success") {
        await alert("An error occured, please try again.");
      } else {
        this.data = await data["data"];
        this.data.gender = (""+this.data.gender).toLowerCase();
        console.log(this.data);
        if (
          this.$store.getters.getActive == "innerCitizenAccounts" ||
          this.$store.getters.getActive == "innerOfficerAccounts" ||
          this.$store.getters.getActive == "innerAccountsArchive" ||
          this.$store.getters.getActive == "regRequests"
        ) {
          await this.sendUsername(this.data["user_name"], this.data['profile']);
        }
      }
    },
    toggle() {
      this.valid_id = !this.valid_id;
    },
  },
};
</script>