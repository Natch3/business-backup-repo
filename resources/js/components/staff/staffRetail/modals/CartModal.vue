<script setup lang="ts">
import { computed, ref, watch } from "vue"
import { useForm } from '@inertiajs/vue3'
import { ElMessage } from "element-plus";
import qz from "qz-tray"

const props = defineProps({
  items: { type: Array, default: () => [] },
  addBag: { type: Boolean, default: false },
  bagPrice: { type: Number, default: 5 }
})
const emit = defineEmits(['orderPlaced'])
// reactive states
const cash_given = ref(0)
const addBag = ref(props.addBag)
const bagPrice = ref(props.bagPrice)

// computed values
const subtotalPrice = computed(() => {
  return props.items.reduce((sum, item) => sum + (Number(item.product_price) * item.quantity), 0)
})

const totalAmount = computed(() => subtotalPrice.value + (addBag.value ? bagPrice.value : 0))
const change = computed(() => cash_given.value - totalAmount.value)

// inertia form
const form = useForm({
  items: props.items.map(item => ({
    product_id: item.id ?? null,
    product_name: item.product_name,
    product_price: item.product_price,
    quantity: item.quantity
  })),
  subtotal: subtotalPrice.value,
  addBag: addBag.value,
  bagPrice: addBag.value ? bagPrice.value : 0,
  total_amount: totalAmount.value,
  cash_given: cash_given.value,
  change_amount: change.value
})

// keep form in sync with refs/computeds
watch([subtotalPrice, addBag, bagPrice, totalAmount, cash_given, change], () => {
  form.subtotal = subtotalPrice.value
  form.addBag = addBag.value
  form.bagPrice = addBag.value ? bagPrice.value : 0
  form.total_amount = totalAmount.value
  form.cash_given = cash_given.value
  form.change_amount = change.value
})

const showReceiptModal = ref(false)
const receiptData = ref("")


// place order handler
const placeOrder = () => {
  if (!cash_given.value || cash_given.value <= 0) {
    ElMessage.warning('Please enter cash amount before placing the order.')
    return
  }

  if (change.value < 0) {
    ElMessage.error('Cash is not enough.')
    return
  }

// helper to format each line properly
function formatLine(name: string, qty: number, price: number, width = 28) {
  const item = `${name} x${qty}`;
  const priceStr = `₱${price.toFixed(2)}`;
  const space = width - item.length - priceStr.length;
  return item + " ".repeat(space > 0 ? space : 1) + priceStr;
}

receiptData.value = `
    *** Diskubre Store ***
    Tangub City, Mis. Occ.

    --------------------------
${props.items.map(i => 
  formatLine(i.product_name, i.quantity, i.product_price * i.quantity)
).join("\n")}
    --------------------------
Subtotal:           ₱${subtotalPrice.value.toFixed(2)}
Bag:                ${addBag.value ? "₱" + bagPrice.value.toFixed(2) : "N/A"}
Total:              ₱${totalAmount.value.toFixed(2)}
Cash:               ₱${cash_given.value.toFixed(2)}
Change:             ₱${change.value.toFixed(2)}

    --------------------------
    Thank you!
    Please come again.
`

// ✅ Show modal instead of saving immediately
showReceiptModal.value = true

}

const commitOrder = () => {
  form.post(route('staffpanel.staffretail.Order.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      cash_given.value = 0
      showReceiptModal.value = false
      ElMessage.success('Order placed & successfully Print!')
      emit('orderPlaced')

      // 🔽 Auto print after saving
      qz.websocket.connect()
        .then(() => qz.printers.find("POS-58")) // replace with your printer name
        .then(printer => {
          return qz.print({ printer }, [
            { type: 'raw', format: 'plain', data: receiptData.value }
          ])
        })
        .catch(err => console.error("Print error:", err))
    },
    onError: (errors) => {
      console.error(errors)
      ElMessage.error('Failed to place order.')
    }
  })
}


</script>

<template>
    <form @submit.prevent="placeOrder">
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


 <div class="p-4">
<h1 class="text-xl font-semibold text-slate-900 border-b border-gray-300 pb-2 mb-4">Placement Cart</h1>

<div class="grid lg:grid-cols-3 lg:gap-x-8 gap-x-6 gap-y-8 mt-6">
              <div  v-if="items.length > 0"           class="lg:col-span-2 space-y-6 max-h-[70vh] overflow-y-auto pr-2">
                  <div   v-for="(item, index) in items"
          :key="index"
                     class="flex gap-4 bg-white px-4 py-6 border-b border-gray-300">
                      <div class="flex gap-6 sm:gap-4 max-sm:flex-col">
                          <div class="w-24 h-24 max-sm:w-24 max-sm:h-24 shrink-0">
                              <!-- Image with fallback -->
