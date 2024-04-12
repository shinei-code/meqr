<template>
  <div>
    <v-text-field
      v-model="setValue"
      :placeholder="placeholder"
      background-color="teal lighten-5"
      outlined
      :class="[leftSharp ? 'left-sharp' : '', rightSharp ? 'right-sharp' : '']"
      :rules="rules"
      @change="$emit('change')"
      @compositionstart="$emit('input-start')"
      @compositionend="$emit('input-end')"
    >
    </v-text-field>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      default: null,
    },
    placeholder: {
      default: null,
    },
    requiredCheck: {
      default: false,
      type: Boolean,
    },
    integerCheck: {
      default: false,
      type: Boolean,
    },
    leftSharp: {
      default: false,
      type: Boolean,
    },
    rightSharp: {
      default: false,
      type: Boolean,
    },
  },
  data() {
    return {
      // 必須チェック
      rules: [
        (value) => {
          if (!value && this.requiredCheck) {
            return '入力必須です。'
          } else {
            return true
          }
        },

        // 数値チェック
        (value) => {
          if (value && isNaN(value) && this.integerCheck) {
            return '数値以外が入力されています。'
          } else {
            return true
          }
        },
      ],
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
.left-sharp {
  border-top-left-radius: 0px;
  border-bottom-left-radius: 0px;
}
.right-sharp {
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
}
</style>


