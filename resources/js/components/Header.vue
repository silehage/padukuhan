<template>

   <Head :title="title"></Head>

   <div class="page-header">
      <h1>{{ title }}</h1>
      <slot></slot>
   </div>

</template>


<script setup lang="ts">

import { Head } from '@inertiajs/vue3';

defineProps<{
  title?: string;
  description?: string;
}>();

</script>
