<script setup lang="ts">
import AppContent from '@/components/staff/staffRetail/AppContent.vue';
import AppShell from '@/components/staff/staffRetail/AppShell.vue';
import AppSidebar from '@/components/staff/staffRetail/AppSidebar.vue';
import AppSidebarHeader from '@/components/staff/staffRetail/AppSidebarHeader.vue';
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
