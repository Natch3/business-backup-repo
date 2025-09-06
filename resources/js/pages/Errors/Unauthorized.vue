<script setup lang="ts">

import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Unauthorized',
    href: '/errors/unauthorized',
  },
];
</script>
<template>
    <Head title="Unauthorized" />
  <div class="min-h-screen flex flex-col items-center justify-center bg-white text-center">
    <h1 class="text-5xl font-bold text-red-600">403</h1>
    <p class="mt-4 text-xl text-gray-700">Unauthorized Access</p>
    <p class="text-gray-500">You do not have permission to view this page.</p>
    <a href="/" class="mt-6 text-blue-600 hover:underline">Go back to homepages</a>
  </div>
</template>

