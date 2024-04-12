<template>
<div>
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="2480" height="3507" viewBox="0 0 2480 3507">
    <defs>
      
      <clipPath id="clip-カスタムサイズ_1">
        <rect width="2480" height="3507"/>
      </clipPath>
    </defs>
    <g id="カスタムサイズ_1" data-name="カスタムサイズ – 1" class="cls-1">
      <rect class="cls-11" width="2480" height="3507"/>
      <text id="同_意_書" data-name="同　　　意　　　書" class="cls-2" transform="translate(970 656)"><tspan x="0" y="0">同　　　意　　　書</tspan></text>
      <text id="精神障害者保健福祉手帳交付のため_必要事項の調査に同意いたします_" data-name="精神障害者保健福祉手帳交付のため、必要事項の調査に同意いたします。" class="cls-3" transform="translate(307 1020)"><tspan x="0" y="0">精神障害者保健福祉手帳交付のため、必要事項の調査に同意いたします。</tspan></text>
      <text id="住_所" data-name="住　　所" class="cls-4" transform="translate(1159 1598)"><tspan x="0" y="0">住　　所</tspan></text>
      <text id="氏_名" data-name="氏　　名" class="cls-4" transform="translate(1159 1784)"><tspan x="0" y="0">氏　　名</tspan></text>
      <text id="宮_崎_市_長_殿" data-name="宮　崎　市　長　殿" class="cls-5" transform="translate(538 2262)"><tspan x="0" y="0">宮　崎　市　長　殿</tspan></text>
      <!-- <g id="楕円形_1" data-name="楕円形 1" class="cls-6" transform="translate(2042 1745)">
        <circle class="cls-9" cx="70.5" cy="70.5" r="70.5"/>
        <circle class="cls-10" cx="70.5" cy="70.5" r="68"/>
      </g>
      <text id="印" class="cls-4" transform="translate(2090 1834)"><tspan x="0" y="0">印</tspan></text> -->
      <text id="_document_id" data-name="$document_id" class="cls-4" transform="translate(1965 3432)"><tspan x="0" y="0">MD_103</tspan></text>
      <text id="_uketuke_dt" data-name="$uketuke_dt" class="cls-4" transform="translate(585.5 1143.5)"><tspan x="-135" y="39">令和　　　年　　　月　　　日</tspan></text>
      <text 
        id="_t_address_" 
        data-name="$t_address" 
        class="cls-4" 
        transform="translate(1402 1598)"
      >
        <tspan x="0" y="0" xml:space="preserve" v-bind="wAdjust.ptAddr">{{ this.patient.ptAddr }}</tspan>
      </text>
      <text 
        id="_t_address_building_" 
        data-name="$t_address_building" 
        class="cls-4" 
        transform="translate(1402 1667)"
      >
        <tspan x="0" y="0" xml:space="preserve" v-bind="wAdjust.ptAddrBldg">{{ this.patient.ptAddrBldg }}</tspan>
      </text>
      <!-- <g id="長方形_1" data-name="長方形 1" class="cls-7" transform="translate(1960 145)">
        <rect class="cls-9" width="300" height="300"/>
        <rect class="cls-10" x="0.5" y="0.5" width="299" height="299"/>
      </g>
      <text id="QR" class="cls-8" transform="translate(2110 325)"><tspan x="-84.624" y="0">QR</tspan></text> -->
    </g>
  </svg>
</div>
</template>

<script>
export default {
  data() {
    return {
      patient: {},
      md101: {},

      // 幅調整
      wAdjust: {
        ptAddr: null,
        ptAddrBldg: null,
      }
    }
  },
  mounted() {
    this.md101 = this.$store.getters.getMd101;  // sessionStorage取得
    this.patient = this.$store.getters.getPatient;  // sessionStorage取得

    // 幅調整
    this.wAdjust.ptAddr = this.$wAdjustAttr(this.patient.ptAddr, 850);
    this.wAdjust.ptAddrBldg = this.$wAdjustAttr(this.patient.ptAddrBldg, 850);
},
}
</script>

<style scoped>
  .cls-1 {
    clip-path: url(#clip-カスタムサイズ_1);
  }

  .cls-2, .cls-3, .cls-4, .cls-5, .cls-6, .cls-7 {
    stroke: #000;
  }

  .cls-2 {
    font-size: 60px;
  }

  /* .cls-2, .cls-3, .cls-4, .cls-5 {
    font-family: MS-Mincho, MS Mincho;
  } */

  .cls-3 {
    font-size: 50px;
  }

  .cls-3, .cls-4, .cls-5 {
    letter-spacing: 0.05em;
  }

  .cls-4 {
    font-size: 45px;
  }

  .cls-5 {
    font-size: 55px;
  }

  .cls-11, .cls-6 {
    fill: #fff;
  }

  .cls-6 {
    stroke-width: 5px;
    stroke-dasharray: 25;
  }

  .cls-10, .cls-7 {
    fill: none;
  }

  .cls-8 {
    font-size: 97px;
    /* font-family: Meiryo; */
    letter-spacing: 0.3em;
  }

  .cls-9 {
    stroke: none;
  }
</style>

