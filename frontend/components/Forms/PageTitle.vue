<template>
  <div class="my-5">
    <div class="out">
      <span class="number">{{ number }}</span>
      <span class="title">{{ title }}</span>
    </div>
    <div v-if="desc" class="pt-3">{{ desc }}</div>
  </div>
</template>

<script>
export default {
  props: {
    number: {
      dafault: null,
      required: true,
    },
    title: {
      default: '',
      required: false,
    },
    desc: {
      default: '',
      required: false,
    }
  },
}
</script>

<style lang="scss" scoped>
.out {
  background: whitesmoke;
  display: flex;
  align-items: center;
  background: #fff8e1;
  border: 2px solid #ffb300;

  .number {
    font-size: 30px;
    padding: 0.2em 0.8em;
    background: #ffb300;
    color: #ffffff;
  }

  .title {
    font-size: 30px;
    padding-left: 1em;
  }
}
</style>