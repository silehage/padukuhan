<template>
  <q-layout view="hHh LpR fFf">

    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          Administrasi RT 05

        </q-toolbar-title>
        <q-btn icon="logout" flat round @click="router.visit(logout())">
          <q-tooltip>Logout</q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered :mini="mini" :width="210">
      <q-list class="q-py-md">
        <q-item clickable v-for="(nav, idx) in navItems" :key="idx" @click="handleClickMenu(nav.href)">
          <q-item-section side>
            <q-icon :name="nav.icon"></q-icon>
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ nav.title }}</q-item-label>
          </q-item-section>
          <q-tooltip v-if="mini" anchor="center right" self="center left" :offset="[10, 10]"
            class="bg-purple text-white">{{ nav.title }}</q-tooltip>

        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <q-page padding class="bg-grey-2">
        <slot />
      </q-page>
    </q-page-container>

  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { dashboard } from '@/routes';
import penduduk from '@/routes/penduduk';
import { router } from '@inertiajs/vue3';
import inventaris from '@/routes/inventaris';
import pengurus from '@/routes/pengurus';
import kas from '@/routes/kas';
import { logout } from '@/routes';
import { useQuasar } from 'quasar';

const $q = useQuasar()

defineProps<{
  title?: string;
  description?: string;
}>();
const leftDrawerOpen = ref(false)
const mini = ref(false)

const toggleLeftDrawer = () => {

  if ($q.platform.is.desktop) {
    leftDrawerOpen.value = true
    mini.value = !mini.value
  } else {
    leftDrawerOpen.value = !leftDrawerOpen.value
  }
}

const handleClickMenu = (href) => {
  if ($q.platform.is.mobile) {
    leftDrawerOpen.value = !leftDrawerOpen.value
  }
  router.visit(href)
}

const navItems = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: 'dashboard'
  },
  {
    title: 'Kartu Keluarga',
    href: penduduk.index(),
    icon: 'list_alt'
  },
  {
    title: 'Data Penduduk',
    href: penduduk.list(),
    icon: 'account_box'
  },
  {
    title: 'Kas',
    href: kas.index(),
    icon: 'account_balance'
  },
  {
    title: 'Inventaris',
    href: inventaris.index(),
    icon: 'inventory'
  },
  {
    title: 'Pengurus',
    href: pengurus.index(),
    icon: 'groups'
  },
]


</script>