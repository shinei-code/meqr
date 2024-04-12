<template>
  <div>
    <v-row>
      <v-col cols=12 md="9" class="vh100">
        <DocumentsFormMD101 v-if="documentId=='MD101'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMD102 v-if="documentId=='MD102'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMD104 v-if="documentId=='MD104'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ1011 v-if="documentId=='MJ1011'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ1012 v-if="documentId=='MJ1012'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ1013 v-if="documentId=='MJ1013'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ102 v-if="documentId=='MJ102'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ104 v-if="documentId=='MJ104'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormMJ107 v-if="documentId=='MJ107'" @next-step="nextStep" @prev-step="prevStep" />
        <DocumentsFormSJ101 v-if="documentId=='SJ101'" @next-step="nextStep" @prev-step="prevStep" />
      </v-col>

      <v-col cols="3" md="3" class="vh100 mx-auto d-sm-none d-xs-none d-md-block">
        <UserInfo />
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      documentId: null,
    }
  },
  mounted() {
    this.$initCheck(this.$route.path);  // 直リンクチェック
    this.documentId = this.$store.getters.getDocumentId;
  },
  fetchOnServer: false,
  methods: {
    nextStep() {
      this.$setStep(4);
    },
    prevStep() {
      this.$setStep(2);
    }
  }
}
</script>

<style lang="scss" scoped>
.vh100 {
  overflow-y: scroll; 
  height:calc(100vh - 84px);
  &::-webkit-scrollbar {
    display: none;
  }
}
</style>