<script setup lang="ts">
import { ref, computed, watch ,defineAsyncComponent} from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/vue3';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader
import {  onMounted,onBeforeUnmount } from 'vue'
import CartModals from '@/components/staff/staffRetail/modals/CartModal.vue';

import { ElMessage } from 'element-plus';

const dropdownRef = ref(null);


// Lazy-load the layout to enable suspense loading
const AppLayout = defineAsyncComponent(() => import('@/layouts/staff/staffRetail/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Order',
    href: '/staffpanel/Order',
  },
];


const props = defineProps<{
    perPage: number;
  search?: string;
  sortBy: string;
   category?: string;
  sortDirection: string;
  inventoryRetail: {
    data: any[];
    links: any[];
    current_page: number;
    last_page: number;
    total: number;
    from: number;
    to: number;
    first_page_url: string | null;
    prev_page_url: string | null;
    next_page_url: string | null;
    last_page_url: string | null;
  };
}>();

const form = useForm({
  product_name: '',
  product_description: '',
  product_category: '',
  product_stock_quantity: '',
    product_price: '',
      product_unit: '',
        product_sku: '',
          created_at: '',
  // other fields...
});
const showCartModal = ref(false)
const cartItems = ref([])
const cartCount = ref(0)
const cash_given = ref(0) 
const addBag = ref(false)
const bagPrice = ref(5)

// Add product
const addToCart = (product) => {
  const existing = cartItems.value.find(p => p.id === product.id)

  if (existing) {
    // if already in cart, just increase quantity
    existing.quantity++
  } else {
    // if first time, add with quantity = 1
    cartItems.value.push({ ...product, quantity: 1 })
  }

  updateCartCount()
}

// Remove product
const removeFromCart = (index) => {
  cartItems.value.splice(index, 1)
  updateCartCount()
}

// Update quantity
const updateQuantity = ({ index, type }) => {
  const item = cartItems.value[index]
  if (!item) return

  if (type === "increase") {
    item.quantity++
  } else if (type === "decrease") {
    item.quantity--
    if (item.quantity <= 0) {
      cartItems.value.splice(index, 1) // auto remove if 0
    }
  }

  updateCartCount()
}

// keep cartCount synced with all quantities
const updateCartCount = () => {
  cartCount.value = cartItems.value.reduce((sum, item) => sum + item.quantity, 0)
}

const imageSrc = ref('') // Set your image source here

const imageLoaded = ref(false)
const showLoader = ref(true)

const handleImageLoad = () => {
  // Wait 3 seconds before showing image
  setTimeout(() => {
    imageLoaded.value = true
    showLoader.value = false
  }, 3000) // change to 4000 for 4s
}

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


// Reactive state
const perPage = ref(props.perPage || 10);
const search = ref(props.search || '');
const sortBy = ref(props.sortBy || 'branch_name');
const sortDirection = ref(props.sortDirection || 'asc');
const isDropdownOpen = ref(false);
const category = ref(props.category || ''); 

watch(search, (value) => {
  router.get(window.location.pathname,
    {
      perPage: perPage.value,
      search: value,
      category: category.value, // ✅ include category in search
      sortBy: sortBy.value,
      sortDirection: sortDirection.value,
    },
    { preserveState: true, replace: true }
  );
});

// Watch for category changes
watch(category, (value) => {
  router.get(window.location.pathname,
    {
      perPage: perPage.value,
      search: search.value,
      category: value, // ✅ apply category filter
      sortBy: sortBy.value,
      sortDirection: sortDirection.value,
    },
    { preserveState: true, replace: true }
  );
});
// Sort handler
function handleSort(column: string) {
  if (sortBy.value === column) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortBy.value = column;
    sortDirection.value = 'asc';
  }

  router.get(window.location.pathname,
    {
      perPage: perPage.value,
      search: search.value,
      sortBy: sortBy.value,
      sortDirection: sortDirection.value,
    },
    { preserveState: true, replace: true }
  );
} // ← closing brace added here

// Update per-page select
function updatePerPage() {
  router.get(window.location.pathname,
    {
      perPage: perPage.value,
      search: search.value,
      sortBy: sortBy.value,
      sortDirection: sortDirection.value,
    },
    { preserveState: true, preserveScroll: true }
  );
}

// Pagination links
function goTo(url: string | null) {
  if (!url) return;
  const fullUrl = new URL(url, window.location.origin);
  fullUrl.searchParams.set('perPage', perPage.value.toString());
  fullUrl.searchParams.set('search', search.value);
  fullUrl.searchParams.set('sortBy', sortBy.value);
  fullUrl.searchParams.set('sortDirection', sortDirection.value);

  router.visit(fullUrl.toString(), {
    preserveScroll: true,
    preserveState: true,
  });
}

