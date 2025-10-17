<template>
  <!-- SideBar -->
  <div
    :class="[
      'bg-white text-gray-700 transition-all duration-300 flex-shrink-0',
      isCollapsed ? 'w-16' : 'w-39',
    ]"
  >
    <div class="p-2 h-full flex flex-col bg-white dark:bg-gray-800 border-r">
      <!-- Logo -->
      <a href="#">
        <div
          class="flex justify-center lg:justify-start items-center gap-2 py-2 cursor-pointer border-2"
          @click="toggleSidebar"
        >

          <span v-if="!isCollapsed" class="font-bold text-orange-300 transition-all duration-600">
            APPLICATION
          </span>
        </div>
      </a>

      <div class="flex flex-col h-full overflow-y-auto flex-grow pt-2 justify-between">
        <div class="flex flex-col space-y-1 mx-1 lg:mt-1">
          <!-- Exemple d’item -->
          <router-link
            to="/modules"
            active-class="text-white bg-primary-500"
            :class="[
              'flex items-center h-12 rounded-md font-semibold text-gray-600 hover:text-primary-500 transition',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
          >
            <span class="inline-flex items-center mr-2">
              <!-- Icône -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  fill="currentColor"
                  d="M10.894 22h2.212c3.447 0 5.17 0 6.345-1.012s1.419-2.705 1.906-6.093l.279-1.937c.38-2.637.57-3.956.029-5.083s-1.691-1.813-3.992-3.183l-1.385-.825C14.2 2.622 13.154 2 12 2s-2.199.622-4.288 1.867l-1.385.825c-2.3 1.37-3.451 2.056-3.992 3.183s-.35 2.446.03 5.083l.278 1.937c.487 3.388.731 5.081 1.906 6.093S7.447 22 10.894 22"
                  opacity=".5"
                />
                <path
                  fill="currentColor"
                  d="M9.447 15.397a.75.75 0 0 0-.894 1.205A5.77 5.77 0 0 0 12 17.75a5.77 5.77 0 0 0 3.447-1.148a.75.75 0 0 0-.894-1.205A4.27 4.27 0 0 1 12 16.25a4.27 4.27 0 0 1-2.553-.853"
                />
              </svg>
            </span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300">AllModules</span>
          </router-link>

          Modules
          <router-link
            to=""
            active-class=""
            :class="[
              'flex items-center h-12 rounded-md font-semibold  text-white',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
            v-if="modulesStore.isActiveModule"
          >
            <span class="inline-flex items-center mr-2"></span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300 transition"
              >WURL Shortener</span
            >
          </router-link>

          <router-link
            to=""
            active-class=""
            :class="[
              'flex items-center h-12 rounded-md font-semibold  text-white',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
             v-if="modulesStore.isActiveModule"
          >
            <span class="inline-flex items-center mr-2"></span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300 transition"
              >Wallet</span
            >
          </router-link>

          <router-link
            to=""
            active-class=""
            :class="[
              'flex items-center h-12 rounded-md font-semibold  text-white',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
             v-if="modulesStore.isActiveModule"
          >
            <span class="inline-flex items-center mr-2"></span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300 transition"
              >WMarketplace</span
            >
          </router-link>

          <router-link
            to=""
            active-class=""
            :class="[
              'flex items-center h-12 rounded-md font-semibold  text-white',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
             v-if="modulesStore.isActiveModule"
          >
            <span class="inline-flex items-center mr-2"></span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300 transition"
              >Time Tracker</span
            >
          </router-link>

          <router-link
            to=""
            active-class=""
            :class="[
              'flex items-center h-12 rounded-md font-semibold  text-white',
              isCollapsed ? 'justify-center px-0' : 'px-3',
            ]"
             v-if="modulesStore.isActiveModule"
          >
            <span class="inline-flex items-center mr-2"></span>
            <span v-if="!isCollapsed" class="lg:block hover:text-orange-300 transition"
              >Investment Tracker</span
            >
            
          </router-link>
        </div>

        <div
          v-if="authStore.user"
          class="flex flex-col items-center justify-center p-3 mt-auto mb-4"
        >
          <div class="relative">
            <img
              :src="authStore.user.avatar || 'public/default-avatar.png'"
              alt="Avatar"
              class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600"
            />
            <span
              class="absolute bottom-0 right-0 block w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"
              title="Online"
            ></span>
          </div>

          <p
            class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-200 truncate text-center w-full"
          >
            {{ authStore.user.name }}
          </p>
        </div>


      </div>

      <div class="px-1" @click="logout">
        <div
          :class="[
            'flex flex-row items-center rounded-md h-12 font-semibold cursor-pointer',
            isCollapsed ? 'justify-center px-0' : 'justify-start pr-3.5 lg:pr-6',
          ]"
        >
          <span class="inline-flex justify-center items-center ml-3.5">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.25rem"
              height="1.25rem"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M15 2h-1c-2.828 0-4.243 0-5.121.879C8 3.757 8 5.172 8 8v8c0 2.828 0 4.243.879 5.121C9.757 22 11.172 22 14 22h1c2.828 0 4.243 0 5.121-.879C21 20.243 21 18.828 21 16V8c0-2.828 0-4.243-.879-5.121C19.243 2 17.828 2 15 2"
                opacity=".6"
              ></path>
              <path
                fill="currentColor"
                d="M8 8c0-1.538 0-2.657.141-3.5H8c-2.357 0-3.536 0-4.268.732S3 7.143 3 9.5v5c0 2.357 0 3.535.732 4.268S5.643 19.5 8 19.5h.141C8 18.657 8 17.538 8 16z"
                opacity=".4"
              ></path>
              <path
                fill="currentColor"
                fill-rule="evenodd"
                d="M4.47 11.47a.75.75 0 0 0 0 1.06l2 2a.75.75 0 0 0 1.06-1.06l-.72-.72H14a.75.75 0 0 0 0-1.5H6.81l.72-.72a.75.75 0 1 0-1.06-1.06z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </span>
          <span
            v-if="!isCollapsed"
            class="ml-2 text-sm tracking-wide truncate capitalize lg:block text-orange-300 hover:text-orange-200"
            >Logout</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/authStore'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const isCollapsed = ref(false)
const authStore = useAuthStore()

import { useModuleStore } from "@/stores/moduleStore";

const modulesStore = useModuleStore();

const router = useRouter()

const logout = () => {
  authStore.logout()
  router.push('/login')
}

function toggleSidebar() {
  isCollapsed.value = !isCollapsed.value
}
</script>
