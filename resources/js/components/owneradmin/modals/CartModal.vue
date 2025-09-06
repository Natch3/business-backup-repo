
<script setup lang="ts">

</script>
<template>
    <div 
   class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center px-0 sm:px-2 md:px-4">
<div class="bg-white md:w-full m-3 md:mx-auto w-full rounded-lg shadow-lg p-6 relative overflow-auto height-full max-h-[99vh]">
 
        <!-- Close Button -->
  <div class="relative"> <!-- Make sure parent has relative positioning -->
<button @click="$emit('close')"
  class="absolute cursor-pointer top-0 right-0 size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600 text-2xl">
  &times;
</button>

</div>


 <div class=" mx-auto p-4">
<h1 class="text-xl font-semibold text-slate-900 border-b border-gray-300 pb-2 mb-4">Shopping Cart</h1>

          <div class="grid lg:grid-cols-3 lg:gap-x-8 gap-x-6 gap-y-8 mt-6">
              <div class="lg:col-span-2 space-y-6 ">
                  <div class="flex gap-4 bg-white px-4 py-6 border-b border-gray-300">
                      <div class="flex gap-6 sm:gap-4 max-sm:flex-col">
                          <div class="w-24 h-24 max-sm:w-24 max-sm:h-24 shrink-0">
                              </div>
                          <div class="flex flex-col gap-4">
                              <div>
                                  <h3 class="text-sm sm:text-base font-semibold text-slate-900">Stylish Golden Watch</h3>
                                  
                                </div>
                              <div class="flex items-center gap-2 cursor-pointer">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 cursor-pointer fill-red-400 hover:fill-red-600 inline-block" viewBox="0 0 24 24">
                                  <path d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z" data-original="#000000"></path>
                                  <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z" data-original="#000000"></path>
                              </svg>
                                  <h3 class="text-sm font-semibold text-red-400 hover:text-red-600">Remove</h3>
                              </div>
                        
                       <div class="flex items-center gap-3 mt-auto">
                            <!-- Minus Button -->
                            <button type="button"
                                class="flex items-center justify-center w-6 h-6 cursor-pointer bg-slate-400 outline-none rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white" viewBox="0 0 124 124">
                                    <path d="M112 50H12C5.4 50 0 55.4 0 62s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12z" data-original="#000000"></path>
                                </svg>
                            </button>

                            <!-- Quantity -->
                            <span class="font-semibold text-base leading-[18px]">2</span>

                            <!-- Plus Button -->
                            <button type="button"
                                class="flex items-center justify-center w-6 h-6 cursor-pointer bg-slate-800 outline-none rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white" viewBox="0 0 42 42">
                                    <path d="M37.059 16H26V4.941C26 2.224 23.718 0 21 0s-5 2.224-5 4.941V16H4.941C2.224 16 0 18.282 0 21s2.224 5 4.941 5H16v11.059C16 39.776 18.282 42 21 42s5-2.224 5-4.941V26h11.059C39.776 26 42 23.718 42 21s-2.224-5-4.941-5z" data-original="#000000"></path>
                                </svg>
                            </button>
                            </div>        
                          </div>
                      </div>

                      <div class="ml-auto flex flex-col">
                          <div class="flex items-start gap-4 justify-end">
                             <h3 class="text-base font-semibold text-slate-900">₱20</h3>
                          </div>
                      </div>
                  </div>


              </div>

              <div class="bg-white rounded-md px-4 py-6 h-max shadow-sm border ">
                  <ul class="text-slate-500 font-medium space-y-4">
                      <li class="flex flex-wrap gap-4 text-sm">Subtotal <span class="ml-auto font-semibold text-slate-900">$200.00</span></li>
                      <li class="flex flex-wrap gap-4 text-sm">Shipping <span class="ml-auto font-semibold text-slate-900">$2.00</span></li>
                      <li class="flex flex-wrap gap-4 text-sm">Tax <span class="ml-auto font-semibold text-slate-900">$4.00</span></li>
                      <hr class="border-slate-300" />
                      <li class="flex flex-wrap gap-4 text-sm font-semibold text-slate-900">Total <span class="ml-auto">$206.00</span></li>
                  </ul>
                  <div class="mt-8 space-y-4">
                      <button type="button" class="text-sm px-4 py-2.5 w-full font-medium tracking-wide bg-slate-800 hover:bg-slate-900 text-white rounded-md cursor-pointer">Place Order</button>
                      <button
                       @click="$emit('close')"
                      type="button" class="text-sm px-4 py-2.5 w-full font-medium tracking-wide bg-slate-50 hover:bg-slate-100 text-slate-900 border border-gray-300 rounded-md cursor-pointer">Continue Shopping</button>
                  </div>
                  <div class="mt-5 flex flex-wrap justify-center gap-4">
                      <img src='https://readymadeui.com/images/master.webp' alt="card1" class="w-10 object-contain" />
                      <img src='https://readymadeui.com/images/visa.webp' alt="card2" class="w-10 object-contain" />
                      <img src='https://readymadeui.com/images/american-express.webp' alt="card3" class="w-10 object-contain" />
                  </div>
              </div>
          </div>
      </div>

      <!-- <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-danger-alert">
          Cancel
        </button>
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none" href="#">
         Submit
        </a>
      </div> -->
      </div>
    </div>

</template>