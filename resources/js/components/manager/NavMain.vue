<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { HomeIcon, EllipsisHorizontalCircleIcon,UserIcon, ClipboardDocumentListIcon,UserGroupIcon ,ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'

const page = usePage<SharedData>();

const items: NavItem[] = [
  {
    title: 'Dashboard',
    icon: HomeIcon,
    href: 'manager.dashboard',
  },
  {
    title: 'Inventory',
    icon: ClipboardDocumentListIcon,
    href: 'manager.Inventory',
  },
  
    {
    title: 'Add Account',
    icon: UserIcon,
    href: 'manager.AddAccount',
  },
        {
    title: 'Contact Owner',
    icon: ChatBubbleLeftRightIcon,
    href: 'manager.OwnerMessage',
  },
      {
    title: 'Users Feedback & Questions',
    icon: ChatBubbleLeftRightIcon ,
    href: 'manager.FeedbackQuestion',
  },
]
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
