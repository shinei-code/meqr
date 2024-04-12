<template>
  <div style="display: flex;">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="2480" height="3507" viewBox="0 0 2480 3507">
      <defs>
        <clipPath >
          <rect width="2480" height="3507"/>
        </clipPath>
      </defs>
      <g  class="mj_108_cls-1">
        <rect class="mj_108_cls-11" width="2480" height="3507"/>
        <text   class="mj_108_cls-2" transform="translate(1003 535)"><tspan x="0" y="52">同　　意　　書</tspan></text>
        <text   class="mj_108_cls-3" transform="translate(351 469)"><tspan x="0" y="0">（別紙様式１）</tspan></text>
        <text   class="mj_108_cls-3" transform="translate(381 772)"><tspan x="0" y="0">宮　崎　市　長　殿</tspan></text>
        <text   class="mj_108_cls-4" transform="translate(351 1029)"><tspan x="0" y="41">　障がい者自立支援法に基づく自立支援医療費の支給認定に関して必要がある</tspan><tspan x="0" y="116">ときは、私の診断書等についてxx市が、官公署等に対し必要な文書の閲覧若</tspan><tspan x="0" y="191">しくは資料の提供を求めることに同意します。</tspan></text>
        <text   class="mj_108_cls-5" transform="translate(541 1322)"><tspan x="0" y="41">年　　　月　　　日</tspan></text>
        <text   class="mj_108_cls-3" transform="translate(1081 1642)"><tspan x="0" y="41">住　所：</tspan><tspan class="mj_108_cls-6" y="0">　　　　　　　　　　　　　　　</tspan></text>
        <text   class="mj_108_cls-3" transform="translate(1081 1892)"><tspan x="0" y="0">氏　名：</tspan><tspan class="mj_108_cls-6" y="0">　　　　　　　　　　　　　　　</tspan></text>
        <text   class="mj_108_cls-5" transform="translate(1297 1701)"><tspan x="0" y="41">{{ patient.ptAddrBldg }}</tspan></text>
        <text   class="mj_108_cls-5" transform="translate(1297 1642)"><tspan x="0" y="41">{{ patient.ptAddr }}</tspan></text>
        <text   class="mj_108_cls-7" transform="translate(2038 3367)"><tspan x="0" y="0">MJ_108</tspan></text>
        <text   class="mj_108_cls-5" transform="translate(1297 1849)"><tspan x="0" y="41"></tspan></text>
        <g   class="mj_108_cls-8" transform="translate(1393 2398)">
          <rect class="mj_108_cls-9" width="738" height="619"/>
          <rect class="mj_108_cls-10" x="5" y="5" width="728" height="609"/>
        </g>
        <text   class="mj_108_cls-3" transform="translate(1627 2461)"><tspan x="0" y="0">受　付　印</tspan></text>
      </g>
    </svg>
  </div>
</template>


<script>
export default {
  data() {
    return {
      patient: {},
    }
  },
  mounted() {
    this.patient = this.$store.getters.getPatient;
  },
}
</script>


<style scoped>
  .mj_108_cls-1 {
    clip-path: url(#clip-MJ_108);
  }

  .mj_108_cls-2, .mj_108_cls-3, .mj_108_cls-4, .mj_108_cls-5, .mj_108_cls-7, .mj_108_cls-8 {
    stroke: #000;
  }

  .mj_108_cls-2 {
    font-size: 60px;
  }

  /* .mj_108_cls-2, .mj_108_cls-3, .mj_108_cls-4 {
    font-family: HGMaruGothicMPRO;
  } */

  .mj_108_cls-2, .mj_108_cls-3 {
    letter-spacing: 0.1em;
  }

  .mj_108_cls-3 {
    font-size: 50px;
  }

  .mj_108_cls-4, .mj_108_cls-5 {
    font-size: 48px;
  }

  .mj_108_cls-4 {
    letter-spacing: 0.04em;
  }

  .mj_108_cls-6 {
    text-decoration: underline;
  }

  .mj_108_cls-7 {
    font-size: 40px;
  }

  .mj_108_cls-10, .mj_108_cls-8 {
    fill: none;
  }

  .mj_108_cls-8 {
    stroke-width: 10px;
  }

  .mj_108_cls-9 {
    stroke: none;
  }

  .mj_108_cls-11 {
    fill: #fff;
  }
</style>