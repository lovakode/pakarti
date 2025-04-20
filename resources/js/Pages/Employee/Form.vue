<template>
    <div class="content">
        <div class="content-header">
            <div class="mt-auto mb-0">
                <div class="text-lg font-semibold">{{ title }}</div>
            </div>
            <div class="mt-auto mb-0">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: '/' }">{{ $t('base.dashboard') }}</el-breadcrumb-item>
                    <el-breadcrumb-item :to="{ path: '/employee' }">{{ $t('base.employee', 2) }}</el-breadcrumb-item>
                    <el-breadcrumb-item>{{ $t(route.params.id ? 'common.edit' : 'common.create') }}</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>

        <el-card body-class="p-0" class="!rounded-lg !shadow-md" v-loading="formLoading">
            <el-form :model="form" :rules="formRules" ref="formRef" @submit.prevent="onSubmit" label-position="top">
                <div class="p-4">
                    <div class="border-b mb-4">
                        <h3 class="text-lg font-semibold py-2">1. {{ $t('employee.personal_information') }}</h3>
                    </div>
                    <el-row :gutter="20" justify="space-between">
                        <el-col :md="12">
                            <el-form-item :label="$t('common.image')">
                                <image-upload v-model="form.image" size="small" />
                            </el-form-item>
                            <el-form-item :label="$t('common.name')" prop="name">
                                <el-input v-model="form.name" />
                            </el-form-item>
                            <el-form-item :label="$t('employee.employee_id')" prop="code">
                                <el-input v-model="form.code" />
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-row :gutter="16">
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.gender')" prop="gender">
                                        <el-radio-group v-model="form.gender">
                                            <el-radio value="male">{{ $t('employee.male') }}</el-radio>
                                            <el-radio value="female">{{ $t('employee.female') }}</el-radio>
                                        </el-radio-group>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="16">
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.birth_date')" prop="birth_date">
                                        <el-date-picker v-model="form.birth_date" format="DD-MM-YYYY"
                                            value-format="YYYY-MM-DD" />
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.birth_place')" prop="birth_place">
                                        <el-input v-model="form.birth_place" />
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.blood_type')">
                                        <el-input v-model="form.blood_type" />
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.marital_status')" prop="marital_status">
                                        <el-select v-model="form.marital_status" class="w-full"
                                            :placeholder="$t('common.select')">
                                            <el-option value="single" :label="$t('employee.single')" />
                                            <el-option value="married" :label="$t('employee.married')" />
                                            <el-option value="divorced" :label="$t('employee.divorced')" />
                                            <el-option value="widowed" :label="$t('employee.widowed')" />
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.religion')" prop="religion">
                                        <el-select v-model="form.religion" class="w-full"
                                            :placeholder="$t('common.select')">
                                            <el-option value="islam" :label="$t('employee.islam')" />
                                            <el-option value="protestant" :label="$t('employee.protestant')" />
                                            <el-option value="catholic" :label="$t('employee.catholic')" />
                                            <el-option value="hindu" :label="$t('employee.hindu')" />
                                            <el-option value="buddha" :label="$t('employee.buddha')" />
                                            <el-option value="confucian" :label="$t('employee.confucian')" />
                                            <el-option value="other" :label="$t('common.other')" />
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('employee.mother_name')" prop="mother_name">
                                        <el-input v-model="form.mother_name" />
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-col>
                    </el-row>
                </div>
                <div class="p-4">
                    <div class="border-b mb-4">
                        <h3 class="text-lg font-semibold py-2">2. {{ $t('employee.contact_emergency_information') }}
                        </h3>
                    </div>
                    <el-row :gutter=20>
                        <el-col :md="12">
                            <el-form-item :label="$t('common.address')">
                                <el-input v-model="form.addressline1" class="mb-4" />
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
                <div class="p-4">
                    <div class="border-b mb-4">
                        <h3 class="text-lg font-semibold py-2">3. {{ $t('employee.employent_information') }}</h3>
                    </div>
                    <el-row :gutter="20">
                        <el-col :md="12">
                            <el-form-item :label="$t('employee.last_education')" prop="last_education">
                                <el-select v-model="form.last_education" class="w-full"
                                    :placeholder="$t('common.select')">
                                    <el-option value="junior_high_school" :label="$t('employee.junior_high_school')" />
                                    <el-option value="senior_high_school" :label="$t('employee.senior_high_school')" />
                                    <el-option value="diploma" :label="$t('employee.diploma')" />
                                    <el-option value="bachelor" :label="$t('employee.bachelor')" />
                                    <el-option value="master" :label="$t('employee.master')" />
                                </el-select>
                            </el-form-item>
                            <el-form-item :label="$t('base.department')" prop="department_id">
                                <select-department v-model="form.department_id" />
                            </el-form-item>
                            <el-form-item :label="$t('base.job_position')" prop="job_position_id">
                                <select-job-position v-model="form.job_position_id" />
                            </el-form-item>
                            <el-form-item :label="$t('base.grade')" prop="grade_id">
                                <select-grade v-model="form.grade_id" />
                            </el-form-item>
                            <el-form-item :label="$t('base.expertise')" prop="expertise_id">
                                <select-expertise v-model="form.expertise_id" />
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('employee.superior')" prop="superior_id">
                                <select-employee v-model="form.superior_id" />
                            </el-form-item>
                            <el-form-item :label="$t('employee.ptkp')" prop="ptkp">
                                <el-input v-model="form.ptkp" />
                            </el-form-item>
                            <el-form-item :label="$t('employee.join_date')" prop="join_date">
                                <el-date-picker v-model="form.join_date" format="DD-MM-YYYY"
                                    value-format="YYYY-MM-DD" />
                            </el-form-item>
                            <el-form-item :label="$t('common.status')">
                                <el-select v-model="form.status" class="w-full" :placeholder="$t('common.select')">
                                    <el-option value="permanent" :label="$t('employee.permanent')" />
                                    <el-option value="contract" :label="$t('employee.contract')" />
                                    <el-option value="internship" :label="$t('employee.internship')" />
                                    <el-option value="resigned" :label="$t('employee.resigned')" />
                                    <el-option value="retired" :label="$t('employee.retired')" />
                                    <el-option value="passed_away" :label="$t('employee.passed_away')" />
                                </el-select>
                            </el-form-item>
                            <el-form-item :label="$t('employee.exit_date')" prop="exit_date"
                                v-if="['resigned', 'retired', 'passed_away'].includes(form.status)">
                                <el-date-picker v-model="form.exit_date" format="DD-MM-YYYY"
                                    value-format="YYYY-MM-DD" />
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
    </div>
