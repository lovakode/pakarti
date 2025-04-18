<template>
    <el-card class="shadow-sm sm:rounded-lg" v-loading="formLoading">
        
        <el-form :model="form" :rules="formRules" ref="formRef" @submit.prevent="onSubmit" label-position="top">
            <div class="p-4">
                <div class="border-b mb-4">
                    <h3 class="text-lg font-semibold py-2">1. {{ $t('employee.personal_information') }}</h3>
                </div>
                <el-row :gutter="20" justify="space-between">
                    <el-col :md="12">
                        <el-form-item :label="$t('common.image')">
                            <image-upload v-model="form.image" size="small"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.name')" prop="name">
                            <el-input v-model="form.name" />
                        </el-form-item>
                        <el-row :gutter="16">
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.gender')">
                                    <el-radio-group v-model="form.gender">
                                        <el-radio value="male">{{ $t('employee.male') }}</el-radio>
                                        <el-radio value="female">{{ $t('employee.female') }}</el-radio>
                                    </el-radio-group>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :md="12">
                        <el-row :gutter="16">
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.birth_date')">
                                    <el-date-picker v-model="form.birth_date"
                                    format="DD-MM-YYYY"
                                    value-format="YYYY-MM-DD" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.birth_place')">
                                    <el-input v-model="form.birth_place" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.blood_type')">
                                    <el-input v-model="form.blood_type" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.marital_status')">
                                    <el-select v-model="form.marital_status" class="w-full" :placeholder="$t('common.select')">
                                        <el-option value="single" :label="$t('employee.single')"/>
                                        <el-option value="married" :label="$t('employee.married')"/>
                                        <el-option value="divorced" :label="$t('employee.divorced')"/>
                                        <el-option value="widowed" :label="$t('employee.widowed')"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.religion')">
                                    <el-select v-model="form.religion" class="w-full" :placeholder="$t('common.select')">
                                        <el-option value="islam" :label="$t('employee.islam')"/>
                                        <el-option value="protestant" :label="$t('employee.protestant')"/>
                                        <el-option value="catholic" :label="$t('employee.catholic')"/>
                                        <el-option value="hindu" :label="$t('employee.hindu')"/>
                                        <el-option value="buddha" :label="$t('employee.buddha')"/>
                                        <el-option value="confucian" :label="$t('employee.confucian')"/>
                                        <el-option value="other" :label="$t('common.other')"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('employee.mother_name')">
                                    <el-input v-model="form.mother_name" />
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-col>
                </el-row>
            </div>
            <div class="p-4">
                <div class="border-b mb-4">
                    <h3 class="text-lg font-semibold py-2">2. {{ $t('employee.contact_emergency_information') }}</h3>
                </div>
                <el-row :gutter=20>
                    <el-col :md="12">
                        <el-form-item :label="$t('common.address')">
                            <el-input v-model="form.addressline1" class="mb-4"/>
                            <el-input v-model="form.addressline2" />
                        </el-form-item>
                        <el-row :gutter="16">
                            <el-col :md="12">
                                <el-form-item :label="$t('common.city')">
                                    <el-input v-model="form.city" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('common.state')">
                                    <el-input v-model="form.state" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('common.zip_code')">
                                    <el-input v-model="form.zip_code" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('common.country')">
                                    <el-input v-model="form.country" />
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item :label="$t('common.email')">
                            <el-input v-model="form.email" />
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-row :gutter="16">
                            <el-col :md="12">
                                <el-form-item :label="$t('common.phone')">
                                    <el-input v-model="form.phone" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('common.mobile')">
                                    <el-input v-model="form.mobile" />
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item :label="$t('employee.emergency_contact_name')">
                            <el-input v-model="form.emergency_contact_name" />
                        </el-form-item>
                        <el-form-item :label="$t('employee.emergency_contact_phone')">
                            <el-input v-model="form.emergency_contact_phone" />
                        </el-form-item>
                        <el-form-item :label="$t('employee.emergency_contact_relationship')">
                            <el-input v-model="form.emergency_contact_relationship" />
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div class="p-4 float-end">
                <el-button native-type="submit" type="primary">
                    {{ $t('common.save') }}
                </el-button>
            </div>
        </el-form>
    </el-card>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import ImageUpload from '@/Components/Form/ImageUpload.vue';
import { useI18n } from 'vue-i18n';
import { useAuthStore } from '@/Stores/auth';
import { useHead } from '@/Composable/useBase.js';
import { useFormatter } from '@/Composable/useFormatter';

const { formatDate, objectToFormData } = useFormatter();
const { t } = useI18n();
const { setTitle } = useHead();

const emit = defineEmits(['childinit']);

const auth = useAuthStore();
const user = computed(() => auth.user);

const formRef = ref(null);
const formLoading = ref(false);
const form = ref({
    name: null,
    email: null,
    birth_date: null,
    birth_place: null,
    blood_type: null,
    gender: "male",
    marital_status: null,
    religion: null,
    mother_name: null,
    addressline1: null,
    addressline2: null,
    state: null,
    city: null,
    zipcode: null,
    country: null,
    phone: null,
    mobile: null,
    emergency_contact_name: null,
    emergency_contact_phone: null,
    emergency_contact_relationship: null,
    last_education: null,
});

const formRules = ref({
    name: [
        { required: true, message: t('validation.required', { attribute: t('common.name') }), trigger: 'blur' },
    ],
    email: [
        { required: true, message: t('validation.required', { attribute: t('common.email') }), trigger: 'blur' },
    ]
});

const onSubmit = async () => {
    if (!formRef.value) return;
    formRef.value.validate(async (valid) => {
        if (valid) {
            try {
                formLoading.value = true;
                await axios({
                    method : 'post',
                    url : '/profile/update',
                    data: objectToFormData(form.value),
                    headers: {
                        "Content-Type": "multipart/form-data"
                    },
                });
                auth.getUser();
                ElMessage({
                    message: t('message.success_save'),
                    type: 'success',
                });
                formLoading.value = false;
            } catch (error) {
                console.log('Form Error:',error);
                formLoading.value = false;
                ElMessage({
                    message: t('message.error_server'),
                    type: 'error',
                });
            }
        } else {
            ElMessage({
                message: t('message.error_input'),
                type: 'error',
            });
        }
    });
};

onMounted(() => {
    emit('childinit', 'Edit Profile');
    setTitle('Edit Profile');
    form.value.name = user.value.name;
    form.value.email = user.value.email;
    form.value.image = user.value.image;
});

</script>


