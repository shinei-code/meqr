<template>
  <div :class="isUnderSm ? 'mr-3' : ''">
    <v-card class="pb-3 pt-6 mb-5">
      <v-img :src="require('@/assets/images/hospital.png')" class="mx-auto img" alt="基本情報"></v-img>
      <div class="d-flex justify-center teal white--text my-3 mx-4 py-1 mb-1 rounded-t-xl">利用情報</div>
      <v-card-text class="pb-0 px-5">
          <v-text-field
            v-model="iryo" 
            label="自立支援（精神）" 
            readonly
            dense 
            :class="iryoExpired ? 'expired mb-6' : 'mb-3'" 
            :error="iryoExpired"
            :error-messages="iryoExpired ? '有効期限が切れています' : ''"
          />
          <v-text-field 
            v-model="techo" 
            label="精神手帳" 
            readonly 
            dense 
            :class="techoExpired ? 'expired mb-6' : 'mb-3'" 
            :error="techoExpired"
            :error-messages="techoExpired ? '有効期限が切れています' : ''"
          />
          <v-text-field v-model="hokenja" label="健康保険" class="mb-3" readonly dense />
          <v-text-field v-if="hospital1" v-model="hospital1" label="病院1" class="mb-3" readonly dense />
          <v-text-field v-if="yakkyoku" v-model="yakkyoku" label="薬局" class="mb-3" readonly dense />
          <v-text-field v-if="houkan" v-model="houkan" label="訪問看護" class="mb-3" readonly dense />
          <v-text-field v-if="hospital2" v-model="hospital2" label="病院2" class="mb-n3" readonly dense />
      </v-card-text>
      <div class="teal mx-4 py-1 mt-0 rounded-b-xl"></div>
    </v-card>

    <v-card class="pb-3 pt-6 mb-5">
      <v-img :src="require('@/assets/images/wo-man.png')" class="mx-auto img1" alt="申請者"></v-img>
      <div class="d-flex justify-center teal white--text my-3 mx-4 py-1 mb-1 rounded-t-xl">申請者情報</div>
      <v-card-text class="pb-0 px-5">
          <v-text-field v-model="ptName" label="氏名" class="mb-3" readonly dense />
          <v-text-field v-model="patient.ptAddr" label="住所" class="mb-3" readonly dense />
          <v-text-field v-if="patient.ptAddrBldg" v-model="patient.ptAddrBldg" label="アパート・マンション等" class="mb-3" readonly dense />
          <v-text-field v-model="ptBday" label="生年月日" class="mb-3" readonly dense />
          <v-text-field v-model="ptTel" label="電話番号" class="mb-n3" readonly dense />
      </v-card-text>
      <div class="teal mx-4 py-1 mt-0 rounded-b-xl"></div>
    </v-card>

    <v-card v-if="patient.under18" class="pt-6 pb-3">
      <v-img :src="require('@/assets/images/family.png')" class="img2 mx-auto" alt="申請者"></v-img>
      <div class="d-flex justify-center teal white--text my-3 mx-4 py-1 mb-1 rounded-t-xl">保護者情報</div>
      <v-card-text class="pb-0 px-5">
        <v-text-field v-model="hgName" label="氏名" class="mb-3" readonly dense />
        <v-text-field v-model="patient.hgAddr" label="住所" class="mb-3" readonly dense />
        <v-text-field v-if="patient.hgAddrBldg" v-model="patient.hgAddrBldg" label="アパート・マンション等" class="mb-n3" readonly dense />
      </v-card-text>
      <div class="teal mx-4 py-1 mt-0 rounded-b-xl"></div>
    </v-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ptName: null,
      ptKana: null,
      ptBday: null,
      ptTel: null,
      hgName: null,
      hgKana: null,
      iryo: null,
      techo: null,
      iryoExpired: false,
      techoExpired: false,
      patient: {},
      hokenja: null,
      hospital1: null,
      yakkyoku: null,
      houkan: null,
      hospital2: null,
    }
  },
  mounted() {
    this.$initCheck(this.$route.path);  // 直リンクチェック
    
    this.patient = this.$store.getters.getPatient;
    this.ptName = `${this.$getPtName()} (${this.$getPtKana()})`;
    this.ptBday = this.$getPtBday(false);
    this.ptTel = this.$getPtTel();
    this.hgName = `${this.$getHgName()} (${this.$getHgKana()})`;
    this.iryo = this.patient.jyukyusyaNo ? `${this.patient.jyukyusyaNo} (${this.patient.iryoExpY}年${this.patient.iryoExpM}月まで)` : 'なし';
    this.techo = this.patient.techoNo ? `${this.patient.techoNo} (${this.patient.techoExpY}年${this.patient.techoExpM}月まで)` : 'なし';

    this.hokenja = this.$getHokenja('name');
    this.hospital1 = this.$getHospital1('name');
    this.yakkyoku = this.$getYakkyoku('name');
    this.houkan = this.$getHoukan('name');
    this.hospital2 = this.$getHospital2('name');

    // 有効期限が今日時点で過ぎているか
    this.iryoExpired = this.$isExpired(this.patient.iryoExpY, this.patient.iryoExpM);  // 自立支援（医療）
    this.techoExpired = this.$isExpired(this.patient.techoExpY, this.patient.techoExpM);  // 精神手帳
  },
  fetchOnServer: false,
  methods: {
    nextStep() {
      this.$setStep(4);
    },
    prevStep() {
      this.$setStep(2);
    }
  },
  computed: {
    isUnderSm() {
      return ['sm', 'xs'].includes(this.$vuetify.breakpoint.name)
    }
  },
}
</script>

<style lang="scss" scoped>
.img{
  width: 45%;
}
.img1 {
  width: 60%;
}
.img2 {
  width: 70%;
}
.expired {
  :deep(input) {
    color: #F44336;
  }
}
</style>