</template>

<script setup lang="js">
import { Icon } from '@iconify/vue';
import { ref, onMounted } from 'vue';
import ImageUpload from '@/Components/Form/ImageUpload.vue';
import { useRoute, useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useHead } from '@/Composable/useBase.js';
import SelectGrade from '@/Components/Form/SelectGrade.vue';
import SelectDepartment from '@/Components/Form/SelectDepartment.vue';
import SelectJobPosition from '@/Components/Form/SelectJobPosition.vue';
import SelectExpertise from '@/Components/Form/SelectExpertise.vue';
import SelectEmployee from '@/Components/Form/SelectEmployee.vue';
import { useFormatter } from '@/Composable/useFormatter';

const { objectToFormData } = useFormatter();
const { setTitle } = useHead();
const route = useRoute();
const router = useRouter();
const { t } = useI18n();
const title = ref(`${t('common.add')} ${t('base.employee')}`);
const tabActive = ref('general');
const formRef = ref(null);
const form = ref({
    id: null,
    image: null,
    code: null,
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
    department_id: null,
    subdirectorate: null,
    grade_id: null,
    job_position_id: null,
    superior_id: null,
    status: null,
    ptkp: null,
    join_date: null,
    exit_date: null,
    expertise_id: null
});
const formRules = ref({
    code: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.code') }),
            trigger: 'blur'
        }
    ],
    name: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.name') }),
            trigger: 'blur'
        },
        {
            min: 3,
            message: t('validation.min', { min: 3 }),
            trigger: 'blur'
        }
    ],
    email: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.email') }),
            trigger: 'blur'
        },
        {
            type: 'email',
            message: t('validation.email'),
            trigger: ['blur', 'change']
        }
    ],
    birth_date: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.birth_date') }),
            trigger: 'change'
        }
    ],
    birth_place: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.birth_place') }),
            trigger: 'blur'
        }
    ],
    blood_type: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.blood_type') }),
            trigger: 'change'
        }
    ],
    gender: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.gender') }),
            trigger: 'change'
        }
    ],
    marital_status: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.marital_status') }),
            trigger: 'change'
        }
    ],
    religion: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.religion') }),
            trigger: 'change'
        }
    ],
    mother_name: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.mother_name') }),
            trigger: 'blur'
        }
    ],
    addressline1: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.address') }),
            trigger: 'blur'
        }
    ],
    zipcode: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.zip_code') }),
            trigger: 'blur'
        },
        {
            type: 'number',
            message: t('validation.numeric', { attribute: t('common.zip_code') }),
            trigger: 'blur'
        }
    ],
    phone: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.phone') }),
            trigger: 'blur'
        },
        {
            pattern: /^[0-9]+$/,
            message: t('validation.numeric', { attribute: t('common.phone') }),
            trigger: 'blur'
        }
    ],
    mobile: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.mobile') }),
            trigger: 'blur'
        },
        {
            pattern: /^[0-9]+$/,
            message: t('validation.numeric', { attribute: t('common.mobile') }),
            trigger: 'blur'
        }
    ],
    emergency_contact_name: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.emergency_contact_name') }),
            trigger: 'blur'
        }
    ],
    emergency_contact_phone: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.emergency_contact_phone') }),
            trigger: 'blur'
        },
        {
            pattern: /^[0-9]+$/,
            message: t('validation.numeric', { attribute: t('employee.emergency_contact_phone') }),
            trigger: 'blur'
        }
    ],
    emergency_contact_relationship: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.emergency_contact_relationship') }),
            trigger: 'blur'
        }
    ],
    last_education: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.last_education') }),
            trigger: 'change'
        }
    ],
    department_id: [
        {
            required: true,
            message: t('validation.required', { attribute: t('base.department') }),
            trigger: 'change'
        }
    ],
    job_position_id: [
        {
            required: true,
            message: t('validation.required', { attribute: t('base.job_position') }),
            trigger: 'change'
        }
    ],
    expertise_id: [
        {
            required: true,
            message: t('validation.required', { attribute: t('base.expertise') }),
            trigger: 'change'
        }
    ],
    join_date: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.join_date') }),
            trigger: 'change'
        }
    ],
    status: [
        {
            required: true,
            message: t('validation.required', { attribute: t('common.status') }),
            trigger: 'change'
        }
    ],
    ptkp: [
        {
            required: true,
            message: t('validation.required', { attribute: t('employee.ptkp') }),
            trigger: 'change'
        }
    ]
});


