<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import InputError from "@/components/InputError.vue";
import { LoaderCircle } from "lucide-vue-next";
import vueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Props from backend
// const props = defineProps<{
//   totalBranchesUser: number;
//   branchLimit: number;
// }>();

// FilePond registration with plugins
const FilePond = vueFilePond(FilePondPluginImagePreview, FilePondPluginFilePoster);
const page = usePage();
const csrfToken = page.props.csrf_token;

// FilePond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

// Dialog state
const dialogVisible = ref(false);
const dialogWidth = ref("90%");

// Responsive dialog
function updateDialogWidth() {
  const screenWidth = window.innerWidth;
  dialogWidth.value = screenWidth >= 1024 ? "50%" : "90%";
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

// Form using Inertia's useForm
const form = useForm({
  branch_name: "",
  business_type: "",
  address: "",
  city: "",
  province: "",
  contact_number: "",
  email: "",
  branch_logo: "",
});

const props = defineProps<{
  totalBranches: number;
  branchLimit: number;
  branchLimitReached: boolean;
}>();

interface FilePondFileItem {
  source: string;
  options: {
    type: "local";
    metadata: {
      poster: string;
    };
  };
}

// Reinitialize FilePond when modal opens
watch(dialogVisible, (val) => {
  if (val) {
    handleFilePondInit();
  }
});

function handleFilePondInit() {
  if (form.branch_logo && form.branch_logo !== "") {
    fileItems.value = [
      {
        source: form.branch_logo,
        options: {
          type: "local",
          metadata: {
            poster: form.branch_logo,
          },
        },
      },
    ];
  } else {
    fileItems.value = [];
  }
}

const filePondServerConfig = {
  process: {
    url: "/upload-logo-owneradmin",
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": csrfToken,
    },
    onload: (response: string) => {
      form.branch_logo = response;
      ElMessage.success("Image uploaded successfully!");
      return response;
    },
  },
  revert: (uniqueId: string, load: () => void, error: (message: string) => void) => {
    fetch("/upload-logo-owneradmin-revert", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
      },
      body: JSON.stringify({ path: uniqueId }),
    })
      .then((res) => {
        if (res.ok) {
          form.branch_logo = "";
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

// Submit form
function submit() {
  // Branch limit check
  if (props.branchLimitReached) {
    return ElMessage.error("You have reached the branch limit. You cannot add more branches.");
  }

  if (!form.branch_name.trim()) return ElMessage.error("Branch Name is required.");
  if (!form.business_type.trim()) return ElMessage.error("Business Type is required.");
  if (!form.address.trim()) return ElMessage.error("Address is required.");
  if (!form.city.trim()) return ElMessage.error("City is required.");
  if (!form.province.trim()) return ElMessage.error("Province is required.");
  if (!form.contact_number.trim()) return ElMessage.error("Contact Number is required.");
  if (!form.email.trim()) return ElMessage.error("Email is required.");

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(form.email)) {
    return ElMessage.error("Please enter a valid email address.");
  }

  form.post(route("owneradmin.RegisterBusiness.store"), {
    preserveScroll: true,
    onSuccess: () => {
      fileItems.value = [];
      ElMessage.success("Branch created successfully!");
      dialogVisible.value = false;
      form.reset();
      form.branch_logo = "";
    },
  });
}

// FilePond label
const filePondLabelIdle = `
  <div class='flex cursor-pointer appearance-none justify-center mt-2 text-xm' tabindex='0'>
    <span class='flex items-center space-x-2'>
      <svg class='h-6 w-6 stroke-gray-400' viewBox='0 0 256 256'>
        <path d='M96,208H72A56,56,0,0,1,72,96a57.5,57.5,0,0,1,13.9,1.7' fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='24'></path>
        <path d='M80,128a80,80,0,1,1,144,48' fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='24'></path>
        <polyline points='118.1 161.9 152 128 185.9 161.9' fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='24'></polyline>
        <line x1='152' y1='208' x2='152' y2='128' fill='none' stroke-linecap='round' stroke-linejoin='round' stroke-width='24'></line>
      </svg>
      <span class='text-xm text-gray-600'>
        Drop files to Attach, or
        <span class='text-blue-600 underline'>browse</span>
      </span>
    </span>
  </div>
`;
</script>



<template>
  <form @submit.prevent="submit">
    <div class="p-2.5 cursor-pointer ml-8 mt-8">
<el-button
  @click="dialogVisible = true"
  class="transition-all duration-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
  style="
    background-color: var(--btn-bg);
    color: var(--btn-text);
    border-color: var(--btn-border);
  "
>
  Add Branch
</el-button>


    </div>

    <el-dialog v-model="dialogVisible" title="Add Branch" :width="dialogWidth" class="custom-modal">
  <div style="width: 100%">
    <span style="display: block; color: #606266; font-size: 14px;">
      Fill in the fields to add a new branch.
    </span>
  </div>
  <div class="pt-4">
    <!-- Show message if limit reached -->
    <div v-if="props.branchLimitReached" class="p-3 bg-red-100 border border-red-300 rounded-lg text-red-700 font-semibold">
      🚫 You have reached the branch limit. You cannot add more branches.
    </div>
  </div>
  <!-- Branch Name -->
  <div style="margin-top: 20px; width: 100%">
    <label for="branch_name" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Branch Name
    </label>
    <el-input
      type="text"
      id="branch_name"
      v-model="form.branch_name"
      placeholder="Enter Branch Name..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.branch_name" />
  </div>

  <!-- Business Type -->
<div style="margin-top: 10px; width: 100%">
  <label for="business_type" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Business Type
  </label>
  <el-select
    v-model="form.business_type"
    placeholder="Select Business Type"
    style="width: 100%; height: 35px;"
    id="business_type"
    name="business_type"
    required
  >
    <el-option label="Retail" value="Retail" />
    <el-option label="Restaurant" value="Restaurant" />
    <el-option label="Salon" value="Salon" />
    
  </el-select>
  <InputError class="mt-2" :message="form.errors.business_type" />
</div>

  <!-- Address -->
  <div style="margin-top: 10px; width: 100%">
    <label for="address" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Address
    </label>
    <el-input
      type="text"
      id="address"
      v-model="form.address"
      placeholder="Enter Address..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.address" />
  </div>

  <!-- City -->
  <div style="margin-top: 10px; width: 100%">
    <label for="city" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      City
    </label>
    <el-input
      type="text"
      id="city"
      v-model="form.city"
      placeholder="Enter City..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.city" />
  </div>

  <!-- Province -->
  <div style="margin-top: 10px; width: 100%">
    <label for="province" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Province
    </label>
    <el-input
      type="text"
      id="province"
      v-model="form.province"
      placeholder="Enter Province..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.province" />
  </div>

  <!-- Contact Number -->
  <div style="margin-top: 10px; width: 100%">
    <label for="contact_number" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Contact Number
    </label>
    <el-input
      type="number"
      id="contact_number"
      v-model="form.contact_number"
      placeholder="Enter Contact Number..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.contact_number" />
  </div>

  <!-- Email -->
  <div style="margin-top: 10px; width: 100%">
    <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Email
    </label>
    <el-input
      type="email"
      id="email"
      v-model="form.email"
      placeholder="Enter Email..."
      style="width: 100%; height: 35px;"
    />
    <InputError class="mt-2" :message="form.errors.email" />
  </div>

      <!-- Image Upload Section -->
    <div class="filepond-wrapper" style="margin-top: 20px; width: 100%">
          <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
      Upload Branch Logo
    </label>
  <file-pond
    name="branch_logo"
    ref="pond"
    :allow-multiple="false"
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
          <LoaderCircle v-if="form.processing"   class="h-4 w-4 animate-spin mr-2 inline-block" />
          Add Branch
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
