<template>
  <div>
    <v-dialog v-model="show" width="500" >

      <v-card height="200">
        <v-card-title class="text-h5 amber darken-3 white--text font-weight-bold">
          {{ title }}
        </v-card-title>

        <v-card-text class="message">
          <span v-html="message"></span>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-row class="justify-end mr-1">
            <v-btn color="blue-grey darken-1" @click="isShow = false" class="white--text mt-3">
              閉じる
            </v-btn>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      required: true,
    },
    message: {
      required: true,
    },
    show: {
      default: false
    }
  },
  computed: {
    isShow: {
      get() { return this.show },
      set(newVal) {
        return this.$emit('update:show', newVal);
      }
    }
  },
}
</script>

<style lang="scss" scoped>
.message {
  margin-top: 20px;
  font-size: 17px;
  height: 65px;
}
</style>
