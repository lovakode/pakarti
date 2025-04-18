<template>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <family :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <education :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <experience :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <bank-account :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <agreement :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <certification :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <insurance :employee="user.employee_id" header-class="px-4"/>
    </el-card>
    <el-card class="shadow-sm sm:rounded-lg mb-4" body-class="!p-0">
        <medical :employee="user.employee_id" header-class="px-4"/>
    </el-card>
</template>

<script setup>
import { computed, onMounted, defineEmits, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { useHead } from '@/Composable/useBase.js';
import Family from '../Employee/Family.vue';
import Education from '../Employee/Education.vue';
import Experience from '../Employee/Experience.vue';
import BankAccount from '../Employee/BankAccount.vue';
import Agreement from '../Employee/Agreement.vue';
import Certification from '../Employee/Certification.vue';
import Insurance from '../Employee/Insurance.vue';
import Medical from '../Employee/Medical.vue';
import { useAuthStore } from '@/Stores/auth';

const { t } = useI18n();
const { setTitle } = useHead();
const auth = useAuthStore();

const emit = defineEmits(['childinit']);
const user = computed(() => auth.user);


const form = ref({
    old_password : null,
    new_password : null,
    password_confirmation : null
});
const errors = ref({});
const loading = ref(false);

const onSubmit = async () => {
    loading.value = true;
    const url = '/profile/password';
    try {
        const response = await axios.post(url, form.value);
        console.log(response.data.result);
        ElMessage({message: t('success_msg'), type: 'success'});
    } catch (error) {
        errors.value = error.validation;
        ElMessage({message: t('error_msg'), type: 'error'});
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
  emit('childinit', 'Additional Data');
  setTitle('Additional Data');
});
</script>


