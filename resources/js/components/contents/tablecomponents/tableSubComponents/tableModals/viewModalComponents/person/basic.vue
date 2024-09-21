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
      <div class="w-1/2 flex flex-col justify-start">
        <label class="text-start" for="">AGE</label>
        <input
          v-if="data['age'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['age']"
          type="text"
        />
        <input
          v-if="data['age'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-1/2 flex flex-col justify-start">
        <label class="text-start" for="">SEX</label>
        <svg
          v-if="data.gender == 'male'"
          class="w-1/2 h-full pointer-events-none"
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
          class="w-1/2 h-full"
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
          v-if="!data.gender"
          class="w-1/2 h-full"
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
    </div>
    <div class="mt-3 flex gap-1">
      <div class="w-3/4 flex flex-col justify-start">
        <label class="text-start" for="">NICKNAME</label>
        <input
          v-if="data['nick_name'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['nick_name']"
          type="text"
        />
        <input
          v-if="data['nick_name'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">FACEBOOK</label>
        <input
          v-if="data['facebook'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['facebook']"
          type="text"
        />
        <input
          v-if="data['facebook'] == null"
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
        <label class="text-start" for="">TELEPHONE</label>
        <input
          v-if="data['telephone'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['telephone']"
          type="text"
        />
        <input
          v-if="data['telephone'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
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
    <div class="mt-3 flex gap-1">
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">UNDER THE INFLUENCE:</label>
        <input
          v-if="data['under_influence'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['under_influence']"
          type="text"
        />
        <input
          v-if="data['under_influence'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">CIVIL STATUS</label>
        <input
          v-if="data['civil_status'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['civil_status']"
          type="text"
        />
        <input
          v-if="data['civil_status'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
      </div>
      <div class="w-full flex flex-col justify-start">
        <label class="text-start" for="">NATIONALITY</label>
        <input
          v-if="data['nationality'] != null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="data['nationality']"
          type="text"
        />
        <input
          v-if="data['nationality'] == null"
          class="w-full rounded-md bg-blue-100 pointer-events-none"
          :value="'No data'"
          type="text"
        />
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
      },
      data: {},
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
  props: ["suspectIdRequest", "setProf"],
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
        if((this.$store.getters.getActive == 'innerSuspectsArchive' || this.$store.getters.getActive == 'innerVictimsArchive' || this.$store.getters.getActive == 'innerWitnessesArchive' || this.$store.getters.getActive == 'innerSuspects' || this.$store.getters.getActive == 'innerVictims' || this.$store.getters.getActive == 'innerWitnesses') && this.data.id_card_presented) this.setProf(this.data.id_card_presented);
        console.log(this.data);
      }
    },
  },
};
</script>