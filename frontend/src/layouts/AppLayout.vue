<template>
  <div id="app" class="w-screen h-screen grid grid-cols-[auto_1fr]">
    <Sidebar />
    <main
      class="bg-white overflow-hidden bg-cover bg-center transition-all duration-500"
      :style="{ backgroundImage: `url(${currentBg})` }"
    >
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'

const route = useRoute()
const showBgButtons = computed(() => route.name === 'board')
</script>
