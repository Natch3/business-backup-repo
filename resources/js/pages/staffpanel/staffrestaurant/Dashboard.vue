<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader

// Lazy-load the layout to enable suspense loading
const AppLayout = defineAsyncComponent(() => import('@/layouts/staff/staffRestaurant/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/staffpanel/staffrestaurant/dashboard',
  },
];
</script>
<template>
  <Head title="Dashboard" />
  <Suspense>
    <template #default>
         <AppLayout :breadcrumbs="breadcrumbs">

         </AppLayout>



        </template>
      <template #fallback>
         <PlaceholderPattern />
      
    </template>
  </Suspense>
</template>