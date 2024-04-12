<template>
  <div>
    <SvgMD101 class="svg" v-if="documentId == 'MD101'" />
    <SvgMD103 class="svg" v-if="documentId == 'MD101' && md101.sstc_sinseihouhou_kbn_key == '2'" />
    <SvgMD102 class="svg" v-if="documentId == 'MD102'" />
    <SvgMD104 class="svg" v-if="documentId == 'MD104'" />
    <SvgMJ1011 class="svg" v-if="documentId == 'MJ1011'" />
    <SvgMJ1012 class="svg" v-if="documentId == 'MJ1012'" />
    <SvgMJ1013 class="svg" v-if="documentId == 'MJ1013'" />
    <SvgMJ1031 class="svg" v-if="documentId == 'MJ1011'" />
    <SvgMJ1032 class="svg" v-if="documentId == 'MJ1012'" />
    <SvgMJ108 class="svg" v-if="documentId == 'MJ1011' && mj101.ssti_sinseinaiyou_kbn_key == '8'"/>
    <SvgMJ102 class="svg" v-if="documentId == 'MJ102'" />
    <SvgMJ104 class="svg" v-if="documentId == 'MJ104'" />
    <SvgMJ107 class="svg" v-if="documentId == 'MJ107'" />
    <SvgSJ101 class="svg" v-if="documentId == 'SJ101'" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      documentId: null,
      md101: null,
    }
  },
  mounted() {
    this.$initCheck(this.$route.path);  // 直リンクチェック
    
    this.documentId = this.$store.getters.getDocumentId;
    this.md101 = this.$store.getters.getMd101;
    this.mj101 = this.$store.getters.getMj101;
    window.scroll({top: 0});
  }
}
</script>

<style lang="scss">
  @media screen {
    svg {
      max-width: 210mm;
      max-height: 295.5mm;
      width: 100%;
      height: 100%;
      border: 1px solid #BDBDBD;
      box-shadow: 0 10px 25px 0 rgba(0, 0, 0, .3);
      user-select: none;
    }
    .svg {
      display: flex;
      justify-content: center;
      margin: auto;
      margin-bottom: 10px;
      > div {
        margin-left: 8px;
        margin-right: 8px;
      }
    }

  }

  @media print {
    .meqr-header, .meqr-footer, .meqr-stepper {
      display: none;
    }
    @page {
      size: A4 portrait;
      margin: 0;
    }
    * {
      margin: 0mm;
      padding: 0mm;
    }
    body {
      margin-top: -15mm;
    }
    svg {
      width: 210mm;
      height: 295.5mm;
      margin-bottom: -50mm;
    }

  }
</style>