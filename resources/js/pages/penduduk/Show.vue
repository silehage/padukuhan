<script setup lang="ts">
import { createItem, editItem, searchkartuKeluarga, updateKartuKeluarga } from '@/routes/penduduk';
defineProps(['data', 'items', 'columns'])

import { guard } from '@/lib/utils';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
const module = 'Penduduk'
const can = (ability) => {
   return guard(`${ability} ${module}`)
}
const selectOptions = ref([])
const form = useForm({
   kartu_keluarga_id: '',
   penduduk_id: ''
})

const selected = ref(null)
const dialogModal = ref(false)
const handlePindahKK = (item) => {
   form.penduduk_id = item.id
   selected.value = item
   dialogModal.value = true
}

const filterFn = async (val, update) => {
   if (!val || val == '') {
      update(() => {
         selectOptions.value = []
      })
      return
   }

   const response = await fetch(searchkartuKeluarga(val).url)
   const result = await response.json()


   update(() => {
      selectOptions.value = result.map(el => ({ label: `${el.kepala_keluarga} - ${el.nomor}`, value: el.id }))
      // const needle = val.toLowerCase()
      // penduduk_options.value = props.penduduk.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
   })
}

const submitData = () => {
   form.post(updateKartuKeluarga().url, {
      onSuccess: () => {
         dialogModal.value = false
      }
   })
   
}
</script>

<template>

   <AppHeader title="Penduduk">
      <q-btn v-if="can('Create')" color="primary" :href="createItem(data.id).url">Tambah Anggota</q-btn>

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
                        <th v-if="can('Update')">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(item, idx) in items" :key="idx">
                        <td>{{ 1 + idx }}</td>
                        <td v-for="(key, i) in columns" :key="i">{{ item[key] }} </td>
                        <td class="q-gutter-sm">
                           <q-btn v-if="can('Update')" color="blue" class="btn-action"
                              :href="editItem({ id: data.id, itemId: item.id }).url">Edit</q-btn>
                           <q-btn v-if="can('Update')" color="purple" class="btn-action" no-caps
                              @click="handlePindahKK(item)">Pindah KK</q-btn>
                        </td>
                     </tr>
                  </tbody>
               </table>


            </div>
            <div class="text-center py-4" v-if="!items.length">Tidak ada data</div>

         </div>

      </q-card-section>
   </q-card>

   <q-dialog v-model="dialogModal">
      <q-card class="card-lg">
         <q-card-section>
            <div class="card-title flex justify-between items-center">
               <div>Form Pindak Kartu Keluarga</div>
               <q-btn flat icon="close" dense v-close-popup></q-btn>
            </div>
            <div>
               <q-item v-if="selected" class="q-px-none">
                  <q-item-section side>Nama</q-item-section>
                  <q-item-section>{{ selected.nama_lengkap }}</q-item-section>
               </q-item>
               <q-select debounce="700" use-input emit-value map-options v-model="form.kartu_keluarga_id"
                  label="Kartu Keluarga" :options="selectOptions" @filter="filterFn"></q-select>

               <q-btn :disable="!form.kartu_keluarga_id" label="Simpan Data" color="primary" class="full-width q-mt-lg"
                  @click="submitData"></q-btn>
            </div>
         </q-card-section>
      </q-card>
   </q-dialog>

</template>
