<template>
  <v-snackbar v-model="isShow" timeout="2000" :color="isError ? error : success" top right>
    {{ msg }}
    <template v-slot:action="{ attrs }">
      <v-btn text v-bind="attrs" @click="showSearchFailed = false">
        <v-icon small>mdi-close</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  data() {
    return {
      error: "red accent-2",
      success: "amber darken-3"
    }
  },
  props: {
    msg: {
      required: true,
    },
    show: {
      default: false
    },
    isError: {
      default: true
    }
  },
  computed: {
    isShow: {
      get() { return this.show; },
      set(newVal) { return this.$emit('update:show', newVal); }
    }
  }
}
</script>