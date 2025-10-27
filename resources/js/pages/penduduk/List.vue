<script setup lang="ts">
import { create, list } from '@/routes/penduduk'
import { exportDataIndukPadukuhan, exportDataIndukPenduduk, exportExcel, exportPdf } from '@/routes';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps(['data', 'queryParams'])

const columns = [
   'nomor KK',
   'nama_lengkap',
   'nik',
   'Jenis_kelamin',
   'tempat_lahir',
   'tanggal_lahir',
   'agama',
   'pendidikan',
   'jenis_pekerjaan',
   'golongan_darah',
   'status_perkawinan',
   'tanggal_perkawinan',
   'status_hubungan_keluarga',
   'kewarganegaraan',
   'no_paspor',
   'no_kitap',
   'nama_ayah',
   'nama_ibu'
]
const query = reactive({
   search: props.queryParams?.search || ''
})

const searchData = () => {
   router.visit(list({ query: query }))
}
</script>

<template>

   <AppHeader title="Data Penduduk">

      <div class="flex q-gutter-sm">
         <q-btn-dropdown label="Export Data" color="teal">
            <q-list separator>
               <q-item color="teal" :href="exportExcel().url" target="_blank">ALL DATA (EXCEL)</q-item>
               <q-item color="teal" :href="exportDataIndukPadukuhan().url" target="_blank">DATA INDUK PADUKUHAN (PDF)</q-item>
               <q-item color="teal" :href="exportDataIndukPenduduk().url" target="_blank">DATA INDUK PENDUDUK (PDF)</q-item>
            </q-list>
         </q-btn-dropdown>
         <!-- <q-btn color="primary" @click="router.visit(create())">Tambah Data</q-btn>
         <q-btn color="teal" :href="exportExcel().url" target="_blank">Export Excel</q-btn>
         <q-btn color="teal" :href="exportPdf().url" target="_blank">Export PDF</q-btn> -->
      </div>
   </AppHeader>

   <q-card class="section">
      <q-card-section>

         <q-input dense outlined placeholder="Ketik NIK, KK atau Nama" class="q-mb-sm" v-model="query.search"
            label="Search" @keydown.enter.prevent="searchData" clearable @clear="router.visit(list())">
            <template v-slot:append>
               <q-btn size="11px" :disable="!query.search" color="dark" icon="search" flat dense
                  @click="searchData"></q-btn>
               <!-- <q-btn size="11px" color="red" label="Reset" @click="router.visit(list())"></q-btn> -->
            </template>
         </q-input>
         <!-- <AppPagination v-bind="data"></AppPagination> -->
         <div class="table-responsive">

            <table class="table bordered">
               <thead>
                  <tr>
                     <th class="text-left">#</th>
                     <th class="text-left uppercase" v-for="(item, i) in columns" :key="i">{{ item.split('_').join(' ')
                        }}</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="(item, idx) in data.data" :key="idx">
                     <td>{{ 1 + idx }}</td>
                     <td v-for="(val, key) in item" :key="key" style="min-width:100px">{{ val }}</td>
                  </tr>
               </tbody>
            </table>

         </div>

         <AppPagination v-bind="data"></AppPagination>

      </q-card-section>

   </q-card>

</template>