const filteredLinks = computed(() => {
  const links = props.branches.links || [];
  const numberLinks = links.filter(link => {
    const label = link.label.toLowerCase().replace(/&[a-z]+;/g, '').trim();
    return /^[0-9]+$/.test(label) || label === '...';
  });
  const currentPageIndex = numberLinks.findIndex(link => link.active);
  const start = Math.max(currentPageIndex - 2, 0);
  const end = Math.min(currentPageIndex + 3, numberLinks.length);
  return numberLinks.slice(start, end);
});

const handleOrderPlaced = () => {
  showCartModal.value = false   // ✅ close modal
  cartItems.value = []          // ✅ clear cart
  cartCount.value = 0           // ✅ reset counter
  cash_given.value = 0          // ✅ reset cash
  addBag.value = false          // ✅ reset eco bag
}
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
            v-model="search"
      id="default-search"
        class="w-full outline-none bg-transparent text-gray-600 text-sm" />
    </div>

    <!-- Cart Button with Counter -->
 <div class="relative ml-4">
    <button type="button"
      @click="showCartModal = true"
      class="p-3 rounded-full bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer transition duration-300 ease-in-out"
      aria-label="Cart"
    >
      <!-- SVG Icon -->
      <svg fill="#ffffff" version="1.1" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 902.86 902.86" stroke="#ffffff" class="w-6 h-6">
        <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z"/>
        <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717 c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744 c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742 C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744 c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z  M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742  S619.162,694.432,619.162,716.897z"/>
      </svg>
    </button>

    <!-- Badge -->
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
<!-- Dropdown menu -->
<!-- Dropdown menu -->
<ul
  v-show="isDropdownOpen"
  class="absolute rounded-sm shadow-lg bg-white py-2 z-[1000] min-w-full w-max divide-y divide-gray-200 max-h-96 overflow-auto"
>
  <!-- All option -->
  <li
    @click="category = ''; isDropdownOpen = false"
    :class="[
      'px-5 py-2.5 text-sm font-medium cursor-pointer',
      category === '' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-gray-50'
    ]"
  >
    All Categories
  </li>

  <!-- Dynamic categories -->
  <li
    v-for="cat in ['Beverages','Snacks','Dairy','Household']"
    :key="cat"
    @click="category = cat; isDropdownOpen = false"
    :class="[
      'px-5 py-2.5 text-sm font-medium cursor-pointer',
      category === cat ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-gray-50'
    ]"
  >
    {{ cat }}
  </li>
</ul>


  </div>
</div>

          
<div class="py-2 px-4 sm:px-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 sm:gap-6 gap-4">
  <div v-for="Retail in props.inventoryRetail.data"
       :key="Retail.id"
       class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm overflow-hidden relative">

<div class="aspect-square rounded-full overflow-hidden mx-auto relative flex items-center justify-center bg-white">
    <!-- Loader -->
<div 
  v-if="showLoader" 
  class="flex space-x-2 justify-center items-center absolute inset-0 bg-white "
>
  <span class="sr-only">Loading...</span>
  
  <div class="flex space-x-2 border-1 border-gray-300 p-3 h-full w-full justify-center items-center rounded-full">
    <div class="h-3 w-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
    <div class="h-3 w-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
    <div class="h-3 w-3 bg-blue-600 rounded-full animate-bounce"></div>
  </div>
</div>


    <!-- Image -->
    <img  
      v-if="Retail.images.length > 0"
      :src="`/storage/${Retail.images[0].image_path}`" 
      alt="Product Image"
      class="h-full w-full object-cover object-top rounded-lg z-10 transition-opacity duration-500"
      :class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }"
      @load="handleImageLoad"
    />
  </div>

    <div class="mt-3 text-center">
      <h4 class="text-slate-900 text-sm font-semibold">
        {{ Retail.product_name ?? "No Name" }}
      </h4>
    </div>

    <div class="mt-6 flex justify-center">
      <button 
        type="button" 
        @click="addToCart(Retail)"  
        class="text-[15px] cursor-pointer font-medium px-6 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white tracking-wide w-full md:w-auto"
      >
        Buy again
      </button>
    </div>
  </div>

              

            </div>
        </div>
<!-- End Listings -->
  <CartModals 
    v-if="showCartModal" 
    :items="cartItems" 
    @close="showCartModal = false" 
    @remove="removeFromCart" 
      @updateQuantity="updateQuantity" 
      v-model:cash_given="cash_given"
      v-model:addBag="addBag"
      v-model:bagPrice="bagPrice" 
       @orderPlaced="handleOrderPlaced"
  />
         </AppLayout>



        </template>
      <template #fallback>
         <PlaceholderPattern />
      
    </template>
  </Suspense>
</template>