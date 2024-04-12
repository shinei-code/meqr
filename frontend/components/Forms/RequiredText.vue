<template>
  <v-text-field
    v-model="setValue"
    required
    :rules="[v => !!v || '入力必須です']" 
  >
    <template v-slot:label>
      {{ label }}
      <span style="color: red"> *</span>
    </template>
  </v-text-field>
</template>

<script>
export default {
  data() {
    return {
    }
  },

  props: {
    label: {
      default: null,
    },
    value: {
      default: null,
    }
  },

  computed: {
    setValue: {
      get () {
        return this.value
      },
      set (newVal) { 
        return this.$emit('update:value', newVal)
      }
    }
  }
}
</script>
