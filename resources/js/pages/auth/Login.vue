<script setup>
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController.ts';
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import Input from '@/components/Input.vue';
import Checkbox from '@/components/Checkbox.vue';
defineProps({
    status: String,
    canResetPassword: Boolean
});
</script>

<template>
    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
        {{ status }}
    </div>
    
    <div class="flex column justify-center items-center full-width">
        <div class="page-title q-mb-lg text-center">
            <div>{{ $page.props.name }}</div>
            <div>DUSUN KERJO II</div>
        </div>

        <q-card class="card-md section">
            <q-card-section>

                <div class="card-title">Login</div>

                <Form v-bind="AuthenticatedSessionController.store.form()" :reset-on-success="['password']"
                    v-slot="{ errors, processing }">
                    <div class="q-gutter-y-sm">
                        <div>
                            <Input name="email" id="email" label="Email Address" required></Input>
                            <InputError :message="errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Input id="password" type="password" name="password" required :tabindex="2"
                                autocomplete="current-password" placeholder="Password" />
                            <InputError :message="errors.password" />
                        </div>

                        <div class="flex items-center justify-between">
                            <Checkbox id="remember" name="remember" :tabindex="3" label="Remember Me" />
                        </div>

                        <q-btn type="submit" class="q-mt-md full-width" color="primary" :tabindex="4"
                            :disable="processing" data-test="login-button" label="Login">
                        </q-btn>
                    </div>

                </Form>
            </q-card-section>
        </q-card>
    </div>


</template>
