<template>
  <v-row justify="center">
    <v-dialog
      v-model="isShow"
      persistent
      max-width="550"
    >
      <v-card>
        <v-card-title class="text-h5 teal lighten-4">
          <span v-if="!succeedDecode">
            <v-icon large color="black">mdi-account-box-multiple-outline</v-icon>
            入力履歴があります
          </span>
          <span v-if="succeedDecode">
            <v-icon color="black">mdi-file-document-multiple-outline</v-icon>
            入力履歴内容</span>
        </v-card-title>
        <v-card-text v-if="!succeedDecode">
          <p class="mt-4">入力履歴を使用するには、入力履歴保存時のパスワードを入力してください</p>
        </v-card-text>

        <v-container>
          <v-col cols=10 class="mx-auto mt-n5" v-if="!succeedDecode">
            <form @submit.prevent>
              <v-text-field
                v-model="password"
                ref="password"
                label="パスワード"
                :rules="this.changedPw ? ruleSucceed : []"
                required
                type="password"
                prepend-icon="mdi-lock"
                autocomplete="off"
              ></v-text-field>
            </form>
          </v-col>
                
          <div v-if="succeedDecode" class="mx-10">
            <v-text-field
              label="氏名"
              :value="
                `${decoded.ptNameSei}　${decoded.ptNameMei}`
                +(decoded.ptKanaSei && decoded.ptNameMei ? `　(${decoded.ptKanaSei}　${decoded.ptKanaMei})` : '')"
              readonly
            ></v-text-field>
            <v-text-field
              label="生年月日"
              :value="$getLabel($SEIREKI_WAREKI.YEAR, decoded.ptBdayY)+' '+decoded.ptBdayM+'月 '+decoded.ptBdayD+'日'"
              readonly
            ></v-text-field>
            <v-text-field
              label="住所"
              :value="decoded.ptAddr+(decoded.ptAddrBldg ? '　'+decoded.ptAddrBldg : '')"
              readonly
            ></v-text-field>
          </div>

          <v-card-actions class="pb-4 pr-6">
            <v-spacer></v-spacer>
            <v-btn color="primary" width="100" @click="changePw" v-if="!succeedDecode">
              検索
            </v-btn>
            <v-btn color="primary" width="100" @click="okBtn" v-if="succeedDecode">
              使用する
            </v-btn>
            <v-btn color="normal" @click="isShow = false">
              キャンセル
            </v-btn>
          </v-card-actions>
        </v-container>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    data () {
      return {
        password: null,
        succeedDecode: false,  // 復号化: 失敗
        changedPw: false,  // PW: 未入力
        showPw: false,
        decoded: null,  // 復号化データ
        ruleSucceed: [
          this.succeedDecode || "パスワードが違います"
        ],
      }
    },
    props: {
      encoded: {
        default: null
      },
      show: {
        default: false
      },
    },
    computed: {
      isShow: {
        get() {
          // 初期化
          this.password = null;
          this.succeedDecode = false;  // 復号化: 失敗
          this.changedPw = false;  // PW: 未入力
          return this.show;
        },
        set(newVal) { return this.$emit('update:show', newVal); }
      }
    },
    methods: {
      changePw() {
        this.changedPw = true;  // PW: 入力済
        const decoded = this.$decode(this.encoded, this.password, true);  // 復号化
        if (decoded) {
          this.succeedDecode = true;
          this.decoded = decoded;
        } else {
          this.succeedDecode = false;
          this.password = null;
        }
      },
      okBtn() {
        this.$emit("okBtn", this.decoded);
        this.isShow = false;
      },
    }
  }
</script>
