<script setup lang="ts">
import AppContent from '@/components/usersportal/AppContent.vue';
import AppShell from '@/components/usersportal/AppShell.vue';
import AppSidebar from '@/components/usersportal/AppSidebar.vue';
import AppSidebarHeader from '@/components/usersportal/AppSidebarHeader.vue';
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
