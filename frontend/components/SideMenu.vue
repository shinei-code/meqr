<template>
  <div>
    <div align="center" class="mt-5 mb-3 pointer"
      @click="$setStep(0)"
    >
      <v-icon large>mdi-home-circle-outline</v-icon><br>
      <small>ホーム</small>
    </div>
    <v-divider></v-divider>
    <v-stepper
      vertical 
      alt-labels
      flat
      v-model="step"
    >
      <v-stepper-step
      v-for="item in $COMMON.STEPS"
      :key="item.step"
      :complete="step > item.step"
      :step="item.step"
      @click="step > item.step ? $setStep(item.step) : '';"
      class="stepper-step"
      :class="step > item.step ? 'pointer' : ''"
      color="amber darken-1"
      >
      <small v-html="item.label"></small>
      </v-stepper-step>
    </v-stepper>
  </div>
</template>

<script>
export default {
  computed: {
    step() {
      return this.$store.getters.getStep;
    },
  },
}
</script>

<style lang="scss" scoped>
  .stepper-step {
    :first-child{
      margin-right: 0px !important;
    }
  }
  .pointer {
    :hover {
      cursor: pointer;
    }
  }
</style>