<template>
  <v-col cols="12" xs="12" sm="6" md="4">
    <v-card
      class="my-3 mx-auto card-style"
      color="grey lighten-5"
      hover
    >
      <v-card-title class="title justify-center align-center border">{{ title }}</v-card-title>
      <v-divider class="mx-4 mt-n2"></v-divider>
      <v-card-text class="desc">
        {{ desc }}
      </v-card-text>
      <v-card-text>
        <v-btn color="teal" dark x-large rounded  @click="onClick" class="d-block mx-auto px-16">作成する</v-btn>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
export default {
  props: [
    "title",
    "desc",
  ],
  methods: {
    onClick() {
      this.$emit("onClick")
    }
  }
}
</script>

<style lang="scss" scoped>
  .card-style {
    min-height: 270px;
  }
  .border {
    border-top: 10px solid #78909C;
  }
  .title {
    min-height: 100px;
  }
  .desc {
    min-height: 80px;
  }
</style>