<script setup lang="ts">
import AppContent from '@/components/owneradmin/AppContent.vue';
import AppShell from '@/components/owneradmin/AppShell.vue';
import AppSidebar from '@/components/owneradmin/AppSidebar.vue';
import AppSidebarHeader from '@/components/owneradmin/AppSidebarHeader.vue';

import type { BreadcrumbItemType } from '@/types';


interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
