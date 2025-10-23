<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Input from '@/components/Input.vue';
import { Form } from '@inertiajs/vue3';
import { store, update } from '@/routes/kas';
import Select from '@/components/Select.vue';
import { computed } from 'vue';

const props = defineProps(['kas_options', 'date', 'data'])

const defaultDate = computed(() => {
    if (props.data) {
        return props.data.tanggal
    }
    if (props.date) {
        return props.date
    }
    return ''
})

const formAction = computed(() => {
    if (props.data) {
        return update.form(props.data.id)
    } else {
        return store.form()
    }
})

</script>

<template>

    <AppHeader title="Form Kas RT" />

    <q-card class="section">
        <q-card-section>

            <div>

                <Form v-bind="formAction" v-slot="{ errors, processing }">

                    <div class="q-gutter-y-sm">
                        <div>
                            <Input type="date" id="tanggal" label="Tanggal" name="tanggal" required
                                :defaultValue="defaultDate" />
                            <InputError :message="errors.tanggal" />
                        </div>

                        <div>
                            <Select :options="kas_options" id="in_out" map-options emit-value
                                label="Penerimaan / Pengeluaran" name="in_out"
                                :defaultValue="data ? data.in_out : ''" />
                            <InputError :message="errors.in_out" />
                        </div>

                        <div>
                            <Input id="keterangan" label="Keterangan" name="keterangan"
                                :defaultValue="data ? data.keterangan : ''" />
                            <InputError :message="errors.keterangan" />
                        </div>

                        <div>
                            <Input type="number" id="jumlah" label="Jumlah" name="jumlah" required
                                :defaultValue="data ? data.jumlah : ''" />
                            <InputError :message="errors.jumlah" />
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
