<template>
  <div class="mr-4 ml-2">
    <FormsPageTitle number="1" title="申請者の情報を入力してください"></FormsPageTitle>

    <FormsAlert message="氏名・住所・保護者・保険・医療機関に変更がある場合は、新しい内容を入力してください。" />

    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
    >
      <!-- 精神医療情報 -->
      <v-row class="pb-0">
        <v-col cols="12" sm="6">  <!-- 受給者番号・入力履歴検索 -->
          <FormsFormTitleSm label="自立支援（精神）受給者番号"/>
          <v-text-field
            v-model="formData.jyukyusyaNo"
            placeholder="自立支援医療（精神）受給者番号"
            background-color="teal lighten-5"
            outlined
          >
            <template v-slot:append-outer>
              <v-btn color="teal" dark @click="searchRireki" class="rireki-search" x-large>
              <v-icon sm="1" class="ml-n1">mdi-clipboard-text-search-outline</v-icon>
              保存履歴検索
              </v-btn>
            </template>
          </v-text-field>
        </v-col>
        <v-col cols="12" sm="6">  <!-- 自立支援（精神）有効期限 -->
          <FormsFormTitleSm label="自立支援（精神）有効期限" />
          <v-row>
            <v-col cols="6" class="pr-0">
              <FormsSelect
                :select.sync="formData.iryoExpY"
                :placeholder="$WAREKI_TODAY.WS_YEAR"
                :items="$SEIREKI_WAREKI.YEAR_REV"
                :rightSharp="true"
                :requiredCheck="this.formData.jyukyusyaNo ? true : false"
              />
            </v-col>
            <v-col cols="6" class="pl-0">
              <FormsSelect
                :select.sync="formData.iryoExpM"
                :placeholder="$WAREKI_TODAY.MONTH"
                :items="$SEIREKI_WAREKI.MONTH"
                :leftSharp="true"
                :searchInput="false"
                :requiredCheck="this.formData.jyukyusyaNo ? true : false"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>

      <!-- 精神手帳情報 -->
      <v-row>
        <v-col cols="12" sm="6">  <!-- 精神手帳番号 -->
          <FormsFormTitleSm label="精神手帳番号" />
          <FormsInputBasic :value.sync="formData.techoNo" placeholder="精神手帳番号"/>
        </v-col>
        <v-col cols="12" sm="6">  <!-- 精神手帳有効期限 -->
          <FormsFormTitleSm label="精神手帳　有効期限" />
          <v-row>
            <v-col cols="6" class="pr-0">
              <FormsSelect
                :select.sync="formData.techoExpY"
                :placeholder="$WAREKI_TODAY.WS_YEAR"
                :items="this.$SEIREKI_WAREKI.YEAR_REV"
                :rightSharp="true"
                :requiredCheck="this.formData.techoNo ? true : false"
              />
            </v-col>
            <v-col cols="6" class="pl-0">
              <FormsSelect
                :select.sync="formData.techoExpM"
                :placeholder="$WAREKI_TODAY.MONTH"
                :items="this.$SEIREKI_WAREKI.MONTH"
                :leftSharp="true"
                :searchInput="false"
                :requiredCheck="this.formData.techoNo ? true : false"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>

      <!-- 氏名・カナ -->
      <v-row>
        <v-col cols="12" sm="6">  <!-- 氏名 -->
          <FormsFormTitleSm label="氏名（漢字）" :required="true"/>
          <v-row>
            <v-col cols="6" class="pr-0">
              <FormsInputBasic :value.sync="formData.ptNameSei" placeholder="xx" :requiredCheck="true" :rightSharp="true" />
            </v-col>
            <v-col cols="6" class="pl-0">
              <FormsInputBasic :value.sync="formData.ptNameMei" placeholder="一郎" :requiredCheck="true" :leftSharp="true" />
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" sm="6">  <!-- カナ氏名 -->
          <FormsFormTitleSm label="氏名（カナ）" :required="true" />
          <v-row>
            <v-col cols="6" class="pr-0">
              <FormsInputBasic 
                :value.sync="formData.ptKanaSei" 
                placeholder="ミヤザキ" 
                :requiredCheck="true" 
                :rightSharp="true" 
                @input-end="formData.ptKanaSei = $toKana(formData.ptKanaSei)"
              />
            </v-col>
            <v-col cols="6" class="pl-0">
              <FormsInputBasic 
                :value.sync="formData.ptKanaMei" 
                placeholder="イチロウ" 
                :requiredCheck="true" 
                :leftSharp="true" 
                @input-end="formData.ptKanaMei = $toKana(formData.ptKanaMei)"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>

      <!-- 生年月日 -->
      <FormsFormTitleSm label="生年月日" :required="true" />
      <v-checkbox v-model="formData.under18" label="18歳以下" color="teal">
        <template v-slot:label>
          <div>
            18歳以下
            <template>
              <span class="amber--text text--darken-3">&emsp;※申請時点で１８歳以下の場合は申請者は保護者になります。</span>
            </template>
          </div>
        </template>
      </v-checkbox>
      <v-row>
        <v-col cols="8">
          <v-row>
            <v-col cols="6" class="pr-0">
              <FormsSelectWarekiYear
                :select.sync="formData.ptBdayY"
                :placeholder="$WAREKI_TODAY.WS_YEAR"
                :items="$SEIREKI_WAREKI.YEAR"
                :rightSharp="true"
                :requiredCheck="true"
              />
            </v-col>
            <v-col cols="3" class="px-0">
              <FormsSelect
                :select.sync="formData.ptBdayM"
                :placeholder="$WAREKI_TODAY.MONTH"
                :items="$SEIREKI_WAREKI.MONTH"
                :leftSharp="true"
                :rightSharp="true"
                :searchInput="false"
                :requiredCheck="true"
              />
            </v-col>
            <v-col cols="3" class="pl-0">
              <FormsSelect
                :select.sync="formData.ptBdayD"
                :placeholder="$WAREKI_TODAY.DAY"
                :items="$SEIREKI_WAREKI.DAY"
                :leftSharp="true"
                :searchInput="false"
                :requiredCheck="true"
                :forceErr="isDate"
                errMsg="存在しない日付です"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>

      <!-- 住所 -->
      <FormsFormTitleSm label="住所" :required="true" />
      <v-row>
        <v-col cols="12" sm="5" class="pr-0">  <!-- 住所 -->
          <FormsInputBasic :value.sync="formData.ptAddr" placeholder="市・町名・番地（xx市橘通西1丁目1番1号）" :requiredCheck="true" :rightSharp="true" />
        </v-col>
        <v-col cols="12" sm="7" class="pl-0">  <!-- 方書 -->
          <FormsInputBasic :value.sync="formData.ptAddrBldg" placeholder="アパート・マンションなど（xxマンション101号）" :leftSharp="true" />
        </v-col>
      </v-row>

      <!-- 電話番号 -->
      <FormsFormTitleSm label="電話番号" />
      <v-row class="mb-5">
        <v-col cols="6">
          <v-row>
            <v-col cols="3" class="pr-0"><FormsInputBasic :value.sync="formData.ptTel_1st" placeholder="080" :integerCheck="true"/></v-col>
            <v-col cols="1" class="pt-7 text-center"><strong>ー</strong></v-col>
            <v-col cols="3" class="px-0"><FormsInputBasic :value.sync="formData.ptTel_2nd" placeholder="1234" :integerCheck="true"/></v-col>
            <v-col cols="1" class="pt-7 text-center"><strong>ー</strong></v-col>
            <v-col cols="3" class="px-0"><FormsInputBasic :value.sync="formData.ptTel_3rd" placeholder="5678" :integerCheck="true"/></v-col>
          </v-row>
        </v-col>
      </v-row>

      <!-- ////////// 保護者 ////////// -->
      <v-expand-transition>
        <div v-if="formData.under18" class="mb-7">
          <FormsFormTitleLg label="保護者" />
          <!-- 保護者氏名・カナ -->
          <v-row>
            <v-col cols="12" sm="6">  <!-- 氏名 -->
              <FormsFormTitleSm label="氏名（漢字）" :required="true"/>
              <v-row>
                <v-col cols="6" class="pr-0">
                  <FormsInputBasic :value.sync="formData.hgNameSei" placeholder="xx" :requiredCheck="true" :rightSharp="true" />
                </v-col>
                <v-col cols="6" class="pl-0">
                  <FormsInputBasic :value.sync="formData.hgNameMei" placeholder="一郎母" :requiredCheck="true" :leftSharp="true" />
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12" sm="6">  <!-- カナ氏名 -->
              <FormsFormTitleSm label="氏名（カナ）" />
              <v-row>
                <v-col cols="6" class="pr-0">
                  <FormsInputBasic 
                    :value.sync="formData.hgKanaSei" 
                    placeholder="ミヤザキ" 
                    :requiredCheck="true" 
                    :rightSharp="true" 
                    @input-end="formData.hgKanaSei = $toKana(formData.hgKanaSei)"
                  />
                </v-col>
                <v-col cols="6" class="pl-0">
                  <FormsInputBasic 
                    :value.sync="formData.hgKanaMei" 
                    placeholder="イチロウハハ" 
                    :requiredCheck="true" 
                    :leftSharp="true" 
                    @input-end="formData.hgKanaMei = $toKana(formData.hgKanaMei)"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>

          <!-- 住所 -->
          <FormsFormTitleSm label="住所" :required="true" />
          <v-chip class="mb-3" color="teal lighten-2" dark @click="formData.hgAddr = formData.ptAddr; formData.hgAddrBldg = formData.ptAddrBldg; ">受給者と同じ</v-chip>
          <v-row>
            <v-col cols="12" sm="5" class="pr-0">  <!-- 住所 -->
              <FormsInputBasic :value.sync="formData.hgAddr" placeholder="市・町名・番地（xx市橘通西1丁目1番1号）" :requiredCheck="true" :rightSharp="true" />
            </v-col>
            <v-col cols="12" sm="7" class="pl-0">  <!-- 方書 -->
              <FormsInputBasic :value.sync="formData.hgAddrBldg" placeholder="アパート・マンションなど（xxマンション101号）" :leftSharp="true" />
            </v-col>
          </v-row>

          <!-- 続柄 -->
          <FormsFormTitleSm label="続柄" />
          <v-row>
            <v-col cols="12" sm="6">
              <FormsSelect
                :select.sync="formData.hgTuzukigara"
                placeholder="母"
                :items="$COMMON.TUZUKIGARA_1"
                :searchInput="false"
              />
            </v-col>
          </v-row>
        </div>
      </v-expand-transition>

      <!-- ////////// 保険 ////////// -->
      <FormsFormTitleLg label="保険" />
      <div class="hoken-type mb-15">
        <p class="teal--text text--darken-3 font-weight-bold">保険種別</p>
        <v-radio-group
          v-model="formData.hokenType"
        >
          <v-radio 
            v-for="item in $COMMON.HOKEN_TYPE"
            :key="item.val" 
            :label="item.label"
            :value="item.val"
            color="teal"
          ></v-radio>
        </v-radio-group>
      </div>

      <!-- 保険者 -->
      <v-expand-transition>
        <div v-if="formData.hokenType && formData.hokenType != '11'">  <!-- 保険選択時 & 生保(受給中)以外 --> 
          <FormsFormTitleMd label="保険者" :required="true" />
          <FormsCaution label="一覧にない場合は、お問合せください。" class="mb-3"/>
          <FormsSelectHokenja 
            :select.sync="formData.hokenja" 
            :items="insurances"
            :requiredCheck="true"
            class="mb-4"
          />

          <!-- 保険記号番号 -->
          <FormsFormTitleMd label="保険記号番号" />
          <v-row class="mb-3">
            <v-col cols="12" sm="6">
              <FormsFormTitleSm label="保険記号" />
              <FormsInputBasic :value.sync="formData.hokenKigo" placeholder="記号" />
            </v-col>
            <v-col cols="12" sm="6">
              <FormsFormTitleSm label="保険番号" />
              <FormsInputBasic :value.sync="formData.hokenBango" placeholder="番号" />
            </v-col>
          </v-row>

          <v-expand-transition>
            <div v-if="formData.hokenType  == '02'">  <!-- 健保(家族) -->
              <!-- 被保険者居住地 -->
              <FormsFormTitleMd label="被保険者居住地" />
              <FormsRadio
                :items="$COMMON.IS_MIYAZAKI"
                :value.sync="formData.hihoIsMiyazaki"
              />
              <v-expand-transition>
                <div v-if="formData.hihoIsMiyazaki == 0" >
                  <FormsFormTitleSm label="市区町村" :required="true" />
                  <FormsInputBasic :value.sync="formData.hihoCity" placeholder="xx県都城市" :requiredCheck="true" />
                </div>
              </v-expand-transition>

              <!-- 被保険者 -->
              <FormsFormTitleMd label="被保険者" />
              <v-row>
                <v-col cols="12" sm="6">
                  <FormsFormTitleSm label="被保険者名（漢字）" :required="true"/>
                  <v-row>
                    <v-col cols="6" class="pr-0">
                      <FormsInputBasic :value.sync="formData.hihoNameSei" placeholder="xx" :requiredCheck="true" :rightSharp="true" />
                    </v-col>
                    <v-col cols="6" class="pl-0">
                      <FormsInputBasic :value.sync="formData.hihoNameMei" placeholder="一郎父" :requiredCheck="true" :leftSharp="true" />
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" sm="6">
                  <FormsFormTitleSm label="被保険者名（カナ）" />
                  <v-row>
                    <v-col cols="6" class="pr-0">
                      <FormsInputBasic 
                        :value.sync="formData.hihoKanaSei" 
                        placeholder="ミヤザキ" 
                        :rightSharp="true"  
                        @input-end="formData.hihoKanaSei = $toKana(formData.hihoKanaSei)"
                      />
                    </v-col>
                    <v-col cols="6" class="pl-0">
                      <FormsInputBasic 
                        :value.sync="formData.hihoKanaMei" 
                        placeholder="イチロウチチ" 
                        :leftSharp="true"  
                        @input-end="formData.hihoKanaMei = $toKana(formData.hihoKanaMei)"
                      />
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>

              <!-- 被保険者生年月日 -->
              <FormsFormTitleSm label="生年月日" :required="true" />
              <v-row>
                <v-col cols="6" class="pr-0">
                  <FormsSelectWarekiYear
                    :select.sync="formData.hihoBdayY"
                    :placeholder="$WAREKI_TODAY.WS_YEAR"
                    :items="$SEIREKI_WAREKI.YEAR"
                    :rightSharp="true"
                    :requiredCheck="true"
                  />
                </v-col>
                <v-col cols="3" class="px-0">
                  <FormsSelect
                    :select.sync="formData.hihoBdayM"
                    :placeholder="$WAREKI_TODAY.MONTH"
                    :items="$SEIREKI_WAREKI.MONTH"
                    :leftSharp="true"
                    :rightSharp="true"
                    :searchInput="false"
                    :requiredCheck="true"
                  />
                </v-col>
                <v-col cols="3" class="pl-0">
                  <FormsSelect
                    :select.sync="formData.hihoBdayD"
                    :placeholder="$WAREKI_TODAY.DAY"
                    :items="$SEIREKI_WAREKI.DAY"
                    :leftSharp="true"
                    :requiredCheck="true"
                    :searchInput="false"
                    :forceErr="isDateHiho"
                    errMsg="存在しない日付です"
                  />
                </v-col>
              </v-row>
            </div>
          </v-expand-transition>
        </div>
      </v-expand-transition>

      <!-- ////////// 医療機関 ////////// -->
      <FormsFormTitleLg label="医療機関" />
      <FormsFormTitleSm label="病院1" />
      <FormsSelectIryoKikan 
        :select.sync="formData.hospital1" 
        :items="hospitals.filter(i => i.type == 1)" 
        :requiredCheck="true" 
        :addBookmarkIcon="true"
        :bookmarks="bookmarks.length ? bookmarks.filter(i => i.type == 1) : []"
        @addBookmark="addBookmark('hospital1')"
        @deleteBookmarks="deleteBookmark"
        
      />
      <FormsFormTitleSm label="薬局" />
      <FormsSelectIryoKikan 
        :select.sync="formData.yakkyoku" 
        :items="hospitals.filter(i => i.type == 3)"  
        :addBookmarkIcon="true"
        :bookmarks="bookmarks.length ? bookmarks.filter(i => i.type == 3) : []"
        @addBookmark="addBookmark('yakkyoku')"
        @deleteBookmarks="deleteBookmark"
      />
      <FormsFormTitleSm label="訪問看護" />
      <FormsSelectIryoKikan 
        :select.sync="formData.houkan" 
        :items="hospitals.filter(i => i.type == 5)"  
        :addBookmarkIcon="true"
        :bookmarks="bookmarks.length ? bookmarks.filter(i => i.type == 5) : []"
        @addBookmark="addBookmark('houkan')"
        @deleteBookmarks="deleteBookmark"
      />
      <FormsFormTitleSm label="病院2" />
      <FormsSelectIryoKikan 
        :select.sync="formData.hospital2" 
        :items="hospitals.filter(i => i.type == 1)"  
        :addBookmarkIcon="true"
        :bookmarks="bookmarks.length ? bookmarks.filter(i => i.type == 1) : []"
        @addBookmark="addBookmark('hospital2')"
        @deleteBookmarks="deleteBookmark"
      />

      <v-row class="mb-10 mt-6">
        <!-- 戻るボタン -->
        <v-col cols="2" sm="2">
          <FormsPrevButton @click="$setStep(0)" />
        </v-col>
        
        <v-col cols="8" sm="7" align="center">
          <!-- 入力履歴保存ボタン -->
          <v-chip :disabled="!valid" color="teal" :dark="valid" label outlined large @click="savePatient" class="mr-3">
            <v-icon>mdi-content-save-edit</v-icon>
            入力履歴保存
          </v-chip>
          <!-- 次ページ遷移ボタン -->
          <v-btn :disabled="!valid" color="teal" :dark="valid" x-large @click="nextPage" class="px-10 font-weight-bold text-h6">申請書選択へ
            <v-icon class="ml-1">mdi-arrow-right-circle</v-icon>
          </v-btn>
        </v-col>

        <!-- 項目クリアボタンと警告ダイアログ -->
        <v-col cols="2" sm="3" align="right">
          <template>
            <div class="text-end">
              <v-dialog v-model="dialog" width="500">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn x-large v-bind="attrs" v-on="on">
                    項目クリア
                    <v-icon color="grey darken-2">mdi-trash-can-outline</v-icon>
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="text-h5 orange lighten-3">
                    <v-icon color="black" class="mr-1">mdi-alert</v-icon>
                    注意
                  </v-card-title>
                  <v-card-text class="mt-5 text-h6">
                    入力内容をすべて削除しますか？
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn 
                      color="primary" dark width="100"
                      @click="$refs.form.reset(), dialog = false">
                      はい
                    </v-btn>
                    <v-btn
                      color="grey" dark width="100"
                      @click="dialog = false">
                      いいえ
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </div>
          </template>
        </v-col>
      </v-row>

    </v-form>

    <!-- 入力履歴検索エラーメッセージ -->
    <FormsSnackbar :show.sync="showSBar" :msg="sBarMsg" :isError="sBarErr"/>

    <!-- 復号化ダイアログ -->
    <DecodeDialog
      @okBtn="decodeCompleted"
      :encoded="patientEncoded"
      :show.sync="showDecodeDialog"
    >
    </DecodeDialog>

    <!-- 暗号化ダイアログ / localstorage保存 -->
    <EncodeDialog
      :show.sync="showEncodeDialog"
      :formData="formData"
    >
    </EncodeDialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      valid: true,
      formData: {},
      showSBar: false,
      sBarMsg: null,
      sBarErr: true,
      patientEncoded: null,
      showDecodeDialog: false,  // 複合化ダイアログ
      showEncodeDialog: false,  // 暗号化ダイアログ
      dialog: false, //ダイアログを閉じる
      hospitals: [],
      insurances: [],
      bookmarks: []
    };
  },
  mounted() {
    this.$initCheck(this.$route.path);  // 直リンクチェック
    
    this.formData = this.$store.getters.getPatient;
    this.bookmarks = this.$store.getters.getBookmarks;  // お気に入り医療機関
    this.$refs.form.resetValidation();
  },
  async fetch() {
    this.hospitals = await fetch(
      '/api/hospitals'
    ).then(res => res.json()).catch((err) => {console.log(err); return [];})

    this.insurances = await fetch(
      '/api/insurances'
    ).then(res => res.json()).catch((err) => {console.log(err); return [];})
  },
  fetchOnServer: false,
  computed: {
    // 日付妥当性
    isDate: function() {
      if (!(this.formData.ptBdayY
        && this.formData.ptBdayM
        && this.formData.ptBdayD)) {
        return true;
      }
      return this.$isDate(this.formData.ptBdayY, this.formData.ptBdayM, this.formData.ptBdayD);
    },
    isDateHiho: function() {
      if (!(this.formData.hihoBdayY
        && this.formData.hihoBdayM
        && this.formData.hihoBdayD)) {
        return true;
      }
      return this.$isDate(this.formData.hihoBdayY, this.formData.hihoBdayM, this.formData.hihoBdayD);
    },
  },
  methods: {
    // 本人住所=>保護者住所
    copyAddr() {
      this.formData.hgAddr = this.formData.ptAddr;
      this.formData.hgAddrBldg = this.formData.ptAddrBldg;
    },
    // 次へボタン
    nextPage() {
      if (this.$refs.form.validate()) {
        if (!this.formData.under18) {  // 18歳以下オフの場合
          this.formData.hgNameSei = null;
          this.formData.hgNameMei = null;
          this.formData.hgKanaSei = null;
          this.formData.hgKanaMei = null;
          this.formData.hgAddr = null;
          this.formData.hgAddrBldg = null;
          this.formData.hgTuzukigara = null;
        }
        if (!(this.formData.hokenType && this.formData.hokenType != '11')) {  // 保険非選択時 or 生保(受給中)
          this.formData.hokenja = null;
          this.formData.hokenKigo = null;
          this.formData.hokenBango = null;
          this.formData.hihoIsMiyazaki = null;
          this.formData.hihoCity = null;
          this.formData.hihoNameSei = null;
          this.formData.hihoNameMei = null;
          this.formData.hihoKanaSei = null;
          this.formData.hihoKanaMei = null;
          this.formData.hihoBdayY = null;
          this.formData.hihoBdayM = null;
          this.formData.hihoBdayD = null;
        }
        if (this.formData.hihoIsMiyazaki) {  // 被保険者居住地 xx市外の場合
          this.formData.hihoCity = null;
        }
        if (this.formData.hokenType != '02') {  // 健保(家族)以外
          this.formData.hihoIsMiyazaki = null;
          this.formData.hihoCity = null;
          this.formData.hihoNameSei = null;
          this.formData.hihoNameMei = null;
          this.formData.hihoKanaSei = null;
          this.formData.hihoKanaMei = null;
          this.formData.hihoBdayY = null;
          this.formData.hihoBdayM = null;
          this.formData.hihoBdayD = null;
        }

        // 最新の保険者・医療機関情報を取得
        this.formData.hokenja = this.formData.hokenja ? this.insurances.find(item => item.code == this.formData.hokenja.code) : null;
        this.formData.hospital1 = this.formData.hospital1 ? this.hospitals.find(item => item.code == this.formData.hospital1.code) : null;
        this.formData.yakkyoku = this.formData.yakkyoku ? this.hospitals.find(item => item.code == this.formData.yakkyoku.code) : null;
        this.formData.houkan = this.formData.houkan ? this.hospitals.find(item => item.code == this.formData.houkan.code) : null;
        this.formData.hospital2 = this.formData.hospital2 ? this.hospitals.find(item => item.code == this.formData.hospital2.code) : null;

        this.$store.commit('setPatient', this.formData); // sessionStorage保存
        this.$setStep(2);
      }
    },
    
    // 入力履歴保存
    savePatient() {
      if (!this.$refs.form.validate()) {
        return false;
      }
      if (!this.formData.jyukyusyaNo) {
        this.sBarMsg = "受給者番号を入力してください。";
        this.showSBar = true; // 入力履歴なしメッセージ表示
        this.sBarErr = true;
        return false;
      }
      this.showEncodeDialog = true; // 暗号化ダイアログ
    },

    // 入力履歴検索ボタン処理
    searchRireki() {
      if (!this.formData.jyukyusyaNo) {
        this.sBarMsg = "受給者番号を入力してください。";
        this.showSBar = true; // 入力履歴なしメッセージ表示
        this.sBarErr = true;
        return;
      }
      const patient = this.$store.state.patients[this.formData.jyukyusyaNo]; // 受給者番号で検索
      if (patient) {
        this.patientEncoded = patient;
        this.showDecodeDialog = true; // 復号化ダイアログ
      }
      else {
        this.sBarMsg = "入力履歴はありません";
        this.showSBar = true; // 入力履歴なしメッセージ表示
        this.sBarErr = true;
      }
    },

    // 復号化ダイアログOK処理
    decodeCompleted(decoded) {
      for (const key in this.formData) {
          this.formData[key] = decoded[key];
      }
    },

    // お気に入り医療機関 追加
    addBookmark(type) {
      if (this.bookmarks.filter(item => item.val == this.formData[type].code).length == 0) {
        this.bookmarks.push({
          val: this.formData[type].code, 
          label: this.formData[type].name, 
          type: this.formData[type].type, 
        })
        this.$store.commit('setBookmarks', this.bookmarks);

        this.sBarMsg = "お気に入りに登録しました";
        this.showSBar = true;
        this.sBarErr = false;
      }
    },

    // お気に入り医療機関 削除
    deleteBookmark(type, code) {
      for (let index = 0; index < this.bookmarks.length; index++) {
        if (this.bookmarks[index].val == code && this.bookmarks[index].type == type) {
          this.bookmarks.splice(index, 1)
        }
      }
      this.$store.commit('setBookmarks', this.bookmarks);
    },
  },
}
</script>

<style lang="scss" scoped>
.hoken-type {
  background: #f8f8f8;
  padding: 1em 2em;
  p {
    border-bottom: 1px solid #707070;
  }
}
.rireki-search {
  top: -16px;
  border-radius: 10px;
}

.hozonBtn {
  vertical-align: bottom;
}

.theme--dark.v-btn--active::before {
  opacity: 0.55;
  color: white !important;

  border: 5px solid rgb(51, 118, 106);
}

</style>
