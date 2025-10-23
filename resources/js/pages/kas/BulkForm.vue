<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Input from '@/components/Input.vue';
import { Form } from '@inertiajs/vue3';
import { bulkStore } from '@/routes/kas';

defineProps(['queryParams'])

</script>

<template>

    <AppHeader title="Bulk Form" />

    <q-card class="section">
        <q-card-section>

            <div>

                <Form v-bind="bulkStore.form()" v-slot="{ errors, processing }">
                    <div>
                        <Input filled type="date" id="tanggal" label="Tanggal" name="tanggal" required
                            :default-value="queryParams.date ? queryParams.date + '-01' : ''" />
                        <InputError :message="errors.tanggal" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 q-mt-lg">

                        <div>

                            <div class="card-subtitle">Penerimaan</div>

                            <div class="q-gutter-y-xs">
                                <Input dense filled type="number" id="saldo" label="saldo" name="saldo" required />
                                <Input dense filled type="number" id="jimpitan" label="jimpitan" name="jimpitan"
                                    required />
                                <Input dense filled type="number" id="iuran" label="iuran" name="iuran" required />
                                <Input dense filled type="number" id="sp" label="sp" name="sp" required />
                                <Input dense filled type="number" id="lain" label="lain" name="lain" required />
                            </div>
                        </div>


                        <div>

                            <div class="card-subtitle">Pengeluaran</div>
                            <div class="q-gutter-y-xs">
                                <Input dense filled type="number" id="insiden" label="insiden" name="insiden"
                                    required />
                                <Input dense filled type="number" id="cadangan" label="cadangan" name="cadangan"
                                    required />
                                <Input dense filled type="number" id="sosial" label="sosial" name="sosial" required />
                                <Input dense filled type="number" id="hutang" label="hutang" name="hutang" required />
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
