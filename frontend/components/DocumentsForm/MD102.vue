<template>
  <div>
    <FormsPageTitle number="3" title="記載事項変更届・再交付申請書" :desc="$Documents.SEISIN_TECHO.find(item => item.documentId == 'MD102').desc" />

    <FormsAlert v-if="isExpired" message="有効期限が切れている場合、記載事項変更・再交付申請はできません。" />

    <v-form ref="form" v-model="valid" lazy-validation>
      <div class="mb-5">
        <!-- 届出内容 -->
        <FormsFormTitleLg label="記載事項変更"/>
        <FormsCheckboxes
          :items="$MD102.is_sstc_todoke"
          :select.sync="todokedeVal"
          :requiredCheck="true"
          :falseCombo="[
            {key: 1, val: [2]},
            {key: 4, val: [1, 2, 3]}
          ]"
        />

        <v-expand-transition>
          <div v-if="todokedeVal.length">
            <!-- 再交付 -->
            <v-expand-transition>
              <div v-if="excludeKengai">
                <FormsFormTitleLg label="再交付" />
                <v-checkbox
                  v-model="formData.is_saikouhu_shinsei"
                  label="再交付申請"
                  class="ml-5"
                  color="teal"
                />
              </div>
            </v-expand-transition>

            <!-- 手帳の顔写真 -->
            <v-expand-transition>
              <div v-if="includeKengai || isSaikoufu">
                <FormsFormTitleLg label="手帳の顔写真" :required="true"/>
                <FormsRadio
                  :items="this.$COMMON.is_techou_face_pic"
                  :value.sync="formData.is_techou_face_pic"
                  :requiredCheck="true"
                ></FormsRadio>
              </div>
            </v-expand-transition>

            <!-- 再交付理由 -->
            <v-expand-transition>
              <div v-if="excludeKengai && isSaikoufu">
                <FormsFormTitleLg label="再交付理由" :required="true"/>
                <FormsRadio
                  :items="this.$MD102.saikouhu_riyu"
                  :value.sync="formData.saikouhu_riyu"
                  :requiredCheck="true"
                ></FormsRadio>
              </div>
            </v-expand-transition>

            <!-- 記載事項変更内容 -->
            <v-expand-transition>
              <div v-if="$aryInAry(todokedeVal, [1, 2, 3])">
                <FormsFormTitleLg label="記載事項変更内容" />
                <p class="mx-2">変更内容を確認のうえ、<span style="color: red">変更前</span>の情報を入力してください。</p>
              </div>
            </v-expand-transition>
            <div class="px-2 mb-3">
              <v-expand-transition>
                <div v-if="$aryInAry(todokedeVal, [1, 2])">
                  <FormsFormTitleMd label="住所" />
                  <div class="px-2">
                    <FormsChengedTitle :before="true"/>
                    <v-row>
                      <v-col cols="4" class="pr-0">
                        <FormsInputBasic 
                          :value.sync="formData.old_address" 
                          :rightSharp="true" 
                          placeholder="市・町名・番地"
                        />
                      </v-col>
                      <v-col cols="8" class="pl-0">
                        <FormsInputBasic 
                          :value.sync="formData.old_address_bldg" 
                          :leftSharp="true"
                          placeholder="マンション名・ビル名"
                        />
                      </v-col>
                    </v-row>

                    <div class="mt-n8 mb-2 ml-5">
                      <v-icon x-large>mdi-arrow-down-bold</v-icon>
                    </div>
                    
                    <div class="mb-7">
                      <FormsChengedTitle :before="false"/>
                      <FormsInputReadonly :value="patient.ptAddr + patient.ptAddrBldg" />
                    </div>
                  </div>
                </div>
              </v-expand-transition>
            
              <v-expand-transition>
                <div v-if="todokedeVal.includes(3)">
                  <FormsFormTitleMd label="氏名（漢字）" />
                  <div class="px-2 mb-5">
                    <v-row>
                      <v-col cols="6">
                        <FormsChengedTitle :before="true"/>
                        <v-row>
                          <v-col cols="6" class="pr-0">
                            <FormsInputBasic 
                              :value.sync="formData.old_name_sei"
                              :rightSharp="true"
                              placeholder="姓"
                            />
                          </v-col>
                          <v-col cols="6" class="pl-0">
                            <FormsInputBasic :value.sync="formData.old_name_mei"
                              :leftSharp="true"
                              placeholder="名"
                            />
                          </v-col>
                        </v-row>
                      </v-col>
                      ​
                      <v-col cols="1" class="text-center mt-12">
                        <v-icon x-large>mdi-arrow-right-bold</v-icon>
                      </v-col>
                      ​
                      <v-col cols="5">
                        <FormsChengedTitle :before="false"/>
                        <FormsInputReadonly :value="$getPtName()" />
                      </v-col>
                    </v-row>
                  </div>
                
                </div>
              </v-expand-transition>
            </div>

            <!-- 手帳交付希望窓口 -->
            <div v-if="excludeKengai && isSaikoufu">
              <FormsFormTitleLg label="手帳交付希望窓口" :required="true"/>
              <FormsCaution
                label="県での審査・作成のため、⼿帳の交付までに２〜３ヶ⽉かかります。"
              />
              <FormsRadio
                :items="this.$COMMON.section_key"
                :value.sync="formData.section_key"
                :requiredCheck="true"
              ></FormsRadio>

              <!-- 交付決定通知書 送付先 -->
              <FormsFormTitleLg label="交付決定通知書 送付先" :required="true"/>
              <FormsCaution 
                label="通常は本人住所へ送付します。" 
              />
              <FormsSofusaki
                :sofusakiKbn.sync="formData.sofusakiKbn"
                :sofusakiIryoKikan.sync="formData.sofusakiIryoKikan"
                :isTecho="true"
              />
            </div>
          </div>
        </v-expand-transition>
      </div>

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
      valid: false,
      todokedeVal: [],
      formData: {},
      patient: {},
      isExpired: this.$isExpiredTecho()
    }
  },
  watch: {
    todokedeVal(newVal) {
      // 記載事項変更 配列 => 個別
      this.$aryToIndexItem(newVal, this.formData, 'is_sstc_todoke', 4);
    },
  },
  computed: {
    includeKengai() { return this.todokedeVal.includes(2) },
    excludeKengai() { return !this.todokedeVal.includes(2) },
    isSaikoufu() { return this.formData.is_saikouhu_shinsei == '1' },
  },
  mounted() {
    this.formData = this.$store.getters.getMd102; // sessionStorage取得
    this.patient = this.$store.getters.getPatient; // sessionStorage取得
    this.$refs.form.resetValidation();

    // 記載事項変更 個別 => 配列
    this.$aryToIndexItem(this.todokedeVal, this.formData, 'is_sstc_todoke', 4, true);

  },
  methods: {
    preview() {
      if (this.$refs.form.validate()) {
        if (!(this.excludeKengai)) {
          this.formData.is_saikouhu_shinsei = null;
        }

        if (!(this.includeKengai || this.isSaikoufu)) {
          this.formData.is_techou_face_pic = null
        }

        if (!(this.excludeKengai && this.isSaikoufu)) {
          this.formData.saikouhu_riyu = null
        }

        if (!(this.todokedeVal.includes(1) || this.todokedeVal.includes(2))) {
          this.formData.old_address = "";
          this.formData.old_address_bldg = "";
        }

        if (!this.todokedeVal.includes(3)) {
          this.formData.old_name_sei = "";
          this.formData.old_name_mei = "";
          this.formData.old_kana_sei = "";
          this.formData.old_kana_mei = "";
        }

        if (!(this.excludeKengai && this.isSaikoufu)) {
          this.formData.section_key = "";
          this.formData.sofusakiKbn = "";
          this.formData.sofusakiIryoKikan = "";
        }

        this.$store.commit('setMd102', this.formData); // sessionStorage保存
        this.$emit('next-step');
      }
    },
  },
}
</script>
