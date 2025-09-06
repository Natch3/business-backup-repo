<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';

const isOpen = ref(false);
const dropdownRef = ref<HTMLElement | null>(null);

const handleClickOutside = (event: MouseEvent) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div class="absolute right-4 flex gap-2">
    <div class="relative" ref="dropdownRef">
      <!-- Toggle Button -->
      <button
        @click="isOpen = !isOpen"
        class="size-9.5 cursor-pointer inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700"
      >
        <!-- Notification Icon -->
        <svg
          class="shrink-0 size-4"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path d="M6 8a6 6 0 0112 0c0 7 3 9 3 9H3s3-2 3-9" />
          <path d="M10.3 21a1.94 1.94 0 003.4 0" />
        </svg>
      </button>

      <!-- Dropdown -->
      <div
        v-if="isOpen"
        class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-neutral-800 dark:border-neutral-700"
      >
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
          <h3 class="text-sm font-semibold text-gray-700 dark:text-white">
            Notifications
          </h3>
        </div>

        <ul class="max-h-60 overflow-y-auto">
          <li
            class="p-3 text-sm text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-700"
          >
            📩 Placeholder notification 1
          </li>
          <li
            class="p-3 text-sm text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-700"
          >
            🔔 Placeholder notification 2
          </li>
        </ul>

        <div class="p-3 text-center border-t border-gray-200 dark:border-neutral-700">
          <a
            href="#"
            class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
          >
            View all
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
