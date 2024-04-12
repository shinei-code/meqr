<template>

  <v-alert
    border="left"
    colored-border
    color="teal lighten-1"
    class="pt-0 pb-0 rounded-0 mb-2 titleSmStyle"
    dense
  >
    {{ label }}
    <template v-if="required">
      <!-- <span class="text-red"> *</span> -->
      <span class="required">必須</span>
    </template>
  </v-alert>

</template>
<script>
export default {
  props: {
    label: {
      required: true,
    },
    required: {
      defalut: false,
      type: Boolean,
    },
  },
}
</script>
<style lang="scss" scoped>
.titleSmStyle {
  font-size: 17px;
  font-weight: 550;

  .required {
    padding: 5px;
    font-size: 12px;
    color: white;
    border-radius: 5px;
    background-color: rgb(226, 31, 31);
    vertical-align: middle;
  }
}

</style>