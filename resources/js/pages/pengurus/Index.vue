<script setup>

import { searchPenduduk } from '@/routes/api';
import { create, assignPengurus, index } from '@/routes/pengurus';
import { router, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const props = defineProps(['data', 'options', 'penduduk', 'queryParams'])

const form = useForm({
    penduduk_id: '',
    pengurus_id: ''
})

const modal = ref(false)
const isEdit = ref(false)

const handleEdit = (item) => {
    isEdit.value = true
    modal.value = true
    form.penduduk_id = item.id
    form.pengurus_id = item.pengurus_id ?? ''
}
const handleCreate = () => {
    isEdit.value = false
    modal.value = true
}

const submitData = () => {
    form.submit(assignPengurus(), {
        onFinish: () => {
            modal.value = false
            form.penduduk_id = ''
            form.pengurus_id = ''
        }
    })
}

const query = reactive({
    search: props.queryParams?.search || ''
})

const searchData = () => {
    router.visit(index({ query: query }))
}

const penduduk_options = ref([])

const filterFn = async (val, update) => {
    if (!val || val == '') {
        update(() => {
            penduduk_options.value = []
        })
        return
    }

    const response = await fetch(searchPenduduk(val).url)
    const result = await response.json()


    update(() => {
         penduduk_options.value = result.map(el => ({label: el.nama_lengkap, value: el.id}))
        // const needle = val.toLowerCase()
        // penduduk_options.value = props.penduduk.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
    })
}


import { guard } from '@/lib/utils';
const module = 'Pengurus'
const can = (ability) => {
    return guard(`${ability} ${module}`)
}

</script>

<template>

    <AppHeader title="Susunan Pengurus">
        <div class="flex justify-end q-gutter-sm">
            <q-btn v-if="can('Create')" color="primary" @click="handleCreate">Tambah Data</q-btn>
        </div>
    </AppHeader>

    <q-card class="section">
        <q-card-section>

            <q-input dense outlined placeholder="Nama" class="q-mb-md" v-model="query.search" label="Search"
                @keydown.enter.prevent="searchData" clearable @clear="router.visit(index())">
                <template v-slot:append>
                    <q-btn size="11px" :disable="!query.search" color="dark" icon="search" flat dense
                        @click="searchData"></q-btn>
                    <!-- <q-btn size="11px" color="red" label="Reset" @click="router.visit(index())"></q-btn> -->
                </template>
            </q-input>

            <div>
                <!-- <AppPagination v-bind="data"></AppPagination> -->
                <div class="table-responsive">

                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th class="text-left uppercase">#</th>
                                <th class="text-left uppercase">Nama</th>
                                <th class="text-left uppercase">Jabatan</th>
                                <th class="text-left uppercase">Jenis Kelamin</th>
                                <th class="text-left uppercase">Tempat Lahir</th>
                                <th class="text-left uppercase">Tanggal Lahir</th>
                                <th class="text-left uppercase">Status</th>
                                <th class="text-left uppercase" v-if="can('Update')">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in data.data" :key="idx">
                                <td>{{ data.from + idx }}</td>
                                <td>{{ item.nama_lengkap }}</td>
                                <td>{{ item.jabatan }}</td>
                                <td>{{ item.Jenis_kelamin }}</td>
                                <td>{{ item.tempat_lahir }}</td>
                                <td>{{ item.tanggal_lahir }}</td>
                                <td>{{ item.status_perkawinan }}</td>
                                <td class="q-gutter-xs no-wrap">
                                    <q-btn v-if="can('Update')" class="btn-action" no-caps color="blue" @click="handleEdit(item)">Edit</q-btn
                                        color="blue">
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

    <q-dialog v-model="modal">
        <q-card class="section card-lg">
            <q-card-section>
                <div class="card-title">Update Pengurus</div>
                <q-form @submit="submitData">
                    <q-select debounce="700" use-input :disable="isEdit" emit-value map-options v-model="form.penduduk_id"
                        label="Nama Pengurus" :options="penduduk_options" @filter="filterFn"></q-select>
                    <q-select emit-value map-options v-model="form.pengurus_id" label="Jabatan"
                        :options="[{ label: 'Pilih', value: '' }, ...options]"></q-select>
                    <q-btn :loading="form.processing" class="full-width q-mt-lg" type="submit" label="Submit Data"
                        color="primary"></q-btn>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>

</template>
