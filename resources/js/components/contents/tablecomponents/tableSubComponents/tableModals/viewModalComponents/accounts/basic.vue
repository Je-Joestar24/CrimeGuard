<template>
  <div class="w-3/4 h-full bg-white p-3 rounded-lg border">
    <div class="flex gap-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">LAST NAME</label>
        <input
          v-if="data['last_name'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['last_name']"
          type="text"
        />
        <input
          v-if="data['last_name'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No Data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">FIRST NAME</label>
        <input
          v-if="data['first_name'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['first_name']"
          type="text"
        />
        <input
          v-if="data['first_name'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">MIDDLE NAME</label>
        <input
          v-if="data['middle_name'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['middle_name']"
          type="text"
        />
        <input
          v-if="data['middle_name'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
    <div class="mt-3 flex gap-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">EMAIL</label>
        <input
          v-if="data.email != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data.email"
          type="text"
        />
        <input
          v-if="data.email == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          value="No data"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">CONTACT</label>
        <input
          v-if="data['contact'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['contact']"
          type="text"
        />
        <input
          v-if="data['contact'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
    <div v-if="$store.getters.getActive == 'innerCitizenAccounts'" class="mt-3 flex gap-1">
      <div class="w-1/2 flex flex-col justify-start">
        <label class="text-start" for="">FACEBOOK</label>
        <input
          v-if="data['fb_name'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['fb_name']"
          type="text"
        />
        <input
          v-if="data['fb_name'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
    </div>
    <div class="mt-3 gap-10 flex">
      <div class="flex flex-col justify-start">
        <label class="text-start" for="">SEX</label>
        <svg
          v-if="data.gender == 'male'"
          class="w-10 h-10 pointer-events-none"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
        >
          <path
            fill="#3700ff"
            d="M442 48h-90a22 22 0 0 0 0 44h36.89l-60.39 60.39c-68.19-52.86-167-48-229.54 14.57C31.12 234.81 31.12 345.19 99 413a174.21 174.21 0 0 0 246 0c62.57-62.58 67.43-161.35 14.57-229.54L420 123.11V160a22 22 0 0 0 44 0V70a22 22 0 0 0-22-22M313.92 381.92a130.13 130.13 0 0 1-183.84 0c-50.69-50.68-50.69-133.16 0-183.84s133.16-50.69 183.84 0s50.69 133.16 0 183.84"
          />
        </svg>
        <svg
          v-if="data.gender == 'female'"
          class="w-10 h-10 pointer-events-none"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
        >
          <g fill="none" fill-rule="evenodd">
            <path
              d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"
            />
            <path
              fill="#ff00ea"
              d="M7 9.5a7.5 7.5 0 1 1 2.942 5.957l-1.788 1.787L9.58 18.67a1 1 0 1 1-1.414 1.414L6.74 18.659l-2.12 2.12a1 1 0 0 1-1.414-1.415l2.12-2.12l-1.403-1.403a1 1 0 1 1 1.414-1.414L6.74 15.83l1.79-1.79A7.467 7.467 0 0 1 7 9.5M14.5 4a5.5 5.5 0 1 0 0 11a5.5 5.5 0 0 0 0-11"
            />
          </g>
        </svg>
        <svg
          v-if="!data.gender "
          class="w-10 h-10"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
      <div
        v-if="$store.getters.getActive != 'innerAccountsArchive' && $store.getters.getActive == 'innerCitizenAccounts'"
        class="w-50 flex flex-col justify-start"
      >
        <label class="text-start" for="">USER</label>
        <span
          class="py-1 text-white px-4 font-bold font-mono text-lg bg-green-600"
          >CITIZEN</span
        >
      </div>

      <div v-if=" $store.getters.getActive == 'innerCitizenAccounts'" class="w-50 flex flex-col justify-start">
        <label class="text-start" for="">VALID ID</label>
        <button
          type="button"
          class="text-white gap-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          @click="toggle"
        >
          <svg
            class="h-5 w-5 text-white"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
            />
          </svg>

          view
        </button>
      </div>
    </div>
    <div v-if="$store.getters.getActive == 'innerOfficerAccounts'" class="mt-3 gap-10 flex">
      <div
        v-if="$store.getters.getActive != 'innerAccountsArchive'"
        class="w-50 flex flex-col justify-start"
      >
        <label class="text-start" for="">USER</label>
        <span
          class="py-1 text-white px-4 font-bold font-mono text-lg bg-red-600"
          >OFFICER</span
        >
      </div>
      <div
        v-if="$store.getters.getActive != 'innerAccountsArchive'"
        class="w-50 flex flex-col justify-start"
      >
        <label class="text-start" for="">RANK</label>
        <span
          class="py-1 text-white px-4 font-bold font-mono text-lg bg-yellow-500"
          >{{ data['rank'] }}</span
        >
      </div>

    </div>
  </div>
  
  <div v-if="valid_id" class=" fixed bg-gray-800 flex justify-center  bg-opacity-20" style="top: 0px; left: 0px; width: 100vw; height: 100vh;">
    <div class=" rounded h-60 bg-white mt-32 flex flex-col" style="height: 400px; width: 600px;">
      <div class=" p-1 w-full flex justify-end">
        <button
        type="button"
        @click="toggle"
        class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
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
      <img :src="data['valid_id']" alt="valid id" class=" border bg-transparent h-full w-full object-cover"></img>
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