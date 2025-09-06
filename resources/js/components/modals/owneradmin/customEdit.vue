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

    <!-- Name -->
    <el-form label-position="top" label-width="100%">
      <el-form-item label="Name">
        <el-input v-model="form.name" placeholder="Enter name" />
      </el-form-item>

      <!-- Email -->
      <el-form-item label="Email">
        <el-input v-model="form.email" placeholder="Enter email" />
      </el-form-item>


<el-form label-position="top" label-width="100%">
  <!-- Subscription Duration (selectable) -->
  <el-form-item label="Update Role">
    <el-select
  v-model="form.role"
  placeholder="Update role"
  style="width: 100%; height: 35px"
  required
>
  <!-- Display subscription expiration as a disabled option -->
  <el-option
    v-if="form.role"
    :label="`Role : ${form.role}`"
    value=""
    disabled
  />
  <el-option label="Users" value="Users" />
  <el-option label="OwnerAdmin" value="OwnerAdmin" />
</el-select>

    <InputError class="mt-2" :message="form.errors.role" />
  </el-form-item>
</el-form>

<el-form label-position="top" label-width="100%">
  <el-form-item label="Subscription Expires At">
    <el-select
      v-model="form.subscription_expires_at"
      placeholder="Select subscription duration"
      style="width: 100%; height: 35px"
    >
      <!-- Read-only display of current expiration -->
      <el-option
        v-if="form.subscription_expires_at"
        :label="`Current: ${form.subscription_expires_at}`"
        value=""
        disabled
      />
      <el-option label="1 Month" value="1_monthSub" />
      <el-option label="1 Year" value="1_yearSub" />
    <el-option label="Remove Subscription" value="Remove_Subscription" />
    </el-select>

    <InputError class="mt-2" :message="form.errors.subscription_expires_at" />
  </el-form-item>
</el-form>


      <!-- Password -->
      <el-form-item label="Password">
        <el-input v-model="form.password" placeholder="Enter password" type="password" />
      </el-form-item>

      <!-- Confirm Password -->
      <el-form-item label="Confirm Password">
        <el-input v-model="form.confirmPassword" placeholder="Confirm password" type="password" />
      </el-form-item>
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
    default: () => ({ id: null, name: '', email: '' ,subscription_expires_at: '' })
  }
});

watch(
  () => props.selectedAccount,
  (newVal) => {
    if (newVal && props.form) {
      props.form.name = newVal.name || '';
      props.form.email = newVal.email || '';
      props.form.role = newVal.role || '';

      // Convert subscription_expires_at date to enum string for the form select
      if (newVal.subscription_expires_at) {
        const expiresAtDate = new Date(newVal.subscription_expires_at);
        const now = new Date();

        // Calculate difference and decide if 1 month or 1 year
        const diffInMs = expiresAtDate.getTime() - now.getTime();
        const diffInDays = diffInMs / (1000 * 60 * 60 * 24);

        if (diffInDays > 300) {
          props.form.subscription_expires_at = '1_yearSub';
        } else if (diffInDays > 25) {
          props.form.subscription_expires_at = '1_monthSub';
        } else {
          props.form.subscription_expires_at = '';
        }
      } else {
        props.form.subscription_expires_at = '';
      }

      props.form.password = '';
      props.form.confirmPassword = '';
    }
  },
  { immediate: true }
);
</script>

