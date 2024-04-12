<template>
  <div class="mb-5 mt-15 px-0">
    <FormsPrevButton @click="$emit('prev-step')" />  <!-- 戻るボタン -->
    <v-btn
      :disabled="!showValid"
      color="teal"
      :dark="showValid"
      x-large
      @click="$emit('preview')"
      class="rounded-lg d-flex mx-auto px-15 py-8 mt-n16 text-h6"
    >
      申請書プレビュー
      <v-icon class="ml-1">mdi-file-document-check-outline</v-icon>
    </v-btn>
  </div>
</template>

<script>
export default {
  props: ['showValid'],
}
</script>
