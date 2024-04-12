<template>
  <div>
    <v-form ref="form" v-model="valid" lazy-validation>
      <FormsPageTitle number="3" title="記載事項変更届書" :desc="$Documents.SEISIN_IRYO.find(item => item.documentId == 'MJ104').desc" />

    <FormsAlert v-if="$isExpiredIryo()" message="有効期限が切れている場合、記載事項変更はできません。" />

      <!-- 届出内容 -->
      <FormsFormTitleLg label="届出内容" :required="true" />
      <FormsCheckboxes
        :items="$MJ104.is_ssti_todoke"
        :select.sync="sinseiVal"
        :requiredCheck="true"
        :falseCombo="[
          {key: 1, val: [2]},
        ]"
      />
      <!-- 記載事項変更内容 -->
      <v-expand-transition>
        <div v-if="sinseiVal.length">
          <FormsFormTitleLg label="記載事項変更内容" />
          <p>変更内容を確認のうえ、<span style="color: red">変更前</span>の情報を入力してください。</p>
        </div>
      </v-expand-transition>
      <div class="px-2 mb-3">
        <!-- 住所 -->
        <v-expand-transition>
          <div v-if="sinseiVal.includes(1) || sinseiVal.includes(2)">
            <FormsFormTitleMd label="住所" />
            <div class="mb-8 mx-2">
              <FormsChengedTitle :before="true" />
              <v-row>
                <v-col cols="5" class="pr-0">
                  <FormsInputBasic
                    :value.sync="formData.d_address"
                    :rightSharp="true"
                    id="d_address"
                    placeholder="市・町名・番地"
                  />
                </v-col>
                <v-col cols="7" class="pl-0">
                  <FormsInputBasic
                    :value.sync="formData.d_address_building"
                    :leftSharp="true"
                    placeholder="アパート名・マンション名"
                  />
                </v-col>
              </v-row>
              <div class="mt-n8 mb-2 ml-5">
                <v-icon x-large>mdi-arrow-down-bold</v-icon>
              </div>
              <FormsChengedTitle :before="false" />
              <FormsInputReadonly :value="$getPtAddr()" />
            </div>
          </div>
        </v-expand-transition>

        <!-- 氏名 -->
        <v-expand-transition>
          <div v-if="sinseiVal.includes(3)">
            <!-- 氏名（漢字） -->
            <FormsFormTitleMd label="氏名（漢字）" />
            <div class="mb-3 mx-2">
              <v-row>
                <v-col cols="6">
                  <FormsChengedTitle :before="true" />
                  <v-row>
                    <v-col cols="6" class="pr-0">
                      <FormsInputBasic
                        :value.sync="formData.d_name_sei"
                        :rightSharp="true"
                        placeholder="姓"
                      />
                    </v-col>
                    <v-col cols="6" class="pl-0">
                      <FormsInputBasic
                        :value.sync="formData.d_name_mei"
                        :leftSharp="true"
                        placeholder="名"
                      />
                    </v-col>
                  </v-row>
                </v-col>

                <v-col cols="1" class="text-center mt-13">
                  <v-icon x-large>mdi-arrow-right-bold</v-icon>
                </v-col>

                <v-col cols="5">
                  <FormsChengedTitle :before="false" />
                  <FormsInputReadonly :value="$getPtName()" />
                </v-col>
              </v-row>
            </div>
          </div>
        </v-expand-transition>

        <!-- 保護者 -->
        <v-expand-transition>
          <div v-if="sinseiVal.includes(4)">
            <!-- 保護者（漢字） -->
            <FormsFormTitleMd label="保護者氏名（漢字）" />
            <div class="mb-3 mx-2">
              <v-row>
                <v-col cols="6">
                  <FormsChengedTitle :before="true" />
                  <v-row>
                    <v-col cols="6" class="pr-0">
                      <FormsInputBasic
                        :value.sync="formData.d_hg_name_sei"
                        :rightSharp="true"
                        placeholder="姓"
                      />
                    </v-col>
                    <v-col cols="6" class="pl-0">
                      <FormsInputBasic
                        :value.sync="formData.d_hg_name_mei"
                        :leftSharp="true"
                        placeholder="名"
                      />
                    </v-col>
                  </v-row>
                </v-col>

                <v-col cols="1" class="text-center mt-13">
                  <v-icon x-large>mdi-arrow-right-bold</v-icon>
                </v-col>

                <v-col cols="5">
                  <FormsChengedTitle :before="false" />
                  <FormsInputReadonly :value="$getHgName()" />
                </v-col>
              </v-row>
            </div>
          </div>
        </v-expand-transition>

        <!-- 保険 -->
        <v-expand-transition>
          <div v-if="sinseiVal.includes(5)">
            <!-- 保険者 -->
            <FormsFormTitleMd label="保険者" />
            <div class="mb-3 mx-2">
              <v-row>
                <v-col cols="6">
                  <FormsChengedTitle :before="true" />
                  <FormsAutocompHokenja :value.sync="formData.d_hokensha_no" class="ml-0 mr-0" />
                </v-col>
                <v-col cols="1" class="text-center mt-13">
                  <v-icon x-large>mdi-arrow-right-bold</v-icon>
                </v-col>
                <v-col cols="5">
                  <FormsChengedTitle :before="false" />
                  <FormsInputReadonly :value="hokenja" />
                </v-col>
              </v-row>
            </div>
            <!-- 記号番号 -->
            <!-- <FormsFormTitleMd label="記号番号" /> -->
            <div class="mb-6 mx-2">
              <v-row>
                <v-col cols="6">
                  <!-- <FormsChengedTitle :before="true" /> -->
                  <FormsInputBasic
                    :value.sync="formData.d_hoken_kigou_no"
                    placeholder="記号・番号を入力してください"
                  />
                </v-col>
                <v-col cols="1" class="text-center mt-2">
                  <v-icon x-large>mdi-arrow-right-bold</v-icon>
                </v-col>
                <v-col cols="5">
                  <!-- <FormsChengedTitle :before="false" /> -->
                  <FormsInputReadonly
                    :value="$getHokenKigoBango()"
                  />
                </v-col>
              </v-row>
            </div>
          </div>
        </v-expand-transition>
      </div>

      <!-- 送付先 -->
      <FormsFormTitleLg label="受給者証送付先" :required="true"/>
      <FormsCaution label="県での審査・作成のため、受給者証交付までに1～3か月かかります。" />
      
      <FormsSofusaki
        :sofusakiKbn.sync="formData.sofusakiKbn"
        :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan"
        :isTecho="false"
      />
      <!-- 申請書プレビュー -->
      <FormsActionButton
        @preview="preview"
        @prev-step="$emit('prev-step')"
        :showValid="valid"
      ></FormsActionButton>
    </v-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      sinseiVal: [],
      nenkinVal: [],
      sikyumotoVal: [],
      formData: {},
      patient: {},
      hokenja: null,
    }
  },
  watch: {
    sinseiVal(newVal) {
      // 届出内容 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_ssti_todoke', 5);
    },
  },
  mounted() {
    this.$refs.form.resetValidation();
    this.formData = this.$store.getters.getMj104;
    this.patient = this.$store.getters.getPatient; // sessionStorage取得

    // 届出内容 個別 => 配列
    this.$aryToIndexItem(this.sinseiVal, this.formData, 'is_ssti_todoke', 5, true);

    this.hokenja = this.$getHokenja('name');
  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {

        if (!(this.sinseiVal.includes(1) || this.sinseiVal.includes(2))) {
          this.formData.d_address = "";
          this.formData.d_address_building = "";
        }

        if (!this.sinseiVal.includes(3)) {
          this.formData.d_name_sei = "";
          this.formData.d_name_mei = "";
          this.formData.d_kana_name_sei = "";
          this.formData.d_kana_name_mei = "";
        }

        if (!this.sinseiVal.includes(4)) {
          this.formData.d_hg_name_sei = "";
          this.formData.d_hg_name_mei = "";
          this.formData.d_hg_kana_name_sei = "";
          this.formData.d_hg_kana_name_mei = "";
        }

        if (!this.sinseiVal.includes(5)) {
          this.formData.d_hokensha_no = "";
          this.formData.d_hoken_kigou_no = "";
        }

        this.$store.commit('setMj104', this.formData);
        this.$emit('next-step');
      }
    },
  },
}
</script>

