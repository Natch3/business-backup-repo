<script setup lang="ts">
import AppContent from '@/components/staff/AppContent.vue';
import AppShell from '@/components/staff/AppShell.vue';
import AppSidebar from '@/components/staff/AppSidebar.vue';
import AppSidebarHeader from '@/components/staff/AppSidebarHeader.vue';
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
