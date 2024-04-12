import crypto from 'crypto-js';

export default ({ app, store }, inject) => {

  const page = () => {
    switch (store.getters.getStep) {
      case 0:
        return "/";
      case 1:
        return "/Patient";
      case 2:
        return "/Documents";
      case 3:
        return "/DocumentForm";
      case 4:
        return "/DocumentPreview";
      default:
        return "/";
    }
  }

  // step移動
  inject('setStep',(step) => {
    store.commit('setStep', step)
    app.router.push(page());
  })

  // 暗号化
  inject('encode',(text, key) => {
    if (typeof text === "object") {
      text = JSON.stringify(text)
    }
    return crypto.AES.encrypt(text, key).toString();
  })

  // 復号化
  inject('decode',(encrypted, key, jsonParse) => {
    try {
      let decoded = crypto.AES.decrypt(encrypted, key).toString(crypto.enc.Utf8);
      if (jsonParse) {
        decoded = JSON.parse(decoded)
      }
      return decoded
    } catch (error) {
      return false;
    }
  })

  // 患者情報localStorage保存
  inject('setPatients', (jyukyusyaNo, val) => {
    store.commit("setPatients", {key: jyukyusyaNo, val: val})
  })

  // 医療機関取得
  inject('getIryoKikan', (code) => {
    if (!code) {
      return null
    }
    return fetch(
      `/api/hospital/code/${code}`
    )
    .then(res => {return res.json()})
    .catch(
      (err) => {
        console.log(err);
        return null;
      }
    )
  })

  // 保険者取得
  inject('getHokenja', (code) => {
    if (!code) {
      return null
    }
    return fetch(
      `/api/insurance/code/${code}`
    )
    .then(res => {return res.json()})
    .catch(
      (err) => {
        console.log(err);
        return null;
      }
    )
  })

  // SVG形式QRコード生成
  inject('svgQRCode', (data, size="300") => {

    const binData = [];
    const binIndex = [];
    for (const [i, value] of data.entries()) {
      if( String(value).match(/[^\x01-\x7E]/) ){  // 日本語含む場合
        value = Buffer.from(value).toString('base64');  // バイナリ化
        binIndex.push(i)  // バイナリ項目index
      }
      binData[i] = value;
    }

    const qrObj = {
      v: binData.join(","),     // データ部
      b: binIndex.join(",")  // バイナリ項目index
    }
    const qrTxt = JSON.stringify(qrObj);  // オブジェクト => 文字列

    const QRCode = require('qrcode');
    const options = {
      type: 'svg',
      width: size,
    };
    
    let svg = null;
    const test = QRCode.toString(qrTxt, options, function (err, str) {
      svg = str;
    });

    if (!store.getters.isProd) {
      // ////////// Debug //////////
      console.log('■■■■■■ ↓↓↓ QRCode Debug ↓↓↓ ■■■■■');
      console.log(data);
      console.log(qrTxt);
      console.log('■■■■■ ↑↑↑ QRCode Debug ↑↑↑ ■■■■■');
      // ////////// Debug //////////
    }

    return svg;
  })

  // 有効期限切れチェック
  const isExpired = (y, m, exp) => {
    if (!y || !m) {
      return false;
    }
    const expYM = String(exp.getFullYear()) + String(exp.getMonth() + 1).padStart(2, '0');
    const ym = String(y) + String(m).padStart(2, '0');
    return ym < expYM;
  }

  // 有効期限切れチェック
  inject('isExpired', (y, m, exp = new Date()) => {
    return isExpired(y, m, exp);
  })

  // 自立支援（精神） 有効期限切れチェック
  inject('isExpiredIryo', (exp = new Date()) => {
    const patient = store.getters.getPatient;
    return isExpired(patient.iryoExpY, patient.iryoExpM, exp)
  })

  // 精神手帳 有効期限切れチェック
  inject('isExpiredTecho', (exp = new Date()) => {
    const patient = store.getters.getPatient;
    return isExpired(patient.techoExpY, patient.techoExpM, exp)
  })

  // 日付妥当性チェック
  inject('isDate', (y, m, d) => {
    const dt = new Date(y, m-1, d);
    if (isNaN(dt) || dt.getMonth() + 1 != m) {
      return false;
    }
    return true;
  })

  // 西暦 => 和暦変換
  inject('cnvWareki', (y, m, d, short=true, kugiri=".") => {
    return cnvWareki(y, m, d, short, kugiri);
  })

  // 西暦 => 和暦変換
  inject('cnvWarekiYmd', (date, short=true, kugiri=".") => {
    const arrayDate = String(date).split("-");
    return cnvWareki(arrayDate[0], arrayDate[1], arrayDate[2], short, kugiri);
  })

  // 今日日付 和暦
  inject('today', (short=true, kugiri=".") => {
    const dt = new Date();
    return cnvWareki(dt.getFullYear(), dt.getMonth()+1, dt.getDate(), short, kugiri)
  })

  // 西暦 => 和暦変換
  const cnvWareki = (y, m, d, short=true, kugiri=".") => {
    const dt = new Date(y, m-1, d);

    let wareki = null;

    if (short) {
      wareki = [gengo(dt, short), m, d].join(kugiri);
    } else {
      wareki = gengo(dt, short)+"年" + m+"月" + d+"日";
    }

    return wareki;
  }

  // 西暦年 => 和暦年
  const gengo = (dt, short) => {
    let g = null;
    let ggg = null;
    let y = dt.getFullYear();

    switch (true) {
      case (new Date(1868, 10, 23) <= dt && dt <= new Date(1912, 7, 29)):
        g = 'M';
        ggg = '明治';
        y = (y + 33) % 100;
        break;
      case (new Date(1912, 7, 30) <= dt && dt <= new Date(1926, 12, 24)):
        g = 'T';
        ggg = '大正';
        y = (y - 11) % 100;
        break;
      case (new Date(1926, 12, 25) <= dt && dt <= new Date(1989, 1, 7)):
        g = 'S';
        ggg = '昭和';
        y = (y - 25) % 100;
        break;
      case (new Date(1989, 1, 8) <= dt && dt <= new Date(2019, 4, 30)):
        g = 'H';
        ggg = '平成';
        y = (y + 12) % 100;
        break;
      case (new Date(2019, 5, 1) <= dt):
        g = 'R';
        ggg = '令和';
        y = (y - 18) % 100;
        break;
    }

    if (y == 1 && !short) {
      y = "元";
    }

    return short ? g+y : ggg+y;
  }

  // constantsのlabel取得
  inject('getLabel', (items, val) => {
    const item = items.find((item) => item.val == val);
    if (item) {
      return item.label;
    } else {
      return null;
    }
  })

  const joinArray = (items = []) => {
    items.map((item, i, array) => array[i] = item == null ? '' : item);
    return items.join('　');
  }

  // 患者氏名
  inject('getPtName', () => {
    return joinArray([
      store.getters.getPatient.ptNameSei,
      store.getters.getPatient.ptNameMei
    ]);
  })

  // 患者氏名カナ
  inject('getPtKana', () => {
    return joinArray([
      store.getters.getPatient.ptKanaSei,
      store.getters.getPatient.ptKanaMei
    ]);
  })

  // 患者住所
  inject('getPtAddr', () => {
    return joinArray([
      store.getters.getPatient.ptAddr,
      store.getters.getPatient.ptAddrBldg
    ]);
  })

  // 患者生年月日
  inject('getPtBday', (short=true) => {
    const patient = store.getters.getPatient;
    return patient.ptBdayY ? cnvWareki(patient.ptBdayY, patient.ptBdayM, patient.ptBdayD, short) : '';
  })

  //患者生年月日(西暦)
  inject('getPtBdaySeireki' , () => {
    const patient = store.getters.getPatient;
    return [
      patient.ptBdayY, 
      String(patient.ptBdayM).padStart(2, "0"), 
      String(patient.ptBdayD).padStart(2, "0")
    ].join("-")
  })

  // 患者電話番号
  inject('getPtTel', () => {
    const patient = store.getters.getPatient;
    let tel = [
      patient.ptTel_1st,
      patient.ptTel_2nd,
      patient.ptTel_3rd,
    ].join("-");

    tel = tel.replace('--', '-');
    tel = tel.slice(0, 1) == '-' ? tel.slice(1) : tel;
    tel = tel.slice(-1) == '-' ?tel.slice(0, -1) : tel;

    return tel;
  })

  // 保護者氏名
  inject('getHgName', () => {
    return joinArray([
      store.getters.getPatient.hgNameSei,
      store.getters.getPatient.hgNameMei
    ]);
  })

  // 保護者氏名カナ
  inject('getHgKana', () => {
    return joinArray([
      store.getters.getPatient.hgKanaSei,
      store.getters.getPatient.hgKanaMei
    ]);
  })

  // 保護者住所
  inject('getHgAddr', () => {
    return joinArray([
      store.getters.getPatient.hgAddr,
      store.getters.getPatient.hgAddrBldg
    ]);
  })

  // 被保険者氏名
  inject('getHihoName', () => {
    return joinArray([
      store.getters.getPatient.hihoNameSei,
      store.getters.getPatient.hihoNameMei
    ]);
  })

  // 被保険者氏名カナ
  inject('getHihoKana', () => {
    return joinArray([
      store.getters.getPatient.hihoKanaSei,
      store.getters.getPatient.hihoKanaMei
    ]);
  })

  // 被保険者生年月日
  inject('getHihoBday', (short=true) => {
    const patient = store.getters.getPatient;
    return patient.hihoBdayY ? cnvWareki(patient.hihoBdayY, patient.hihoBdayM, patient.hihoBdayD, short) : null;
  })

  //被保険者生年月日(西暦)
  inject('getHihoBdaySeireki' , () => {
    const patient = store.getters.getPatient;
    if (!patient.hihoBdayY || !patient.hihoBdayM || patient.hihoBdayD) {
      return null;
    }
    return [
      patient.hihoBdayY, 
      String(patient.hihoBdayM).padStart(2, "0"), 
      String(patient.hihoBdayD).padStart(2, "0")
    ].join("-")
  })

  // 保険記号番号
  inject('getHokenKigoBango', () => {
    const patient = store.getters.getPatient;


    let kigoBango = [
      patient.hokenKigo,
      patient.hokenBango,
    ].join("-");

    kigoBango = kigoBango.slice(0, 1) == '-' ? kigoBango.slice(1) : kigoBango;
    kigoBango = kigoBango.slice(-1) == '-' ? kigoBango.slice(0, -1) : kigoBango;

    return kigoBango;
  })

  // 精神手帳 有効期限
  inject('getTechoExp', (seireki=true) => {
    return [
      seireki ? store.getters.getPatient.techoExpY : gengo(new Date(store.getters.getPatient.techoExpY, store.getters.getPatient.techoExpM, 0)),
      '年',
      store.getters.getPatient.techoExpM,
      '月'
    ].join('');
  })

  // 自立支援精神 有効期限
  inject('getIryoExp', (seireki=true) => {
    return [
      seireki ? store.getters.getPatient.iryoExpY : gengo(new Date(store.getters.getPatient.iryoExpY, store.getters.getPatient.iryoExpM, 0)),
      '年',
      store.getters.getPatient.iryoExpM,
      '月'
    ].join('');
  })

  // 医療機関
  inject('getUserIryoKikan', (item) => {
    return store.getters.getIryoKikan[item];
  })
  
  // 保険者
  inject('getHokenja', (item) => {
    return store.getters.getPatient.hokenja ? store.getters.getPatient.hokenja[item] : null;
  })

  // 病院1
  inject('getHospital1', (item) => {
    return store.getters.getPatient.hospital1 ? store.getters.getPatient.hospital1[item] : null;
  })

  // 薬局
  inject('getYakkyoku', (item) => {
    return store.getters.getPatient.yakkyoku ? store.getters.getPatient.yakkyoku[item] : null;
  })

  // 訪問看護
  inject('getHoukan', (item) => {
    return store.getters.getPatient.houkan ? store.getters.getPatient.houkan[item] : null;
  })

  // 病院2
  inject('getHospital2', (item) => {
    return store.getters.getPatient.hospital2 ? store.getters.getPatient.hospital2[item] : null;
  })

  // QRコード送付先区分・送付先名前
  inject('getQrSofusaki', (formData, type) => {
    switch (type) {
      case 'kbn':
        return formData.sofusakiKbn ? formData.sofusakiKbn : null;
        break;
      case 'sofusaki':
        return formData.sofusakiKbn == 1 ? formData.sofusakiIryoKikan : '';
        break;
      default:
        return null;
        break;
    }
  })

  // QRコード受付者
  inject('getQrVisitor', () => {
    return store.getters.getIryoKikan.name;
  })

  // 年齢計算
  const age = (year, month, day, jiten = new Date()) => {
    let age = 0;

    // 生年月日 年月
    let bMonth = month.toString().padStart(2, "0");
    let bDay = day.toString().padStart(2, "0");
    let bMonthDay = Number(bMonth + bDay);
    
    // 時点 年月
    let jMonth = jiten.getMonth().toString().padStart(2, "0");
    let jDay = jiten.getDate().toString().padStart(2, "0") ;
    let jMonthDay = Number(jMonth + jDay) ;
    
    
    if (bMonthDay <= jMonthDay) {
      age = jiten.getFullYear() - year;
    } else {
      age = (jiten.getFullYear() - year) - 1;  // 時点で誕生日を迎えてない場合
    }

    return age;
  }

  // 患者年齢
  inject('getPtAge', (jiten = new Date()) => {
    return age(
      store.getters.getPatient.ptBdayY,
      store.getters.getPatient.ptBdayM,
      store.getters.getPatient.ptBdayD,
      jiten
    );
  })

  inject('age', (year, month, day, jiten = new Date()) => {
    return age(year, month, day, jiten);
  })

  // 帳票項目 幅調整
  inject('wAdjustAttr', (text, max) => {
    
    const width = String(text).length * 40;

    if (width > max) {
      return {textLength: max, lengthAdjust: "spacingAndGlyphs"};
    } else {
      return;
    }
  })

  // 配列同士の比較
  inject('aryInAry', (ary1, ary2) => {
    return ary1.filter(item => ary2.includes(item)).length ? true : false
  })

  // 直リンクチェック
  inject('initCheck', (route) => {
    // 申請者情報 医療機関必須
    if (route == "/Patient" && store.getters.getIryoKikan == null) {
      store.commit('setStep', 0);
      return app.router.push('/');
    }

    // 申請書選択 申請者情報必須
    if (route == "/Documents" && store.getters.getPatient.ptNameSei == null) {
      store.commit('setStep', 1);
      return app.router.push('/Patient');
    }

    // 申請内容 申請書ID必須
    if (route == "/DocumentForm" && store.getters.getDocumentId == null) {
      store.commit('setStep', 2);
      return app.router.push('/Documents');
    }

    // 申請書 申請内容必須
    if (route == "/DocumentPreview") {

      const docId = store.getters.getDocumentId;
      if (docId == null) {
        store.commit('setStep', 2);
        return app.router.push('/Documents');
      }

      if (docId == 'SJ101') {
        if (store.getters.getSj101.konkaiSinsei.length == 0) {
          store.commit('setStep', 3);
          return app.router.push('/DocumentForm');
        } else {
          return;
        }
      }

      const requiredItem = {
        MD101: {getters :"getMd101", item: "sofusakiKbn"},
        MD102: {getters :"getMd102", item: "sofusakiKbn"},
        MD104: {getters :"getMd104", item: "sstc_henkanriyu_kbn_key"},
        MJ1011: {getters :"getMj101", item: "sofusakiKbn"},
        MJ1012: {getters :"getMj101", item: "sofusakiKbn"},
        MJ1013: {getters :"getMj101", item: "sofusakiKbn"},
        MJ104: {getters :"getMj104", item: "sofusakiKbn"},
        MJ102: {getters :"getMj102", item: "sofusakiKbn"},
        MJ107: {getters :"getMj107", item: "ssti_henkanriyu_kbn_key"},
      }[docId]
      
      if (store.getters[requiredItem.getters][requiredItem.item] == null) {
        store.commit('setStep', 3);
        return app.router.push('/DocumentForm');
      }
    }
  })

  inject('toKana', (text) => {
    if (!text) {
      return null;
    }
    return text.replace(/[\u3041-\u3096]/g, match => 
      String.fromCharCode(match.charCodeAt(0) + 0x60)
    );

  })

  inject('aryToIndexItem', (ary, formData, item, length, reverse=false) => {
    for (let index = 1; index <= length; index++) {
      if (reverse) {
        // 個別 => 配列
        if (formData[item + index]) {
          ary.push(index);
        }
      } else {
        // 配列 => 個別
        if (ary.includes(index)) {
          formData[item + index] = '1';
        } else {
          formData[item + index] = '';
        }
      }
    }
  })

}
