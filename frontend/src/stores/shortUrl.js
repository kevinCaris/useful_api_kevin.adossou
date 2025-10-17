import { defineStore } from 'pinia'
import api from '@/services/api'
import { showError, showSuccess } from '@/helpers/toastHelper'

export const useshortUrlStore = defineStore('shortUrl', {
  state: () => ({
    shortUrl: null,
    shortUrls:[],
    loading: false,
    error: null,

  }),

  actions: {

    async AllModules() {
      this.loading = true
      this.error = null
      this.errors = {}

      try {
        const { data } = await api.get('modules')

        this.modules = data
        console.log(this.module)

        showSuccess("mosules load successful!")

      } catch (err) {
        if (err.response) {
          this.error = err
          showError(this.error)
        }
      } finally {
        this.loading = false
      }
    },

    async activateModules(moduleId) {
      this.loading = true
      this.error = null
      this.errors = {}

      try {
        const { data } = await api.post(`/modules/${moduleId}/activate`)

        showSuccess(data.message)

      } catch (err) {
        if (err.response) {
          this.error = err
          showError(this.error)
        }
      } finally {
        this.loading = false
      }
    },

     async activateModules(moduleId) {
      this.loading = true
      this.error = null
      this.errors = {}

      try {
        const { data } = await api.post(`/modules/${moduleId}/deactivate`)

        showSuccess(data.message)

      } catch (err) {
        if (err.response) {
          this.error = err
          showError(this.error)
        }
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
    paths: ['token', 'user', 'isAdmin'],
  },
})
