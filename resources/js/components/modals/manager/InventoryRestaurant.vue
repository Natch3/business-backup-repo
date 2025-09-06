<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import InputError from "@/components/InputError.vue";
import { LoaderCircle } from "lucide-vue-next";
import vueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

const FilePond = vueFilePond(FilePondPluginImagePreview, FilePondPluginFilePoster);
const page = usePage();
const csrfToken = page.props.csrf_token;

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

const dialogVisible = ref(false);
const dialogWidth = ref("90%");

function updateDialogWidth() {
  dialogWidth.value = window.innerWidth >= 1024 ? "50%" : "90%";
}

onMounted(() => {
  updateDialogWidth();
  window.addEventListener("resize", updateDialogWidth);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updateDialogWidth);
});

// FilePond file list
const fileItems = ref<FilePondFileItem[]>([]);
const props = defineProps({
  branchId: Number
})
// Form using Inertia's useForm
const form = useForm({
  menu_name: "",
  menu_description: "No description provided.",
  menu_price: "",
  menu_category: "",
id_branch: props.branchId,
  imageUploads: [] as string[], // <-- store multiple images
});

interface FilePondFileItem {
  source: string;
  options: {
    type: "local";
    metadata: {
      poster: string;
    };
  };
}

watch(dialogVisible, (val) => {
  if (val) {
    handleFilePondInit();
  }
});

interface FilePondFileItem {
  source: string;
  options: { type: "local"; metadata: { poster: string } };
}

// Handle FilePond initialization for previews
function handleFilePondInit() {
  if (form.imageUploads.length > 0) {
    fileItems.value = form.imageUploads.map((img) => ({
      source: img,
      options: { type: "local", metadata: { poster: img } },
    }));
  } else {
    fileItems.value = [];
  }
}

// FilePond server config
const filePondServerConfig = {
process: {
  url: "/manager/upload-logo-owneradmin",
  method: "POST",
  headers: { "X-CSRF-TOKEN": csrfToken },
  onload: (response: string) => {
    let path = response;

    try {
      const parsed = JSON.parse(response);

      if (Array.isArray(parsed) && parsed.length > 0) {
        // Case 1: response is an array
        path = parsed[0];
      } else if (parsed && typeof parsed === "object" && parsed.path) {
        // Case 2: response is an object with "path"
        path = parsed.path;
      }
    } catch {
      // Case 3: response is a plain string, do nothing
    }

    form.imageUploads.push(path);
    ElMessage.success("Image successfully uploaded!");

    return path;
  },
},

 revert: (uniqueId: string, load: () => void, error: (message: string) => void) => {
  fetch("/manager/upload-logo-owneradmin-revert", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken,
    },
    body: JSON.stringify({ path: uniqueId }), // send object with path
  })
    .then((res) => {
      if (res.ok) {
        form.imageUploads = form.imageUploads.filter((img) => img !== uniqueId);
        ElMessage.success("Image removed!");
        load();
      } else {
        ElMessage.error("Failed to remove image.");
        error("Server error");
      }
    })
    .catch((err) => {
      console.error("Revert error:", err);
      error("Error while reverting.");
    });
},

};

// FilePond label
const filePondLabelIdle = `
  <div class='flex cursor-pointer justify-center mt-2 text-xm'>
    <span class='flex items-center space-x-2'>
      <span class='text-xm text-gray-600'>
        Drop files to Attach, or
        <span class='text-blue-600 underline'>browse</span>
      </span>
    </span>
  </div>
`;
function submit() {
  
  if (!form.menu_name.trim()) return ElMessage.error("Branch Name is required.");
  if (!form.menu_price.trim()) return ElMessage.error("Business Type is required.");
  if (!form.menu_category.trim()) return ElMessage.error("Address is required.");
  if (!form.menu_description.trim()) return ElMessage.error("Address is required.");

  form.post(route("manager.InventoryList.ViewInventoryRestaurant.store"), {
    preserveScroll: true,
    onSuccess: () => {
      fileItems.value = [];
      ElMessage.success("Branch created successfully!");
      dialogVisible.value = false;
      form.reset();
      form.imageUploads = [];
    },
  });
}

</script>



<template>
  <form @submit.prevent="submit">
    <div class="p-3 cursor-pointer m-6">
<el-button
  @click="dialogVisible = true"
  class="transition-all duration-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
  style="
    background-color: var(--btn-bg);
    color: var(--btn-text);
    border-color: var(--btn-border);
  "
>
  Add Restaurant
</el-button>


    </div>

    <el-dialog v-model="dialogVisible" title="Add Restaurant" :width="dialogWidth" class="custom-modal">
  <div style="width: 100%">
    <span style="display: block; color: #606266; font-size: 14px;">
      Fill in the fields to add a new branch.
    </span>
  </div>

<div style="margin-top: 20px; width: 100%">
  <label for="menu_name" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Menu Name
  </label>
  <el-input
    type="text"
    id="menu_name"
    name="menu_name"
    v-model="form.menu_name"
    placeholder="Enter Title..."
    style="width: 100%"
  />
  <InputError class="mt-2" :message="form.errors.menu_name" />
</div>


<div style="margin-top: 10px; width: 100%">
  <label for="menu_price" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
   Menu Price
  </label>
  <el-input
    type="number"
    id="menu_price"
    name="menu_price"
    v-model="form.menu_price"
    placeholder="Enter Menu Price..."
    step="any"
    style="width: 100%"
  />
</div>


<div style="margin-top: 10px; width: 100%">
  <label for="menu_category" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Menu Category
  </label>
  <el-select
    id="menu_category"
    v-model="form.menu_category"
    placeholder="Select a category"
    style="width: 100%"
  >
    <el-option label="Appetizer" value="appetizer" />
    <el-option label="Main Course" value="main_course" />
    <el-option label="Dessert" value="dessert" />
    <el-option label="Beverage" value="beverage" />
  </el-select>
</div>



 <!-- Description Field -->
<div style="margin-top: 10px; width: 100%">
  <label for="menu_description" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
   Menu Description (Optional)
  </label>
  <el-input
    type="textarea"
    id="menu_description"
    name="menu_description"
    v-model="form.menu_description"
    placeholder="Enter description..."
    :rows="5"
    style="width: 100%"
  />
</div>

<!-- Replace previous file-pond block -->
<div class="filepond-wrapper" style="margin-top: 20px; width: 100%">
  <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Upload Menu Images
  </label>
  <file-pond
    name="imageUploads"
    ref="pond"
    :allow-multiple="true" 
    accepted-file-types="image/png, image/jpeg"
    :label-idle="filePondLabelIdle"
    :server="filePondServerConfig"
    :files="fileItems"
    @init="handleFilePondInit"
  />
</div>

  <!-- Modal Footer -->
  <template #footer>
    <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="submit"
          :disabled="form.processing"
        >
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
  padding: 20px;
  background-color: white;
  font-size: 14px;
  height: auto;
  min-height: 80px;
  transition: all 0.3s ease;
  outline: none;
}

.filepond-wrapper ::v-deep(.filepond--root:focus-within) {
  border: 1.5px dashed #2563eb; /* Tailwind's blue-600 */
  outline: none;
  box-shadow: 0 0 0 1px #2563eb;
}

.filepond-wrapper ::v-deep(.filepond--root:disabled),
.filepond-wrapper ::v-deep(.filepond--root[disabled]) {
  cursor: not-allowed;
  background-color: #e5e7eb; /* Tailwind's gray-200 */
  opacity: 0.75;
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
