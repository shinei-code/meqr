<template>
    <!-- 暗号化パスワードダイアログ -->
    <v-dialog
      v-model="isShow"
      persistent
      max-width="550"
    >
      <v-card>
        <v-card-title class="text-h5 teal lighten-4">
          <v-icon color="black">mdi-content-save-edit</v-icon>
          入力履歴保存
        </v-card-title>
        <v-card-text>
          <p class="mt-4">次回、入力履歴から患者情報を呼び出すときに使用するパスワードです</p>
        </v-card-text>

        <v-container>
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            @submit.prevent
          >
            <v-col cols=10 class="mx-auto mt-n5">
              <v-text-field
                v-model="password"
                :append-icon="showPw ? 'mdi-eye' : 'mdi-eye-off'"
                :type="showPw ? 'text' : 'password'"
                @click:append="showPw = !showPw"
                counter
                ref="password"
                label="パスワード"
                :rules="rules"
                required
                prepend-icon="mdi-lock"
                :validate-on-blur="true"
                success-messages="英小文字 / 数字 / 記号 の全てを含む 8文字以上 で入力してください"
                autocomplete="off"
              ></v-text-field>
            </v-col>
          </v-form>

          <v-card-actions class="pb-4 pr-6">
            <v-spacer></v-spacer>
            <v-btn :disabled="!valid" color="primary" :dark="valid" @click="okBtn" width="100">
              保存する
            </v-btn>
            <v-btn color="normal" @click="isShow = false">
              キャンセル
            </v-btn>
          </v-card-actions>
        </v-container>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      valid: null,
      password: null,
      showPw: false,
      rules: [
        value => !!value || '入力必須です',
        value => this.$COMMON.PW_REG.test(value) || "英小文字 / 数字 / 記号 の全てを含む 8文字以上 で入力してください",
      ]
    }
  },
  props: {
    show: {
      default: false
    },
    formData: {
      default: null
    },
  },
  computed: {
    isShow: {
      get() { return this.show },
      set(newVal) { return this.$emit('update:show', newVal);
      }
    }
  },
  methods: {
    okBtn() {
      if (!this.$refs.form.validate()) { // バリデーション
        return;
      }
      this.isShow = false;
      const encoded = this.$encode(this.formData, this.password); // 暗号化
      this.$setPatients(this.formData.jyukyusyaNo, encoded); // localStorage保存
    },
  }
}
</script>