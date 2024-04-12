<template>
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="2480" height="3507"
    viewBox="0 0 2480 3507">
    <defs>
   
      <clipPath id="clip-MJ_107">
        <rect width="2480" height="3507" />
      </clipPath>
    </defs>
    <g class="mj_107_cls-1">
      <rect class="mj_107_cls-10" width="2480" height="3507" />
      <text class="mj_107_cls-2" transform="translate(730 733)">
        <tspan x="0" y="50">自立支援医療受給者証（精神通院）返還届</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(405 1228)">
        <tspan x="0" y="43">自立支援医療受給者証（精神通院）について、下記のとおり返還します。</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(357 926)">
        <tspan x="0" y="43">xx県知事　殿</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(506 1377)">
        <tspan x="0" y="43">受給者　　:</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(506 1452)">
        <tspan x="0" y="43">受給者番号:</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(1676 552)">
        <tspan x="0" y="43">受付市町村　xx市</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(1105 2419)">
        <tspan x="0" y="43">届出日：</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(1105 2494)">
        <tspan x="0" y="43">届出者：</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(506 1601)">
        <tspan x="0" y="43">【理由】</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(556 1750)">
        <tspan x="0" y="43">□　受給者死亡のため。（死亡日　　　　　　　　　　　　　　　）　</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(556 1824)">
        <tspan x="0" y="43">□　精神疾患による通院を行わなくなったため。</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(556 1898)">
        <tspan x="0" y="43">□　再交付申請後に、失くしていた受給者証が見つかったため。</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(556 1972)">
        <tspan x="0" y="43">□　その他（　　　　　　　　　　　　　　　　）</tspan>
      </text>
      <line class="mj_107_cls-4" x2="550" transform="translate(862.5 1436.5)" />
      <line class="mj_107_cls-4" x2="550" transform="translate(862.5 1511.5)" />
      <line class="mj_107_cls-4" x2="823" transform="translate(1305.5 2486.5)" />
      <line class="mj_107_cls-4" x2="823" transform="translate(1305.5 2561.5)" />
      <text class="mj_107_cls-3" transform="translate(869 1371)">
        <tspan x="0" y="43">{{ $getPtName() }}</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(869 1452)">
        <tspan x="0" y="43">{{ patient.jyukyusyaNo }}</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(1388 1750)">
        <tspan x="0" y="43">{{ siboubi}}</tspan>
      </text>
      <text class="mj_107_cls-3" transform="translate(1316 2419)">
        <tspan x="0" y="43"> 　　 　　年　　　月　　　日</tspan>
      </text>
      <text class="mj_107_cls-11" transform="translate(570 1745)">
        <tspan x="0" y="43">{{ henkanriyu_sibou }}</tspan>
      </text>
      <text class="mj_107_cls-11" transform="translate(570 1819)">
        <tspan x="0" y="43">{{ henkanriyu_keigen }}</tspan>
      </text>
      <text class="mj_107_cls-11" transform="translate(570 1893)">
        <tspan x="0" y="43">{{ henkanriyu_found }}</tspan>
      </text>
      <text class="mj_107_cls-11" transform="translate(570 1967)">
        <tspan x="0" y="43">{{ henkanriyu_other }}</tspan>
      </text>
      <text class="mj_107_cls-5" transform="translate(2000 3403)">
        <tspan x="0" y="34">MJ107</tspan>
      </text>
      <g class="mj_107_cls-6" transform="translate(1960 146)">
        <rect class="mj_107_cls-8" width="300" height="300" />
        <rect class="mj_107_cls-9" x="1" y="1" width="299" height="299" />
      </g>
      <!-- <text class="mj_107_cls-7" transform="translate(2025 326)">
        <tspan x="0" y="0">QR</tspan>
      </text> -->
    </g>
    <g transform="translate(1900 80)" v-html="qrcode"></g>
  </svg>
</template>

<script>
export default {
  data() {
    return {
      mj107: {},
      patient: {},
      henkanriyu_sibou: null,
      henkanriyu_keigen: null,
      henkanriyu_found: null,
      henkanriyu_other: null,
      siboubi: null,
      qrcode: null,
    }
  },
  mounted() {
    this.mj107 = this.$store.getters.getMj107;
    this.patient = this.$store.getters.getPatient;

    this.henkanriyu_sibou = this.mj107.ssti_henkanriyu_kbn_key == '1' ? "✔︎" : "";
    this.henkanriyu_keigen = this.mj107.ssti_henkanriyu_kbn_key == '2' ? "✔︎" : "";
    this.henkanriyu_found = this.mj107.ssti_henkanriyu_kbn_key == '3' ? "✔︎" : "";
    this.henkanriyu_other = this.mj107.ssti_henkanriyu_kbn_key == '99' ? "✔︎" : "";
    this.siboubi = this.mj107.ssti_henkanriyu_kbn_key == '1' ? this.$cnvWarekiYmd(this.mj107.sibou_dt, false) : '';

    // QRコード生成
    this.qrcode = this.$svgQRCode([
      4,
      46,
      10,
      this.mj107.ssti_henkanriyu_kbn_key,
      this.mj107.sibou_dt,
      this.$getQrVisitor('visitor'),
    ], 400);

  }
}
</script>

<style scoped>
.mj_107_cls-1 {
  clip-path: url(#clip-MJ_107);
}

.mj_107_cls-2,
.mj_107_cls-3,
.mj_107_cls-4,
.mj_107_cls-5,
.mj_107_cls-6,
.mj_107_cls-11 {
  stroke: #000;
}

.mj_107_cls-2 {
  font-size: 58px;
  letter-spacing: -0.075em;
}

/* .mj_107_cls-2,
.mj_107_cls-3,
.mj_107_cls-5 {
  font-family: MS-Mincho, MS Mincho;
} */

.mj_107_cls-3 {
  font-size: 50px;
}

.mj_107_cls-4,
.mj_107_cls-9 {
  fill: none;
}

.mj_107_cls-4 {
  stroke-width: 4px;
}

.mj_107_cls-5 {
  font-size: 40px;
}

.mj_107_cls-10,
.mj_107_cls-6 {
  fill: #fff;
}

.mj_107_cls-7 {
  font-size: 97px;
  /* font-family: Meiryo; */
  letter-spacing: 0.3em;
}

.mj_107_cls-8 {
  stroke: none;
}

.mj_107_cls-11 {
  font-size: 80px;
}
</style>
