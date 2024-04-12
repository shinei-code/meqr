<template>
  <div class="base"
      :class="[before ? 'before' : 'after']"
  >{{before ? "変更前" : "変更後"}}</div>
</template>

<script>
export default {
  props: {
    before: {
      default: true,
      type: Boolean
    }
  }
}
</script>

<style lang="scss" scoped>
.base {
  width: 80px;
  padding: 5px;
  margin-bottom: 10px;
  color: white;
  text-align: center;
}
.before {
  background-color: rgb(229, 139, 48);
}
.after {
  background-color: rgb(124, 124, 124);
}

</style>