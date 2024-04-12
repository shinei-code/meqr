<template>
  <v-app class="v-app">

    <v-navigation-drawer app v-model="leftBar" left clipped mobile-breakpoint="sm" width="100" v-if="step >= 1" class="meqr-stepper" :temporary="step == 4">
      <SideMenu />
    </v-navigation-drawer>

    <div v-if="step == 3" class="d-md-none d-lg-none d-xl-none">
      <v-navigation-drawer app v-model="rightBar" right clipped width="300" temporary class="px-3 py-3 teal lighten-4">
        <UserInfo />
      </v-navigation-drawer>

      <a class="user-info" @click="rightBar=!rightBar">
        <v-img 
          width="80" 
          :src="require('@/assets/images/hospital.png')" 
          alt="基本情報" 
        />
        <p>申請者情報</p>
      </a>

    </div>

    <v-app-bar fixed app dense dark clipped-left clipped-right color="teal lighten-3" class="meqr-header">
      <v-app-bar-nav-icon @click="leftBar=!leftBar" v-if="step > 0"></v-app-bar-nav-icon>
      <nav><a @click="$setStep(0)"><img src="../assets/images/logo_name.png"></a></nav>
      <v-btn elevation="4" fab absolute bottom right large color="primary" @click="print" v-if="step == 4">
        <v-icon large>mdi-printer</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main class="mx-5">
      <v-container fluid>
        <Nuxt />
      </v-container>
    </v-main>

    <v-footer app class="meqr-footer" color="blue-grey darken-1">
      <v-col class="text-center py-0" cols="12">
      <span class="justify-end white--text">xx課 &copy; {{ new Date().getFullYear() }} example.com</span>
      </v-col>
      <v-btn elevation="4" fab absolute top right dark large color="grey darken-3" @click="$setStep(3)" v-if="step == 4">
        戻る
      </v-btn>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "default",
  data() {
    return {
      leftBar: null,
      rightBar: false,
    };
  },
  computed: {
    step() {
      if (this.$store.getters.getStep == 5) {
        this.leftBar = false;
      }
      return this.$store.getters.getStep;
    },
  },
  watch: {
    step (val, old) {
      if (old == 4 && val != 4) {
        const size = this.$vuetify.breakpoint.name;
        if (['md', 'lg', 'xl'].includes(size)) {
          this.leftBar = true;          
        }
      }
    }
  },
  methods: {
    print() {
      window.print();
    },
  },
}
</script>

<style lang="scss" scoped>
  img {
    width: 15%;
  }

  .user-info{
    position: fixed;
    bottom: 40px; 
    right: 40px;
    z-index: 2;
    border-radius: 50%;
    color: black;
    font-size: 0.9em;
  }
</style>
