<template>
  <div class="min-h-screen flex items-center justify-center bg-[#007E90] p-4">
    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-center text-[#017E91] mb-6">Sign In</h2>

      <!-- Message d'erreur global -->
      <div
        v-if="authStore.error"
        class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-r-lg flex items-center gap-3"
      >
        <i class="fa-solid fa-xmark text-red-600"></i>
        <span class="flex-1">{{ authStore.error }}</span>
        <button @click="authStore.clearAllErrors()" class="text-red-800 hover:text-red-700">
          ✕
        </button>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <!-- Email -->
        <div>
          <label for="email" class="block text-[#017E91] font-semibold mb-1">Email</label>
          <input
            id="email"
            type="email"
            v-model="email"
            :class="inputClasses('email')"
            placeholder="Enter your email"
            @input="authStore.clearFieldError('email')"
            required
          />
          <p v-if="authStore.getFieldError('email')" class="text-red-600 text-sm mt-1">
            {{ authStore.getFieldError('email') }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-[#017E91] font-semibold mb-1">Password</label>
          <input
            id="password"
            type="password"
            v-model="password"
            :class="inputClasses('password')"
            placeholder="Enter your password"
            @input="authStore.clearFieldError('password')"
            required
          />
          <p v-if="authStore.getFieldError('password')" class="text-red-600 text-sm mt-1">
            {{ authStore.getFieldError('password') }}
          </p>
        </div>
        <router-link to="/password/forgot">
          <p class="mt-2 mb-2 cursor-pointer text-blue-500 hover:text-blue-600">Forgot password?</p>
        </router-link>
        <button
          type="submit"
          :disabled="authStore.loading || !email || !password"
          class="w-full bg-[#017E91] text-white py-3 rounded-lg font-semibold hover:bg-[#017E91] disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="authStore.loading" class="flex items-center justify-center gap-2">
            <span class="animate-spin">⏳</span>
            Logging in...
          </span>

          <span v-else>Login</span>
        </button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        New user?
        <a href="/signup" class="text-[#017E91] font-semibold hover:underline">Create account</a>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import router from '@/router'
import { showSuccess } from '@/helpers/toastHelper'

const authStore = useAuthStore()
const email = ref('')
const password = ref('')

function inputClasses(field) {
  const base =
    'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 transition-all duration-300'
  const error = 'border-red-500 focus:ring-red-500 bg-red-50'
  const normal = 'border-gray-200 focus:ring-indigo-800'
  return `${base} ${authStore.hasFieldError(field) ? error : normal}`
}

const handleLogin = async () => {
  authStore.clearAllErrors()
  const result = await authStore.login(email.value, password.value)
  if (result.success) {
    showSuccess(result.message || 'Connected successfully')
    router.push('/')
  } else {
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}
</script>
