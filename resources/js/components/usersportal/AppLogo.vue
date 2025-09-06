<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/staff/AppLogoIcon.vue';

const page = usePage();
const user = page.props.auth.user;
</script>
<template>
    <div class="flex aspect-square size-20 items-center justify-center bg-white rounded-full">
        <AppLogoIcon class="size-20 fill-current rounded-full" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate font-semibold leading-none">{{ user.role }} Portal</span>
    </div>
</template>
