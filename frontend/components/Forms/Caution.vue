<template>
  <V-alert color="red" text prominent class="cau1 pl-2 mb-0" dense>
    <span class="cau2">注意</span>
    {{ label }}
  </V-alert>
</template>

<script>
export default {
  props: {
    label: {
      defalut: null,
    },
  },
}
</script>

<style>
.cau1 {
  width: 100%;
  margin: 0 5px;
}
.cau2 {
    background-color: rgb(255, 134, 4);
    color: white;
    padding: 3px;
    border-radius: 5px;
  }
</style>