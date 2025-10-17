import { defineStore } from 'pinia'
import api from '@/services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: null,
    user: null,
    loading: false,
    error: null,
    errors: {},
    message: null,
  }),

  actions: {

    async signup(dataRegister) {
      this.loading = true
      this.error = null
      this.errors = {}
      this.message = null

      try {
        const { data } = await api.post('/register', dataRegister)

        this.message = data.message || 'Registration successful!'

        if (data) {
          this.user = data
          this.isAuth = true
        }

        return { success: true, message: this.message }

      } catch (err) {
        if (err.response) {
          const responseData = err.response.data

          // Erreur de validation (422)
          if (err.response.status === 422) {
            this.error = responseData.message || 'Please correct the errors'
            this.errors = responseData.errors || {}
          }
          // Autres erreurs HTTP
          else {
            this.error = responseData.message || 'An error occurred during registration'
            this.errors = responseData.errors || {}
          }
        }
        else {
          this.error = 'An unexpected error has occurred'
        }
        return { success: false, message: this.error, errors: this.errors }
      } finally {
        this.loading = false
      }
    },

    async login(email, password) {
      this.loading = true
      this.error = null
      this.errors = {}
      this.message = null

      try {
        const { data } = await api.post('/login', { email, password })

        if (data.token) {
          this.token = data.token
          localStorage.setItem('token', data.token)
          this.isAuth = true
          this.error = null
          this.message = 'Connection successful!'
          return { success: true, message: this.message }
        } else {
          this.error = data.message || 'Login failed'
          return { success: false, message: this.error }
        }

      } catch (err) {
        if (err.response) {
          const responseData = err.response.data
          this.error = responseData.message || 'Incorrect credentials'
          this.errors = responseData.errors || {}
        } else {
          this.error = 'An error has occurred'
        }
        return { success: false, message: this.error, errors: this.errors }
      } finally {
        this.loading = false
      }
    },

    //Charger le token depuis le localStorage
    loadTokenFromStorage() {
      const token = localStorage.getItem('token')
      if (token) {
        this.token = token
        this.isAuth = true
      }
    },

    //Obtenir l'erreur d'un champ spécifique
    getFieldError(field) {
      return this.errors[field]?.[0] || null
    },

    setFieldError(field, message) {
      this.fieldErrors[field] = message
    },

    //Vérifier si un champ a une erreur
    hasFieldError(field) {
      return !!this.errors[field]
    },

    //Effacer l'erreur d'un champ
    clearFieldError(field) {
      if (this.errors[field]) {
        delete this.errors[field]
      }
      // Si plus d'erreurs, effacer le message global
      if (Object.keys(this.errors).length === 0) {
        this.error = null
      }
    },

    //Effacer toutes les erreurs
    clearAllErrors() {
      this.error = null
      this.errors = {}
      this.message = null
    },
  },

  getters: {
    //Vérifier s'il y a des erreurs
    hasErrors: (state) => {
      return Object.keys(state.errors).length > 0
    },

    //Compter le nombre d'erreurs
    errorCount: (state) => {
      return Object.values(state.errors).reduce((total, fieldErrors) => {
        return total + fieldErrors.length
      }, 0)
    }
  },

  persist: {
    key: 'auth',
    paths: ['token', 'user'],
  },
})
