<template>
  <div>
    <FormsPageTitle number="3" title="支給認定申請書（医療機関変更）" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ1013').desc" />

    <FormsAlert v-if="$isExpiredIryo()" message="有効期限が切れている場合、支給認定申請書（医療機関変更）はできません。" />

    <v-form ref="form" v-model="valid" lazy-validation>
      <div class="mb-5">
        <!-- 変更後の医療機関確認 -->
        <div class="mb-8">
          <FormsFormTitleLg label="変更後の医療機関確認" />
          <div class="mb-4 mx-n1">
            <FormsCaution label="内容に誤りがある場合は、申請者情報に戻って正しい内容を入力してください。" />
          </div>

          <div v-if="hospital1" >
            <FormsFormTitleSm label="病院１" />
            <FormsInputReadonly :value="hospital1"/>
          </div>

          <div v-if="yakkyoku" >
            <FormsFormTitleSm label="薬局" />
            <FormsInputReadonly :value="yakkyoku" />
          </div>

          <div v-if="houkan" >
            <FormsFormTitleSm label="訪問看護" />
            <FormsInputReadonly :value="houkan" />
          </div>

          <div v-if="hospital2" >
            <FormsFormTitleSm label="病院２" />
            <FormsInputReadonly :value="hospital2" />
          </div>
        </div>

        <!-- 受給者証送付先 -->
        <FormsFormTitleLg label="受給者証送付先" :required="true"/>
        <FormsCaution label="県での審査・作成のため、受給者証の交付までに１～３ヶ月かかります。" />

        <FormsSofusaki 
          :sofusakiKbn.sync="formData.sofusakiKbn"
          :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan"
          :isTecho="false"
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
      formData: {},
      iryoKikan: [],  // 医療機関選択肢
      hospital1: null,
      yakkyoku: null,
      houkan: null,
      hospital2: null
    }
  },

  mounted() {
    this.formData = this.$store.getters.getMj101; // sessionStorage取得
    
    this.hokenja = this.$getHokenja('name');
    this.hospital1 = this.$getHospital1('name');
    this.yakkyoku = this.$getYakkyoku('name');
    this.houkan = this.$getHoukan('name');
    this.hospital2 = this.$getHospital2('name');

    this.$refs.form.resetValidation();
  },

  methods: {
    preview() {
      if (this.$refs.form.validate()) {
        this.$store.commit('setMj101', this.formData); // sessionStorage保存
        this.$emit('next-step');
      }
    },
  },
}
</script>
