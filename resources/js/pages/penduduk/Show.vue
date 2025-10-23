<script setup lang="ts">
import { createItem, editItem } from '@/routes/penduduk';
defineProps(['data', 'items', 'columns'])
</script>

<template>

   <AppHeader title="Penduduk">
      <q-btn color="primary" :href="createItem(data.id).url">Tambah Anggota</q-btn>

   </AppHeader>

   <q-card class="section">
      <q-card-section>

         <div>
            <div class="flex justify-end">

            </div>

            <table class="table">
               <tr>
                  <td>No Kartu Keluarga</td>
                  <td>{{ data.nomor }}</td>
               </tr>
               <tr>
                  <td>Kepala Keluarga</td>
                  <td>{{ data.kepala_keluarga }}</td>
               </tr>
            </table>

            <div class="table-responsive q-mt-lg">

               <table class="table">
                  <thead>
                     <tr>
                        <th class="text-left">#</th>
                        <th class="text-left uppercase" v-for="col in columns" :key="col">{{ col.split('_').join(' ') }}
                        </th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(item, idx) in items" :key="idx">
                        <td>{{ 1 + idx }}</td>
                        <td v-for="(key, i) in columns" :key="i">{{ item[key] }} </td>
                        <td>
                           <q-btn color="blue" class="btn-action"
                              :href="editItem({ id: data.id, itemId: item.id }).url">Edit</q-btn>
                        </td>
                     </tr>
                  </tbody>
               </table>


            </div>
            <div class="text-center py-4" v-if="!items.length">Tidak ada data</div>

         </div>

      </q-card-section>
   </q-card>

</template>
