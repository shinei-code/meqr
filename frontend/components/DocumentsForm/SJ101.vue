<template>
  <div>
    <FormsPageTitle number="3" title="送付状" :desc="$Documents.SOFUJO.find(item => item.documentId == 'SJ101').desc" />

    <v-form ref="form" v-model="valid" lazy-validation>

      <!-- 今回の申請 -->
      <FormsFormTitleLg label="今回の申請" :required="true" />
      <FormsCheckboxes 
        :items="$SJ101.KONKAI_SINSEI" 
        :select.sync="formData.konkaiSinsei" 
        :requiredCheck="true"
      />

      <v-row class="mb-10">
        <!-- 精神手帳（左側）>>>>>>>>>> -->
        <v-col cols="12" sm="6" class="techo">

          <p class="text-center amber py-1">精神手帳</p>
          <v-expand-transition>
            <p class="text-center" v-if="!formData.konkaiSinsei.includes(1)">申請なし</p>
          </v-expand-transition>

          <v-expand-transition>
            <div v-if="formData.konkaiSinsei.includes(1)">

              <!-- 手帳申請 -->
              <FormsFormTitleLg label="手帳申請" :required="true" />
              <FormsCheckboxes 
                :items="$SJ101.is_sstc_sinseinaiyou" 
                :select.sync="formData.techoSinseiNiyou" 
                :requiredCheck="true"
                :falseCombo="[
                  {key: 1, val: [2, 3, 4, 5, 6, 7] },
                  {key: 7, val: [1, 2, 3, 4, 5, 6] },
                  {key: 4, val: [3, 6] }
                ]"
              />
              <FormsPopupMessage :show.sync="show" title="⚠注意" message="自立支援精神通院との同時申請はできません。" />

              <!-- 手帳申請方法 -->
              <v-expand-transition>
                <div v-if="formData.techoSinseiNiyou.includes(1) || formData.techoSinseiNiyou.includes(3) || formData.techoSinseiNiyou.includes(4)">
                  <FormsFormTitleLg label="手帳申請方法" :required="true" />
                  <FormsRadio 
                    :items="$SJ101.sstc_sinseihouhou_kbn_key" 
                    :value.sync="formData.techoSinseiHohou"
                    :requiredCheck="true"
                  ></FormsRadio>
                </div>
              </v-expand-transition>

              <!-- 同時申請 -->
              <v-expand-transition>
                <div v-if="$aryInAry(formData.techoSinseiNiyou, [1, 3]) && formData.techoSinseiHohou == '2'">
                  <FormsFormTitleLg label="手帳と自立の同時申請" :required="true" />
                  <FormsRadio 
                    :items="$SJ101.sstc_douzishinsei_kbn_key" 
                    :value.sync="formData.techoDojiSinsei"
                    :requiredCheck="true"
                  ></FormsRadio>
                </div>
              </v-expand-transition>

            </div>
          </v-expand-transition>
        </v-col>
        <!-- <<<<<<<<<< 精神手帳（左側） -->


        <!-- 自立支援精神通院（右側）>>>>>>>>>> -->
        <v-col cols="12" sm="6">

          <p class="text-center teal lighten-3 py-1">自立支援（精神）</p>
          <v-expand-transition>
            <p class="text-center" v-if="!formData.konkaiSinsei.includes(2)">申請なし</p>
          </v-expand-transition>

          <!-- 自立支援精神通院申請内容 -->
          <v-expand-transition>
            <div v-if="formData.konkaiSinsei.includes(2)">

              <FormsFormTitleLg label="自立支援精神通院申請内容" :required="true"/>
              <FormsCheckboxes 
                :items="$SJ101.is_ssti_sinseinaiyou_" 
                :select.sync="formData.iryoSinseiNaiyou" 
                :requiredCheck="true"
                :falseCombo="[
                  {key: 1, val: [2, 3, 4, 5, 6, 7, 8] },
                  {key: 8, val: [1, 2, 3, 4, 5, 6, 7] }
                ]"
              />

              <!-- 自立申請方法 -->
              <v-expand-transition>
                <div v-if="formData.iryoSinseiNaiyou.includes(1) || formData.iryoSinseiNaiyou.includes(3)">
                  <FormsFormTitleLg label="自立申請方法" :required="true"/>
                  <FormsRadio 
                    :items="$SJ101.ssti_sinseihouhou_kbn_key" 
                    :value.sync="formData.iryoSinseiHohou"
                    :requiredCheck="true"
                  ></FormsRadio>
                </div>
              </v-expand-transition>
              <FormsPopupMessage :show.sync="show2" title="⚠注意" message="要件が限られています。<br>担当課へお問い合わせください。" />

              <!-- 医療変更内容 -->
              <v-expand-transition>
                <div v-if="formData.iryoSinseiNaiyou.includes(6)">
                  <FormsFormTitleLg label="医療機関変更内容" :required="true"/>
                  <FormsCheckboxes 
                    :items="$SJ101.iryohenkounaiyou_key" 
                    :select.sync="formData.iryoHenkou" 
                    :requiredCheck="true" 
                  />
                </div>
              </v-expand-transition>

            </div>
          </v-expand-transition>
        </v-col>
        <!-- <<<<<<<<<< 自立支援精神通院（右側） -->
      </v-row>

      <v-expand-transition>
        <div v-if="is_tenpu_doc.length">
          <p class="text-center mb-0 red--text text--lighten-1">申請に必要な添付資料をご確認ください。</p>
          <p class="text-center text-wide red--text text--lighten-1"><span class="up-down">▼</span></p>

          <!-- 添付資料 -->
          <FormsFormTitleLg label="添付書類" />
          <div class="ml-4 pb-10">
            <div v-for="item in is_tenpu_doc" :key="item.val">
              <v-checkbox 
                v-model="formData['is_tenpu_doc'+String(item.val)]" 
                :label="item.label"
                class="mb-n6" 
                color="teal"
              />
            </div>
          </div>
        </div>
      </v-expand-transition>


      <FormsActionButton @preview="preview" @prev-step="$emit('prev-step')" :showValid="valid" />


      <!-- 申請書プレビュー押下後 確認画面 -->
      <v-dialog v-model="show3" width="700" >
        <v-card>
          <v-card-title class="text-h5 amber darken-3 white--text font-weight-bold">
            <v-icon dark class="mr-3">mdi-alert-outline</v-icon>確認
          </v-card-title>

          <v-card-text class="pt-5">
            <div class="amber lighten-3 py-3 px-3 black--text">
              診断書による手帳申請の場合は、自立支援支給認定との同時申請を行うことが可能です。
              手帳の有効期限と自立支援医療の有効期限が異なる場合でも、自立支援医療の有効期限を
              調整(短縮)することにより手続き可能です。添付する診断書の頻度を減らすことができ、
              申請者のメリットになる場合もありますので、ご本人様へのご確認をお願いします。
            </div>
          
            <div v-for="item in noDoujiRiyu" :key="item.val">
              <v-checkbox 
                v-model="formData['noDoujiRiyu'+String(item.val)]"
                :label="item.label"
                class="mb-n8" 
                color="amber darken-3"
              />
            </div>
          
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-btn color="amber darken-3" dark @click="confirmOk" class="ml-auto">
              OK
            </v-btn>
            <v-btn color="blue-grey darken-1" dark @click="show3 = false">
              戻る
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>






    </v-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      show2: false,
      show3: false,
      valid: true,
      formData: this.$store.getters.getSj101,
    };
  },
  watch: {
    // 手帳申請内容の等級変更が選択された場合
    'formData.techoSinseiNiyou'(newVal, oldVal) {
      if (!oldVal.includes(4) && newVal.includes(4)) {
        this.show = true;
      }
    },
    // 自立支援精神の申請方法の手帳の写しが選択された場合
    'formData.iryoSinseiHohou'(newVal) {
      if (newVal == 3) {
        this.show2 = true;
      }
    }
  },
  computed: {
    is_tenpu_doc() {
      const vals = [];

      // 年金証書等, 振込通知書
      if (this.formData.techoSinseiHohou == 1) { // 手帳申請方法: 障がい年金による申請
        vals.push(1, 2); 
      }
      
      // 手帳用診断書
      if (this.formData.techoSinseiHohou == 2) {  // 手帳申請方法: 診断書による申請
        vals.push(3);
      }

      // 受給者証原本
      if ( this.formData.iryoSinseiNaiyou.includes(4) // 自立支援精神通院申請内容: 記載事項変更
        || this.formData.iryoSinseiNaiyou.includes(5) // 自立支援精神通院申請内容: 医療機関単純
        || this.formData.iryoSinseiNaiyou.includes(6) // 自立支援精神通院申請内容: 医療機関複数
        || this.formData.iryoSinseiNaiyou.includes(8) // 自立支援精神通院申請内容: 返還
        || this.formData.techoDojiSinsei == 2  // 同時申請: 期間調整希望
      ) {
        vals.push(4);
      }

      // 保険証・生保受給者証の写し
      if ( this.formData.iryoSinseiNaiyou.includes(1) // 自立支援精神通院申請内容: 新規
        || this.formData.iryoSinseiNaiyou.includes(2) // 自立支援精神通院申請内容: 県外転入
        || this.formData.iryoSinseiNaiyou.includes(3) // 自立支援精神通院申請内容: 更新
      ) {
        vals.push(5);
      }

      // 県外手帳原本
      if (this.formData.techoSinseiNiyou.includes(2)) { // 手帳申請: 県外転入
        vals.push(6);
      }

      // 手帳原本
      if (this.formData.techoSinseiNiyou.includes(7)) { // 手帳申請: 県外転入
        vals.push(7);
      }

      // 精神通院用診断書
      if (this.formData.iryoSinseiHohou == 1 // 自立申請方法: 自立用診断書
          || this.formData.iryoHenkou.includes(1) // 医療機関変更内容: 病院2
      ) {
        vals.push(8);
      }

      // 県外受給者証原本
      if (this.formData.iryoSinseiNaiyou.includes(2)) { // 自立支援精神通院申請内容: 県外転入
        vals.push(9);
      }

      // 複数医療理由書
      if (this.formData.iryoHenkou.includes(1)) {  // 医療機関変更内容: 病院2
        vals.push(10);
      }

      // 訪問看護指示書
      if (this.formData.iryoHenkou.includes(2)) {  // 医療機関変更内容: 訪看関連
        vals.push(11);
      }

      // 顔写真
      if ( this.formData.techoSinseiNiyou.includes(1) // 自立支援精神通院申請内容: 新規
        || this.formData.techoSinseiNiyou.includes(2) // 自立支援精神通院申請内容: 県外転入
        || this.formData.techoSinseiNiyou.includes(3) // 自立支援精神通院申請内容: 更新
        || this.formData.techoSinseiNiyou.includes(4) // 自立支援精神通院申請内容: 等級変更
        || this.formData.techoSinseiNiyou.includes(6) // 自立支援精神通院申請内容: 再交付
      ) {
        vals.push(12);
      }

      // 手帳の写し
      if (this.formData.iryoSinseiHohou == 1 ) {  // 自立申請方法: 自立用診断書
        vals.push(13);
      }

      return this.$SJ101.is_tenpu_doc.filter(item => vals.includes(item.val));
    },
    noDoujiRiyu() {
      const vals = [6];  // 6: その他 は必ず表示

      if (!this.formData.konkaiSinsei.includes(1)) { // 精神手帳 未チェック
        vals.push(3, 4, 5); 
      }

      if (!this.formData.konkaiSinsei.includes(2)) { // 自立支援(精神) 未チェック
        vals.push(1, 2); 
      }

      return this.$SJ101.no_douji_riyu.filter(item => vals.includes(item.val));
    }
  },

  mounted() {
    this.$refs.form.resetValidation();
  },
  
  methods: {
    preview() {

      if (this.$refs.form.validate()) {
        // 今回申請のいずれか未チェックの場合 確認ダイアログ表示
        if (
          this.formData.konkaiSinsei.length < 2
          && this.formData.techoSinseiHohou != 1       // 手帳申請方法 年金による申請 以外
          ) {
          this.show3 = true;
        } else {
          this.confirmOk();
        }
      }
    },
    confirmOk() {
      this.show3 = false;

      // 画面表示されてないチェックボックスはnullに設定
      for (let index = 1; index <= 13; index++) {
        if (this.is_tenpu_doc.filter(item => item.val == index).length == 0) {
          this.formData['is_tenpu_doc'+index] = false;
        }
      }
      for (let index = 1; index <= 6; index++) {
        if (this.noDoujiRiyu.filter(item => item.val == index).length == 0) {
          this.formData['noDoujiRiyu'+index] = false;
        }
      }

      if (!this.formData.konkaiSinsei.includes(1)) {
        this.formData.techoSinseiNiyou = [];
      }

      if (!(
        this.formData.techoSinseiNiyou.includes(1) 
        || this.formData.techoSinseiNiyou.includes(3) 
        || this.formData.techoSinseiNiyou.includes(4)
      )) {
        this.formData.techoSinseiHohou = null;
      }

      if (!(this.$aryInAry(this.formData.techoSinseiNiyou, [1, 3]) && this.formData.techoSinseiHohou == '2')) {
        this.formData.techoDojiSinsei = null;
      }

      if (!this.formData.konkaiSinsei.includes(2)) {
        this.formData.iryoSinseiNaiyou = [];
      }

      if(!(
        this.formData.iryoSinseiNaiyou.includes(1) 
        || this.formData.iryoSinseiNaiyou.includes(3)
      )) {
        this.formData.iryoSinseiHohou = null;
      }

      if (!this.formData.iryoSinseiNaiyou.includes(6)) {
        this.formData.iryoHenkou = [];
      }

      this.$store.commit("setSj101", this.formData);
      this.$emit("next-step");
    }
  },
}
</script>

<style lang="scss" scoped>
.techo {
  border-right: 1px solid rgba(0, 0, 0, 0.12);
}
.up-down {
  animation: move-y 0.5s infinite alternate ease-in-out;
  display: inline-block;
}
.text-wide {
    transform: scale(3, 1);
}
@keyframes move-y {
  from {
    transform: translateY(0);
  }
  to {
    transform: translateY(10px);
  }
}

.v-center {
  display: inline-flex;
  align-items: center;
}
</style>