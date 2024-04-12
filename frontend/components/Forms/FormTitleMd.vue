<template>
    <p>{{label}}
      <span v-if="required == true" class="required">必須</span>
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
    },
  }
  }
</script>

<style lang="scss" scoped>
  p {border-left: 10px solid #8D6E63;
    background-color : #EFEBE9;
    padding: 8px;
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
  }
</style>