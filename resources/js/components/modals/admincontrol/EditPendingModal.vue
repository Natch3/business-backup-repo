<template>
  <el-dialog
    :model-value="visible"
    @update:modelValue="$emit('update:visible', $event)"
    title="Edit Account"
     :width="dialogWidthEdit"
  >
    <span style="display: block; color: #606266; font-size: 14px; margin-bottom: 1rem;">
  Update the fields below to edit the selected account.<br />
    </span>
<div style="display: flex; flex-wrap: wrap; align-items: flex-start; gap: 1.5rem; margin-bottom: 1.5rem;">
  
  <!-- Business Logo -->
  <div 
    style="flex: 0 0 160px; display: flex; justify-content: center;"
  >
    <div 
      v-if="form.branch_logo" 
      style="width: 160px; height: 160px; border-radius: 12px; overflow: hidden; transition: transform 0.3s ease; cursor: pointer;"
      @mouseover="event.target.style.transform='scale(1.05)'"
      @mouseleave="event.target.style.transform='scale(1)'"
    >
      <img 
        :src="`/storage/${form.branch_logo}`" 
        alt="Business Logo" 
        style="width: 100%; height: 100%; object-fit: contain; background-color: #fff;"
      />
    </div>

    <p 
      v-else 
      style="color: #909399; font-size: 14px; background: #f5f7fa; padding: 0.5rem 1rem; border-radius: 6px; border: 1px dashed #dcdfe6; text-align: center;"
    >
      No logo available
    </p>
  </div>

  <!-- Inputs -->
  <div style="flex: 1; min-width: 250px;">
    <el-form label-position="top" label-width="100%">
      <!-- Name -->
      <el-form-item label="Branch Name">
        <el-input v-model="form.branch_name" placeholder="Enter Branch" readonly />
      </el-form-item>

      <!-- Email -->
      <el-form-item label="Email Address">
        <el-input v-model="form.email" placeholder="Enter email" readonly />
      </el-form-item>

    </el-form>
  </div>

</div>
    <el-form label-position="top" label-width="100%">
              <!-- Business Type -->
      <el-form-item label="Business Type">
        <el-input v-model="form.business_type" placeholder="Enter business type" readonly />
      </el-form-item>
        <!-- Address -->
        <el-form-item label="Branch  Address">
          <el-input v-model="form.address" placeholder="Enter address" readonly/>
        </el-form-item>
        <!-- Province -->
        <el-form-item label="Branch Province">
            <el-input v-model="form.province" placeholder="Enter province" readonly/>
        </el-form-item>
        <!-- City -->
        <el-form-item label="Branch City">
            <el-input v-model="form.city" placeholder="Enter city" readonly/>
        </el-form-item>
        <!-- Contact Number -->
        <el-form-item label="Contact Number">
            <el-input v-model="form.contact_number" placeholder="Enter contact number" readonly/>
        </el-form-item>
        <div class="read-item">
  <label>Status</label>
<el-select
  v-model="form.status"
  placeholder="Select Status"
  class="w-full"
  :class="{
    '!text-yellow-500 !font-semibold': form.status === 'Pending',
    '!text-green-500 !font-semibold': form.status === 'Approved',
    '!text-red-500 !font-semibold': form.status === 'Rejected'
  }"
>
  <el-option
    label="Pending"
    value="Pending"
    class="!text-yellow-500 !font-semibold"
  />
  <el-option
    label="Approved"
    value="Approved"
    class="!text-green-500 !font-semibold"
  />
  <el-option
    label="Rejected"
    value="Rejected"
    class="!text-red-500 !font-semibold"
  />
</el-select>

</div>

    </el-form>

    <template #footer>
      <el-button @click="$emit('update:visible', false)">Cancel</el-button>
      <el-button type="primary" @click="$emit('confirm')" :disabled="form.processing">
  <LoaderCircle
    v-if="form.processing"
    class="h-4 w-4 animate-spin mr-2 inline-block"
  />
  <span>{{ form.processing ? 'Submitting...' : 'Submit' }}</span>
</el-button>

    
    </template>
  </el-dialog>
</template>

<script setup lang="ts">
import {ref, watch, onBeforeUnmount,onMounted } from 'vue';
import { LoaderCircle } from 'lucide-vue-next'

const dialogWidthEdit = ref("90%"); // Default width

// Update dialog width based on screen size
function updatedialogWidthEdit() {
  const screenWidth = window.innerWidth;
  dialogWidthEdit.value = screenWidth >= 1024 ? "50%" : "90%"; // 1024px is 'lg' breakpoint
}

// Set up on mount and clean up on unmount
onMounted(() => {
  updatedialogWidthEdit();
  window.addEventListener("resize", updatedialogWidthEdit);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updatedialogWidthEdit);
});


const props = defineProps({
  visible: Boolean,
  form: Object,
  selectedAccount: {
    type: Object,
    default: () => ({ id: null, branch_name: '', email: '', business_type: '', address: '', province: '', city: '', contact_number: '', branch_logo: '' })
  }
});

watch(
  () => props.selectedAccount,
  (newVal) => {
    if (newVal && props.form) {
      props.form.branch_name = newVal.branch_name || '';
      props.form.email = newVal.email || '';
      props.form.business_type = newVal.business_type || '';
      props.form.address = newVal.address || '';
      props.form.province = newVal.province || '';
      props.form.city = newVal.city || '';
      props.form.contact_number = newVal.contact_number || '';
      props.form.branch_logo = newVal.branch_logo || '';
            props.form.status = newVal.status || '';

    }
  },
  { immediate: true }
);
</script>

