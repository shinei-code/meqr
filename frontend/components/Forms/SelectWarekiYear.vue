<template>
  <v-select
    v-model="setSelect"
    :items="getItems" 
    item-text="label"
    item-value="val"
    :class="[leftSharp ? 'left-sharp' : '', rightSharp ? 'right-sharp' : '']"
    :rules="[required]" 
    outlined 
    background-color="teal lighten-5"
    :placeholder="placeholder"
    clearable
    no-data-text="対象データがありません"
  >
    <template v-slot:prepend-item v-if="searchInput">
      <v-text-field
        v-model="word"
        label="検索"
        dense
        class="px-5 pt-3"
        append-icon="mdi-close"
        @click:append="word = ''; gengo = null;"
        background-color="teal lighten-5"
        hide-details
        ref="searchInput"
      >
      </v-text-field>
      <v-chip-group v-model="gengo" row dense hide-details class="px-5" active-class="teal--text">
        <v-chip
          v-for="item in $COMMON.GENGO"
          :key="item.val"
          @click="word = item.label; $refs.searchInput.focus()"
        >{{ item.label }}</v-chip>
      </v-chip-group>

    </template>
  </v-select>
</template>

<script>
export default {
  data() {
    return {
      word: "",
      gengo: null,
      //必須チェック
      required: (value) => {
        if (!value && this.requiredCheck) {
          return '選択してください。';
        } else {
          return true;
        }
      },
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