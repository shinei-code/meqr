<template>
  <v-dialog v-model="isShow" width="700">
    <v-card>
      <v-card-title class="text-h5 orange lighten-3">
        <v-icon large class="mr-1" color="grey darken-4">mdi-help-circle</v-icon>
        {{ title }}
      </v-card-title>
      <v-card-text class="mt-3 black--text">
        {{ desc }}
        <v-img :src="require('@/assets/images/'+img)" class="img" :alt="alt" />
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="white" text @click="isShow = false"
          class="font-weight-bold h5 blue-grey lighten-1">
          閉じる
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    title: {
      required: true,
    },
    desc: {
      default: null,
    },
    img: {
      default: null,
    },
    alt: {
      default: null,
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
