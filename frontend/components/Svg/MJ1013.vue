<template>
  <SvgMJ101
    :qrcode="qrcode"
    sinseiNaiyou="変更"
    documentId="MJ_1013"
  />
</template>

<script>
export default {
  data() {
    return {
      qrcode: null,
    }
  },
  mounted() {
    const mj101 = this.$store.getters.getMj101;

    // QRコード生成
    this.qrcode = this.$svgQRCode([
      4,
      43,
      7,
      this.$getHospital1("code"),
      this.$getYakkyoku("code"),
      this.$getHoukan("code"),
      this.$getHospital2("code"),
      this.$getQrSofusaki(mj101, 'kbn'),
      this.$getQrSofusaki(mj101, 'sofusaki'),
      this.$getQrVisitor('visitor'),
    ], 450);
  }
}
</script>