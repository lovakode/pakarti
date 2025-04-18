<template>
    <div class="content">
        <el-skeleton class="w-full" animated :loading=isLoading>
            <template #template>
                <div class="flex justify-between mb-4">
                    <el-skeleton-item type="rect" class="w-[300px] h-[30px] bg-neutral-300"/>
                    <el-skeleton-item type="rect" class="w-[200px] h-[20px] bg-neutral-300"/>
                </div>
            </template>
            <template #default>
                <div class="content-header">
                    <div class="mt-auto mb-0">
                        <div class="text-xl font-semibold">{{ $t('base.employee') }}</div>
                    </div>
                    <div class="mt-auto mb-0">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item :to="{ path: '/' }">{{ $t('base.dashboard')}}</el-breadcrumb-item>
                            <el-breadcrumb-item :to="{ path: '/employee' }">{{ $t('base.employee', 2)}}</el-breadcrumb-item>
                            <el-breadcrumb-item>{{ data ? data.name : '' }}</el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>
                </div>
            </template>
        </el-skeleton>
        <el-card class="!shadow-sm !rounded-lg" body-class="!p-0">
            <el-skeleton animated :loading=isLoading>
                <template #template>
                    <div class="flex justify-between mb-10 align-middle">
                        <div class="my-auto">
                            <el-skeleton-item type="variant" class="block !mb-1 w-[107px] h-[16]"/>
                            <el-skeleton-item type="variant" class="w-[350px] h-[40px] me-1"/>
                            <div class="flex">
                                <el-skeleton-item type="rect" class="w-[80px] h-[16px] me-1"/>
                                <el-skeleton-item type="rect" class="w-[80px] h-[16px] me-1"/>
                                <el-skeleton-item type="rect" class="w-[80px] h-[16px] me-1"/>
                            </div>
                        </div>
                        <div class="my-auto flex">
                            <el-skeleton-item variant="image" class="w-[80px] h-[80px] me-1"/>
                            <el-skeleton-item variant="image" class="w-[80px] h-[80px]"/>
                        </div>
                    </div>
                    <el-row :gutter="20" class="mb-4">
                        <el-col :md="8">
                            <el-skeleton-item variant="rect" class="block !mb-1 w-[107px] h-[16]"/>
                            <el-skeleton-item variant="rect" class="w-[200px] h-[30]"/>
                        </el-col>
                        <el-col :md="8">
                            <el-skeleton-item variant="rect" class="block !mb-1 w-[107px] h-[16]"/>
                            <el-skeleton-item variant="rect" class="w-[200px] h-[30]"/>
                        </el-col>
                        <el-col :md="8">
                            <el-skeleton-item variant="rect" class="block !mb-1 w-[107px] h-[16]"/>
                            <el-skeleton-item variant="rect" class="w-[200px] h-[30]"/>
                        </el-col>
                    </el-row>
                    <div class="mb-4">
                        <el-skeleton-item variant="rect" class="block !mb-1 w-[107px] h-[16]"/>
                        <el-skeleton-item variant="rect" class="block !mb-1 w-full h-[24]"/>
                        <el-skeleton-item variant="rect" class="block !mb-1 w-2/3 h-[24]"/>
                        <el-skeleton-item variant="rect" class="block !mb-1 w-1/2 h-[24]"/>
                    </div>
                    <el-row :gutter="20" class="mb-4">
                        <el-col :md="8" class="mb-4" v-for="n in 8" :key="n">
                            <el-skeleton-item variant="rect" class="block !mb-1 w-[107px] h-[16]"/>
                            <el-skeleton-item variant="rect" class="w-[200px] h-[30]"/>
                        </el-col>
                    </el-row>
                </template>
                <template #default v-if="data">
                    <div class="p-4">
                        <el-row :gutter="20" class="mb-3">
                            <el-col :md="4">
                                <div class="flex justify-center items-center mb-3">
                                    <img :src="data.image_path" class="w-32 h-32 rounded-md mx-auto"/>
                                </div>
                                <el-row :gutter="16">
                                    <el-col :md="12">
                                        <el-button type="primary" class="!w-full" tag="router-link" :to="`/employee/${data.id}/edit`" v-if="can('update', 'employee')">
                                            {{ $t('common.edit') }}
                                        </el-button>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-button type="danger" class="!w-full" v-if="can('delete', 'employee')">
                                            {{ $t('common.delete') }}
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col :md="9">
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('common.name')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.name ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('employee.employee_id')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.code ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('base.department')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.department?.name ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('base.grade')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.grade?.name ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('base.job_position')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.job_position?.name ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('base.expertise')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.expertise?.name ?? '-' }}</div>
                                </div>
                            </el-col>
                            <el-col :md="9">
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('employee.superior')}}
                                   </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.superior ? data.superior.name : '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('employee.ptkp')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.ptkp ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('common.status')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.status ?? '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('employee.join_date')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.join_date ? formatDate(data.join_date) : '-' }}</div>
                                </div>
                                <div class="flex align-middle items-center justify-between mb-2">
                                    <span class="inline-flex items-center">
                                        {{ $t('employee.exit_date')}}
                                    </span>
                                    <div class="text-gray-800 font-semibold mb-0">{{ data.exit_date ? formatDate(data.exit_date) : '-' }}</div>
                                </div>
                            </el-col>
                        </el-row>
                        <el-tabs v-model="activeTab">
                            <el-tab-pane name="personal" :label="$t('employee.personal')">
                                <div class="flex items-center justify-between mb-2 border-b py-2">
                                    <h6 class="font-semibold text-sm">{{ $t('employee.personal_information')}}</h6>
                                </div>
                                <el-row :gutter="30">
                                    <el-col :md="12">
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.gender')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ $t(`employee.${data.gender}`)}}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.birthday')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ formatDate(data.birth_date) }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.birth_place')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.birth_place }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.blood_type')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.blood_type }}</div>
                                        </div>
                                    </el-col>
                                    <el-col :md="12">
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.religion')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ $t(`employee.${data.religion}`) }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.marital_status')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ $t(`employee.${data.marital_status}`) }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.mother_name')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.mother_name }}</div>
                                        </div>
                                    </el-col>
                                </el-row>
                                <div class="flex items-center justify-between mb-2 border-b py-2">
                                    <h6 class="font-semibold text-sm">{{ $t('employee.contact_emergency_information')}}</h6>
                                </div>
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('common.email')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.email ?? '-' }}</div>
                                        </div>
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.phone')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.phone ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.mobile')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.mobile ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                        </el-row>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('common.address')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">
                                                <div class="">{{ data.addressline1 }}</div>
                                                <div class="">{{ data.addressline2 }}</div>
                                            </div>
                                        </div>
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.zip_code')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.zipcode ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.city')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.city ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.state')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.state ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                            <el-col :md="12">
                                                <div class="flex align-middle items-center justify-between mb-2">
                                                    <span class="inline-flex items-center">
                                                        {{ $t('common.country')}}
                                                    </span>
                                                    <div class="text-gray-800 font-semibold mb-0">{{ data.country ?? '-' }}</div>
                                                </div>
                                            </el-col>
                                        </el-row>
                                    </el-col>
                                    <el-col :md="12">
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.emergency_contact_name')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.emergency_contact_name }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.emergency_contact_phone')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.emergency_contact_phone }}</div>
                                        </div>
                                        <div class="flex align-middle items-center justify-between mb-2">
                                            <span class="inline-flex items-center">
                                                {{ $t('employee.emergency_contact_relationship')}}
                                            </span>
                                            <div class="text-gray-800 font-semibold mb-0">{{ data.emergency_contact_relationship }}</div>
                                        </div>

                                    </el-col>
                                </el-row>
                            </el-tab-pane>
                            <el-tab-pane name="family" lazy :label="$t('employee.family')" v-if="can('view', 'employee_family')">
                                <family :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="education" :label="$t('employee.education')" v-if="can('view', 'employee_education')">
                                <education :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="experience" :label="$t('employee.experience')" v-if="can('view', 'employee_experience')">
                                <experience :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="bank_account" :label="$t('employee.bank_account')" v-if="can('view', 'employee_bank_account')">
                                <bank-account :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="work_agreement" :label="$t('employee.work_agreement')" v-if="can('view', 'employee_agreement')">
                                <agreement :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="insurance" :label="$t('employee.insurance')" v-if="can('view', 'employee_insurance')">
                                <insurance :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="medical" :label="$t('employee.medical_checkup')" v-if="can('view', 'employee_mcu')">
                                <medical :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="certification" :label="$t('employee.certification')" v-if="can('view', 'employee_certification')">
                                <certification :employee="route.params.id"/>
                            </el-tab-pane>
                            <el-tab-pane name="attachment" :label="$t('employee.attachment')" v-if="can('view', 'employee_attachment')">
                                <attachment :employee="route.params.id"/>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </template>
            </el-skeleton>
        </el-card>

        <el-card class="!shadow-sm !rounded-lg" body-class="!p-0">
            <el-skeleton animated :loading=isLoading>
                <template>
                    
                </template>
            </el-skeleton>
        </el-card>
    </div>