<!-- Image with fallback -->
<img
  v-if="item.images && item.images.length > 0"
  :src="`/storage/${item.images[0].image_path}`"
  alt="Product Image"
  class="w-full h-full object-contain"
  @error="(e) => { e.target.style.display='none'; e.target.nextElementSibling.style.display='flex' }"
/>

<!-- Placeholder Box (hidden by default) -->
<div class="w-full h-full hidden items-center justify-center border-2 border-dashed border-gray-400 bg-gray-100">
  <span class="text-gray-500 text-2xl">//</span>
</div>

 </div>
                          <div class="flex flex-col gap-4">
                              <div>
                                  <h3 class="text-sm sm:text-base font-semibold text-slate-900">{{ item.product_name }}</h3>
                                  
                                </div>
                              <div class="flex items-center gap-2 cursor-pointer">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 cursor-pointer fill-red-400 hover:fill-red-600 inline-block" viewBox="0 0 24 24">
                                  <path d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z" data-original="#000000"></path>
                                  <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z" data-original="#000000"></path>
                              </svg>
                                  <h3     @click="removeItem(index)" class="text-sm font-semibold text-red-400 hover:text-red-600">Remove</h3>
                              </div>
                        
<!-- Quantity Controls -->
  <div class="flex items-center gap-3 mt-auto">
    <!-- Minus Button -->
    <button type="button"
      class="flex items-center justify-center w-6 h-6 cursor-pointer bg-slate-400 outline-none rounded-md"
      @click="decreaseQuantity(index)">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white" viewBox="0 0 124 124">
        <path d="M112 50H12C5.4 50 0 55.4 0 62s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12z"></path>
      </svg>
    </button>

    <!-- Quantity -->
    <span class="font-semibold text-base leading-[18px]">{{ item.quantity }}</span>

    <!-- Plus Button -->
    <button type="button"
      class="flex items-center justify-center w-6 h-6 cursor-pointer bg-slate-800 outline-none rounded-md"
      @click="increaseQuantity(index)">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white" viewBox="0 0 42 42">
        <path d="M37.059 16H26V4.941C26 2.224 23.718 0 21 0s-5 2.224-5 4.941V16H4.941C2.224 16 0 18.282 0 21s2.224 5 4.941 5H16v11.059C16 39.776 18.282 42 21 42s5-2.224 5-4.941V26h11.059C39.776 26 42 23.718 42 21s-2.224-5-4.941-5z"></path>
      </svg>
    </button>
  </div>      
                          </div>
                      </div>

                      <div class="ml-auto flex flex-col">
                          <div class="flex items-start gap-4 justify-end">
                             <h3 class="text-base font-semibold text-slate-900">₱ {{ item.product_price }}</h3>
                          </div>
                      </div>
                  </div>


              </div>

<div class="bg-white rounded-md px-4 py-6 h-max shadow-sm border lg:col-span-1 lg:col-start-3">
    <ul class="text-slate-500 font-medium space-y-4">
      <li class="flex flex-wrap gap-4 text-sm">
        Subtotal <span class="ml-auto font-semibold text-slate-900">₱ {{ subtotalPrice }}</span>
      </li>
 <li class="flex items-center justify-between gap-4 text-sm">
   <!-- ✅ Eco Bag Checkbox + Editable Price -->
<div class="flex items-center gap-2">
  <!-- Checkbox for selecting -->
  <input 
    type="checkbox" 
    id="addBag" 
    v-model="addBag" 
    class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
  >
  <label for="addBag" class="text-slate-500 font-medium">Eco Bag</label>
</div>

<!-- Editable price -->
<div class="flex items-center gap-1" v-if="addBag">
  <span class="text-slate-900">₱</span>
  <input 
    type="number" 
    v-model.number="bagPrice" 
    min="0" 
    step="5"
    class="w-16 border-b-2 text-right text-slate-900 focus:outline-none"
  >
</div>

<!-- If not checked, show 0 -->
<div v-else class="flex items-center gap-1 text-slate-400">
  <span class="text-slate-900">₱</span> 0
