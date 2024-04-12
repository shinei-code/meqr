<template>
  <div>
    <FormsPageTitle number="3" title="支給認定申請書（新規・再認定）" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ1011').desc" />
    <v-form ref="form" v-model="valid" lazy-validation>
      <FormsFormTitleLg label="申請内容" :required="true" />
      <FormsRadio
        :items="$MJ101.ssti_sinseinaiyou_kbn_key"
        :value.sync="formData.ssti_sinseinaiyou_kbn_key"
        :requiredCheck="true"
      ></FormsRadio>
      <v-expand-transition>
        <FormsAlert v-if="msgExpired" :message="msgExpired" class="mx-2 mt-n7 mb-8"/>
      </v-expand-transition>

      <v-expand-transition>
        <div v-if="formData.ssti_sinseinaiyou_kbn_key == '4'">
          <FormsFormTitleLg label="有効期限切れ更新時の記載内容変更" />
          <FormsCheckboxes
            placeholder="変更があれば選択してください"
            :items="$MJ101.kisaiJikoHenko"
            :select.sync="kisaiJikoHenko"
          />
        </div>
      </v-expand-transition>

      <v-expand-transition>
        <div v-if="[1,4].includes(formData.ssti_sinseinaiyou_kbn_key)">
          <FormsFormTitleLg label="申請方法" :required="true" />
          <FormsRadio
            :items="$MJ101.ssti_sinseihouhou_kbn_key"
            :value.sync="formData.ssti_sinseihouhou_kbn_key"
            :requiredCheck="true"
            ></FormsRadio>
        </div>
      </v-expand-transition>

      <v-expand-transition>
        <div v-if="formData.ssti_sinseinaiyou_kbn_key == '2'">
          <FormsFormTitleLg label="診断書有無" :required="true" />
          <FormsRadio
            :items="$MJ101.is_sindansho_umu"
            :value.sync="formData.is_sindansho_umu"
            :requiredCheck="true"
          ></FormsRadio>
        </div>
      </v-expand-transition>

      <v-expand-transition>
        <div v-if="!$isExpiredIryo() && formData.ssti_sinseinaiyou_kbn_key == '3'">
          <FormsFormTitleLg label="期間調整" :required="true" infoLabel="期間調整とは?" @click="showKikanChoseiInfo = true"/>
          <FormsRadio
            :items="$MJ101.is_kikan_chosei"
            :value.sync="formData.is_kikan_chosei"
            :requiredCheck="true"
          ></FormsRadio>
        </div>
      </v-expand-transition>
      <FormsImageInfomation
        :show.sync="showKikanChoseiInfo" 
        title="期間調整とは" 
        desc="自立支援（精神通院）の有効期限を切り捨て、今回申請する手帳の有効期限に合わせることで、次回診断書の必要なタイミングと更新受付期間が同じになります。"
        img="kikantyousei_img.png" 
        alt="期間調整イメージ図" 
      />

      <v-expand-transition>
        <div v-if="
            [1,4].includes(formData.ssti_sinseinaiyou_kbn_key) && [1,2].includes(formData.ssti_sinseihouhou_kbn_key) ||
            formData.ssti_sinseinaiyou_kbn_key == 2 && formData.is_sindansho_umu == '1'">
          <FormsFormTitleLg label="重度かつ継続" :required="true" infoLabel="重度かつ継続とは?" @click="showJyudoInfo = true"/>
          <FormsRadio
            :items="$MJ101.is_jyudo_keizoku_gaito"
            :value.sync="formData.is_jyudo_keizoku_gaito"
            :requiredCheck="true"
          ></FormsRadio>
          <FormsImageInfomation 
            :show.sync="showJyudoInfo" 
            title="重度かつ継続とは" 
            img="judokeizoku.png" 
            alt="重度かつ継続イメージ図" 
          />
        </div>
      </v-expand-transition>
      
      <FormsFormTitleLg label="障がい年金等" :required="true" />
      <FormsCheckboxes
        placeholder="一つ選んでください"
        :items="$MJ101.is_shogai_nenkin"
        :select.sync="nenkinVal"
        :requiredCheck="true"
        :falseCombo="[
          {key: 1, val: [2, 3, 4, 5, 6, 7] }
        ]"
      />

      <v-expand-transition>
        <div v-if="nenkinVal.includes(2) || nenkinVal.includes(5)">
          <FormsFormTitleLg label="年金支給元" :required="true" />
          <FormsCheckboxes
            placeholder="一つ選んでください"
            :items="$COMMON.is_nenkin_sikyumoto"
            :select.sync="sikyumotoVal"
          />
        </div>
      </v-expand-transition>

      <FormsFormTitleLg label="受給者証送付先" :required="true" />
      <FormsCaution label="県での審査・作成のため、受給者証交付までに1～3か月かかります。" />

      <FormsSofusaki 
        :sofusakiKbn.sync="formData.sofusakiKbn"
        :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan"
        :isTecho="false"
      />

      <FormsActionButton
        @preview="preview"
        @prev-step="$emit('prev-step')"
        :showValid="valid"
      />
    </v-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      nenkinVal: [],
      sikyumotoVal: [],
      kisaiJikoHenko: [],
      mj101: {},
      formData: {},
      patient: {},
      showKikanChoseiInfo: false,
      showJyudoInfo: false
    }
  },

  watch: {
    nenkinVal(newVal) {
      // 障がい年金等 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_shogai_nenkin', 7);
    },
    sikyumotoVal(newVal) {
      // 年金支給元 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_nenkin_sikyumoto', 6);
    },
    kisaiJikoHenko(newVal) {
      // 記載事項変更 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'kisaiJikoHenko', 4);
    },
  },

  mounted() {
    this.$refs.form.resetValidation();

    this.formData = this.$store.getters.getMj101; // sessionStorage取得
    this.patient = this.$store.getters.getPatient;

    // 個別 => 配列
    this.$aryToIndexItem(this.nenkinVal, this.formData, 'is_shogai_nenkin', 7, true);  // 障がい年金等 
    this.$aryToIndexItem(this.sikyumotoVal, this.formData, 'is_nenkin_sikyumoto', 6, true);  // 年金支給元
    this.$aryToIndexItem(this.kisaiJikoHenko, this.formData, 'kisaiJikoHenko', 4, true);  // 記載事項変更
  },

  computed: {
    msgExpired: function() {
      if (!this.patient.jyukyusyaNo) {
        return null;
      }
      // 有効期限切れ && 再認定期限内
      if (this.$isExpiredIryo() && this.formData.ssti_sinseinaiyou_kbn_key == 2) {
        return '有効期限が切れている場合、'
          + this.$getLabel(this.$MJ101.ssti_sinseinaiyou_kbn_key, this.formData.ssti_sinseinaiyou_kbn_key)
          + 'はできません。';
      }
      // 有効期限内 && 再認定有効期限切れ
      if (!this.$isExpiredIryo() && this.formData.ssti_sinseinaiyou_kbn_key == 4) {
        return '有効期限が残っている場合、'
          + this.$getLabel(this.$MJ101.ssti_sinseinaiyou_kbn_key, this.formData.ssti_sinseinaiyou_kbn_key)
          + 'はできません。';
      }
    }
  },

  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (![1,4].includes(this.formData.ssti_sinseinaiyou_kbn_key)) {
          this.formData.ssti_sinseihouhou_kbn_key = null;
        }

        if (this.formData.ssti_sinseinaiyou_kbn_key != '2') {
          this.formData.is_sindansho_umu = null;
        }

        if (!(!this.$isExpiredIryo() && this.formData.ssti_sinseinaiyou_kbn_key == '3')) {
          this.formData.is_kikan_chosei = null;
        }

        if (
            !([1,4].includes(this.formData.ssti_sinseinaiyou_kbn_key) && [1,2].includes(this.formData.ssti_sinseihouhou_kbn_key) ||
            this.formData.ssti_sinseinaiyou_kbn_key == 2 && this.formData.is_sindansho_umu == '1')
        ) {
          this.formData.is_jyudo_keizoku_gaito = null;
        }

        if (!(this.nenkinVal.includes(2) || this.nenkinVal.includes(5))) {
          for (let index = 1; index < 7; index++) {
            this.formData['is_nenkin_sikyumoto' + index] = null;
          }
        }

        this.$store.commit('setMj101', this.formData); // sessionStorage保存
        this.$emit('next-step');
      }
    },
  },
}
</script>


