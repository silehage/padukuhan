<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Input from '@/components/Input.vue';
import { Form } from '@inertiajs/vue3';
import { computed } from 'vue';
import { update, store } from '@/routes/penduduk';

const props = defineProps(['data'])

const formAction = computed(() => {
    if (props.data) {
        return update.form(props.data.id)
    } else {
        return store.form()
    }
})


</script>

<template>

    <AppHeader title="Form Kartu Keluarga" />

    <q-card class="section">
        <q-card-section>

            <div>

                <Form v-bind="formAction" v-slot="{ errors, processing }">

                    <div class="grid grid-cols-2 gap-4">

                        <div class="q-gutter-y-sm">
                            <div>
                                <Input id="nomor" label="No Kartu Keluarga" name="nomor" required
                                    :default-value="data ? data.nomor : ''" />
                                <InputError :message="errors.nomor" />
                            </div>
                            <div>
                                <Input id="kepala_keluarga" label="Nama Kepala Keluarga" name="kepala_keluarga" required
                                    :default-value="data ? data.kepala_keluarga : ''" />
                                <InputError :message="errors.kepala_keluarga" />
                            </div>
                            <div>
                                <Input id="rt_rw" label="RT/RW" name="rt_rw" required
                                    :defaultValue="data ? data.rt_rw : '005/002'" />
                                <InputError :message="errors.rt_rw" />
                            </div>
                            <div>
                                <Input id="alamat" label="Alamat" name="alamat" required
                                    :defaultValue="data ? data.alamat : 'KERJO II DUSUN KERJO II'" />
                                <InputError :message="errors.alamat" />
                            </div>
                            <div>
                                <Input id="kelurahan" label="kelurahan" name="kelurahan"
                                    :defaultValue="data ? data.kelurahan : 'GENJAHAN'" />
                                <InputError :message="errors.kelurahan" />
                            </div>
                        </div>
                        <div class="q-gutter-y-sm">
                            <div>
                                <Input id="kecamatan" label="Kecamatan" name="kecamatan" required
                                    :defaultValue="data ? data.kecamatan : 'PONJONG'" />
                                <InputError :message="errors.kecamatan" />
                            </div>
                            <div>
                                <Input id="kabupaten" label="Kabupaten" name="kabupaten" required
                                    :defaultValue="data ? data.kabupaten : 'GUNUNGKIDUL'" />
                                <InputError :message="errors.kabupaten" />
                            </div>
                            <div>
                                <Input id="provinsi" label="Provinsi" name="provinsi" required
                                    :defaultValue="data ? data.provinsi : 'DAERAH ISTIMEWA YOGYAKARTA'" />
                                <InputError :message="errors.provinsi" />
                            </div>
                            <div>
                                <Input id="kodepos" label="Kodepos" name="kodepos" required
                                    :defaultValue="data ? data.kodepos : '55892'" />
                                <InputError :message="errors.kodepos" />
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
