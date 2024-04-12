<template>
  <div>
    <FormsRadio
      :items="$COMMON.SOFUSAKI_KBN.sort((a,b) => isTecho ? a.techo - b.techo : a.iryo - b.iryo)"
      :value.sync="setSofusakiKbn"
      :requiredCheck="true"
    ></FormsRadio>
    <v-expand-transition>
      <FormsCaution v-if="sofusakiKbn == 99" label="送付状の「その他特記事項」に送付先住所をご記入ください。" class="mt-n9" />
    </v-expand-transition>


    <v-expand-transition>
      <div v-if="sofusakiKbn == 1">
        <FormsFormTitleMd label="送付先医療機関選択" :required="true" />
        <FormsRadio
          :items="iryoKikan"
          :value.sync="setSofusakiIryoKikan"
          :requiredCheck="true"
          class="mt-n1"
        ></FormsRadio>
      </div>
    </v-expand-transition>
  </div>  
</template>

<script>
export default {
  data() {
    return {
      patient: {},
      iryoKikan: []  // 医療機関選択肢
    }
  },

  props: {
    sofusakiKbn: {
      default: null,
      required: true,
    },
    sofusakiIryoKikan: {
      default: null,
      required: true,
    },
    isTecho: {
      default: true,
    }
  },

  mounted() {
    const patient = this.$store.getters.getPatient;

    for (const iryoKikan of ['hospital1', 'houkan', 'hospital2']) {
      if (patient[iryoKikan]) {
        this.iryoKikan.push({
          val: patient[iryoKikan].name,
          label: patient[iryoKikan].name
        })
      }
    }
  },

  computed: {
    setSofusakiKbn: {
      get() {
        return this.sofusakiKbn;
      },
      set(newVal) {
        return this.$emit('update:sofusakiKbn', newVal);
      }
    },
    setSofusakiIryoKikan: {
      get() {
        return this.sofusakiIryoKikan;
      },
      set(newVal) {
        return this.$emit('update:sofusakiIryoKikan', newVal);
      }
    },
  },

  watch: {
    setSofusakiKbn: function(newVal) {
      if (newVal != 1) {
        this.setSofusakiIryoKikan = null;
      };
    }
  }
}
</script>