<template>
    <div class="fixed z-50 bg-white top-0  animate-popup w-full overflow-auto  pb-20" style="height: 100vh;">
      <div class="w-full flex justify-end p-2">
        <svg
          class="w-10 h-10 p-2 text-blue-300 rounded-xl cursor-pointer hover:bg-opacity-50 hover:bg-blue-500 hover:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
          @click.prevent="changeA()"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </div>
      <h1 class="w-full flex justify-center">
        <span class="font-bold rounded text-xl bg-white px-30 py-2"
          >SIGNUP HERE</span
        >
      </h1>
      <span class="flex justify-center pb-2">
        <span class="border px-4 py-0">CRIME GUARD</span></span
      >

      <form class="max-w-lg mx-auto pb-3 bg-white p-10 *:pt-6">
        <p
          v-show="err"
          class="border-yellow-400 mb-4 bg-yellow-100 border rounded-md p-2 flex items-center text-red-700 text-sm font-light"
        >
          <svg
            class="flex-shrink-0 inline w-4 h-4 me-2"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
            />
          </svg>
          Please fill up the form correctly...
        </p>
        <p
          v-show="!err && submited"
          class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50"
        >
          <svg
            class="h-6 w-6 text-green-600 me-2"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" />
            <circle cx="12" cy="12" r="9" />
            <path d="M9 12l2 2l4 -4" />
          </svg>
          Account request sent, waiting for police station to approve...
        </p>
        <!-- HERE -->
        <!-- Personal Information -->
        <div class="w-full" v-show="active == 1">
          <div class="grid">
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="signUpForm.last_name"
                required
              />
              <label
                for="floating_phone"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >LAST NAME</label
              >
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="signUpForm.first_name"
                required
              />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >FIRST NAME</label
              >
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="signUpForm.middle_name"
                required
              />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >MIDDLE NAME</label
              >
            </div>
          </div>
          <div class="relative z-0 w-full mb-5 group grid grid-cols-2">
            <div class="relative z-0 w-full group">
              <label
                class="block text-sm font-medium text-gray-600"
                for="valid_id"
                >VALID ID:</label
              >
              <input
                class="block w-full text-md text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                type="file"
                @change="onFileChange($event, 'valid_id')"
              />
            </div>
            <div class="relative z-0 w-full group">
              <label
                class="block text-sm font-medium text-gray-600"
                for="profile"
                >PROFILE:</label
              >
              <input
                class="block w-full text-md text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                type="file"
                @change="onFileChange($event, 'profile')"
              />
            </div>
            <div class="relative z-0 w-full group">
              <label class="block text-sm font-medium text-gray-600">SEX</label>
              <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"
                v-model="signUpForm.gender"
              >
                <option value="">SELECT GENDER</option>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
              </select>
            </div>
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="email"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.email"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >EMAIL ADDRESS</label
            >
          </div>
          <div class="grid">
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="tel"
                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="signUpForm.contact"
                required
              />
              <label
                for="floating_phone"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >MOBILE NUMBER</label
              >
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="signUpForm.fb_name"
                required
              />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >FACEBOOK NAME</label
              >
            </div>
          </div>
        </div>
        <div class="w-full" v-show="active == 2">
          <span class="font-semibold text-md">CURRENT ADDRESS:</span>
          <hr class="mb-2 mt-1 bg-gradient-to-r from-blue-500 to-green-500" />
          <div>
            <div class="grid grid-cols-1 gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_province"
                  type="text"
                  class="block py-2 focus:py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.province"
                  @click="
                    setKeyVal('province', current_address);
                    generateAddress(current_address, 'province');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >PROVINCE</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'province' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_city"
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.city"
                  @click="
                    setKeyVal('city', current_address);
                    generateAddress(current_address, 'city');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >CITY</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'city' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_barangay"
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.barangay"
                  @click="
                    setKeyVal('barangay', current_address);
                    generateAddress(current_address, 'barangay');
                  "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >BARANGAY</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'barangay' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="grid grid-cols-1 gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_village"
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.sitio"
                  required
                  @click="
                    setKeyVal('sitio', current_address);
                    generateAddress(current_address, 'sitio');
                  "
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >SITIO</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'sitio' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.village"
                  @click="
                    setKeyVal('village', current_address);
                    generateAddress(current_address, 'village');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >VILLAGE</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'village' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_street"
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.street"
                  @click="
                    setKeyVal('street', current_address);
                    generateAddress(current_address, 'street');
                  "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >STREET</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'street' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="grid grid-cols-1 gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'house_number' || key == 'block') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.house_number"
                  @click="
                    setKeyVal('house_number', current_address);
                    generateAddress(current_address, 'house_number');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >HOUSE NO.</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'house_number' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'house_number' || key == 'block') &&
                      values == current_address
                    ),
                }"
              >
                <input
                  id="signup_current_house_no"
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="current_address.block"
                  @click="
                    setKeyVal('block', current_address);
                    generateAddress(current_address, 'block');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >BLOCK</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'block' &&
                  values == current_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full" v-show="active == 3">
          <span class="font-semibold text-md">OTHER ADDRESS:</span>
          <hr class="mb-2 mt-1" />
          <div>
            <div class="grid gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.province"
                  @click="
                    setKeyVal('province', other_address);
                    generateAddress(other_address, 'province');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >PROVINCE</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'province' &&
                  values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.city"
                  @click="
                    setKeyVal('city', other_address);
                    generateAddress(other_address, 'city');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >CITY</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 && key == 'city' && values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'province' ||
                        key == 'city' ||
                        key == 'barangay') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.barangay"
                  @click="
                    setKeyVal('barangay', other_address);
                    generateAddress(other_address, 'barangay');
                  "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >BARANGAY</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'barangay' &&
                  values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="grid gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.sitio"
                  required
                  @click="
                    setKeyVal('sitio', other_address);
                    generateAddress(other_address, 'sitio');
                  "
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >SITIO</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 && key == 'sitio' && values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.village"
                  @click="
                    setKeyVal('village', other_address);
                    generateAddress(other_address, 'village');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >VILLAGE</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'village' &&
                  values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'sitio' || key == 'village' || key == 'street') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.street"
                  @click="
                    setKeyVal('street', other_address);
                    generateAddress(other_address, 'street');
                  "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >STREET</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'street' &&
                  values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="grid gap-y-3">
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'house_number' || key == 'block') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.house_number"
                  @click="
                    setKeyVal('house_number', other_address);
                    generateAddress(other_address, 'house_number');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >HOUSE NO.</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 &&
                  key == 'house_number' &&
                  values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
              <div
                class="relative z-0 w-full group"
                :class="{
                  'mb-5':
                    places.length <= 0 ||
                    !(
                      (key == 'house_number' || key == 'block') &&
                      values == other_address
                    ),
                }"
              >
                <input
                  type="text"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="other_address.block"
                  @click="
                    setKeyVal('block', other_address);
                    generateAddress(other_address, 'block');
                  "
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >BLOCK</label
                >
              </div>
              <div
                v-if="
                  places.length > 0 && key == 'block' && values == other_address
                "
                class="mb-4 bg-white divide-y divide-gray-100 rounded-b-lg h-20 overflow-auto border shadow"
              >
                <ul class="text-sm text-gray-700">
                  <li v-for="p in places">
                    <span
                      @click="setAddress(values, key, p)"
                      class="block px-4 py-1 hover:bg-gray-100 border-b"
                      >{{ p }}</span
                    >
                  </li>
                  <li v-if="places.length <= 0">
                    <span
                      class="block h-16 text-center font-semibold pt-2 text-lg px-4 py-1"
                      >SELECT ADDRESS</span
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- Account Information -->
        <div class="w-full" v-show="active == len">
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="text"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.user_name"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >USER NAME</label
            >
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="password"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="signUpForm.password"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >PASSWORD</label
            >
          </div>
          <div class="relative z-0 w-full mb-5 group">
            <input
              type="password"
              class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
              placeholder=" "
              v-model="confirmPass"
              required
            />
            <label
              for="floating_email"
              class="peer-focus:font-medium absolute text-sm text-gray-500 -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >CONFIRM PASSWORD</label
            >
          </div>
        </div>
      </form>
      <div class="w-full border-t-2 pt-4 justify-between bottom-28 flex px-8">
        <button
          v-show="active != 1"
          class="bg-blue-600 px-10 py-2.5 text-sm font-semibold rounded-md px-10 text-white"
          @click="active--"
        >
          <- BACK
        </button>
        <p class="px-10" v-if="active == 1"></p>
        <button
          v-show="active != len"
          class="bg-blue-600 py-2.5 text-sm px-10 font-semibold rounded-md text-white"
          @click="active++"
        >
          NEXT->
        </button>
        <button
          v-show="active == len"
          type="button"
          class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm sm:w-auto py-2.5 text-center px-10"
          @click="sendData() /*sendData()*/"
        >
          Request
        </button>
      </div>
    </div>
