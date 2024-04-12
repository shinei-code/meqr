<template>
  <div>
    <FormsPageTitle number="3" title="障がい者手帳申請書" :desc="$Documents.SEISIN_TECHO.find(item => item.documentId == 'MD101').desc" />
    <v-form ref="form" v-model="valid" lazy-validation>
      <div class="mb-5">
        <!-- 申請内容 -->
        <FormsFormTitleLg label="申請内容" :required="true"/>
        <FormsRadio
          :items="$MD101.sstc_sinseinaiyou_kbn_key"
          :value.sync="formData.sstc_sinseinaiyou_kbn_key"
          :requiredCheck="true"
          class="mb-5"
        ></FormsRadio>
        <v-expand-transition>
          <FormsAlert v-if="msgExpired" :message="msgExpired" class="mx-2 mt-n7 mb-8"/>
        </v-expand-transition>

        <!-- 手帳再発行 -->
        <v-expand-transition>
          <div v-if="formData.sstc_sinseinaiyou_kbn_key == '2'">
            <FormsFormTitleLg label="手帳再発行" :required="true"/>
            <FormsRadio
              :items="$MD101.sstc_saihakkou_kbn_key"
              :value.sync="formData.sstc_saihakkou_kbn_key"
              :requiredCheck="true"
            ></FormsRadio>
          </div>
        </v-expand-transition>

        <!-- 手帳の顔写真 -->
        <v-expand-transition>
          <div v-if="
            [1,3,4,5,6].includes(formData.sstc_sinseinaiyou_kbn_key) ||
              (formData.sstc_sinseinaiyou_kbn_key == '2' && formData.sstc_saihakkou_kbn_key == '2')">
            <FormsFormTitleLg label="手帳の顔写真" :required="true"/>
            <FormsRadio
              :items="$COMMON.is_techou_face_pic"
              :value.sync="formData.is_techou_face_pic"
              :requiredCheck="true"
            ></FormsRadio>
          </div>
        </v-expand-transition>

        <!-- 同時申請 -->
        <v-expand-transition>
          <div v-if="[1,2,3].includes(formData.sstc_sinseinaiyou_kbn_key)">
            <FormsFormTitleLg label="同時申請" :required="true" :kikanInfo="true"/>
            <FormsRadio
              :items="$MD101.sstc_douzishinsei_kbn_key"
              :value.sync="formData.sstc_douzishinsei_kbn_key"
              :requiredCheck="true"
            ></FormsRadio>
          </div>
        </v-expand-transition>

        <!-- 申請方法 -->
        <v-expand-transition>
          <div v-if="[1,2,3,4].includes(formData.sstc_sinseinaiyou_kbn_key)">
            <FormsFormTitleLg label="申請方法" :required="true"/>
            <FormsCaution
              label="年金証書での同時申請・期間調整はできません。"
              class="mt-3"
            />
            <FormsRadio
              :items="$MD101.sstc_sinseihouhou_kbn_key"
              :value.sync="formData.sstc_sinseihouhou_kbn_key"
              :requiredCheck="true"
              :disabled="[2,3].includes(formData.sstc_douzishinsei_kbn_key) ? [2] : []"
            ></FormsRadio>
          </div>
        </v-expand-transition>

        <!-- 年金受給状況 -->
        <v-expand-transition>
          <div v-if="
            [1,2,3,4].includes(formData.sstc_sinseinaiyou_kbn_key) &&
            formData.sstc_sinseihouhou_kbn_key == '2'
          ">
            <FormsFormTitleLg label="年金受給状況" :required="true"/>
            <FormsRadio
              :items="$MD101.nenkin_state_kbn_key"
              :value.sync="formData.nenkin_state_kbn_key"
              :requiredCheck="true"
            ></FormsRadio>
          </div>
        </v-expand-transition>

        <!-- 年金支給元 -->
        <v-expand-transition>
          <div v-if="
            [1,2,3,4].includes(formData.sstc_sinseinaiyou_kbn_key) &&
            formData.sstc_sinseihouhou_kbn_key == '2'
          ">
            <FormsFormTitleLg label="年金支給元" />
            <FormsCheckboxes
              :items="$COMMON.is_nenkin_sikyumoto" 
              :select.sync="nenkinVal"
            />
          </div>
        </v-expand-transition>

        <!-- 交付決定通知書 送付先 -->

        <!-- 手帳交付希望窓口 -->
        <FormsFormTitleLg label="手帳交付希望窓口" :required="true"/>
        <FormsCaution
          label="県での審査・作成のため、⼿帳の交付までに２〜３ヶ⽉かかります。"
        />
        <FormsRadio
          :items="this.$COMMON.section_key"
          :value.sync="formData.section_key"
          :requiredCheck="true"
        ></FormsRadio>

        <FormsFormTitleLg label="交付決定通知書 送付先" :required="true"/>
        <FormsCaution 
          label="通常は本人住所へ送付します。" 
        />
        <FormsSofusaki 
          :sofusakiKbn.sync="formData.sofusakiKbn"
          :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan"
          :isTecho="true"
        />

      </div>

      <!-- 申請書プレビュー -->
      <FormsActionButton
        @preview="preview"
        @prev-step="$emit('prev-step')"
        :showValid="valid"
      ></FormsActionButton>
    </v-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: false,
      nenkinVal:[],
      formData: {},
      patient: {},
      isExpired: this.$isExpiredTecho()
    }
  },
  watch: {
    nenkinVal(newVal) {
      // 年金支給元 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_nenkin_sikyumoto', 6);
    },
  },

  mounted() {
    this.$refs.form.resetValidation();
    this.formData = this.$store.getters.getMd101;
    this.patient = this.$store.getters.getPatient;

    // 年金支給元　個別 => 配列
    this.$aryToIndexItem(this.nenkinVal, this.formData, 'is_nenkin_sikyumoto', 6, true);
  },

  computed: {
    msgExpired: function() {
      if (!this.patient.techoNo) {
        return null;
      }
      // 有効期限切れ && 再認定期限内または手帳同時申請
      if (this.isExpired && [2, 4].includes(this.formData.sstc_sinseinaiyou_kbn_key)) {
        return '有効期限が切れている場合、'
          + this.$getLabel(this.$MD101.sstc_sinseinaiyou_kbn_key, this.formData.sstc_sinseinaiyou_kbn_key)
          + 'はできません。';
      }
      // 有効期限内 && 再認定有効期限切れ
      if (!this.isExpired && [3].includes(this.formData.sstc_sinseinaiyou_kbn_key)) {
        return '有効期限が残っている場合、'
          + this.$getLabel(this.$MD101.sstc_sinseinaiyou_kbn_key, this.formData.sstc_sinseinaiyou_kbn_key)
          + 'はできません。';
      }
    }
  },


  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (this.formData.sstc_sinseinaiyou_kbn_key != '2') {
          this.formData.sstc_saihakkou_kbn_key = null;
        }

        if (
          !([1,3,4,5,6].includes(this.formData.sstc_sinseinaiyou_kbn_key) ||
          (this.formData.sstc_sinseinaiyou_kbn_key == '2' && this.formData.sstc_saihakkou_kbn_key == '2'))
        ) {
          this.formData.is_techou_face_pic = null;
        }

        if (!(
            [1,2,3,4].includes(this.formData.sstc_sinseinaiyou_kbn_key) &&
            this.formData.sstc_sinseihouhou_kbn_key == '2'
        )) {
          this.formData.nenkin_state_kbn_key = null;

          for (let index = 1; index < 7; index++) {
            this.formData['is_nenkin_sikyumoto' + index] = null;
          }
        }

        if (![1,2,3].includes(this.formData.sstc_sinseinaiyou_kbn_key)) {
          this.formData.sstc_douzishinsei_kbn_key = null;
        }

        if (![1,2,3,4].includes(this.formData.sstc_sinseinaiyou_kbn_key)) {
          this.formData.sstc_sinseihouhou_kbn_key = null;
        }

        this.$store.commit('setMd101', this.formData); // sessionStorage保存
        this.$emit('next-step');
      }
    },
  },
}
</script>
