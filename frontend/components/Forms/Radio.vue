<template>
  <v-radio-group v-model="setValue" :rules="rules" class="mb-5 mt-2 pl-4">
    <v-radio
      v-for="item in items"
      :key="item.val"
      :label="item.label"
      :value="item.val"
      :disabled="disabled.includes(item.val)"
      color="teal"
      :class="disabled.includes(item.val) ? 'line-through' : ''"
    ></v-radio>
  </v-radio-group>
</template>

<script>
export default {
  data() {
    return {
      rules: [
        (value) => {
          if ((value === "" || value == null ) && this.requiredCheck){
            return '※ひとつ選択してください'
          } else {
            return true
          }
        },
      ],
    }
  },

  props: {
    items: {
      required: true,
    },
    value: {
      required: true,
      default: null,
    },
    requiredCheck: {
      default: false,
    },
    disabled: {
      default: ()=>[],
    }
  },

  computed: {
    setValue: {
      get() {
        return this.value
      },
      set(newVal) {
        return this.$emit('update:value', newVal)
      },
    },
  },
}
</script>

<style lang="scss" scoped>
.line-through {
  :deep(label) {
    text-decoration: line-through;
  }
}
</style>