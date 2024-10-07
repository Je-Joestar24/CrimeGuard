<template>
  <form
    class="p-4 md:p-5 md:max-w-screen-md rounded-md border shadow-lg"
    :class="{
      'bg-gray-800 text-white border-gray-700': $store.getters.theme,
      'bg-white text-gray-800': !$store.getters.theme,
    }"
  >
    <h2 class="text-2xl font-bold mb-6 text-center" :class="{ 'text-white': $store.getters.theme }">
      Generate Officer Account Report
    </h2>

    <div class="grid md:grid-cols-2 gap-6">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1" :class="{ 'text-gray-300': $store.getters.theme, 'text-gray-700': !$store.getters.theme }">
            Date From
          </label>
          <input
            type="date"
            v-model="generate.date_start"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-opacity-50"
            :class="{
              'bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500': $store.getters.theme,
              'bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500': !$store.getters.theme,
            }"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" :class="{ 'text-gray-300': $store.getters.theme, 'text-gray-700': !$store.getters.theme }">
            Time From
          </label>
          <input
            type="time"
            v-model="generate.time_start"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-opacity-50"
            :class="{
              'bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500': $store.getters.theme,
              'bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500': !$store.getters.theme,
            }"
            required
          />
        </div>
      </div>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1" :class="{ 'text-gray-300': $store.getters.theme, 'text-gray-700': !$store.getters.theme }">
            Date To
          </label>
          <input
            type="date"
            v-model="generate.date_end"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-opacity-50"
            :class="{
              'bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500': $store.getters.theme,
              'bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500': !$store.getters.theme,
            }"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" :class="{ 'text-gray-300': $store.getters.theme, 'text-gray-700': !$store.getters.theme }">
            Time To
          </label>
          <input
            type="time"
            v-model="generate.time_end"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-opacity-50"
            :class="{
              'bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500': $store.getters.theme,
              'bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500': !$store.getters.theme,
            }"
            required
          />
        </div>
      </div>
    </div>

    <div class="mt-6">
      <label class="block text-sm font-medium mb-1" :class="{ 'text-gray-300': $store.getters.theme, 'text-gray-700': !$store.getters.theme }">
        Report Type
      </label>
      <select
        v-model="rtype"
        class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-opacity-50"
        :class="{
          'bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500': $store.getters.theme,
          'bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500': !$store.getters.theme,
        }"
      >
        <option value="" disabled>Select Report Type</option>
        <option value="1">Station Transfer</option>
        <option value="2">Rank Change</option>
        <option value="3">My Station Members</option>
      </select>
    </div>

    <div class="mt-8 flex justify-center">
      <button
        @click="printContent"
        type="button"
        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300"
      >
        Generate Report
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