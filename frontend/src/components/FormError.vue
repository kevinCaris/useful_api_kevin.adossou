<template>
  <transition name="slide-fade">
    <p v-if="error" class="text-red-600 text-sm mt-1 flex items-center gap-1">
      <span> <AlertTriangle class="w-5 h-5" /> </span>
      <span>{{ error }}</span>
    </p>
  </transition>
</template>

<script setup>
defineProps({
  error: {
    type: String,
    default: '',
  },
})
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from {
  transform: translateY(-10px);
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}
</style>
