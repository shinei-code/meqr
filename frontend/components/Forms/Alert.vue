<template>
  <v-alert dense border="left" type="warning" icon="mdi-alert-outline">
    {{ message }}
  </v-alert>
</template>

<script>
export default {
  props: {
    message: {
      default: null
    }
  },
}
</script>
