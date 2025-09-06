<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { ElMessage } from 'element-plus';
import { defineAsyncComponent } from 'vue';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import UserModal from '@/components/modals/admincontrol/AddAccountModal.vue';
import DeleteModal from '@/components/modals/admincontrol/customDelete.vue';
import EditModal from '@/components/modals/admincontrol/EditPendingModal.vue';
import { ChevronUpIcon, ChevronDownIcon  } from '@heroicons/vue/20/solid';

const AppLayout = defineAsyncComponent(() => import('@/layouts/admincontrol/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  { 
    title: 'Pending Branches',
   href: '/admincontrol/PendingBranches' 
},
];

const props = defineProps<{
  perPage: number;
  search?: string;
  sortBy: string;
  sortDirection: string;
  PendingBranchs: {
    data: {
      id: number;
      name: string;
      email: string;
      branch_limit: number;
      subscription_expires_at?: string | null;
      pending_count: number;
      branches: {
        id: number;
        id_users: number;
        branch_name: string;
        status: string;
      }[];
    }[];
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


const isDropdownOpen = ref(false);
// Reactive state
const perPage = ref(props.perPage || 10);
const search = ref(props.search || '');
const sortBy = ref(props.sortBy || 'name');
const sortDirection = ref(props.sortDirection || 'asc');

// Watch for search changes
watch(search, (value) => {
  router.get(window.location.pathname,
    { perPage: perPage.value, search: value, sortBy: sortBy.value, sortDirection: sortDirection.value },
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
  const links = props.PendingBranchs.links || [];
  const numberLinks = links.filter(link => {
    const label = link.label.toLowerCase().replace(/&[a-z]+;/g, '').trim();
    return /^[0-9]+$/.test(label) || label === '...';
  });
  const currentPageIndex = numberLinks.findIndex(link => link.active);
  const start = Math.max(currentPageIndex - 2, 0);
  const end = Math.min(currentPageIndex + 3, numberLinks.length);
  return numberLinks.slice(start, end);
});

// Edit form
const form = useForm({
  branch_name: '',
  status: '',
  branch_logo: '',
  address: '',
  city: '',
  province: '',
  contact_number: '',
  email: '',
  created_at: '',
  total_branches : '',
});



// Edit modal
const showEditModalFlag = ref(false);
const selectedAccount = ref({
  id: null as number | null,
  branch_name: null as string | null,
  email: null as string | null,
  business_type: null as string | null,
  address: null as string | null,
  province: null as string | null,
  city: null as string | null,
  contact_number: null as string | null,
  branch_logo: null as string | null,  
  status: null as string | null,
  

});
function showEditModal(account: any) {
  selectedAccount.value = { ...account };
  showEditModalFlag.value = true;
}

function confirmEdit() {
  if (selectedAccount.value.id !== null) {
    form.put(route('admincontrol.PendingBranches.update', selectedAccount.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        ElMessage.success("User Account Updated Successfully!");
        showEditModalFlag.value = false;
        selectedAccount.value = { id: null, branch_name: null, email: null, business_type: null, address: null, province: null, city: null, contact_number: null, branch_logo: null, status: null};
      },
    });
  }
}

function formatDate(dateString) {
  if (!dateString) return 'N/A';
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
}
// Optional: auto-close on click outside
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false;
  }
}
</script>
<template>
  <Head title="Feedback Questions" />
  <Suspense>
    <template #default>
         <AppLayout :breadcrumbs="breadcrumbs">

          <EditModal
  v-model:visible="showEditModalFlag"
  :form="form"
  :selected-account="selectedAccount"
  @confirm="confirmEdit"
/>

          <div class="m-8">
    <div class="flex flex-col">
      <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
         <div class="flex items-center justify-between mb-4">
  <!-- Search Box -->
  <div class="relative text-gray-500 focus-within:text-gray-900">
    <div class="absolute inset-y-0 left-1 flex items-center pl-3 pointer-events-none">
      <!-- Search Icon -->
      <svg
        class="w-5 h-5"
        viewBox="0 0 20 20"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M17.5 17.5L15.4167 15.4167M15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333C11.0005 15.8333 12.6614 15.0929 13.8667 13.8947C15.0814 12.6872 15.8333 11.0147 15.8333 9.16667Z"
          stroke="#9CA3AF"
          stroke-width="1.6"
          stroke-linecap="round"
        />
      </svg>
    </div>
    <input
      type="text"
      v-model="search"
      id="default-search"
      class="block w-80 h-11 pr-5 pl-12 py-2.5 text-base font-normal shadow-xs text-gray-900 bg-transparent border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors duration-200"
      placeholder="Search for Users"
    />
  </div>

  <!-- Dropdown -->
  <!-- <div ref="dropdownRef" class="relative mr-4">
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

  =
    <ul
      v-show="isDropdownOpen"
      class="absolute right-0 rounded-sm shadow-lg bg-white py-2 z-[1000] min-w-full w-max divide-y divide-gray-200 max-h-96 overflow-auto"
    >
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Dropdown option</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Cloth set</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Sales details</li>
      <li class="px-5 py-2.5 hover:bg-gray-50 text-slate-600 text-sm font-medium cursor-pointer">Marketing</li>
    </ul>
  </div> -->
