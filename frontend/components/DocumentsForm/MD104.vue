<template>
  <div>
    <FormsPageTitle number="3" title="返還届" :desc="$Documents.SEISIN_TECHO.find(item => item.documentId == 'MD104').desc" />

    <v-form ref="form" v-model="valid" lazy-validation>
      <FormsFormTitleLg label="返還理由" :required="true" />
      <FormsRadio
        :items="$MD104.sstc_henkanriyu_kbn_key"
        :value.sync="formData.sstc_henkanriyu_kbn_key"
        :requiredCheck="true"
      />

      <v-expand-transition>
        <div v-if="formData.sstc_henkanriyu_kbn_key == '1'">
          <FormsFormTitleLg label="死亡日" :required="true"/>
          <FormsInputDate :date.sync="formData.sibou_dt" :requiredCheck="true" />
        </div>
      </v-expand-transition>
      
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
    this.formData = this.$store.getters.getMd104;
    this.$refs.form.resetValidation();
  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (this.formData.sstc_henkanriyu_kbn_key != '1') {
          this.formData.sibou_dt = null
        }
        
        this.$store.commit('setMd104', this.formData);
        this.$emit('next-step');
      }
    },
  },
}
</script>
