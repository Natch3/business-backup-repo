<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // This now includes the Tailwind loader
import iconIlustration from '@/assets/img/illustrationIcon.png';

const AppLayout = defineAsyncComponent(() => import('@/layouts/staff/staffRetail/AppLayout.vue'));

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/staffpanel/staffretail/dashboard',
  },
];


</script>
<template>
  <Head title="Dashboard" />
  <Suspense>
<template #default>
  <AppLayout :breadcrumbs="breadcrumbs">
 <div class="bg-gray-100 ">
  <div class="px-8 pt-8 pb-2">

            <!-- Large item -->
<div class="md:col-span-2 md:row-span-2 flex relative overflow-hidden bg-white border border-gray-200 shadow-2xs rounded-xl group px-6 pt-6">
  <!-- Left Content -->
  <div class="flex-1 pr-4 flex flex-col">
    <div class="mb-4">
  <h2 class="text-lg font-bold mb-2">
    Congratulations {{ $page.props.auth?.user?.name }}! 🎉
  </h2>
      <p class="text-sm text-gray-700 ">
        You have done <span class="font-semibold">72% more sales today</span>.
        <br />
        Check your new raising badge in your profile.
      </p>
    </div>

    <!-- Explore More Button at Bottom -->
    <div class="mt-auto mb-4">
      <button
        class="px-3 py-1.5 bg-blue-600 text-sm text-white rounded-lg shadow hover:bg-blue-700"
      >
        Explore More
      </button>
    </div>
  </div>

  <!-- Right Image -->
  <div class="flex-shrink-0 mt-4 md:mt-0 mr-6">
    <img
      :src="iconIlustration"
      alt="Illustration"
      class="max-h-45 w-full object-contain"
    />
  </div>
</div>



  </div>





   
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">

          <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
              <!-- Card -->
              <div
                class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
              >
                <div class="p-4 md:p-5">
                  <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                      Total users
                    </p>
                    <div class="hs-tooltip">
                      <div class="hs-tooltip-toggle">
                        <svg
                          class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        >
                          <circle cx="12" cy="12" r="10" />
                          <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                          <path d="M12 17h.01" />
                        </svg>
                        <span
                          class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700"
                          role="tooltip"
                        >
                          The number of daily users
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="mt-1 flex items-center gap-x-2">
                    <h3
                      class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200"
                    >
                      72,540
                    </h3>
                    <span class="flex items-center gap-x-1 text-green-600">
                      <svg
                        class="inline-block size-4 self-center"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      >
                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                        <polyline points="16 7 22 7 22 13" />
                      </svg>
                      <span class="inline-block text-sm"> 1.7% </span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- End Card -->

              <!-- Card -->
              <div
                class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
              >
                <div class="p-4 md:p-5">
                  <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                      Sessions
                    </p>
                  </div>

                  <div class="mt-1 flex items-center gap-x-2">
                    <h3
                      class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200"
                    >
                      29.4%
                    </h3>
                  </div>
                </div>
              </div>
              <!-- End Card -->

              <!-- Card -->
              <div
                class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
              >
                <div class="p-4 md:p-5">
                  <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                      Avg. Click Rate
                    </p>
                  </div>

                  <div class="mt-1 flex items-center gap-x-2">
                    <h3
                      class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200"
                    >
                      56.8%
                    </h3>
                    <span class="flex items-center gap-x-1 text-red-600">
                      <svg
                        class="inline-block size-4 self-center"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      >
                        <polyline points="22 17 13.5 8.5 8.5 13.5 2 7" />
                        <polyline points="16 17 22 17 22 11" />
                      </svg>
                      <span class="inline-block text-sm"> 1.7% </span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- End Card -->

              <!-- Card -->
              <div
                class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
              >
                <div class="p-4 md:p-5">
                  <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                      Pageviews
                    </p>
                  </div>

                  <div class="mt-1 flex items-center gap-x-2">
                    <h3
                      class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200"
                    >
                      92,913
                    </h3>
                  </div>
                </div>
              </div>
              <!-- End Card -->
            </div>
            <!-- End Grid -->

            <div class="grid lg:grid-cols-2 gap-4 sm:gap-6">
              <!-- Card -->
           <!-- Card -->
<div class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
  <!-- Header -->
  <div class="flex flex-wrap justify-between items-center gap-2">
    <div>
      <h2 class="text-sm text-gray-500 dark:text-neutral-500">
        Income
      </h2>
      <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
        $126,238.49
      </p>
    </div>

    <div>
      <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500">
        <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
        25%
      </span>
    </div>
  </div>
  <!-- End Header -->

  <VisitorsChart />
</div>
<!-- End Card -->
              <!-- End Card -->

              <!-- Card -->
              <div
                class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
              >
                <!-- Header -->
                <div class="flex flex-wrap justify-between items-center gap-2">
                  <div>
                    <h2 class="text-sm text-gray-500 dark:text-neutral-500">Visitors</h2>
                    <p
                      class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200"
                    >
                      80.3k
                    </p>
                  </div>

                  <div>
                    <span
                      class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500"
                    >
                      <svg
                        class="inline-block size-3.5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      >
                        <path d="M12 5v14" />
                        <path d="m19 12-7 7-7-7" />
                      </svg>
                      2%
                    </span>
                  </div>
                </div>
                <!-- End Header -->

              <BarChart />
              </div>
            </div>
            <!-- End Card -->
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