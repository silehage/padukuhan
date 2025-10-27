import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function guard(ability) {
    
    if(ability == 'All') {
        return true;
    }
    const user = computed(() => usePage().props.auth.user)
    const permissions = computed(() => usePage().props.auth.permissions)

    if (permissions.value.includes('can-all')) {
        return true;
    }

    if (!user.value || !permissions.value.length) {
        return false
    }

    if (!ability) {
        return false
    }

    return permissions.value.includes(ability)

}
