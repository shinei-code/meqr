<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    width="2480"
    height="3507"
    viewBox="0 0 2480 3507"
  >
    <defs>

      <clipPath id="clip-MD_104">
        <rect width="2480" height="3507" />
      </clipPath>
    </defs>
    <g class="md_104_cls-1">
      <rect class="md_104_cls-10" width="2480" height="3507" />
      <g
        id="コンポーネント_1_2"
        data-name="コンポーネント 1 – 2"
        transform="translate(356 483)"
      >
        <path
          class="md_104_cls-2"
          d="M0,0H600"
          transform="translate(473.5 1008.091)"
        />
        <path
          class="md_104_cls-2"
          d="M0,0H600"
          transform="translate(473.5 1081.745)"
        />
        <line
          class="md_104_cls-2"
          x2="823"
          transform="translate(949.5 2022.5)"
        />
        <line
          class="md_104_cls-2"
          x2="823"
          transform="translate(949.5 2097.5)"
        />
        <text class="md_104_cls-3" transform="translate(1322 43)">
          <tspan x="0" y="0">受付市町村　xx市</tspan>
        </text>
        <text class="md_104_cls-4" transform="translate(446 238)">
          <tspan x="0" y="0">精神障がい者保健福祉手帳返還届</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(0 412)">
          <tspan x="0" y="0">xx県知事　殿</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(0 710)">
          <tspan x="0" y="0">
            　精神保健及び精神障害者福祉に関する法律第４５条の２第１項（精神保健及
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(0 781)">
          <tspan x="0" y="0">
            び精神障害者福祉に関する法律施行令第１０条第２項・第１０条の２）の規定
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(0 853)">
          <tspan x="0" y="0">
            により精神障がい者保健福祉手帳を返還します。
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(148 1001)">
          <tspan x="0" y="0">手帳所持者:</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(148 1075)">
          <tspan x="0" y="0">手帳番号　:</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(148 1224)">
          <tspan x="0" y="0">【理由】</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(248 1373)">
          <tspan x="0" y="0">
            □　本人死亡のため（死亡日　　　　　　　　　　　　　　　）
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(248 1447)">
          <tspan x="0" y="0">
            □　疾患が軽減し手帳所持の必要がなくなったため。
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(248 1521)">
          <tspan x="0" y="0">
            □　再交付申請後に、失くしていた手帳が見つかったため。
          </tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(248 1594)">
          <tspan x="0" y="0">□　その他（　　　　　　　　　　　　　　　　）</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(751 2014)">
          <tspan x="0" y="0">届出日 :</tspan>
          <tspan x="0" y="60"></tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(751 2089)">
          <tspan x="0" y="0">届出者 :</tspan>
          <tspan x="0" y="60"></tspan>
        </text>
        <text class="md_104_cls-11" transform="translate(258 1373)">
          <tspan x="0" y="0">{{ riyu1 }}</tspan>
        </text>
        <text class="md_104_cls-11" transform="translate(258 1447)">
          <tspan x="0" y="0">{{ riyu2 }}</tspan>
        </text>
        <text class="md_104_cls-11" transform="translate(258 1521)">
          <tspan x="0" y="0">{{ riyu3 }}</tspan>
        </text>
        <text class="md_104_cls-11" transform="translate(258 1594)">
          <tspan x="0" y="0">{{ riyu99 }}</tspan>
        </text>
        <text class="md_104_cls-5" transform="translate(1644 2951)">
          <tspan x="0" y="0">MD_104</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(958 1979)">
          <tspan x="0" y="43"></tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(512 950)">
          <tspan x="0" y="43">{{ $getPtName() }}</tspan>
        </text>
        <text class="md_104_cls-3" transform="translate(512 1024)">
          <tspan x="0" y="43">{{ patient.techoNo }}</tspan>
        </text>

        <text class="md_104_cls-3" transform="translate(1000 1330)">
          <tspan x="0" y="43">{{ sibou }}</tspan>
        </text>
      </g>
      <g class="md_104_cls-6" transform="translate(1940 153)">
        <rect class="md_104_cls-8" width="300" height="300" />
        <rect class="md_104_cls-9" x="1" y="1" width="299" height="299" />
      </g>
      <!-- <text class="md_104_cls-7" transform="translate(2005 333)">
        <tspan x="0" y="0">QR</tspan>
      </text> -->
       <g transform="translate(1920 70)" v-html="qrcode"></g>
    </g>
   
  </svg>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      md104: {},
      patient: {},
      riyu1: null,
      riyu2: null,
      riyu3: null,
      riyu99: null,
      sibou: null,
      qrcode: null, 
    }
  },
  mounted() {
    this.md104 = this.$store.getters.getMd104;
    this.patient = this.$store.getters.getPatient;

    this.riyu1 = this.md104.sstc_henkanriyu_kbn_key == '1' ? '✔︎' : '';
    this.riyu2 = this.md104.sstc_henkanriyu_kbn_key == '2' ? '✔︎' : '';
    this.riyu3 = this.md104.sstc_henkanriyu_kbn_key == '3' ? '✔︎' : '';
    this.riyu99 = this.md104.sstc_henkanriyu_kbn_key == '99' ? '✔︎' : '';
    this.sibou = this.md104.sstc_henkanriyu_kbn_key == '1' ? this.$cnvWarekiYmd(this.md104.sibou_dt, false) : '';

    // QRコード生成
    this.qrcode = this.$svgQRCode([
      '3',
      '33',
      '8',
      this.md104.sstc_henkanriyu_kbn_key,
      this.md104.sstc_henkanriyu_kbn_key == '1' ? this.md104.sibou_dt : '',
      this.$getQrVisitor('visitor'),
    ], 400)

  },
}
</script>

<style scoped>
  .md_104_cls-1 {
    clip-path: url(#clip-MD_104);
  }

  .md_104_cls-2,
  .md_104_cls-9 {
    fill: none;
  }

  .md_104_cls-2,
  .md_104_cls-3,
  .md_104_cls-4,
  .md_104_cls-5,
  .md_104_cls-6,
  .md_104_cls-11 {
    stroke: #000;
  }

  .md_104_cls-2 {
    stroke-width: 4px;
  }

  .md_104_cls-3 {
    font-size: 50px;
  }

  /* .md_104_cls-3,
  .md_104_cls-4,
  .md_104_cls-5 {
    font-family: MS-Mincho, MS Mincho;
  } */

  .md_104_cls-4 {
    font-size: 60px;
  }

  .md_104_cls-5 {
    font-size: 40px;
  }

  .md_104_cls-10,
  .md_104_cls-6 {
    fill: #fff;
  }

  .md_104_cls-7 {
    font-size: 97px;
    /* font-family: Meiryo; */
    letter-spacing: 0.3em;
  }

  .md_104_cls-8 {
    stroke: none;
  }

  .md_104_cls-11 {
    font-size: 80px;
  }
</style>