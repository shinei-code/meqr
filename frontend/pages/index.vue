<template>
  <div>
    <v-row no-gutters id="contents" :class="isOverMd ? 'v-center' : ''">
      <v-col cols="12" xs="12" sm="12" md="8">
        <div class="left mx-auto">
          <div class="my-5">
            <div class="text-center title-h">
              <h2>精神障がい者保健福祉手帳・自立支援医療（精神）</h2>
              <h1 class="h1space">各種申請書作成</h1>
            </div>

            <div class="d-flex flex-column align-center mb-10">
              <v-img :src="require('@/assets/images/logo-sm.png')" class="img" alt="ロゴマーク"></v-img>
              <v-img :src="require('@/assets/images/logo-sm-n.png')" class="img mt-2" alt="ロゴ名前"></v-img>
            </div>
          </div>
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
          >
            <div class="iryou-select">
              <FormsFormTitleSm label="医療機関を選択してください" class="ml-5" :required="true"/>
              <FormsSelectIryoKikan :select.sync="iryoKikanCode" :items="hospitals" :requiredCheck="true" class="mx-5" />
              
              <div v-if="!this.confirmedId">
                <v-text-field
                  label="利用者ID"
                  v-model="uid"
                  :rules="[
                    v => !!v || '入力必須です',
                    validUid || '利用者IDが誤っています'
                  ]"
                  class="uid mb-3"
                  @change="checkUid"
                />
              </div>
            </div>

            <v-btn 
              color="teal" 
              :disabled="!valid"
              :dark="valid" 
              x-large 
              tile
              @click="nextPage"  
              class="createBtn rounded-pill d-block mx-auto mb-10 mt-2">
              作成を始める
            </v-btn>
          </v-form>
        </div>
      </v-col>

      <v-col cols="12" md="4" class="side-space">
        <v-card class="side-card mx-auto" align="center" color="rgba(255,179,0,0.3)">
          <div class="text-h6 mt-5" >
            申請書について
          </div>
          <v-divider class="border mt-3"></v-divider>
          <p align="left" class="pt-8">
            作成した申請書は、xx市障がい福祉課窓口へ提出してください。<br>
            郵送で提出する場合は、消印日が受付日となります。
          </p>
          
          <v-col cols="12" class="inquiry px-5">
            <div align="left">
              <p class="my-n1 pt-3">お問い合わせ先</p>
              <v-divider class="my-1"></v-divider>
              <p>xx市障がい福祉課　医療福祉係<br>
              〒880-8505 xx市橘通西1丁目1番1号<br>
              電話番号&#65306;0985-21-1772
              </p>
            </div>
          </v-col>
          
        </v-card>
      </v-col>
    </v-row>

    <FormsCookieConfirm />
  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      iryoKikanCode: null,
      hospitals: [],
      uid: null,
      validUid: true,
      confirmedId: false,
    }
  },

  async fetch() {
    this.hospitals = await fetch(
      '/api/hospitals'
    ).then(res => res.json()).catch((err) => {console.log(err); return [];})
  },
  fetchOnServer: false,

  mounted() {
    this.iryoKikanCode = this.$store.getters.getIryoKikan;
    this.confirmedId = this.$store.getters.getConfirmedId;
    this.$refs.form.resetValidation();
  },
  computed: {
    isOverMd() {
      return ['md', 'lg', 'xl'].includes(this.$vuetify.breakpoint.name)
    }
  },
  methods: {
    nextPage() {
      if (this.$refs.form.validate()) {
        this.iryoKikanCode = this.hospitals.find(item => item.code == this.iryoKikanCode.code);
        this.$store.commit('setIryoKikan', this.iryoKikanCode);
        this.$store.commit('setConfirmedId', true);
        this.$setStep(1);
      }
    },
    async checkUid() {
      if (!this.confirmedId) {
        this.valid = false;
        this.validUid = await this.$axios.post(`/api/uid/`, {uid: this.uid}).then(res => res.data);
        this.valid = this.validUid;
      }
    },
  }
}
</script>

<style lang="scss" scoped>
  #contents {
    height:calc(100vh - 90px);
    // display: flex;
    justify-content: center;
    margin-right: 30px;
  }
  .left {
    max-width: 800px;
  }
  .v-center {
    align-content: center;
  }
  .title-h {
    margin-bottom: 40px;
    .h1space {
      letter-spacing: 1rem;
    }
  }
  .img {
      width: 140px;
    }
  .iryou-select{
    margin: 0 100px;
  }
  .createBtn {
    width: 300px;
    font-size: 18px;
    height: 65px !important;
  }
  .side-card {
    padding: 30px;
    margin-top: 20px;
    margin-bottom: 30px;
    max-width: 500px;
    .border {
      border-bottom: 4px solid rgb(54, 70, 78);
      width: 25%;
    }
    .inquiry {
      min-height: 150px;
      margin-top: 80px;
      background-color: rgba(255,255,255,0.5);
      border-bottom: 1px dotted rgb(158, 158, 158);
      border-top: 1px dotted rgb(158, 158, 158);
    }
    
  }
  .uid {
    max-width: 250px;
    margin: auto;
  }

</style>
