<script setup lang="ts">

import { index, create } from '@/routes/penduduk'
import { router } from '@inertiajs/vue3';
import { edit, show } from '@/routes/penduduk';
import { reactive } from 'vue';

const props = defineProps(['data', 'queryParams'])

const query = reactive({
    search: props.queryParams?.search || ''
})

const searchData = () => {
    router.visit(index({ query: query }))
}

</script>

<template>

    <AppHeader title="Kartu Keluarga">
        <q-btn color="primary" @click="router.visit(create())">Tambah Data</q-btn>
    </AppHeader>

    <q-card class="section">
        <q-card-section>

            <div>
                <q-input dense outlined placeholder="NO KK atau Nama" class="q-mb-sm" v-model="query.search"
                    label="Search" @keydown.enter.prevent="searchData" clearable @clear="router.visit(index())">
                    <template v-slot:append>
                        <q-btn size="11px" :disable="!query.search" color="dark" icon="search" flat dense
                            @click="searchData"></q-btn>
                        <!-- <q-btn size="11px" color="red" label="Reset" @click="router.visit(index())"></q-btn> -->
                    </template>
                </q-input>
                <div class="table-responsive">

                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th class="text-left uppercase">#</th>
                                <th class="text-left uppercase">No KK</th>
                                <th class="text-left uppercase">Jml Anggota</th>
                                <th class="text-left uppercase">Kepala Keluarga</th>
                                <th class="text-left uppercase">Alamat</th>
                                <th class="text-left uppercase">RT/RW</th>
                                <th class="text-left uppercase">kelurahan</th>
                                <th class="text-left uppercase">Kecamatan</th>
                                <th class="text-left uppercase">Kabupaten</th>
                                <th class="text-left uppercase">Provinsi</th>
                                <th class="text-left uppercase">Kode Pos</th>
                                <th class="text-left uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in data.data" :key="idx">
                                <td>{{ data.from + idx }}</td>
                                <td>{{ item.nomor }}</td>
                                <td>{{ item.items_count }}</td>
                                <td>{{ item.kepala_keluarga }}</td>
                                <td>{{ item.alamat }}</td>
                                <td>{{ item.rt_rw }}</td>
                                <td>{{ item.kelurahan }}</td>
                                <td>{{ item.kecamatan }}</td>
                                <td>{{ item.kabupaten }}</td>
                                <td>{{ item.provinsi }}</td>
                                <td>{{ item.kodepos }}</td>
                                <td class="q-gutter-xs no-wrap">
                                    <q-btn class="btn-action" no-caps color="blue"
                                        @click="router.get(edit(item.id))">Edit</q-btn color="blue">
                                    <q-btn class="btn-action" color="teal"
                                        @click="router.get(show(item.id))">Detail</q-btn>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <AppPagination v-bind="data"></AppPagination>

            </div>
        </q-card-section>
    </q-card>

</template>
