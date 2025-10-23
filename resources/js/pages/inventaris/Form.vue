<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Input from '@/components/Input.vue';
import { Form } from '@inertiajs/vue3';
import { computed } from 'vue';
import { store, update } from '@/routes/inventaris';
import Select from '@/components/Select.vue';

const props = defineProps(['data'])

const formAction = computed(() => {
    if(props.data) {
        return update.form(props.data.id)
    }else {
        return store.form()
    }
})


</script>

<template>

    <AppHeader title="Form Inventaris"/>

     <q-card class="section">
      <q-card-section>

    <div>

        <Form v-bind="formAction" v-slot="{ errors, processing }">

            <div class="">

                <div class="q-gutter-y-sm">
                    <div>
                        <Input id="nama_barang" label="Nama Barang" name="nama_barang" required :default-value="data ? data.nama_barang : ''" />
                        <InputError :message="errors.nama_barang" />
                    </div>
                    <div>
                        <Input id="asal_barang" label="Asal Barang" name="asal_barang" required :default-value="data ? data.asal_barang : ''" />
                        <InputError :message="errors.asal_barang" />
                    </div>
                    <div>
                        <Input type="date" id="tanggal" label="Tanggal Terima / Beli" name="tanggal" required :defaultValue="data ? data.tanggal :  ''" />
                        <InputError :message="errors.tanggal" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                     <div>

                        <Input id="jumlah" label="Jumlah" name="jumlah" required :defaultValue="data ? data.jumlah :  ''" />
                        <InputError :message="errors.jumlah" />
                     </div>
                     <div>

                        <Select :options="['PCS', 'LUSIN', 'BOX']" id="satuan" label="Satuan" name="satuan" required :defaultValue="data ? data.satuan :  'PCS'" />
                        <InputError :message="errors.satuan" />
                     </div>
                    </div>
                    <div>
                        <Input id="tempat_penyimpanan" label="Tempat Penyimpanan" name="tempat_penyimpanan" :defaultValue="data ? data.tempat_penyimpanan :  ''" />
                        <InputError :message="errors.tempat_penyimpanan" />
                    </div>
                    <div>
                        <Select :options="['Baru', 'Bekas']" id="kondisi_barang" label="Kondisi Barang" name="kondisi_barang" :defaultValue="data ? data.kondisi_barang :  ''" />
                        <InputError :message="errors.kondisi_barang" />
                    </div>
                    <div>
                        <Input type="textarea" id="keterangan" label="Keterangan" name="keterangan" :defaultValue="data ? data.keterangan :  ''" />
                        <InputError :message="errors.keterangan" />
                    </div>
                </div>

            </div>

            <q-btn type="submit" class="q-mt-lg full-width" color="primary" :loading="processing">
                  Simpan Data
            </q-btn>

        </Form>
    </div>
    </q-card-section>
    </q-card>
</template>
