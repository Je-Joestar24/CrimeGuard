<template>
  <form
    class="p-4 md:p-5 md:max-w-screen-md rounded-md border shadow-xs"
    :class="{
      'shadow-white  text-white border-gray-600': $store.getters.theme,
      '': !$store.getters.theme,
    }"
  >
    <!-- Form fields -->

    <div class="grid md:grid-cols-8 md:gap-6 p-5">
      <p class="col-span-2 text-lg font-bold text-end">Date & time from:</p>
      <div class="grid md:grid-cols-2 col-span-6 md:gap-6 group">
        <div class="relative z-0 w-full mb-5 group">
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="date"
              pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
              class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none docus:outline-none focus:ring-0 peer"
              :class="{
                'text-gray-50 arder-gray-600 dacus:border-blue-500 f':
                  $store.getters.theme,
                'text-gray-900 border-gray-300 focus:border-blue-600':
                  !$store.getters.theme,
              }"
              placeholder=""
              required
              v-model="generate.date_start"
            />
          </div>
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Start Date:</label
          >
        </div>
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="time"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer"
            :class="{
              'text-gray-50  border-gray-600 focus:border-blue-500':
                $store.getters.theme,
              'text-gray-900 border-gray-300 focus:border-blue-600':
                !$store.getters.theme,
            }"
            v-model="generate.time_start"
            placeholder=" "
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time:</label
          >
        </div>
      </div>
      <p class="col-span-2 text-lg font-bold text-end">Date & time to:</p>
      <div class="grid md:grid-cols-2 col-span-6 md:gap-6 group">
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="date"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer"
            :class="{
              'text-gray-50  border-gray-600 focus:border-blue-500':
                $store.getters.theme,
              'text-gray-900 border-gray-300 focus:border-blue-600':
                !$store.getters.theme,
            }"
            placeholder=" "
            v-model="generate.date_end"
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >End Date:</label
          >
        </div>
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="time"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer"
            :class="{
              'text-gray-50  border-gray-600 focus:border-blue-500':
                $store.getters.theme,
              'text-gray-900 border-gray-300 focus:border-blue-600':
                !$store.getters.theme,
            }"
            placeholder=" "
            v-model="generate.time_end"
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time:</label
          >
        </div>
      </div>
      <p class="col-span-2 text-lg font-bold text-end">REPORT TYPE:</p>

      <div class="col-span-6">
        <select
          v-model="rtype"
          class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
        >
          <option selected disabled value="">Select Report Type</option>
          <option value="1">Station Transfer</option>
          <option value="2">Rank Change</option>
          <option value="3">My Station Members</option>
        </select>
      </div>

      <p class="col-span-2"></p>
      <button
        @click="printContent"
        type="button"
        class="text-white col-span-3 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
        :class="{
          'bg-green-600 hover:bg-green-700 foutline-none focus:ring-green-800':
            $store.getters.theme,
          'bg-green-700 hover:bg-green-800 focus:ring-green-300':
            !$store.getters.theme,
        }"
      >
        GENERATE REPORT
      </button>
    </div>
  </form>
  <div class="hidden" id="content-to-print">
    <h1
      style="
        margin-bottom: 60px;
        display: flex;
        padding-right: 30px;
        padding-left: 30px;
      "
    >
      <img
        style="width: 50px; height: 50px; object-fit: cover"
        src="./logo.png"
        alt="police logo"
      />
      <span class="title" style="text-align: center; flex: 1"
        >Philippine National Police</span
      >
      <img
        style="width: 50px; height: 50px; object-fit: cover"
        src="./PoliceLogo.png"
        alt="police logo"
      />
    </h1>
    <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
      POLICE {{ station.name }}, {{ station.location }}, LEYTE
    </h4>
    <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
      CRIME STATISTICS
    </h4>
    <h4 style="font-size: 10px; margin: 0px; margin-bottom: 5px">
      {{ start }} - {{ end }}
    </h4>
    <h4 style="font-size: 10px; margin: 0px; margin-bottom: 25px">
      Printed: {{ currentDate }}
    </h4>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th v-for="(heads, i) in header" :key="i">{{ heads }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(dataSets, index) in data" :key="index">
          <td>{{ index + 1 }}</td>
          <td v-for="(datas, i) in dataSets" :key="i">{{ datas }}</td>
        </tr>
        <tr v-if="data.length === 0">
          <td
            style="text-align: center"
            class="no-data"
            :colspan="header.length + 2"
          >
            No incident data
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
  <script>
export default {
  data() {
    return {
      header: [],
      data: [],
      station: {},
      generate: {
        date_start: "",
        time_start: "",
        date_end: "",
        time_end: "",
        id: -1,
      },
      rtype: "",
      months: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      incidentT: {
        search: "",
        list: [],
      },
      currentDate: "",
      start: "",
      end: "",
    };
  },
  methods: {
    async printContent() {
      if (this.rtype == 2) {
        await this.getTableData(
          this.generate,
          "api/dashboard/report/change/rank"
        );
      }else 
      if (this.rtype == 1) {
        await this.getTableData(
          this.generate,
          "api/dashboard/report/transfer/station"
        );
      }else 
      if (this.rtype == 3) {
        await this.getTableData(
          this.generate,
          "api/dashboard/generate/my/officers"
        );
      }

      await (async () => {
        const content = document.getElementById("content-to-print").innerHTML;
        const myWindow = window.open("", "", "width=800,height=600");
        myWindow.document.write("<html><head><title>Print</title>");
        myWindow.document.write("<style>" + this.printStyles() + "</style>");
        myWindow.document.write("</head><body>");
        myWindow.document.write(content);
        myWindow.document.write("</body></html>");
        myWindow.document.close();
        myWindow.focus();
        // myWindow.close();
        myWindow.print();
      })();
    },
    printStyles() {
      return `
          body {
            font-family: Arial, sans-serif;
          }
          .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
          }
            
            *{
              font-size:12px;
            }
          .table {
            width: 100%;
            border-collapse: collapse;
          }
          .table th, .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }
          .table th {
            background-color: #f2f2f2;
          }
          .no-data {
            text-align: center;
            font-weight: bold;
            color: #555;
            height: 50px;
          }
          .print-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
          .print-button:hover {
            background-color: #45a049;
          }
        `;
    },
    async clearIt() {
      await this.sleep(500);
      this.incidentT.list = [];
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    formatDate(param) {
      const dateElems = param.split("-");
      return `${this.months[parseInt(dateElems[1]) - 1]} ${dateElems[2]}, ${
        dateElems[0]
      }`;
    },
    formatTime(hours, minutes) {
      const addLeadingZero = (num) => (num < 10 ? "0" : "") + num;

      const period = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = addLeadingZero(minutes);

      return `${hours}:${minutes} ${period}`;
    },
    async getTableData(param, url) {
      this.header = [];
      this.data = [];

      const send = await {
        data: param,
        url: url,
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (data.response == "Success") {
        this.header = await data["table"]["headers"];
        for (const key in this.header)
          this.header[key] = ("" + this.header[key]).toUpperCase();
        this.station = data.station;
        this.data = await data["table"]["data"];
        console.log(this.header, this.data);
        this.type = await data["table"]["type"];
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth() + 1; // Months are zero-indexed
        const day = now.getDate();
        const times = this.formatTime(now.getHours(), now.getMinutes());

        this.currentDate = `${year}-${month}-${day}`;
        this.currentDate = this.formatDate(this.currentDate) + " " + times;
        this.start = this.generate.date_start
          ? this.formatDate(this.generate.date_start)
          : "";
        this.end = this.generate.date_start
          ? this.formatDate(this.generate.date_end)
          : "";
      }
    },
    selectIncident(item, item_id) {
      this.generate.tempType = item;
      this.incidentT.list = [];
      this.generate.incident_type = item_id;
    },
  },
  watch: {
    "generate.tempType": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.search("incidentT", newVal);
      }
    },
  },
  mounted() {
    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.generate.id = credential.id;
  },
  cre() {
    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.generate.id = credential.id;
  },
};
</script>