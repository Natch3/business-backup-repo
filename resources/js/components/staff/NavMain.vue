<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { HomeIcon, ClipboardDocumentListIcon, UserGroupIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'

const page = usePage<SharedData>();

// Get branch type from backend props (make sure you pass it from Laravel)
// Possible values: "Retail", "Salon", "Restaurant"
const branchType = page.props.auth.branch_type;

// Decide the route prefix
let routePrefix = "staffpanel"; // default fallback
switch (branchType) {
  case "Retail":
    routePrefix = "staffpanel.staffretail";
    break;
  case "Salon":
    routePrefix = "staffpanel.staffsalon";
    break;
  case "Restaurant":
    routePrefix = "staffpanel.staffrestaurant";
    break;
}

const items: NavItem[] = [
  {
    title: 'Dashboard',
    icon: HomeIcon,
    href: `${routePrefix}.dashboard`,
  },
  {
    title: 'Order Products',
    icon: ClipboardDocumentListIcon,
    href: `${routePrefix}.Order`,
  },
  {
    title: 'Purchased Items',
    icon: ClipboardDocumentListIcon,
    href: `${routePrefix}.PurchasedItems`,
  },
  {
    title: 'Contact Manager',
    icon: ChatBubbleLeftRightIcon,
    href: `${routePrefix}.ContactManager`,
  },
  {
    title: 'Feedback & Questions',
    icon: ChatBubbleLeftRightIcon,
    href: `${routePrefix}.FeedbackQuestion`,
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
