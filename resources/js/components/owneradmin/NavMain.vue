<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { HomeIcon, ClipboardDocumentListIcon,UserGroupIcon ,ChatBubbleLeftRightIcon  ,BuildingOfficeIcon  } from '@heroicons/vue/24/outline'

const page = usePage<SharedData>();

const items: NavItem[] = [
  {
    title: 'Dashboard',
    icon: HomeIcon,
    href: 'owneradmin.dashboard',
  },
    {
    title: 'Purchased Items',
    icon: ClipboardDocumentListIcon,
    href: 'owneradmin.PurchasedItems',
  },

    {
    title: 'Register Braches',
    icon: BuildingOfficeIcon ,
    href: 'owneradmin.RegisterBusiness',
  },
      {
    title: 'Manager Account',
    icon: UserGroupIcon ,
    href: 'owneradmin.ManagerAccount',
  },
     {
    title: 'Contact Manager',
    icon: ChatBubbleLeftRightIcon,
    href: 'owneradmin.ContactManager',
  },
    {
    title: 'Users Feedback & Questions',
    icon: ChatBubbleLeftRightIcon ,
    href: 'owneradmin.FeedbackQuestion',
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
