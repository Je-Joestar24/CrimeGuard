<template>
  <button onclick="document.getElementById('irForm').style.display = ''"
  >back</button>
  <form class="p-4 md:p-5" id="irForm">
    <!-- Form fields -->
    <div class="grid md:grid-cols-3 md:gap-6">
      <div class="relative z-0 w-full mb-5 group">
        <input
          type="tel"
          pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
          name="floating_phone"
          id="floating_phone"
          class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          placeholder=" "
          required
        />
        <label
          for="floating_phone"
          class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
          >IRF ENTRY NUMBER:</label
        >
      </div>
      <div class="relative z-0 w-full mb-5 group">
        <input
          type="text"
          name="floating_company"
          id="floating_company"
          class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          placeholder=" "
          required
        />
        <label
          for="floating_company"
          class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
          >TYPE OF INCEDENT:</label
        >
      </div>
      <div class="relative z-0 w-full mb-5 group">
        <input
          type="text"
          name="floating_company"
          id="floating_company"
          class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          placeholder=" "
          required
        />
        <label
          for="floating_company"
          class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
          >COPY FOR:</label
        >
      </div>
    </div>
    <div class="grid md:grid-cols-3 md:gap-6">
      <div class="grid md:grid-cols-2 md:gap-6 group">
        <div class="relative z-0 w-full mb-5 group">
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="date"
              pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
              name="floating_phone"
              id="floating_phone"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=""
              required
            />
          </div>
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Date Reported:</label
          >
        </div>
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="time"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time Reported:</label
          >
        </div>
      </div>
      <div class="grid md:grid-cols-2 md:gap-6 group">
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="date"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Date of Incident:</label
          >
        </div>
        <div class="relative z-0 w-full mb-5 group">
          <input
            type="time"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            name="floating_phone"
            id="floating_phone"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
            required
          />
          <label
            for="floating_phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time of Incident:</label
          >
        </div>
      </div>
      <div class="relative z-0 w-full mb-5 group">
        <input
          type="text"
          name="floating_company"
          id="floating_company"
          class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          placeholder=" "
          required
        />
        <label
          for="floating_company"
          class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
          >Place of Incident:</label
        >
      </div>
    </div>
    <p class="text-lg font-semibold text-gray-900 truncate -dark:text-white">
      Involve Personalities
    </p>
    <div class="grid md:grid-cols-3 md:gap-6">
      <ul
        class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2 overflow-auto h-40 shadow border"
      >
        <p
          class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
        >
          Reporting Persons
          <button
            type="button"
            class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
          >
            + Add
          </button>
        </p>
        <li class="pb-3 sm:pb-4">
          <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="flex-1 min-w-0">
              <p
                class="text-sm font-medium text-gray-900 truncate -dark:text-white grid md:grid-cols-7"
              >
                <span class="col-span-2"> Neil Sims </span>
                <span
                  class="text-sm text-gray-500 truncate -dark:text-gray-400 col-span-4"
                  ><span>Contact:</span>
                  email@flowbite.com
                </span>
                <a href="#" class="col-span-1 text-red-400">remove</a>
              </p>
            </div>
          </div>
        </li>
      </ul>
      <ul
        class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2 overflow-auto h-40 shadow border"
      >
        <p
          class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
        >
          Suspects
          <button
            type="button"
            class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
          >
            + Add
          </button>
        </p>
        <li class="pb-3 sm:pb-4">
          <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="flex-1 min-w-0">
              <p
                class="text-sm font-medium text-gray-900 truncate -dark:text-white grid md:grid-cols-7"
              >
                <span class="col-span-2"> Neil Sims </span>
                <span
                  class="text-sm text-gray-500 truncate -dark:text-gray-400 col-span-4"
                  ><span>Contact:</span>
                  email@flowbite.com
                </span>
                <a href="#" class="col-span-1 text-red-400">remove</a>
              </p>
            </div>
          </div>
        </li>
      </ul>
      <ul
        class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2 overflow-auto h-40 shadow border"
      >
        <p
          class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
        >
          Victims
          <button
            type="button"
            class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
            onclick="document.getElementById('irForm').style.display = 'none'"
          >
            + Add
          </button>
        </p>
        <li class="pb-3 sm:pb-4">
          <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="flex-1 min-w-0">
              <p
                class="text-sm font-medium text-gray-900 truncate -dark:text-white grid md:grid-cols-7"
              >
                <span class="col-span-2"> Neil Sims </span>
                <span
                  class="text-sm text-gray-500 truncate -dark:text-gray-400 col-span-4"
                  ><span>Contact:</span>
                  email@flowbite.com
                </span>
                <a href="#" class="col-span-1 text-red-400">remove</a>
              </p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <label
      for="message"
      class="block mb-2 text-sm font-medium text-gray-900 -dark:text-white"
      >Narative of the Incident</label
    >
    <textarea
      id="message"
      rows="4"
      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 -dark:bg-gray-700 -dark:border-gray-600 -dark:placeholder-gray-400 -dark:text-white -dark:focus:ring-blue-500 -dark:focus:border-blue-500"
      placeholder="Write the Narative here..."
    ></textarea>
  </form>
</template>

<script>
</script>