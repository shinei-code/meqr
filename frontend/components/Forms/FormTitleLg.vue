<template>
  <p class="item-label mb-3 font-weight-regular">
    {{label}}
    <span v-if="required ==true" class="required">必須</span>
    <span class="infomation" v-if="infoLabel">
      <v-chip
        color="orange" outlined dark
        class="font-weight-bold"
        @click="$emit('click')"
      >
        <v-icon class="mr-1">mdi-help-circle</v-icon>
        {{ infoLabel }}
      </v-chip>
    </span>
  </p>
</template>

<script>
export default {
  props: {
    label: {
      required: true,
    },
    required: {
      default: false,
      type: Boolean
    },
    infoLabel: {
      default: null,
    },
  },
}
</script>

<style lang="scss" scoped>
  .item-label {
    border-left: 12px solid #C0CA33;
    background: #F9FBE7;
    padding: 8px;
    font-size: 20px;
    letter-spacing: 0.05rem;

    .required {
    padding: 5px;
    margin-left: 5px;
    font-size: 12px;
    color: white;
    border-radius: 5px;
    background-color: rgb(226, 31, 31);
    vertical-align: middle;
    }

    .infomation {
      float: right;
    }
  }
</style>