<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader
import LogoImage from '@/assets/img/logo/profile-icon-design-free-vector.jpg';

// Lazy-load the layout to enable suspense loading
const AppLayout = defineAsyncComponent(() => import('@/layouts/staff/staffSalon/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Feedback Questions',
    href: '/staffpanel/feedback-question',
  },
];
</script>
<template>
  <Head title="Feedback Questions" />
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


<div className="hidden lg:flex-1 lg:flex lg:flex-col">
    <div className="flex-1 overflow-y-auto p-6">
      <div className="text-center">
        <h1 className="text-3xl font-bold text-gray-800 sm:text-4xl">
          Welcome to Preline AI
        </h1>
        <p className="mt-3 text-gray-600">Your AI-powered copilot for the web</p>
      </div>

      <ul className="mt-10 space-y-5">
        <li className="flex gap-x-4">
          <div className="shrink-0 size-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
            AI
          </div>
          <div className="inline-block bg-white border border-gray-200 rounded-lg p-4 space-y-3">
            <h2 className="font-medium text-gray-800">How can we help?</h2>
            <div className="text-sm text-gray-700">
              <p>You can ask questions like:</p>
              <ul className="list-disc pl-5 mt-2 space-y-1">
                <li>What's Preline UI?</li>
                <li>How many Starter Pages & Examples are there?</li>
                <li>Is there a PRO version?</li>
              </ul>
            </div>
          </div>
        </li>

        <li className="flex justify-end gap-x-4">
          <div className="text-end space-y-3">
            <div className="inline-block bg-blue-600 rounded-lg p-4 shadow text-white text-sm">
              What's Preline UI?
            </div>
          </div>
          <span className="shrink-0 size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
            AZ
          </span>
        </li>
        
        <li className="flex justify-end gap-x-4">
          <div className="text-end space-y-3">
            <div className="inline-block bg-blue-600 rounded-lg p-4 shadow text-white text-sm">
              What's Preline UI?
            </div>
          </div>
          <span className="shrink-0 size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
            AZ
          </span>
        </li>
        
        <li className="flex justify-end gap-x-4">
          <div className="text-end space-y-3">
            <div className="inline-block bg-blue-600 rounded-lg p-4 shadow text-white text-sm">
              What's Preline UI?
            </div>
          </div>
          <span className="shrink-0 size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
            AZ
          </span>
        </li>
        
        <li className="flex justify-end gap-x-4">
          <div className="text-end space-y-3">
            <div className="inline-block bg-blue-600 rounded-lg p-4 shadow text-white text-sm">
              What's Preline UI?
            </div>
          </div>
          <span className="shrink-0 size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
            AZ
          </span>
        </li>
        
        <li className="flex justify-end gap-x-4">
          <div className="text-end space-y-3">
            <div className="inline-block bg-blue-600 rounded-lg p-4 shadow text-white text-sm">
              What's Preline UI?
            </div>
          </div>
          <span className="shrink-0 size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">
            AZ
          </span>
        </li>
      </ul>
    </div>

    <div className="border-t bg-white p-4">
      <div className="relative">
        <textarea
          className="w-full p-4 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:outline-none"
          rows={2}
          placeholder="Type your message..."
        ></textarea>
        <div className="absolute bottom-4 right-4 flex items-center gap-2">
         <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
              </button>
    <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-hidden focus:bg-blue-500">
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                </svg>
              </button>
        </div>
      </div>
    </div>
  </div>
</div>
         </AppLayout>



        </template>
      <template #fallback>
         <PlaceholderPattern />
      
    </template>
  </Suspense>
</template>