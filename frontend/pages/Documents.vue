<template>
  <div>
  
    <FormsPageTitle number="2" title="作成する申請書を選択してください"></FormsPageTitle>

    <FormsFormTitleLg label="精神障がい者保健福祉手帳" />
    <v-row class="mb-5">
      <DocumentsCard
        v-for="document in $Documents.SEISIN_TECHO"
        :key="document.documentID"
        :title="document.title"
        :desc="document.desc"
        @onClick="selectDocument(document.documentId)"
      ></DocumentsCard>
    </v-row>
    
    <FormsFormTitleLg label="自立支援医療費(精神通院医療)" />
    <v-row class="mb-5">
      <DocumentsCard
        v-for="document in $Documents.SEISIN_IRYO"
        :key="document.documentID"
        :title="document.title"
        :desc="document.desc"
        @onClick="selectDocument(document.documentId)"
      ></DocumentsCard>
    </v-row>

    <FormsFormTitleLg label="その他文書(精神通院医療)" />
    <v-row>
      <DocumentsCard
        v-for="document in $Documents.SOFUJO"
        :key="document.documentID"
        :title="document.title"
        :desc="document.desc"
        @onClick="selectDocument(document.documentId)"
      ></DocumentsCard>
    </v-row>
    
    <FormsPrevButton @click="$setStep(1)"  class="mt-5"/>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$initCheck(this.$route.path);  // 直リンクチェック
    
    // 各申請画面のstore情報をクリア
    this.$store.commit("clearFormData");
    this.$store.commit('setDocumentId', null)

  },
  methods: {
    selectDocument(id) {
      this.$store.commit('setDocumentId', id); // sessionStorage保存
      this.$setStep(3);
    }
  }
};
</script>