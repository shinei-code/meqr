<template>
    <v-snackbar
      v-model="cookieConfirm"
      timeout="-1"
      max-width="80%"
      color="rgb(51, 51, 51, 0.8)"
    >
      <span>当サイトでは、サイトの利便性向上のため、ウェブストレージ(web storage)を使用しています。</span><br>
      <nuxt-link to="/Notice" target="_blank" class="text-white" rel="noopener">ウェブストレージ(web storage)とは？</nuxt-link>
      <template v-slot:action="{ attrs }">
        <v-btn
          color="grey darken-1"
          v-bind="attrs"
          class="ml-5 mr-3"
          @click="confirmed"
        >
          OK
        </v-btn>
      </template>
    </v-snackbar>
</template>

<script>
export default {
  data() {
    return {
      cookieConfirm: false
    }
  },

  mounted() {
    this.cookieConfirm = !this.$store.getters.getCookieConfirmed;
  },
  methods: {
    confirmed() {
      this.$store.commit('setCookieConfirmed', true);
      this.cookieConfirm = false;
    }
  }
}
</script>

<style lang="scss" scoped>
.text-white {
  color: rgb(255, 255, 255, 0.87);
}
</style>