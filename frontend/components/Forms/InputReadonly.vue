<template>
  <v-text-field class="fontColor pt-0 mt-0 mr-1" v-model="value" readonly>
  </v-text-field>
</template>

<script>
export default {
  props: {
    value: {
      required: true,
    },
  },
}
</script>

<style scoped>
.fontColor >>> input {
  color: #818080 !important;
  background-color: #f7f7f7;
  border-bottom: none !important;
  padding-left: 10px;
  line-height: 80px;
  max-height: 50px;
}
</style>