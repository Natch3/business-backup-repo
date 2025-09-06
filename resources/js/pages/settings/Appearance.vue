<script setup lang="ts">
import { Head,usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';


import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

import AdminControlLayout from '@/layouts/admincontrol/AppLayout.vue';
import StaffLayout from '@/layouts/staff/AppLayout.vue';
import OwnerAdminLayout from '@/layouts/owneradmin/AppLayout.vue';
import ManagerLayout from '@/layouts/manager/AppLayout.vue';
import UserLayout from '@/layouts/usersportal/AppLayout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];
const appLayout = computed(() => {
  if (!user || !user.role) return UserLayout;

  switch (user.role) {
    case 'AdminControl':
      return AdminControlLayout;
    case 'Staff':
      return StaffLayout;
    case 'OwnerAdmin':
      return OwnerAdminLayout;
    case 'Manager':
      return ManagerLayout;
    default:
      return UserLayout; // fallback
  }
});
</script>

<template>
    <component :is="appLayout" :breadcrumbItems="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </component>
</template>