</div>

              <div class="overflow-hidden">
             <table
            class="min-w-full rounded-xl"
            :style="{ backgroundColor: 'var(--table-bg)', borderColor: 'var(--table-border)' }"
          >
            <thead>
              <tr :style="{ backgroundColor: 'var(--table-header-bg)',
                  border: '1px solid var(--table-border-tr)', 
               }">
                <th
                  scope="col"
                  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
                  :style="{ color: 'var(--table-header-text)' }"
                >
                #
                </th>
       <th
  scope="col"
  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
  :style="{ color: 'var(--table-header-text)' }"
>
  <div class="flex items-center gap-1 cursor-pointer" @click="handleSort('name')">
    Owner Name
    <ChevronUpIcon
      v-if="sortBy === 'name' && sortDirection === 'asc'"
      class="w-4 h-4 text-gray-500"
    />
    <ChevronDownIcon
      v-if="sortBy === 'name' && sortDirection === 'desc'"
      class="w-4 h-4 text-gray-500"
    />
  </div>
</th>
               <th
  scope="col"
  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
  :style="{ color: 'var(--table-header-text)' }"
>
  <div class="flex items-center gap-1 cursor-pointer" @click="handleSort('branch_limit')">
    Branch Limit
    <ChevronUpIcon
      v-if="sortBy === 'branch_limit' && sortDirection === 'asc'"
      class="w-4 h-4 text-gray-500"
    />
    <ChevronDownIcon
      v-if="sortBy === 'branch_limit' && sortDirection === 'desc'"
      class="w-4 h-4 text-gray-500"
    />
  </div>
</th>  
               <th
  scope="col"
  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
  :style="{ color: 'var(--table-header-text)' }"
>
  <div class="flex items-center gap-1 cursor-pointer" @click="handleSort('branch_limit')">
    Total Branches
    <ChevronUpIcon
      v-if="sortBy === 'branch_limit' && sortDirection === 'asc'"
      class="w-4 h-4 text-gray-500"
    />
    <ChevronDownIcon
      v-if="sortBy === 'branch_limit' && sortDirection === 'desc'"
      class="w-4 h-4 text-gray-500"
    />
  </div>
</th>  

                         <th
  scope="col"
  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
  :style="{ color: 'var(--table-header-text)' }"
>
  <div class="flex items-center gap-1 cursor-pointer" @click="handleSort('pending_count')">
    Pending Count
    <ChevronUpIcon
      v-if="sortBy === 'pending_count' && sortDirection === 'asc'"
      class="w-4 h-4 text-gray-500"
    />
    <ChevronDownIcon
      v-if="sortBy === 'pending_count' && sortDirection === 'desc'"
      class="w-4 h-4 text-gray-500"
    />
  </div>
</th> 
 <th
  scope="col"
  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
  :style="{ color: 'var(--table-header-text)' }"
>
  <div class="flex items-center gap-1 cursor-pointer" @click="handleSort('subscription_expires_at')">
   Owner Subscription Expires At
    <ChevronUpIcon
      v-if="sortBy === 'subscription_expires_at' && sortDirection === 'asc'"
      class="w-4 h-4 text-gray-500"
    />
    <ChevronDownIcon
      v-if="sortBy === 'subscription_expires_at' && sortDirection === 'desc'"
      class="w-4 h-4 text-gray-500"
    />
  </div>
</th> 
              <th
                  scope="col"
                  class="p-5 text-left text-sm leading-6 font-semibold capitalize rounded-t-xl"
                  :style="{ color: 'var(--table-header-text)' }"
                >
                    Actions
                  </th>
                </tr>
              </thead>
                  <tbody class="divide-y divide-gray-300"
                  >


                  
                    <tr
