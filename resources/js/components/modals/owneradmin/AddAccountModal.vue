<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';

import vueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";
import Password from "@/pages/settings/Password.vue";

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
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  id_branch: "",
  // image: "",
});

defineProps({
  branches: Array,
  form: Object, // pass your form object if using `useForm()`
});


// Submit the post
function submit() {
  if (!form.name.trim()) {
    ElMessage.error("Name is required.");
    return;
  }

  if (!form.email.trim()) {
    ElMessage.error("Email is required.");
    return;
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(form.email)) {
    ElMessage.error("Please enter a valid email address.");
    return;
  }

  if (!form.password.trim()) {
    ElMessage.error("Password is required.");
    return;
  }

  if (form.password !== form.password_confirmation) {
    ElMessage.error("Passwords do not match.");
    return;
  }

  form.post(route("owneradmin.ManagerAccount.store"), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('password', 'password_confirmation');
      fileItems.value = [];
      ElMessage.success("Post created successfully!");
      dialogVisible.value = false;
    },
  });
}


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
  Add Manager Account
</el-button>


    </div>

    <el-dialog v-model="dialogVisible" title="Add Manager Account"  :width="dialogWidth"
  class="custom-modal">
<div style="width: 100%">
  <span style="display: block; color: #606266; font-size: 14px;">
    Fill in the fields to add a new Account to the list.
  </span>
</div>

      <!-- Title Input -->
     <!-- Product Name Field -->
<div style="margin-top: 20px; width: 100%">
  <label for="name" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Name
  </label>
  <el-input
    type="text"
    id="name"
    name="name"
    v-model="form.name"
    placeholder="Enter Name..."
    style="width: 100%; height: 35px;"
    required
  />
  <InputError class="mt-2" :message="form.errors.name" />
</div>


<div style="margin-top: 10px; width: 100%">
  <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Email
  </label>
  <el-input
    type="email"
    id="email"
    name="email"
    v-model="form.email"
    placeholder="Enter Email..."
required
 style="width: 100%; height: 35px;"
  />
</div>
<div style="margin-top: 10px; width: 100%; ">
  <label
    for="branch_id"
    style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;"
  >
    Branch Name
  </label>

  <el-select
    v-model="form.id_branch"
    multiple
    placeholder="Select Branch"
    style="
      width: 100%;
      min-height: 35px;
      white-space: normal;
    "
    required
  >
    <el-option
      v-for="branch in branches"
      :key="branch.id"
      :label="branch.branch_name || `Branch ID: ${branch.id}`"
      :value="branch.id"
    />
  </el-select>

  <InputError class="mt-2" :message="form.errors.branch_id" />
</div>

<div style="margin-top: 10px; width: 100%">
  <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Password
  </label>
  <el-input
    type="password"
    id="password"
    name="password"
    v-model="form.password"
    placeholder="Enter Password..."
 required
 style="width: 100%; height: 35px;"
  />
</div>

<div style="margin-top: 10px; width: 100%">
  <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 500; color: #303133;">
    Confirm password
  </label>
  <el-input
    type="password"
    id="password_confirmation"
    name="password_confirmation"
    v-model="form.password_confirmation"
    placeholder="Confirm password..."
required
 style="width: 100%; height: 35px;"
  />
<InputError :message="form.errors.password_confirmation" />
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
.el-select__tags {
  flex-wrap: wrap !important;
  max-height: none !important; /* remove height restriction */
}
</style>
