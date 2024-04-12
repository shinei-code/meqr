<template>
  <v-btn color="blue-grey lighten-5" x-large @click="$emit('click')" class="rounded-lg">
    <v-icon color="grey darken-1" class="mr-1">mdi-arrow-left-circle-outline</v-icon>
    戻る
  </v-btn>
</template>

<script>
export default {
  props: ['showValid'],
  data() {
    return {
      valid: true,
    }
  },
}
</script>
