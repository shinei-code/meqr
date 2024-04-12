<template>
  <div class="row me-15 mt-5">
    <div class="col-2 mt-3">
      <v-img :src="require('@/assets/images/logo-sm.png')" width="75%" class="mx-auto" alt="ロゴマーク"></v-img>
    </div>
    <div class="col-10">
      <h1 class="mb-2">ウェブサイトのご利用について</h1>
      当ウェブサイトを利用される際には、以下の各事項をご了承くださいますようお願い申し上げます。<br>
      また、状況に応じて当ウェブサイトのご利用条件を変更する事があります。その際には、当ページの改訂版を掲載いたしますので、最新の内容をご確認いただきますようお願い申し上げます。
      <div class="my-12">
        <h2>推奨する閲覧・動作環境</h2>
        <v-divider class="mb-2"></v-divider>
        当サイトは下記のウェブブラウザでの閲覧を対象として制作されています。<br>
        推奨ブラウザ以外でご利用された場合、正常に動作しないおそれがあります。
        <ul class="mt-2">
          <li>Microsoft Edge（最新版）</li>
          <li>Google Chrome（最新版）</li>
        </ul>
      </div>
      <div class="mb-12">
        <h2>利用技術について</h2>
        <v-divider class="mb-2"></v-divider>
        当サイトではSessionStorage（セッションストレージ）、およびLocalStorage（ローカルストレージ）を利用する場合があります。<br>
        これらは、ウェブサイトがウェブブラウザに文字と数字の小さなファイルを保存するための標準化された技術です。<br>
        <div class="mt-2">
          ※SessionStorageファイルはブラウザ（またはタブ）を閉じると、自動的に削除されます。<br>
          ※LocalStorageは、それらを保存したWebサイトがそれらを削除すると削除されます。<br>
          ※設定・削除の方法はご利用のブラウザのヘルプをご確認ください。
        </div>
      </div>
    </div>
  </div>
</template>