<template>
  <div>
    <FormsPageTitle number="3" title="再交付申請書" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ102').desc" />

    <FormsAlert v-if="$isExpiredIryo()" message="有効期限が切れている場合、再交付申請はできません。" />

    <v-form ref="form" v-model="valid" lazy-validation>
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
      formData: {},
    }
  },
  mounted() {
    this.formData = this.$store.getters.getMj102;
    this.$refs.form.resetValidation();
  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {
        this.$store.commit('setMj102', this.formData);
        this.$emit('next-step');
      }
    },
  },
}
</script>