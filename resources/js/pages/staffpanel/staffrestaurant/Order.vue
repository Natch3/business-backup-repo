<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader
import { ref, onMounted,onBeforeUnmount } from 'vue'
import CartModals from '@/components/staff/modals/CartModal.vue';


const isDropdownOpen = ref(false);
const dropdownRef = ref(null);
const showCartModal = ref(false)
const cartCount = ref(3) // ← You can make this dynamic later
// Lazy-load the layout to enable suspense loading
const AppLayout = defineAsyncComponent(() => import('@/layouts/staff/staffRestaurant/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Order',
    href: '/staffpanel/Order',
  },
];
const imageSrc = ref('') // Set your image source here
const imageLoaded = ref(false)

onMounted(() => {
  if (!imageSrc.value) {
    imageLoaded.value = false
  }
})



// Optional: auto-close on click outside
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>
<template>
  <Head title="Order" />
  <Suspense>
    <template #default>
         <AppLayout :breadcrumbs="breadcrumbs">

<div class="w-full h-auto mt-4 px-6">
  <div class="flex justify-between items-center">
    
    <!-- Search Bar -->
    <div class="flex px-4 py-3 rounded-md border-2 border-blue-500 overflow-hidden max-w-md w-full">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px"
        class="fill-gray-600 mr-3 rotate-90">
        <path
          d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
        </path>
      </svg>
      <input type="text" placeholder="Search Something..."
        class="w-full outline-none bg-transparent text-gray-600 text-sm" />
    </div>

    <!-- Cart Button with Counter -->
    <div class="relative ml-4">
      <button type="button"
         @click="showCartModal = true"
        class="p-3 rounded-full bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer transition duration-300 ease-in-out"
        aria-label="Cart"
>
        <!-- Cart SVG Icon -->
        <svg fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 902.86 902.86" stroke="#ffffff" class="w-6 h-6">
          <path
            d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z">
          </path>
          <path
            d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717 
            c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744 
            c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742 
            C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744 
            c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z 
            M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742 
            S619.162,694.432,619.162,716.897z">
          </path>
        </svg>
      </button>

      <!-- Badge Counter -->
     <span v-if="cartCount > 0"
          class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full -mt-1 -mr-1">
          {{ cartCount }}
        </span>
    </div>

  </div>

</div>
<div class="w-full h-auto mt-4 px-6 flex justify-end items-center gap-2">
  <!-- Scanner Button -->
  <div class="w-max">
    <button
      type="button"
      class="p-2 rounded-sm border border-gray-300 bg-white hover:bg-gray-50 text-gray-600 cursor-pointer"
      aria-label="Scan barcode"
    >
      <!-- SVG Scanner Icon -->
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
        <g id="SVGRepo_iconCarrier">
          <path d="M10 22C9.65081 22 9.31779 22 9 21.9991M2 15C2 18.7712 2 19.6569 3.17157 20.8284C3.82475 21.4816 4.69989 21.7706 6 21.8985"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
          <path d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
          <path d="M14 2C14.3492 2 14.6822 2 15 2.00093M22 9C22 5.22876 22 4.34315 20.8284 3.17157C20.1752 2.51839 19.3001 2.22937 18 2.10149"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
          <path d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
          <path d="M2 12H8M22 12H12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
        </g>
      </svg>
    </button>
  </div>

  <!-- Dropdown -->
  <div ref="dropdownRef" class="relative w-max">
    <button
      type="button"
      @click="isDropdownOpen = !isDropdownOpen"
      class="px-5 py-2.5 rounded-sm border border-gray-300 cursor-pointer text-slate-900 text-sm font-medium outline-none bg-white hover:bg-gray-50"
    >
      Dropdown menu
      <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-500 inline ml-2" viewBox="0 0 24 24">
        <path fill-rule="evenodd"
          d="M11.99997 18.1669a2.38 2.38 0 0 1-1.68266-.69733l-9.52-9.52a2.38 2.38 0 1 1 3.36532-3.36532l7.83734 7.83734 7.83734-7.83734a2.38 2.38 0 1 1 3.36532 3.36532l-9.52 9.52a2.38 2.38 0 0 1-1.68266.69734z"
          clip-rule="evenodd" />
      </svg>
    </button>

    <!-- Dropdown menu -->
    <ul
      v-show="isDropdownOpen"
      class="absolute rounded-sm shadow-lg bg-white py-2 z-[1000] min-w-full w-max divide-y divide-gray-200 max-h-96 overflow-auto"
    >
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Dropdown option</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Cloth set</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Sales details</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Marketing</li>
    </ul>
  </div>
</div>

          
<div class="py-2 px-4 sm:px-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 sm:gap-6 gap-4">

             <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm overflow-hidden  relative">
  <div class="aspect-square rounded-full overflow-hidden mx-auto">
    <img  
      :src="imageSrc"
      alt="Product Image"
      @load="imageLoaded = true"
      v-show="imageLoaded"
      class="h-full w-full object-cover object-top rounded-lg z-10" 
    />
    <!-- fallback if no image -->
    <PlaceholderPattern v-if="!imageLoaded" />
  </div>

  <div class="mt-3 text-center">
    <h4 class="text-slate-900 text-sm font-semibold">Up To 40% OFF</h4>
  </div>

  <!-- fixed button -->
  <div class="mt-6 flex justify-center">
    <button 
      type="button" 
      class="text-[15px] cursor-pointer   font-medium px-6 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white tracking-wide w-full md:w-auto"
    >
      Buy again
    </button>
  </div>
</div>

              

            </div>
        </div>
<!-- End Listings -->
           <CartModals v-if="showCartModal" @close="showCartModal = false"/>
         </AppLayout>



        </template>
      <template #fallback>
         <PlaceholderPattern />
      
    </template>
  </Suspense>
</template>