<template>
  <div class="date-width">
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-right="40"
      transition="scale-transition"
      offset-y
      min-width="auto"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
          readonly
          v-bind="attrs"
          v-on="on"
          :placeholder="today"
          outlined
          background-color="teal lighten-5"
          clearable
          clear-icon="mdi-close-circle"
          @click:clear="setdate = null"
          v-model="setDate"
          :rules="rules"
        ></v-text-field>
      </template>
      <v-date-picker
        v-model="setDate"
        @input="menu = false"
        locale="jp-ja"
        :day-format="(date) => new Date(date).getDate()"
        no-title
      ></v-date-picker>
    </v-menu>
  </div>
</template>

<script>
export default {
  props: {
    date: {
      default: null,
    },
    requiredCheck: {
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
            return '入力必須です。';
          } else {
            return true;
          }
        },
      ],
      today: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      menu: false,
    }
  },

  computed: {
    setDate: {
      get() {
        return this.date;
      },
      set(newDate) {
        return this.$emit('update:date', newDate);
      },
    },
  },
}
</script>

<style lang="scss">
.v-date-picker-table.v-date-picker-table--date {
  > table {
    > tbody {
      tr {
        td:nth-child(7) .v-btn__content {
          color: blue;
        }
        td:nth-child(1) .v-btn__content {
          color: red;
        }
      }
    }
  }
}
.date-width {
  width: 60%;
}
</style>