</template>

<script setup>
import FieldReader from '@/Components/FieldReader.vue';
import { onMounted, ref } from 'vue';
import { Icon } from '@iconify/vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { useQuery } from '@tanstack/vue-query';
import { ElMessageBox, ElMessage } from 'element-plus';
import { useFormatter } from '@/Composable/useFormatter';
import { useTitle } from '@vueuse/core';
import Family from './Family.vue';
import Education from './Education.vue';
import Experience from './Experience.vue';
import BankAccount from './BankAccount.vue';
import Agreement from './Agreement.vue';
import Certification from './Certification.vue';
import Insurance from './Insurance.vue';
import Medical from './Medical.vue';
import Attachment from './Attachment.vue';
import { useAbility } from '@casl/vue';

const { formatDate } = useFormatter();
const { can } = useAbility();
const { t } = useI18n();
const route = useRoute();
const activeTab = ref('personal')
const fetchData = async ({
    queryKey
}) => {
    const [_key, queryParams] = queryKey;
    const response = await axios.get(`/employee/${ route.params.id }`, {
        params: queryParams,
    });
    useTitle(response.data.result.name);
    return response.data.result;
};

const {
    data,
    isLoading,
    isError,
    error,
    refetch
} = useQuery({
    queryKey: [`showEmployee-${route.params.id}`],
    queryFn: fetchData,
    keepPreviousData: true,
});

</script>