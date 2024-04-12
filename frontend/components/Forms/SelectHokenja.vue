<template>
  <v-select
    v-model="setSelect"
    :items="getItems" 
    :item-text="item => item.name+' ( ' + item.code + ' )'"
    item-value="code"
    :class="[leftSharp ? 'left-sharp' : '', rightSharp ? 'right-sharp' : '']"
    :rules="[required]" 
    outlined 
    background-color="teal lighten-5"
    :placeholder="placeholder"
    clearable
    return-object
    no-data-text="対象データがありません"
  >
    <template v-slot:prepend-item v-if="searchInput">
      <v-text-field
        v-model="word"
        label="検索"
        dense
        class="px-5 pt-3"
        append-icon="mdi-close"
        @click:append="word = ''"
        background-color="teal lighten-5"
        hide-details
        ref="searchInput"
      >
      </v-text-field>

      <div class="py-3 px-3">
        <v-chip
          color="teal lighten-2" dark 
          v-for="item in $COMMON.HOKEN_QUICK_INPUT"
          :key="item.val"
          @click="word = item.val; $refs.searchInput.focus()"
          class="mx-1"
        >
          {{ item.label }}
        </v-chip>
      </div>

    </template>
  </v-select>
</template>

<script>
export default {
  data() {
    return {
      word: "",
      quickHoken: null,
      //必須チェック
      required: (value) => {
        if (!value && this.requiredCheck) {
          return '選択してください';
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
      return this.items.filter((item) => String(item.code).includes(this.word) || item.name.includes(this.word));
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