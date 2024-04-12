<template>
  <div>
    <FormsPageTitle number="3" title="支給認定申請書（所得区分変更）" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ1012').desc" />

    <FormsAlert v-if="$isExpiredIryo()" message="有効期限が切れている場合、支給認定申請書（所得区分変更）はできません。" />

    <v-form ref="form" v-model="valid" lazy-validation>
      <!-- 障がい年金等 -->
      <FormsFormTitleLg label="障がい年金等" :required="true" />
      <FormsCheckboxes
        :items="$MJ101.is_shogai_nenkin"
        :select.sync="nenkinVal"
        :requiredCheck="true"
        :falseCombo="[
          {key: 1, val: [2, 3, 4, 5, 6, 7] }
        ]"
      />
      
      <!-- 年金支給元 -->
      <v-expand-transition>
        <div v-if="nenkinVal.includes(2) || nenkinVal.includes(5)">
          <FormsFormTitleLg label="年金支給元" />
          <FormsCheckboxes :items="$COMMON.is_nenkin_sikyumoto" :select.sync="sikyumotoVal" />
        </div>
      </v-expand-transition>

      <!-- 受給者証送付先 -->
      <FormsFormTitleLg label="受給者証送付先" :required="true" />
      <FormsCaution label="県での審査・作成のため、受給者証交付までに1～3か月かかります。" />
      
      <FormsSofusaki
        :sofusakiKbn.sync="formData.sofusakiKbn"
        :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan" 
        :isTecho="false"
      />

      <FormsActionButton @preview="preview" @prev-step="$emit('prev-step')" :showValid="valid" />
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
      formData: {},
    };
  },

  watch: {
    nenkinVal(newVal) {
      // 障がい年金等 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_shogai_nenkin', 7);
    },
    sikyumotoVal(newVal) {
      // 年金支給元 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_nenkin_sikyumoto', 6);
    }
  },

  mounted() {
    this.$refs.form.resetValidation();

    this.formData = this.$store.getters.getMj101;

    // 個別 => 配列
    this.$aryToIndexItem(this.nenkinVal, this.formData, 'is_shogai_nenkin', 7, true);  // 障がい年金等 
    this.$aryToIndexItem(this.sikyumotoVal, this.formData, 'is_nenkin_sikyumoto', 6, true);  // 年金支給元

  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (!(this.nenkinVal.includes(2) || this.nenkinVal.includes(5))) {
          for (let index = 1; index < 7; index++) {
            this.formData['is_nenkin_sikyumoto' + index] = null;
          }
        }

        this.$store.commit("setMj101", this.formData);
        this.$emit("next-step");
      }
    },
  },
}
</script>