<script setup lang="ts">
import { LinkComponentBaseProps, Method } from '@inertiajs/core';
import { Link } from '@inertiajs/vue3';

interface Props {
    href: LinkComponentBaseProps['href'];
    tabindex?: number;
    method?: Method;
    as?: string;
}

defineProps<Props>();
</script>

<template>
    <Link
        :href="href"
        :tabindex="tabindex"
        :method="method"
        :as="as"
        class="bg-blue no-outline non-selectable q-btn q-btn--actionable q-btn--rectangle q-btn--standard q-btn-item q-focusable q-hoverable text-white"
    >
    <span class="q-focus-helper"></span>
    <span class="q-btn__content text-center col items-center q-anchor--skip justify-center row">
        <slot />
    </span>
    </Link>
</template>
