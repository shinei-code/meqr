<template>
  <v-menu bottom :offset-y="true" :close-on-content-click="true" :allow-overflow="true">
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="setValue"
        v-bind="attrs"
        v-on="on"
        placeholder="xx国保"
        background-color="teal lighten-5"
        outlined
        :class="[leftSharp ? 'left-sharp' : '', rightSharp ? 'right-sharp' : '']"
        :rules="[required]"
      >
      </v-text-field>
    </template>

    <v-sheet elevation="3">
      <div class="py-3 px-3">
        <v-chip
          color="teal lighten-2" dark 
          @click="setValue = hoken.val"
          v-for="hoken in $COMMON.HOKEN_QUICK_INPUT"
          :key="hoken.val"
          class="mx-1"
        >
          {{ hoken.label }}
        </v-chip>
      </div>
      <v-divider></v-divider>
      <v-list v-if="getItems.length">
        <v-list-item
          v-for="item in getItems"
          :key="item.id"
        >
          <v-list-item-title class="py-0" @click="setValue = item.name">{{ item.name +' ( ' + item.code + ' )' }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-sheet>


  </v-menu>
</template>

<script>
export default {
  data() {
    return {
      //必須チェック
      required: (value) => {
        if (!value && this.requiredCheck) {
          return '入力必須です。';
        } else {
          return true;
        }
      },
      insurances: [],
    }
  },
  props: {
    value: {
      required: true,
      default: null
    },
    requiredCheck: {
      default: false,
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
    setValue: {
      get() {
        return this.value;
      },
      set(newVal) {
        return this.$emit('update:value', newVal);
      }
    },
    getItems () {
      return this.value ? this.insurances.filter(item => item.name.includes(this.value) || item.code.includes(this.value)) : [];
    },
  },
  async fetch() {
    this.insurances = await fetch(
      '/api/insurances'
    ).then(res => res.json()).catch((err) => {console.log(err); return [];})
  },
  fetchOnServer: false,
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