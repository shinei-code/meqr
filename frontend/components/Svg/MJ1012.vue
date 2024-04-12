<template>
  <SvgMJ101
    :qrcode="qrcode"
    sinseiNaiyou="変更"
    documentId="MJ_1012"
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

    // QR生成
    this.qrcode = this.$svgQRCode([
      4,
      42,
      6,
      this.$getPtTel(),
      mj101.is_shogai_nenkin1,
      mj101.is_shogai_nenkin2,
      mj101.is_shogai_nenkin3,
      mj101.is_shogai_nenkin4,
      mj101.is_shogai_nenkin5,
      mj101.is_shogai_nenkin6,
      mj101.is_shogai_nenkin7,
      mj101.is_nenkin_sikyumoto1,
      mj101.is_nenkin_sikyumoto2,
      mj101.is_nenkin_sikyumoto3,
      mj101.is_nenkin_sikyumoto4,
      mj101.is_nenkin_sikyumoto5,
      mj101.is_nenkin_sikyumoto6,
      this.$getQrSofusaki(mj101, 'kbn'),
      this.$getQrSofusaki(mj101, 'sofusaki'),
      this.$getQrVisitor('visitor'),
    ], 450);
  }
}
</script>