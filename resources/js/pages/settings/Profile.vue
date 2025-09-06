<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import AdminControlLayout from '@/layouts/admincontrol/AppLayout.vue';
import StaffLayout from '@/layouts/staff/AppLayout.vue';
import OwnerAdminLayout from '@/layouts/owneradmin/AppLayout.vue';
import ManagerLayout from '@/layouts/manager/AppLayout.vue';
import UserLayout from '@/layouts/usersportal/AppLayout.vue';
import BgImage from '@/assets/img/bg/abstract-bg-1.svg';
import LogoImage from '@/assets/img/logo/profile-icon-design-free-vector.jpg';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

interface Props {
  mustVerifyEmail: boolean;
  status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Profile settings',
    href: '/settings/profile',
  },
];

const form = useForm({
  name: user.name,
  email: user.email,
  avatar: user.avatar,
});

const submit = () => {
  form.patch(route('profile.update'), {
    preserveScroll: true,
  });
};

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
      return UserLayout; 
  }
  
});


</script>


<template>
  <component :is="appLayout" :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Update your name and email address" />

                <form @submit.prevent="submit" class="space-y-6">
             <!-- Banner with profile image on the left -->
<div class="relative h-40 rounded-t-xl bg-no-repeat bg-cover bg-center"
    :style="{ backgroundImage: `url(${BgImage})` }"
>


  <!-- Profile image and buttons -->
  <div class="absolute bottom-0 left-4 flex items-center gap-4 translate-y-1/2">
    <img
  class="inline-block size-24 rounded-full ring-4 ring-white dark:ring-neutral-900"
  :src="form.avatar ? '/storage/' + form.avatar  : LogoImage"
  alt="Avatar"
/>
    <div class="flex gap-2 mt-14">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="17 8 12 3 7 8"/>
          <line x1="12" x2="12" y1="3" y2="15"/>
        </svg>
        Upload logo
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-red-500 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
        Delete
      </button>
    </div>
  </div>
</div>
<div class="mt-20"></div>
<!-- <p>Profile value: {{ form.avatar }}</p> -->
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground cursor-pointer underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </component>
</template>
