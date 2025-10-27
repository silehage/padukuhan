<script setup lang="ts">

import { exportKas } from '@/actions/App/Http/Controllers/ExportController';
import { create, index, bulkCreate, edit } from '@/routes/kas';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { guard } from '@/lib/utils';

const props = defineProps(['data', 'queryParams'])

const query = reactive({
    date: props.queryParams?.date
})

const getData = () => {
    router.visit(index({ query: query }))
}

const module = 'Kas'

const can = (ability) => {
    return guard(`${ability} ${module}`)
}
</script>

<template>

    <AppHeader title="Buku Kas">
        <div class="flex q-gutter-sm">
            <q-btn v-if="can('Create')" color="primary" @click="router.visit(create({query: query}))">Tambah Data</q-btn>
            <q-btn v-if="can('Create')" color="blue" @click="router.visit(bulkCreate())">Tambah Bulk</q-btn>
            <q-btn color="teal" :href="exportKas().url" target="_blank">Export</q-btn>
        </div>
    </AppHeader>

    <q-card class="section">
        <q-card-section>

            <div class="relative">
                <div class="q-mb-md">
                    <input type="month" v-model="query.date" label="Filter" @input="getData" />
                </div>
                <div class="table-responsive">

                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th class="text-left uppercase">NO</th>
                                <th class="text-left uppercase">Tanggal</th>
                                <th class="text-left uppercase">Uraian</th>
                                <th class="text-left uppercase">Penerimaan</th>
                                <th class="text-left uppercase">Pengeluaran</th>
                                <!-- <th class="text-left uppercase">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in data.items" :key="idx">
                                <td>{{ 1 + idx }}</td>
                                <td class="text-nowrap">{{ item.tanggal }}</td>
                                <td>{{ item.keterangan }}</td>
                                <td>
                                    {{ item.in_out == 'IN' ? item.jumlah : '' }}
                                </td>
                                <td>{{ item.in_out == 'OUT' ? item.jumlah : '' }}</td>
                                <!-- <td>
                                    <q-btn size="12px" label="Edit" color="blue" @click="router.visit(edit(item.id))"></q-btn>
                                </td> -->
                            </tr>

                            <tr v-if="!data.items.length">
                                <td colspan="20" class="text-center">Tidak ada data</td>
                            </tr>
                        </tbody>
                        <template v-if="data.items.length">
                        <tfoot>
                            <tr>
                                <th class="bg-grey-1" colspan="2"></th>
                                <th class="bg-grey-1">Jml Penerimaan/Pengeluaran</th>
                                <th class="bg-grey-1">{{ data.total_masuk }}</th>
                                <th class="bg-grey-1">{{ data.total_keluar }}</th>
                            </tr>
                            <tr>
                                <th class="bg-grey-1" colspan="2"></th>
                                <th class="bg-grey-1">Saldo Kas Akhir</th>
                                <th class="bg-grey-1">{{ data.total_masuk - data.total_keluar }}</th>
                                <th class="bg-grey-1"></th>

                            </tr>
                        </tfoot>
                        </template>
                    </table>


                </div>

                <AppPagination v-bind="data"></AppPagination>

            </div>
        </q-card-section>
    </q-card>

</template>
