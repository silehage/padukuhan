<script setup lang="ts">

import { create, edit, destroy } from '@/routes/inventaris';
import { router } from '@inertiajs/vue3';

defineProps(['data'])

</script>

<template>

    <AppHeader title="Inventaris">
        <div class="flex justify-end q-gutter-sm">
            <q-btn color="primary" @click="router.visit(create())">Tambah Data</q-btn>
        </div>
    </AppHeader>

    <q-card class="section">
        <q-card-section>

            <div>
                <!-- <AppPagination v-bind="data"></AppPagination> -->
                <div class="table-responsive">

                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th class="text-left uppercase">#</th>
                                <th class="text-left uppercase">Nama Barang</th>
                                <th class="text-left uppercase">Asal Barang</th>
                                <th class="text-left uppercase">Tgl Terima / Beli</th>
                                <th class="text-left uppercase">Jumlah</th>
                                <th class="text-left uppercase">Tempat Penyimpanan</th>
                                <th class="text-left uppercase">Kondisi Barang</th>
                                <th class="text-left uppercase">Keterangan</th>
                                <th class="text-left uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in data.data" :key="idx">
                                <td>{{ 1 + idx }}</td>
                                <td>{{ item.nama_barang }}</td>
                                <td>{{ item.asal_barang }}</td>
                                <td class="text-nowrap">{{ item.tanggal }}</td>
                                <td>{{ item.jumlah }}</td>
                                <td>{{ item.tempat_penyimpanan }}</td>
                                <td>{{ item.kondisi_barang }}</td>
                                <td>{{ item.keterangan }}</td>
                                <td class="q-gutter-xs no-wrap">
                                    <q-btn class="btn-action" no-caps color="blue"
                                        @click="router.visit(edit(item.id))">Edit</q-btn color="blue">
                                    <q-btn class="btn-action" no-caps color="red"
                                        @click="router.visit(destroy(item.id))">Hapus</q-btn color="blue">
                                </td>
                            </tr>
                            <tr v-if="!data.total">
                                <td colspan="20" class="text-center">Tidak ada data</td>
                            </tr>
                        </tbody>
                    </table>


                </div>

                <AppPagination v-bind="data"></AppPagination>

            </div>
        </q-card-section>
    </q-card>

</template>