</template>
  
  <script>
import axios from "axios";

export default {
  data() {
    return {
      signUpForm: {
        email: "",
        valid_id: "",
        password: "",
        first_name: "",
        last_name: "",
        middle_name: "",
        contact: "",
        user_name: "",
        gender: "",
        fb_name: "",
        profile: "",
      },
      current_address: {
        street: "",
        house_number: "",
        village: "",
        barangay: "",
        city: "",
        province: "",
        block: "",
        sitio: "",
      },
      other_address: {
        street: "",
        house_number: "",
        village: "",
        barangay: "",
        city: "",
        province: "",
        block: "",
        sitio: "",
      },
      confirmPass: "",
      formComplete: true,
      err: false,
      submited: false,
      active: 1,
      selectedPlace: null,
      places: [],
      activePlace: "",
      key: null,
      values: null,
      toggler: false,
      valid_id: null,
      profile: null,
      len: 3,
    };
  },
  computed: {
    passIncorrect() {
      const confirmPass = this.confirmPass;
      const password = this.signUpForm.password;
      return confirmPass != password && password != "" && confirmPass != "";
    },
    formIncomplete() {
      for (const c of Object.values(this.signUpForm)) {
        if (c == "") {
          this.formComplete = false;
          alert();
          break;
        }
      }
      return this.formComplete;
    },
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
  methods: {
    async signUpRequest() {
      const sf = this.signUpForm;
      sf["current_address"] = this.current_address;
      sf["other_address"] = this.other_address;

      const toBESEND = {
        url: "api/user/request/registration",
        data: sf,
      };

      const test = await this.$store.dispatch("sendData", toBESEND);
      return test["response"];
      //await console.log(test);
    },
    changeA() {
      this.changeActive("Home");
    },
    setAddress(param, key, value) {
      param[key] = value;
      this.places = [];
      this.toggler = false;
    },
    setKeyVal(key, val) {
      this.key = key;
      this.values = val;
      this.toggler = true;
    },
    async generateAddress(search, selected) {
      const data = {
        selected: [selected],
        search: search,
      };
      this.activePlace = selected;
      const send = {
        url: "api/address/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
        console.log(this.places);
      } else {
        alert("Error");
      }
    },
    async sendData() {
      if (this.passIncorrect /*  || !this.formIncomplete */) {
        this.err = await true;
        console.log(this.signUpForm, this.confirmPass);
        return;
      }

      //this.$store.commit("addUser", this.signUpForm);
      //console.log(this.$store.state.userInfo);

      const res = await this.signUpRequest();

      if (res != "Error") {
        await this.clearForm(this.signUpForm);
        await this.clearForm(this.other_address);
        await this.clearForm(this.current_address);
        this.submited = await true;
        this.err = await false;
      } else {
        alert("Username Email or Phone, already Exists!");
      }
      //const test = await this.$store.dispatch("sendData", toBESEND);
    },
    clearForm(param) {
      for (const key of Object.keys(param)) {
        if (key != "userLevel") param[key] = "";
      }
      this.confirmPass = "";
    },
    getAddressData(addressData) {
      console.log(addressData);
      addressData.formatted_address;
    },
    initAutocomplete() {
      if (typeof google === "undefined") {
        console.error("Google Maps JavaScript API not loaded");
        return;
      }
      this.setItUp("signup_current_street", "current_address");
      this.setItUp("signup_current_house_no", "current_address");
      this.setItUp("signup_current_village", "current_address");
      this.setItUp("signup_current_barangay", "current_address");
      this.setItUp("signup_current_city", "current_address");
      this.setItUp("signup_current_province", "current_address");

      this.setItUp("signup_other_street", "other_address");
      this.setItUp("signup_other_house_no", "other_address");
      this.setItUp("signup_other_village", "other_address");
      this.setItUp("signup_other_barangay", "other_address");
      this.setItUp("signup_other_city", "other_address");
      this.setItUp("signup_other_province", "other_address");
      /* 
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input, {
          types: ['address'],
          fields: ['address_components'],
          componentRestrictions: { country: 'ph' }, // Restrict to the Philippines
        });
  
        autocomplete.addListener('place_changed', () => {
          const place = autocomplete.getPlace(); 
          if (!place.geometry) {
            console.error('No details available for input: ' + place.name);
            return;
          } 
  
          // Handle the selected place details
          autocomplete.getPlace().address_components.forEach(component => {
          const types = component.types;
          const value = component.long_name;
  
          if (types.includes('street_number')) {
            this.current_address.house_number = value;
          } else if (types.includes('route')) {
            this.current_address.street = value;
          } else if (types.includes('sublocality') || types.includes('sublocality_level_1')) {
            this.current_address.village = value;
          } else if (types.includes('locality')) {
            this.current_address.city = value;
          } else if (types.includes('administrative_area_level_2')) {
            this.current_address.barangay = value;
          } else if (types.includes('administrative_area_level_1')) {
            this.current_address.province = value;
          }
        });
        }); */
    },
    setItUp(theId, key) {
      const input = document.getElementById(theId);
      const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["address"],
        fields: ["address_components"],
        componentRestrictions: { country: "ph" }, // Restrict to the Philippines
      });

      autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        this[key].house_number = "";
        this[key].street = "";
        this[key].village = "";
        this[key].city = "";
        this[key].barangay = "";
        this[key].province = "";

        autocomplete.getPlace().address_components.forEach((component) => {
          const types = component.types;
          const value = component.long_name;

          if (types.includes("street_number")) {
            this[key].house_number = value;
          } else if (types.includes("route")) {
            this[key].street = value;
          } else if (
            types.includes("sublocality") ||
            types.includes("sublocality_level_1")
          ) {
            this[key].village = value;
          } else if (types.includes("locality")) {
            this[key].city = value;
          } else if (types.includes("administrative_area_level_1")) {
            //this[key].barangay = value;
          } else if (types.includes("administrative_area_level_2")) {
            this[key].province = value;
          }
        });
      });
    },
    onFileChange(event, fileType) {
      this[fileType] = event.target.files[0];
      this.uploadFile(fileType);
    },

    async uploadFile(fileType) {
      const file = this[fileType];
      if (!file) {
        this.responseMessage = `No ${fileType} selected.`;
        return;
      }

      let formData = new FormData();
      formData.append("file", file);

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });

        this.responseMessage = response["response"];
        if (this.responseMessage == "Success") {
          this.signUpForm[fileType] = response.file_path;
        }
      } catch (error) {
        console.error(error);
        this.responseMessage = `Upload of ${fileType} failed.`;
      }

      console.log(this.signUpForm);
      alert(this.responseMessage);
    },
    async loadAPI() {
      return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src =
          "https://maps.googleapis.com/maps/api/js?key=AIzaSyAfuU61GhND_tK2_KxcvLtT3tLbJiqlmTM&libraries=places";
        script.async = true;
        script.defer = true;
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
      });
    },
    isPhoneM() {
      return window.innerWidth <= 768;
    },
  },
  mounted() {
    (async () => {
      await this.loadAPI();
      /* await this.initAutocomplete(); */
      if (window.innerWidth <= 768) {
        this.len = 4;
      }
      console.log(this.len);
    })();
  },
  watch: {
    "current_address.province": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.setKeyVal("province", this.current_address);
        this.generateAddress(this.current_address, "province");
      }
    },
    "current_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.current_address);
        this.generateAddress(this.current_address, "city");
      }
    },
    "current_address.barangay": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("barangay", this.current_address);
        this.generateAddress(this.current_address, "barangay");
      }
    },
    "current_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.current_address);
        this.generateAddress(this.current_address, "city");
      }
    },
    "current_address.sitio": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("sitio", this.current_address);
        this.generateAddress(this.current_address, "sitio");
      }
    },
    "current_address.village": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("village", this.current_address);
        this.generateAddress(this.current_address, "village");
      }
    },
    "current_address.street": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("street", this.current_address);
        this.generateAddress(this.current_address, "street");
      }
    },
    "current_address.house_number": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("house_number", this.current_address);
        this.generateAddress(this.current_address, "house_number");
      }
    },
    "current_address.block": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("block", this.current_address);
        this.generateAddress(this.current_address, "block");
      }
    },
    "other_address.province": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("province", this.other_address);
        this.generateAddress(this.other_address, "province");
      }
    },
    "other_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.other_address);
        this.generateAddress(this.other_address, "city");
      }
    },
    "other_address.barangay": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("barangay", this.other_address);
        this.generateAddress(this.other_address, "barangay");
      }
    },
    "other_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.other_address);
        this.generateAddress(this.other_address, "city");
      }
    },
    "other_address.sitio": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("sitio", this.other_address);
        this.generateAddress(this.other_address, "sitio");
      }
    },
    "other_address.village": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("village", this.other_address);
        this.generateAddress(this.other_address, "village");
      }
    },
    "other_address.street": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("street", this.other_address);
        this.generateAddress(this.other_address, "street");
      }
    },
    "other_address.house_number": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("house_number", this.other_address);
        this.generateAddress(this.other_address, "house_number");
      }
    },
    "other_address.block": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("block", this.other_address);
        this.generateAddress(this.other_address, "block");
      }
    },
  },
  props: ["changeActive"],
};
</script>
  <style scoped>
.animate-popup {
  animation: popup 0.1s ease-out forwards;
}

@keyframes popup {
  0% {
    transform: scale(0.5);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>