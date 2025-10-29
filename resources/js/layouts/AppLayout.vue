<template>
  <q-layout view="hHh LpR fFf">

    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          {{ $page.props.name }}

        </q-toolbar-title>
        <q-btn icon="logout" flat round @click="router.visit(logout())">
          <q-tooltip>Logout</q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered :mini="mini" :width="210">
      <q-list class="q-py-md">
        <template v-for="(nav, idx) in navItems" :key="idx">
          <q-item clickable :href="nav.href.url" @click.prevent="handleClickMenu(nav.href)" v-if="guard(nav.ability)">
            <q-item-section side>
              <q-icon :name="nav.icon"></q-icon>
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ nav.title }}</q-item-label>
            </q-item-section>
            <q-tooltip v-if="mini" anchor="center right" self="center left" :offset="[10, 10]"
              class="bg-purple text-white">{{ nav.title }}</q-tooltip>

          </q-item>
        </template>
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
import users from '@/routes/users';
import { logout } from '@/routes';
import { useQuasar } from 'quasar';

import { guard } from '@/lib/utils';
import permissions from '@/routes/permissions';

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
    icon: 'dashboard',
    ability: 'All'
  },
  {
    title: 'Kartu Keluarga',
    href: penduduk.index(),
    icon: 'list_alt',
    ability: 'Read Penduduk'
  },
  {
    title: 'Data Penduduk',
    href: penduduk.list(),
    icon: 'account_box',
    ability: 'Read Penduduk'
  },
  {
    title: 'Kas',
    href: kas.index(),
    icon: 'account_balance',
    ability: 'Read Kas'
  },
  {
    title: 'Inventaris',
    href: inventaris.index(),
    icon: 'inventory',
    ability: 'Read Inventaris'
  },
  {
    title: 'Pengurus',
    href: pengurus.index(),
    icon: 'groups',
    ability: 'Read Pengurus'
  },
  {
    title: 'Users',
    href: users.index(),
    icon: 'account_circle',
    ability: 'Read User'
  },
  {
    title: 'Permissions',
    href: permissions.index(),
    icon: 'verified',
    ability: 'Read Permission'
  },
]


</script>