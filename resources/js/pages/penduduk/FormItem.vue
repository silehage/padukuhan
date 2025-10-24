<script setup lang="ts">
import Input from '@/components/Input.vue';
import InputError from '@/components/InputError.vue';
import { Head, Form } from '@inertiajs/vue3';
import { computed } from 'vue';
import { updateItem, storeItem } from '@/routes/penduduk';

const props = defineProps(['data', 'item'])

const formAction = computed(() => {
    if (props.item) {
        return updateItem.form({ id: props.data.id, itemId: props.item.id })
    } else {
        return storeItem.form(props.data.id)
    }
})

const seleccOpt = { label: 'PILIH', value: '' }
const agama = ["ISLAM", "KRISTEN", 'HINDU', 'BUDHA', 'KATOLIK']
const gender = ["LAKI-LAKI", "PEREMPUAN"]
const pendidikan = ['TIDAK/BELUM SEKOLAH', 'BELUM TAMAT SD SEDERAJAT', 'TAMAT SD/SEDRAJAT', 'SLTP SEDERAJAT', 'SLTA SEDERAJAT', 'AKADEMI/DIPLOMA III/S. MUDA', 'DIPLOMA IV/STRATA I']
const pekerjaan = ['BELUM/TIDAK BEKERJA', 'WIRASWASTA', 'KARYAWAN SWASTA', 'MENGURUS RUMAH TANGGA', 'BURUH HARIAN LEPAS', 'PELAJAR/MAHASISWA', 'PETANI/PEKEBUN', 'SOPIR', 'PEDAGANG', 'GURU', 'PEGAWAI NEGERI SIPIL (PNS)', 'PENSIUNAN']
const statusHubungan = ['KEPALA KELUARGA', 'SUAMI', 'ISTRI', 'ANAK', 'CUCU', 'ORANG TUA', 'MERTUA', 'FAMILI LAIN']
const statusPerkawinan = ['KAWIN TERCATAT', 'BELUM KAWIN', 'CERAI MATI', 'CERAI']
const golonganDarah = ['TIDAK TAHU', 'A', 'B', 'AB', 'O']
const wargaNegara = ['WNI', 'WNA']

const rows = [
    { required: true, default: props.item ? props.item.nama_lengkap : '', name: 'nama_lengkap', type: 'text' },
    { required: true, default: props.item ? props.item.nik : '', name: 'nik', type: 'text' },
    { required: true, default: props.item ? props.item.Jenis_kelamin : '', name: 'Jenis_kelamin', type: 'select', options: [seleccOpt, ...gender.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.tempat_lahir : '', name: 'tempat_lahir', type: 'text' },
    { required: true, default: props.item ? props.item.tanggal_lahir : '', name: 'tanggal_lahir', type: 'date' },
    { required: true, default: props.item ? props.item.agama : '', name: 'agama', type: 'select', options: [seleccOpt, ...agama.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.pendidikan : '', name: 'pendidikan', type: 'select', options: [seleccOpt, ...pendidikan.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.jenis_pekerjaan : '', name: 'jenis_pekerjaan', type: 'select', options: [seleccOpt, ...pekerjaan.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.golongan_darah : '', name: 'golongan_darah', type: 'select', options: [seleccOpt, ...golonganDarah.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.status_perkawinan : '', name: 'status_perkawinan', type: 'select', options: [seleccOpt, ...statusPerkawinan.map(el => ({ label: el, value: el }))] },
    { required: false, default: props.item ? props.item.tanggal_perkawinan : '', name: 'tanggal_perkawinan', type: 'date' },
    { required: true, default: props.item ? props.item.status_hubungan_keluarga : '', name: 'status_hubungan_keluarga', type: 'select', options: [seleccOpt, ...statusHubungan.map(el => ({ label: el, value: el }))] },
    { required: true, default: props.item ? props.item.kewarganegaraan : 'WNI', name: 'kewarganegaraan', type: 'select', options: [seleccOpt, ...wargaNegara.map(el => ({ label: el, value: el }))] },
    // { required: false, default: props.item ? props.item.no_paspor : '', name: 'no_paspor', type: 'text'},
    // { required: false, default: props.item ? props.item.no_kitap : '', name: 'no_kitap', type: 'text'},
    { required: true, default: props.item ? props.item.nama_ayah : '', name: 'nama_ayah', type: 'text' },
    { required: true, default: props.item ? props.item.nama_ibu : '', name: 'nama_ibu', type: 'text' }]

</script>


<template>

    <AppHeader title="Form Anggota" />

    <q-card class="section">
        <q-card-section>

            <div class="">
                <table class="table">
                    <tr>
                        <td>NOMOR KK</td>
                        <td>{{ data.nomor }}</td>
                    </tr>
                    <tr>
                        <td>KEPALA KELUARGA</td>
                        <td>{{ data.kepala_keluarga }}</td>
                    </tr>
                    <tr>
                        <td>ALAMAT</td>
                        <td>{{ data.alamat }}</td>
                    </tr>
                </table>

                <div class="q-mt-lg q-px-md">

                    <Form v-bind="formAction" v-slot="{ errors, processing }">


                        <div class="mt-3">
                            <div class="grid gap-4">
                                <div class="grid gap-2" v-for="(row, idx) in rows" :key="idx">
                                    <select :label="row.name.toUpperCase().split('_').join(' ')"
                                        v-if="row.type == 'select'" :id="row.name" :name="row.name"
                                        :required="row.required" class="">
                                        <option v-for="opt in row.options" :value="opt.value"
                                            :selected="opt.value == row.default">
                                            {{ opt.label }}</option>
                                    </select>
                                    <Input :label="row.name.toUpperCase().split('_').join(' ')"
                                        :default-value="row.default" v-else-if="row.type == 'date'"
                                        placeholder="DD-MM-YYYY" :id="row.name" type="'text'" :name="row.name"
                                        :required="row.required" />
                                    <Input :label="row.name.toUpperCase().split('_').join(' ')"
                                        :default-value="row.default" v-else :id="row.name" :type="row.type"
                                        :name="row.name" :required="row.required" />
                                    <InputError :message="errors[row.name]" />
                                </div>
                            </div>
                        </div>


                        <q-btn type="submit" class="q-mt-lg full-width" color="primary" :loading="processing">
                              Simpan Data
                        </q-btn>

                    </Form>
                </div>


            </div>
        </q-card-section>
    </q-card>
</template>
