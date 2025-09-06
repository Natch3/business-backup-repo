<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import LogoImage from '@/assets/img/logo/profile-icon-design-free-vector.jpg';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader
import OwnerMessageLayout from '@/components/admincontrol/chat/OwnerMessageLayout.vue'
// Lazy-load the layout to enable suspense loading
const AppLayout = defineAsyncComponent(() => import('@/layouts/admincontrol/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Owner Message',
    href: '/admincontrol/OwnerMessage',
  },
];
</script>
<template>
  <Head title="Owner Message" />
  <Suspense>
    <template #default>
         <AppLayout :breadcrumbs="breadcrumbs">

<div className="relative h-screen flex ">

<div className="w-full lg:w-80 bg-white border-r border-gray-200">
    <div className="max-w-md mx-auto rounded-lg overflow-hidden">
      <div className="p-4 border-b">
        <h2 className="text-xl font-semibold text-gray-800">Chats</h2>
      </div>
      <ul className="divide-y divide-gray-200">
    
        <li className="flex items-center justify-between p-4 hover:bg-gray-100 cursor-pointer">
          <div className="flex items-center space-x-4">
            <div className="relative">
              <img className="w-10 h-10 rounded-full object-cover"   :src="LogoImage" alt="User Avatar" />
              <span className="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full" />
            </div>
            <div>
              <p className="text-sm font-medium text-gray-900">John Doe</p>
              <p className="text-xs text-gray-500 truncate w-40">Hey, are you available today?</p>
            </div>
          </div>
          <div className="text-xs text-gray-400 whitespace-nowrap">10:45 AM</div>
        </li>
        <li className="flex items-center justify-between p-4 hover:bg-gray-100 cursor-pointer">
          <div className="flex items-center space-x-4">
            <div className="relative">
              <div className="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">A</div>
              <span className="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 border-2 border-white rounded-full" />
            </div>
            <div>
              <p className="text-sm font-medium text-gray-900">Alice Smith</p>
              <p className="text-xs text-gray-500 truncate w-40">Sure, let's talk later.</p>
            </div>
          </div>
          <div className="text-xs text-gray-400 whitespace-nowrap">Yesterday</div>
        </li>
      </ul>
    </div>
  </div>
<OwnerMessageLayout/>
</div>

         </AppLayout>



        </template>
      <template #fallback>
         <PlaceholderPattern />
      
    </template>
  </Suspense>
</template>