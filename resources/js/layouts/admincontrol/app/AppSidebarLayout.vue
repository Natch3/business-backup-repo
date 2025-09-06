<script setup lang="ts">
import AppContent from '@/components/admincontrol/AppContent.vue';
import AppShell from '@/components/admincontrol/AppShell.vue';
import AppSidebar from '@/components/admincontrol/AppSidebar.vue';
import AppSidebarHeader from '@/components/admincontrol/AppSidebarHeader.vue';

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
