<template>
  <v-select
    v-model="setSelect"
    :items="getItems" 
    item-text="label"
    item-value="val"
    :class="[leftSharp ? 'left-sharp' : '', rightSharp ? 'right-sharp' : '']"
    :rules="[required, error]" 
    outlined 
    :placeholder="placeholder"
    background-color="teal lighten-5"
    clearable
  >
    <template v-slot:prepend-item v-if="searchInput">
      <v-text-field
        v-model="word"
        label="検索"
        dense
        background-color="teal lighten-5"
        class="px-5 py-3"
        append-icon="mdi-close"
        @click:append="word = ''"
        hide-details
      >
      </v-text-field>
    </template>
  </v-select>
</template>

<script>
export default {
  data() {
    return {
      word: "",
      //必須チェック
      required: (value) => {
        if (!value && this.requiredCheck) {
          return '選択してください。';
        } else {
          return true;
        }
      },
      error: () => this.forceErr || String(this.errMsg),
    }
  },
  props: {
    select: {
      required: true,
    },
    items: {
      required: true,
      type: Array
    },
    searchInput: {
      default: true,
      type: Boolean,
    },
    requiredCheck: {
      default: false,
    },
    placeholder: {
      default: "選択してください"
    },
    leftSharp: {
      default: false,
      type: Boolean,
    },
    rightSharp: {
      default: false,
      type: Boolean,
    },
    forceErr: {
      default: true,
      type: Boolean
    },
    errMsg: {
      default: null,
      type: String
    },
  },
  computed: {
    setSelect: {
      get() {
        return this.select;
      },
      set(newVal) {
        return this.$emit('update:select', newVal);
      }
    },
    getItems() {
      return this.items.filter((item) => item.label.includes(this.word));
    }
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