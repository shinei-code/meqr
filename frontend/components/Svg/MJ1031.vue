<template>
  <SvgMJ103
    :sinseiNaiyou="$getLabel($MJ101.ssti_sinseinaiyou_kbn_key, mj101.ssti_sinseinaiyou_kbn_key)"
    documentId="MJ_1031"
  />
</template>

<script>
export default {
  data() {
    return {
      qrcode: null,
      mj101: {}, // store情報の入れ物
    }
  },
  mounted() {
    this.mj101 = this.$store.getters.getMj101;
  },
}
</script>