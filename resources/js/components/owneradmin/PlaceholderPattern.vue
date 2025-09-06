<script setup lang="ts">
import { computed } from 'vue';

const patternId = computed(() => `pattern-${Math.random().toString(36).substring(2, 9)}`);
</script>

<template>
  <div class="relative flex flex-col items-center justify-center h-screen text-gray-600 bg-white">
    <!-- SVG Pattern Background -->
    <svg class="absolute inset-0 w-full h-full stroke-neutral-900/20 dark:stroke-neutral-100/20" fill="none">
      <defs>
        <pattern :id="patternId" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
          <path d="M-1 5L5 -1M3 9L8.5 3.5" stroke-width="0.5"></path>
        </pattern>
      </defs>
      <rect stroke="none" :fill="`url(#${patternId})`" width="100%" height="100%"></rect>
    </svg>

    <!-- Spinner -->
    <div class="animate-spin rounded-full h-16 w-16 border-4 border-t-green-500 border-gray-200"></div>
    <p class="mt-4 text-lg">Loading, please wait...</p>
  </div>
</template>
