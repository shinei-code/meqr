<template>
  <v-select v-model="setSelect" :items="items" :placeholder="placeholder" item-text="label" item-value="val" multiple :menu-props="{ maxHeight: '400' }" class="mx-4 mb-5"
    :rules="[required, falseComboCheck]" outlined background-color="teal lighten-5"></v-select>
</template>

<script>
export default {
  data() {
    return {
      //必須チェック
      required: (value) => {
        if (!value.length && this.requiredCheck) {
          return '一つ以上選択してください';
        } else {
          return true;
        }
      },
      falseComboCheck: (value) => {
        if (!this.falseCombo.length) {
          return true;
        }

        let existFalseCombo = false;
        for (const combo of this.falseCombo) {
          if (
            value.includes(combo.key) 
            && [...value, ...combo.val].filter(item => value.includes(item) && combo.val.includes(item)).length > 0
          ) {
            existFalseCombo = true;
          }
        }

        if (existFalseCombo) {
          return '選択できない組み合わせです。';
        }
        return true;
      }
    }
  },
  props: {
    select: {
      required: true,
      type: Array
    },
    items: {
      required: true,
      type: Array
    },
    requiredCheck: {
      default: false,
    },
    placeholder: {
      default: "選択してください"
    },
    falseCombo: {
      type: Array,
      default: () => []

      // 組み合わせできないルール
      // ex. 1と2, 4と1,2,3
      // [
      //    {key: 1, val: [2]},
      //    {key: 4, val: [1,2,3]}
      // ]
    }
  },
  computed: {
    setSelect: {
      get() {
        return this.select;
      },
      set(newVal) {
        return this.$emit('update:select', newVal);
      }
    }
  }
}
</script>