const formLoading = ref(false);

const onChangeType = (v) => {
    if (v == 'company') {
        form.company_id = null;
    }
}

const onSubmit = async () => {
    if (!formRef.value) return;
    formRef.value.validate(async (valid) => {
        if (valid) {
            try {
                formLoading.value = true;
                const url = form.value.id ? `/employee/${form.value.id}/update` : '/employee/store';
                const method = 'post';

                const response = await axios({
                    method,
                    url,
                    data: objectToFormData(form.value),
                    headers: {
                        "Content-Type": "multipart/form-data"
                    },
                });
                if (response.status === 200) {
                    ElMessage({
                        message: t('message.success_save'),
                        type: 'success',
                    });
                    router.replace({ path: `/employee/${response.data.result}` });
                }
            } catch (error) {
                console.log(error);
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

const fetchData = async () => {
    formLoading.value = true;
    await axios.get(`/employee/${route.params.id}`)
        .then(response => {
            const data = response.data.result;

            form.value.id = data.id;
            form.value.image = data.image;
            form.value.code = data.code;
            form.value.name = data.name;
            form.value.email = data.email;
            form.value.birth_date = data.birth_date;
            form.value.birth_place = data.birth_place;
            form.value.blood_type = data.blood_type;
            form.value.gender = data.gender;
            form.value.marital_status = data.marital_status;
            form.value.religion = data.religion;
            form.value.mother_name = data.mother_name;
            form.value.addressline1 = data.addressline1;
            form.value.addressline2 = data.addressline2;
            form.value.state = data.state;
            form.value.city = data.city;
            form.value.zipcode = data.zipcode;
            form.value.country = data.country;
            form.value.phone = data.phone;
            form.value.mobile = data.mobile;
            form.value.emergency_contact_name = data.emergency_contact_name;
            form.value.emergency_contact_phone = data.emergency_contact_phone;
            form.value.emergency_contact_relationship = data.emergency_contact_relationship;
            form.value.last_education = data.last_education;
            form.value.department_id = data.department_id;
            form.value.subdirectorate = data.subdirectorate;
            form.value.grade_id = data.grade_id;
            form.value.job_position_id = data.job_position_id;
            form.value.superior_id = data.superior_id;
            form.value.status = data.status;
            form.value.ptkp = data.ptkp;
            form.value.join_date = data.join_date;
            form.value.exit_date = data.exit_date;
            form.value.expertise_id = data.expertise_id;
        })
        .finally(() => {
            formLoading.value = false;
        });
};
onMounted(() => {
    if (route.params.id) {
        title.value = `${t('common.edit')} ${t('base.employee')}`;
        fetchData();
    }
    setTitle(title.value);
});
</script>
