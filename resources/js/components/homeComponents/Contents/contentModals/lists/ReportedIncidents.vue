
<template>
  <ul
    v-if="!isPhone"
    class="bg-gray-100 m-12 p-3 rounded-lg overflow-auto w-full divide-y"
    style="height: 80vh"
  >
    <li
      class="text-xl text-red-600 font-semibold border-b border-gray-600 py-2 bg-gray-300 rounded-t-lg px-2"
    >
      Reported Incidents
    </li>
    <li>
      <ul
        class="bg-gray-100 rounded-lg overflow-auto w-full divide-y divide-gray-200"
        style="height: 70vh"
      >
        <!--  dark:divide-gray-700  -->
        <li
          v-if="arr.length > 0"
          v-for="(el, i) in arr"
          class="pb-3 px-1 py-1 my-1 sm:pb-4 border-b"
        >
          <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="flex-shrink-0">{{ i + 1 }}.</div>
            <div class="flex-1 min-w-0 font-bold capitalize">
              {{ el["incident"] }}
            </div>
            <p>
              <span>
                {{ el["location"] }} near
                <span>{{ el["landmark"] }}</span> </span
              >,
              <span>{{ el["time"] }}</span>
            </p>
            <div
              class="inline-flex items-center text-base font-semibold text-gray-900"
            >
              <!--  dark:text-white -->
              <span class="capitalize">- {{ month[el["month"] - 1] }}</span
              >, {{ el["date"] }}
            </div>
          </div>
        </li>
        <li
          v-if="arr.length == 0"
          class="border-t shadow-inner border-gray-800 pt-2 text-center font-semibold text-gray-600"
        >
          No Incident Reported
        </li>
      </ul>
    </li>
  </ul>
  
  <ul v-if="isPhone" class="bg-gray-100 w-full">
    <li class="py-2">
      <div class=" border rounded-lg px-5 py-3 text-lg font-semibold">REPORTED INCIDENTS</div>
      <ul class="bg-gray-100 rounded-lg w-full divide-y border-t mt-5 overflow-auto" style="height: 75vh;">
        <!--  dark:divide-gray-700  -->
        <li
          v-if="arr.length > 0"
          v-for="(el, i) in arr"
          class="pb-3 px-1 py-1 my-4 rounded-md sm:pb-4 border-b shadow-md pt-5 mx-1"
        >
        <div class="flex items-start space-x-4 rtl:space-x-reverse">
          <div class="flex-shrink-0 mb-auto px-3 text-lg font-bold">{{ i + 1 }}.</div>
          <div class="flex flex-col flex-grow rounded-md bg-gray-100 border">
            <div
              class="w-full py-5 px-4 rounded-md bg-red-600 border-b text-xl text-gray-200 font-bold capitalize"
            >
              {{ el["incident"] }}
            </div>
            <p class=" px-3 border-b py-2 w-full">{{ el["location"] }}</p>
            <div
              class="px-3 py-1 bg-gra inline-flex items-center text-base font-semibold text-gray-700 w-full"
            >
              <span class="capitalize">
                {{ el["time"] }} - {{ month[el["month"] - 1] }}
              </span>
              , {{ el["date"] }}
            </div>
          </div>
        </div>
        
        </li>
        <li
          v-if="arr.length == 0"
          class="border-t shadow-inner border-gray-800 pt-2 text-center font-semibold text-gray-600"
        >
          No Report Incidents
        </li>
      </ul>
    </li>
  </ul>
</template>


<script>
export default {
  data() {
    return {
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
      req: {
        url: "api/incidents/citizen/view/display2",
        data: {
          id: -1, //Temporary
        },
      },
    };
  },
  mounted() {
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.req.data.id = credentials.id;
        console.log(this.req);
      })();
      await this.sendData(this.req);

      // Iterate through each element in the array
      for (let i = 0; i < this.arr.length; i++) {
        const element = this.arr[i];

        // Await the conversion of military time to normal time
        element["time"] = await this.$store.dispatch(
          "militaryToNormalTime",
          element["time"]
        );
      }
    })();
  },
  methods: {
    async sendData(param) {
      this.header = [];
      this.data = [];
      const data = await this.$store.dispatch("sendData", param);
      if (data["response"] == "Success") {
        this.arr = await data["data"];
      }
    },
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>