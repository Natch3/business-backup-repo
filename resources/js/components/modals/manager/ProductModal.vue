<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import { LoaderCircle } from 'lucide-vue-next';

import vueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

// Register FilePond with plugins
const FilePond = vueFilePond(FilePondPluginImagePreview, FilePondPluginFilePoster);

// Reactive states
const dialogVisible = ref(false);
const dialogWidth = ref("90%"); // Default width

// Update dialog width based on screen size
function updateDialogWidth() {
  const screenWidth = window.innerWidth;
  dialogWidth.value = screenWidth >= 1024 ? "50%" : "90%"; // 1024px is 'lg' breakpoint
}

// Set up on mount and clean up on unmount
onMounted(() => {
  updateDialogWidth();
  window.addEventListener("resize", updateDialogWidth);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updateDialogWidth);
});

const fileItems = ref<any[]>([]);

// Post form
const form = useForm({
  product_name: "",
  description: "No description provided.",
  price: "",
  stock_quantity: "",
  image: "",

  // Common
  category: "",
  contact: "",

  // Retail
  store_name: "",
  products: "",

  // Restaurant
  restaurant_name: "",
  cuisine: "",
  menu: "",

  // Salon
  salon_name: "",
  services: "",
  location: "",
  hours: "",
});


// Load existing image into FilePond when editing
function handleFilePondInit() {
  if (form.image) {
    fileItems.value = [
      {
        source: "/" + form.image,
        options: {
          type: "local",
          metadata: {
            poster: "/" + form.image,
          },
        },
      },
    ];
  } else {
    fileItems.value = [];
  }
}

// Called when image upload completes
function handleFilePondLoad(response: any) {
  form.image = typeof response === "string" ? response : JSON.parse(response);
  ElMessage.success("Image uploaded successfully!");
}

// Called when user removes image
function handleFilePondRemove(response: any, load: any, error: any) {
  form.image = "";
  ElMessage.success("Image removed.");
  load();
}

// Submit the post
function submit() {
  form.post(route("manager.Inventory.store"), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      fileItems.value = [];
      ElMessage.success("Post created successfully!");
      dialogVisible.value = false;
    },
  });
}

// Reinitialize FilePond when modal opens
watch(dialogVisible, (val) => {
  if (val) {
    handleFilePondInit();
  }
});
</script>


<template>
  <form @submit.prevent="submit">
    <div class="p-2.5 cursor-pointer ml-8 mt-8">
   <el-button
  @click="dialogVisible = true"
  class="transition-all duration-300"
  style="
    background-color: var(--btn-bg);
    color: var(--btn-text);
    border-color: var(--btn-border);
  "
>
  Add Product
</el-button>

    </div>

    <el-dialog v-model="dialogVisible" title="Add Product"  :width="dialogWidth"
  class="custom-modal">
<div style="width: 100%">
  <span style="display: block; color: #606266; font-size: 14px;">
    Fill in the fields to add a new product to the list.
  </span>
</div>

<!--    
<div style="margin-top: 10px; width: 100%">
  <label for="category" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Category
  </label>
  <el-select
    v-model="form.category"
    placeholder="Select Category"
    style="width: 100%"
  >
    <el-option label="Retail" value="Retail" />
    <el-option label="Restaurant" value="Restaurant" />
    <el-option label="Salon" value="Salon" />
  </el-select>
</div>


<div  style="margin-top: 10px;">
  <label>Store Name</label>
  <el-input v-model="form.store_name" placeholder="Enter store name" />

  <label style="margin-top: 10px;">Products Sold</label>
  <el-input v-model="form.products" placeholder="Enter products sold" />

  <label style="margin-top: 10px;">Contact Number</label>
  <el-input v-model="form.contact" placeholder="Enter contact number" />
</div>


