<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { HomeIcon, ClipboardDocumentListIcon, UserGroupIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'

const page = usePage<SharedData>();
const items: NavItem[] = [
  {
    title: 'Dashboard',
    icon: HomeIcon,
    href: `staffpanel.staffrestaurant.Dashboard`,
  },
  {
    title: 'Order Products',
    icon: ClipboardDocumentListIcon,
    href: `staffpanel.staffrestaurant.Order`,
  },
  {
    title: 'Purchased Items',
    icon: ClipboardDocumentListIcon,
    href: `staffpanel.staffrestaurant.PurchasedItems`,
  },
  {
    title: 'Contact Manager',
    icon: ChatBubbleLeftRightIcon,
    href: `staffpanel.staffrestaurant.ContactManager`,
  },
  {
    title: 'Feedback & Questions',
    icon: ChatBubbleLeftRightIcon,
    href: `staffpanel.staffrestaurant.FeedbackQuestion`,
  },
];
</script>


<template>
  <SidebarGroup class="px-2 py-0">
    <SidebarGroupLabel>Platform</SidebarGroupLabel>
    <SidebarMenu>
<SidebarMenuItem v-for="item in items" :key="item.title" class="my-1">
  <SidebarMenuButton
    as-child
    :is-active="route(item.href) === page.url"
    :tooltip="item.title"
  >
    <Link :href="route(item.href)" class="flex items-center gap-2">
      <component :is="item.icon" class="w-5 h-5" />
      <span>{{ item.title }}</span>
    </Link>
  </SidebarMenuButton>
</SidebarMenuItem>

    </SidebarMenu>
  </SidebarGroup>
</template>
