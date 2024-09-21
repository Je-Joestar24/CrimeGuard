<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
    :class="{ ' hidden ': isHidden }"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <button
          type="button"
          class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          @click="hiddenT('view')"
        >
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
        <div class="p-4 md:p-5 text-center">
          <div class="flex text-black font-semibold justify-center">
            VIEW DETAILS
          </div>
          <div>
            <div class="flex p-1 gap-1" style="height: 35vh">
              <div
                class="p-5 flex flex-col justify-center items-center border rounded-lg border-gray-200 shadow-md bg-gray-100"
              >
                <svg
                v-if="profile == ''"
                  class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50"
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
                v-if="profile"
                class="h-64 w-64 border-slate-500 rounded-lg border-2 text-gray-900 bg-slate-50" :src="profile" alt="">
              </div>
              <!-- Basic infos -->
              <basic :setProf="setProf" :suspectIdRequest="suspectId"></basic>
            </div>
            <h1
              class="text-md py-2 rounded-md border-b border-gray-400 mb-1 font-bold text-gray-900"
            >
              OTHER INFORMATION
            </h1>
            <div
              class="flex flex-col rounded-lg border border-gray-300 shadow-sm"
              style="height: 45vh"
            >
              <!-- NAVIGATION -->
              <h1
                class="text-start flex gap-0 bg-blue-200 rounded-t-lg text-sm font-bold text-gray-700"
              >
                <button
                  v-for="navs of viewOtherNav.options"
                  class="hover:bg-blue-100 active:bg-white px-5 rounded-t-lg py-2"
                  :class="{
                    ' bg-white ': navs == viewOtherNav.active,
                    ' bg-blue-200 ': !(navs == viewOtherNav.active),
                  }"
                  @click="changeViewNav(navs)"
                >
                  {{ navs }}
                </button>
              </h1>
              <div>
                <addresses
                  v-if="viewOtherNav.active == 'ADDRESSES'"
                  :suspectIdRequest="suspectId"
                ></addresses>

                <background
                  v-if="
                    viewOtherNav.active == 'BACKGROUND INFORMATION' &&
                    ($store.getters.getActive == 'innerSuspects' || $store.getters.getActive == 'innerSuspectsArchive')
                  "
                  :suspectIdRequest="suspectId"
                ></background>

                <physical
                  v-if="
                    viewOtherNav.active == 'PHYSICAL CHARACTERISTICS' &&
                    ($store.getters.getActive == 'innerSuspects' || $store.getters.getActive == 'innerSuspectsArchive')
                  "
                  :suspectIdRequest="suspectId"
                ></physical>

                <records
                  v-if="viewOtherNav.active == 'PREVIOUS RECORDS'"
                  :suspectIdRequest="suspectId"
                ></records>
                <victims v-if="viewOtherNav.active == 'VICTIMS'" :suspectIdRequest="suspectId"></victims>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import addresses from "./viewModalComponents/person/addressess.vue";
import background from "./viewModalComponents/person/background.vue";
import physical from "./viewModalComponents/person/physical.vue";
import records from "./viewModalComponents/person/records.vue";
import victims from "./viewModalComponents/person/victims.vue";
import basic from "./viewModalComponents/person/basic.vue";

export default {
  components: {
    addresses,
    background,
    physical,
    records,
    victims,
    basic,
  },
  props: ["isHidden", "hiddenT", "suspectId"],
  data() {
    return {
      info: {},
      profile: '',
      viewApis: {
        innerIncident: "",
        innerSuspects: "api/suspects/view/item/details/request",
        innerVictims: "",
        innerWitnesses: "",
        innerNameIncidents: "",
      },
      viewForm: {},
      viewRequestSend: {
        data: {},
        url: "",
      },
      viewOtherNav: {
        active: "ADDRESSES",
        options: [],
      },
    };
  },
  watch: {
    idRequest: function (newValue, oldValue) {
      if (oldValue != newValue && newValue != -1) {
        this.viewRequestSend["url"] =
          this.viewApis[this.$store.getters.getActive];
        //console.log(newValue);
        //this.sendViewData({ id: newValue });
      }
    },
  },
  created() {
    if (this.$store.getters.getActive == "innerSuspects" || this.$store.getters.getActive == "innerSuspectsArchive") {
      this.viewOtherNav.options = [
        "ADDRESSES",
        "PHYSICAL CHARACTERISTICS",
        "BACKGROUND INFORMATION",
        "PREVIOUS RECORDS",
        "VICTIMS",
      ];
    } else {
      this.viewOtherNav.options = ["ADDRESSES", "PREVIOUS RECORDS"];
    }
  },
  methods: {
    async sendViewData(param) {
      this.viewRequestSend["data"] = await param;

      const data = await this.$store.dispatch("sendData", send);
      const res = await data["response"];
      await console.log(this.viewRequestSend);

      /* Suspect Manipulation Controller, send this id and create a session */
      if (res == "Success") {
        this.viewForm = await data;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    changeViewNav(param) {
      this.viewOtherNav.active = param;
    },setProf(param){
      this.profile = param;
    }
  },
};
</script>