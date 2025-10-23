<template>

  <q-layout view="lHh LpR fFf">

    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          {{ title }}
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container>
     <q-page padding class="flex flex-center">
      <slot />
     </q-page>
    </q-page-container>

  </q-layout>
</template>

<script setup lang="ts">

defineProps<{
  title?: string;
  description?: string;
}>();

</script>