v-for="(user, index) in props.PendingBranchs.data" :key="user.id"
                      class="bg-white transition-all duration-500 hover:bg-gray-50"
                        :style="{ backgroundColor: 'var(--tbody-bg)' }"
                      >
                      <td
                        class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "
                        :style="{ color: 'var(--table-text)' }"
                      >
    {{ (props.PendingBranchs.from || 0) + index }}
                           
                      </td>
                      <td
                        class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"
                       :style="{ color: 'var(--table-text)' }"
                        >
           {{ user.name }}
                           
                      </td>


                 <td
                        class="p-5 whitespace-nowrap text-sm leading-6 text-red-500 bg-green-200 font-bold"
                      :style="{ color: 'var(--table-text)' }" >
                   {{user.branch_limit }}
                           
                      </td>
                                <td
                        class="p-5 whitespace-nowrap text-sm leading-6 text-red-500 bg-red-100 font-bold"
                      :style="{ color: 'var(--table-text)' }" >
                   {{user.total_branches  }}
                           
                      </td>
                                       <td
                        class="p-5 whitespace-nowrap text-sm leading-6  text-orange-500 bg-orange-100 font-bold"
                      :style="{ color: 'var(--table-text)' }" >
                   {{ user.pending_count  }}
                           
                      </td>
                      <td
                        class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"
                      :style="{ color: 'var(--table-text)' }" >
{{ formatDate(user.subscription_expires_at) }}


                      </td>

<td class="p-5">
  <div class="flex items-center gap-1">
  <a
  :href="`/admincontrol/branchesrequest/PendingView/${user.id}`"
  class="p-2 rounded-lg group transition-all duration-300 flex items-center gap-2 hover:bg-indigo-50"
>
  <!-- Eye Icon -->
  <svg
    xmlns="http://www.w3.org/2000/svg"
    class="w-5 h-5 text-indigo-500 group-hover:text-indigo-700 transition-colors duration-300"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    stroke-width="2"
  >
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 
    12 5c4.477 0 8.268 2.943 9.542 7-1.274 
    4.057-5.065 7-9.542 7-4.477 
    0-8.268-2.943-9.542-7z"/>
  </svg>
  <!-- Text -->
  <span class="whitespace-nowrap text-sm leading-6 font-semibold text-indigo-600 group-hover:text-indigo-800">
    View
  </span>
</a>


  </div>
</td>



  
                    </tr>
                  </tbody>
                </table>

     <div class="flex items-center justify-between mt-4">
    <!-- Left: Total Entries -->
<div class="flex items-center space-x-2 mb-4">
  <label for="perPage" class="text-sm">Entries per page:</label>
  <select
    id="perPage"
    v-model="perPage"
    @change="updatePerPage"
    class="border border-gray-300 rounded px-2 py-1 text-sm cursor-pointer "
  >
    <option v-for="option in [10, 20, 30, 40, 50, 100]" :key="option" :value="option">
      {{ option }}
    </option>
  </select>
</div>



    <!-- Right: Pagination -->
    <div class="flex space-x-1">
      <!-- First -->
      <!-- First -->
<button
  @click="goTo(PendingBranchs.first_page_url)"
  :disabled="!PendingBranchs.prev_page_url"
  :class="[
    'px-2 py-1 border rounded',
    PendingBranchs.prev_page_url ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'
  ]"
>
  First
</button>

<!-- Prev -->
<button
  @click="goTo(PendingBranchs.prev_page_url)"
  :disabled="!PendingBranchs.prev_page_url"
  :class="[
    'px-2 py-1 border rounded',
    PendingBranchs.prev_page_url ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'
  ]"
>
  Prev
</button>


      <!-- Numbers -->
 <button
  v-for="link in filteredLinks"
  :key="link.label"
  @click="goTo(link.url)"
  :disabled="!link.url"
  class="px-3 py-1 border rounded"
  :class="{
    'bg-blue-600 text-white': link.active,
    'text-gray-400 cursor-not-allowed': !link.url,
    'cursor-pointer': link.url, // ✅ Add cursor-pointer if clickable
  }"
>
  {{ link.label }}
</button>

<!-- Next -->
<button
  @click="goTo(PendingBranchs.next_page_url)"
  :disabled="!PendingBranchs.next_page_url"
  :class="[
    'px-2 py-1 border rounded',
    PendingBranchs.next_page_url ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'
  ]"
>
  Next
</button>

<!-- Last -->
<button
  @click="goTo(PendingBranchs.last_page_url)"
  :disabled="!PendingBranchs.next_page_url"
  :class="[
    'px-2 py-1 border rounded',
    PendingBranchs.next_page_url ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'
  ]"
>
  Last
</button>

    </div>
  </div>

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