<div  style="margin-top: 10px;">
  <label>Restaurant Name</label>
  <el-input v-model="form.restaurant_name" placeholder="Enter restaurant name" />

  <label style="margin-top: 10px;">Cuisine Type</label>
  <el-input v-model="form.cuisine" placeholder="Enter cuisine type" />

  <label style="margin-top: 10px;">Menu</label>
  <el-input v-model="form.menu" placeholder="Enter menu items" />

  <label style="margin-top: 10px;">Contact Number</label>
  <el-input v-model="form.contact" placeholder="Enter contact number" />
</div>


<div  style="margin-top: 10px;">
  <label>Salon Name</label>
  <el-input v-model="form.salon_name" placeholder="Enter salon name" />

  <label style="margin-top: 10px;">Services Offered</label>
  <el-input v-model="form.services" placeholder="Enter services (e.g. haircut, spa)" />

  <label style="margin-top: 10px;">Location</label>
  <el-input v-model="form.location" placeholder="Enter location" />

  <label style="margin-top: 10px;">Contact Number</label>
  <el-input v-model="form.contact" placeholder="Enter contact number" />

  <label style="margin-top: 10px;">Opening Hours</label>
  <el-input v-model="form.hours" placeholder="Enter opening hours" />
</div> -->

<div style="margin-top: 20px; width: 100%">
  <label for="product_name" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Product Name
  </label>
  <el-input
    type="text"
    id="product_name"
    name="product_name"
    v-model="form.product_name"
    placeholder="Enter Title..."
    style="width: 100%"
  />
  <InputError class="mt-2" :message="form.errors.product_name" />
</div>


<div style="margin-top: 10px; width: 100%">
  <label for="price" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Price
  </label>
  <el-input
    type="number"
    id="price"
    name="price"
    v-model="form.price"
    placeholder="Enter Price..."
    step="any"
    style="width: 100%"
  />
</div>


<div style="margin-top: 10px; width: 100%">
  <label for="stock_quantity" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Stock Quantity
  </label>
  <el-input-number
    id="stock_quantity"
    v-model="form.stock_quantity"
    placeholder="Enter stock quantity"
    :min="0"
    style="width: 100%"
  />
</div>


 <!-- Description Field -->
<div style="margin-top: 10px; width: 100%">
  <label for="description" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Description (Optional)
  </label>
  <el-input
    type="textarea"
    id="description"
    name="description"
    v-model="form.description"
    placeholder="Enter description..."
    :rows="5"
    style="width: 100%"
  />
</div>


      <!-- Image Upload Section -->
    <div class="filepond-wrapper">
    <file-pond
      name="image"
      ref="pond"
      :allow-multiple="false"
      accepted-file-types="image/png, image/jpeg"
      :server="{
        process: {
          url: '/upload-products',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': $page.props.csrf_token,
          },
          withCredentials: false,
          onload: handleFilePondLoad,
          onerror: () => {},
        },
        remove: handleFilePondRemove,
      }"
      :files="fileItems"
      @init="handleFilePondInit"
    />
  </div>


      <template #footer>
        <el-button @click="dialogVisible = false">Cancel</el-button>
    <el-button type="primary" @click="submit" :disabled="form.processing">
  <LoaderCircle
    v-if="form.processing"
    class="h-4 w-4 animate-spin mr-2 inline-block"
  />
  <span>{{ form.processing ? 'Submitting...' : 'Submit' }}</span>
</el-button>

      </template>
    </el-dialog>
  </form>
</template>
<style scoped>

.filepond-wrapper ::v-deep(.filepond--root) {
  box-sizing: border-box;
  border: 1.5px dashed #afafaf;
  border-radius: 10px;
  padding: 20px;
  margin-top: 20px;
  background-color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
  font-size: 16px;
  height: auto;        /* auto height for uploaded images */
  min-height: 80px;   /* ✅ ensures empty container still shows full border */
  transition: all 0.3s ease;
}

.filepond-wrapper ::v-deep(.filepond--drop-label) {
  padding: 30px 0;
  color: #606266;
  font-weight: 200;
  text-align: center;
}

.filepond-wrapper ::v-deep(.filepond--panel-root) {
  background-color: transparent;
}
</style>
