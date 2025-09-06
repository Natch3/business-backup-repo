<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import imageUrl from '@/assets/img/logo/Anggot System Logo 1.png';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
  <img :src="imageUrl" :class="className" v-bind="$attrs" alt="Logo" />
</template>