</div>
  </li>


      <hr class="border-slate-300" />
      <li class="flex flex-wrap gap-4 text-sm font-semibold text-slate-900">
        Total <span class="ml-auto">₱ {{ totalAmount }}</span>
      </li>
   <li class="flex items-center justify-between gap-4 text-sm">
      <div class="flex items-center gap-2">
        <label for="cash_given" class="text-slate-900 font-semibold">Cash</label>
      </div>
      <div class="flex items-center gap-1">
        <span class="text-slate-900">₱</span>
<input 
  type="number" 
  id="cash_given" 
  v-model.number="cash_given" 
  min="0" 
  step="1"
  class="w-16 border-b-2 text-right text-slate-900 focus:outline-none"
/>

      </div>
    </li>
          <li class="flex flex-wrap gap-4 text-sm font-semibold text-slate-900">
        Change <span class="ml-auto">₱ {{ change  }}</span>
      </li>
    </ul>

    <div class="mt-8 space-y-4">
      <button         type="submit" 
         
              class="text-sm px-4 py-2.5 w-full font-medium tracking-wide bg-slate-800 hover:bg-slate-900 text-white rounded-md cursor-pointer">
        Place Order
      </button>
      <button @click="$emit('close')"
              type="button"
              class="text-sm px-4 py-2.5 w-full font-medium tracking-wide bg-slate-50 hover:bg-slate-100 text-slate-900 border border-gray-300 rounded-md cursor-pointer">
        Continue Shopping
      </button>
    </div>
                      <div class="mt-5 flex flex-wrap justify-center gap-4">
                      <img src='https://readymadeui.com/images/master.webp' alt="card1" class="w-10 object-contain" />
                      <svg  class="w-10 object-contain" viewBox="0 -140 780 780" enable-background="new 0 0 780 500" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m293.2 348.73l33.359-195.76h53.358l-33.384 195.76h-53.333zm246.11-191.54c-10.569-3.966-27.135-8.222-47.821-8.222-52.726 0-89.863 26.551-90.181 64.604-0.297 28.129 26.515 43.822 46.754 53.185 20.771 9.598 27.752 15.716 27.652 24.283-0.133 13.123-16.586 19.115-31.924 19.115-21.355 0-32.701-2.967-50.225-10.273l-6.878-3.111-7.487 43.822c12.463 5.467 35.508 10.199 59.438 10.445 56.09 0 92.502-26.248 92.916-66.885 0.199-22.27-14.016-39.215-44.801-53.188-18.65-9.056-30.072-15.099-29.951-24.269 0-8.137 9.668-16.838 30.56-16.838 17.446-0.271 30.088 3.534 39.936 7.5l4.781 2.259 7.231-42.427m137.31-4.223h-41.23c-12.772 0-22.332 3.486-27.94 16.234l-79.245 179.4h56.031s9.159-24.121 11.231-29.418c6.123 0 60.555 0.084 68.336 0.084 1.596 6.854 6.492 29.334 6.492 29.334h49.512l-43.187-195.64zm-65.417 126.41c4.414-11.279 21.26-54.724 21.26-54.724-0.314 0.521 4.381-11.334 7.074-18.684l3.606 16.878s10.217 46.729 12.353 56.527h-44.293v3e-3zm-363.3-126.41l-52.239 133.5-5.565-27.129c-9.726-31.274-40.025-65.157-73.898-82.12l47.767 171.2 56.455-0.063 84.004-195.39-56.524-1e-3" fill="#0E4595"></path><path d="m146.92 152.96h-86.041l-0.682 4.073c66.939 16.204 111.23 55.363 129.62 102.42l-18.709-89.96c-3.229-12.396-12.597-16.096-24.186-16.528" fill="#F2AE14"></path></g></svg>
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
    <!-- Receipt Modal -->
<div v-if="showReceiptModal" class="fixed z-50 inset-0 overflow-y-auto">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!-- Overlay -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

    <!-- Modal -->
    <div class="inline-block align-bottom bg-white rounded-lg px-6 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
      <div class="sm:flex sm:items-start">
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Receipt Preview</h3>
          <div class="mt-4 p-4 border rounded bg-gray-50">
            <pre class="text-sm text-gray-800 whitespace-pre-wrap">{{ receiptData }}</pre>
          </div>
        </div>
      </div>
      <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        <button @click="commitOrder" type="button" class="cursor-pointer w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
          Commit
        </button>
        <button @click="showReceiptModal = false" type="button" class="cursor-pointer mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 sm:mt-0 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

</form>
</template>
<style scoped>
/* For Chrome, Safari, Edge, Opera */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* For Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>