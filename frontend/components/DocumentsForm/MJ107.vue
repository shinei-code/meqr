<template>
  <div>
    <FormsPageTitle number="3" title="返還届" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ107').desc" />

    <v-form ref="form" v-model="valid" lazy-validation>

      <!-- 返還理由 -->
      <FormsFormTitleLg label="返還理由" :required="true" />
      <FormsRadio 
        :items="$MJ107.ssti_henkanriyu_kbn_key"
        :value.sync="formData.ssti_henkanriyu_kbn_key"
        :requiredCheck="true"
        ></FormsRadio>

      <!-- 死亡日 -->
      <v-expand-transition>
        <div v-if="formData.ssti_henkanriyu_kbn_key == '1'">
          <FormsFormTitleLg label="死亡日" :required="true" />
          <FormsInputDate :date.sync="formData.sibou_dt" :requiredCheck="true" />
        </div>
      </v-expand-transition>
      
      <FormsActionButton @preview="preview" @prev-step="$emit('prev-step')" :showValid="valid" />
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
    this.formData = this.$store.getters.getMj107;
    this.$refs.form.resetValidation();
  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (this.formData.ssti_henkanriyu_kbn_key != '1') {
          this.formData.sibou_dt = null
        }

        this.$store.commit('setMj107', this.formData);
        this.$emit('next-step');
      }
    },
  },
}
</script>