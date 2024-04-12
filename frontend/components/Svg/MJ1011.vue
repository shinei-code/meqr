<template>
  <SvgMJ101
    :qrcode="qrcode"
    :sinseiNaiyou="[1,8].includes(mj101.ssti_sinseinaiyou_kbn_key) ? '新規' : '再認定'"
    documentId="MJ_1011"
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
    const patient = this.$store.getters.getPatient;
    
    // QRコード生成
    this.qrcode = this.$svgQRCode([
      4,
      41,
      this.mj101.ssti_sinseinaiyou_kbn_key,
      this.mj101.is_sindansho_umu,
      this.mj101.is_kikan_chosei,
      this.mj101.ssti_sinseihouhou_kbn_key,
      this.mj101.is_jyudo_keizoku_gaito,
      0,
      1,
      patient.ptAddr,
      patient.ptAddrBldg,
      this.$getPtTel(),
      this.$getHgKana(),
      this.$getHgName(),
      patient.hgAddr,
      patient.hgAddrBldg,
      patient.hgTuzukigara,
      patient.hokenType,
      this.$getHokenja("code"),
      patient.hokenKigo,
      patient.hokenBango,
      this.$getHihoName(),
      this.$getHihoKana(),
      patient.hihoCity ? patient.hihoCity : "xx市",
      this.$getHihoBdaySeireki(),
      this.$getHospital1("code"),
      this.$getYakkyoku("code"),
      this.$getHoukan("code"),
      this.$getHospital2("code"),
      this.mj101.is_shogai_nenkin1,
      this.mj101.is_shogai_nenkin2,
      this.mj101.is_shogai_nenkin3,
      this.mj101.is_shogai_nenkin4,
      this.mj101.is_shogai_nenkin5,
      this.mj101.is_shogai_nenkin6,
      this.mj101.is_shogai_nenkin7,
      this.mj101.is_nenkin_sikyumoto1,
      this.mj101.is_nenkin_sikyumoto2,
      this.mj101.is_nenkin_sikyumoto3,
      this.mj101.is_nenkin_sikyumoto4,
      this.mj101.is_nenkin_sikyumoto5,
      this.mj101.is_nenkin_sikyumoto6,
      this.$getQrSofusaki(this.mj101, 'kbn'),
      this.$getQrSofusaki(this.mj101, 'sofusaki'),
      this.$getQrVisitor('visitor'),
    ], 450);
  }
}
</script>