<template>
    <div class="content">
        <div class="content-header">
            <div class="mt-auto mb-0">
                <div class="text-lg font-semibold">{{ $t('base.employee', 2) }}</div>
            </div>
            <div class="mt-auto mb-0">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: '/' }">{{ $t('base.dashboard')}}</el-breadcrumb-item>
                    <el-breadcrumb-item>{{ $t('base.employee', 2) }}</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>

        <el-card body-class="!p-0" class="!rounded-lg !shadow-md">
            <div class="flex justify-between items-center p-4">
                <el-select v-model="params.limit" 
                :placeholder="$t('common.select')" 
                :disabled="isLoading"
                class="w-20" @change="refetch()">
                    <el-option label="25" value="25"/>
                    <el-option label="50" value="50"/>
                    <el-option label="100" value="100"/>
                </el-select>

                <div class="flex items-center gap-2">
                    <el-button type="primary" 
                    :disabled="isLoading" @click.prevent="filterShow = !filterShow" 
                    :plain="filterShow">
                        <icon icon="fluent:filter-24-filled" class="me-2"/>
                        {{ $t('common.filter') }}
                    </el-button>       
                    <el-button tag="router-link" type="primary" to="/employee/create" v-if="can('create', 'employee')">
                        <icon icon="mingcute:add-line" class="me-2"/>
                        {{ `${ $t('common.add') } ${ $t('base.employee') }` }}
                    </el-button>
                </div>
            </div>
                    
            <transition name="slide-down">
                <div class="card-filter p-4" v-if="filterShow">
                    <el-form label-position="top" @submit.prevent="refetch">
                        <el-row :gutter="20">
                            <el-col :md="6">
                                <el-form-item :label="$t('common.code')">
                                    <el-input v-model="params.code" clearable/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('common.name')">
                                    <el-input v-model="params.name" clearable/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('common.status')">
                                    <el-select v-model="params.status" clearable>
                                        <el-option value="permanent" :label="$t('employee.permanent')"/>
                                        <el-option value="contract" :label="$t('employee.contract')"/>
                                        <el-option value="resigned" :label="$t('employee.resigned')"/>
                                        <el-option value="retired" :label="$t('employee.retired')"/>
                                        <el-option value="passed_away" :label="$t('employee.passed_away')"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('base.department')">
                                    <select-department v-model="params.dept" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('base.job_position')">
                                    <select-job-position v-model="params.pst" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('base.grade')">
                                    <select-grade v-model="params.grade" />
                                </el-form-item>
                            </el-col>
                            <el-col :md="6">
                                <el-form-item :label="$t('employee.superior')">
                                    <select-employee v-model="params.superior" />
                                </el-form-item>
                            </el-col>
                        </el-row>
                        
                        <div class="flex items-center gap-2">
                            <el-button type="primary" @click.prevent="resetFilter">
                                <Icon icon="fluent:arrow-clockwise-24-regular" class="me-2"/>
                                {{ $t('common.reset')}}
                            </el-button>
                        </div>
                    </el-form>
                </div>
            </transition>
            <el-skeleton :loading="isLoading" animated>
                <template #template>
                    <skeleton-table :rows="15"/>
                </template>
                <template #default v-if="data">
                    <el-table class="!w-full"
                        scrollbar-always-on
                        :data="data.data" @sort-change="sortChange">
                        <el-table-column prop="name" :label="$t('common.name')">
                            <template #default="scope">
                                <div class="flex">
                                    <el-image 
                                        class="!w-10 !h-10 rounded-md me-2"
                                        :src="scope.row.image_path"
                                        :preview-src-list="[scope.row.image_path]"
                                        :initial-index="0"
                                        preview-teleported
                                        />
                                    <div class="my-auto">
                                        <div class="">{{ scope.row.code ?? '-' }}</div>
                                        <div class="font-semibold">{{ scope.row.name }}</div>
                                    </div>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column :label="$t('employee.gender')" sortable width="110">
                            <template #default="scope">
                                {{ scope.row.gender ? $t(`employee.${scope.row.gender}`) : '-' }}
                            </template>
                        </el-table-column>
                        <el-table-column :label="$t('base.job_position')" width="200" sortable>
                            <template #default="scope">
                                <div>{{ scope.row.department ? scope.row.department.name : '-' }}</div>
                                <div class="text-sm">
                                    {{ scope.row.job_position ? scope.row.job_position.name : '-' }}
                                    <el-tag size="small">
                                        {{ scope.row.grade ? scope.row.grade.name : '-' }}
                                    </el-tag>
                                </div>
                            </template>
                        </el-table-column>
                        <!-- <el-table-column prep="department.name" :label="$t('base.department')" width="200" sortable>
                            <template #default="scope">
                                {{ scope.row.department ? scope.row.department.name : '-' }}
                            </template>
                        </el-table-column>
                        <el-table-column prep="job_position.name" :label="$t('base.job_position')" width="170" sortable>
                            <template #default="scope">
                                {{ scope.row.job_position ? scope.row.job_position.name : '-' }}
                            </template>
                        </el-table-column>
                        <el-table-column prep="grade.name" :label="$t('base.grade')" sortable width="110">
                            <template #default="scope">
                                {{ scope.row.grade ? scope.row.grade.name : '-' }}
                            </template>
                        </el-table-column> -->
                        <el-table-column prep="ptkp" :label="$t('employee.ptkp')" sortable width="90">
                            <template #default="scope">
                                {{ scope.row.ptkp ?? '-' }}
                            </template>
                        </el-table-column>
                        <el-table-column prep="status" :label="$t('common.status')" sortable width="140">
                            <template #default="scope">
                                {{ scope.row.status ? $t(`employee.${scope.row.status}`) : '-' }}
                            </template>
                        </el-table-column>
                        <el-table-column :label="$t('common.action')" align="center" width="120">
                            <template #default="scope">
                                <el-dropdown popper-class="dropdown-action" trigger="click" >
                                    <el-button type="primary">
                                        {{ $t('common.action') }}
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item class="w-full">
                                                <router-link :to="`/employee/${scope.row.id}`" class="flex justify-between">
                                                    <Icon icon="mingcute:eye-line" class="me-2"/>
                                                    {{  $t('common.view') }}
                                                </router-link>
                                            </el-dropdown-item>

                                            <el-dropdown-item class="w-full" v-if="can('update', 'employee')">
                                                <router-link :to="`/employee/${scope.row.id}/edit`" class="flex justify-between">
                                                    <Icon icon="mingcute:edit-line" class="me-2"/>
                                                    {{  $t('common.edit') }}
                                                </router-link>
                                            </el-dropdown-item>
                                            <el-dropdown-item v-if="can('delete', 'employee')" class="flex justify-between" @click.prevent="onDelete(scope.row.id)">
                                                <Icon icon="mingcute:delete-2-line" class="me-2"/>
                                                {{ $t('common.delete') }}
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </template>
                        </el-table-column>
                    </el-table>
                    <div class="flex justify-between items-center p-4">
                        <div class="flex items-center gap-2">
                            <span>{{ $t('common.table_paginate', { from: data.from, to: data.to, total:data.total }) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <el-pagination class="float-end" background layout="prev, pager, next"  
                                :page-size="data.per_page" 
                                :total="data.total" 
                                :current-page="params.page" 
                                @current-change="changePage"
                            />
                        </div>
                    </div>
                </template>
            </el-skeleton>
        </el-card>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { ElMessageBox, ElMessage } from 'element-plus';
import { Icon } from '@iconify/vue';
import _ from 'lodash';
import SkeletonTable from '@/Components/SkeletonTable.vue';
import { useQuery } from '@tanstack/vue-query';
import { useI18n } from 'vue-i18n';
import { useHead } from '@/Composable/useBase.js';
import SelectGrade from '@/Components/Form/SelectGrade.vue';
import SelectDepartment from '@/Components/Form/SelectDepartment.vue';
import SelectJobPosition from '@/Components/Form/SelectJobPosition.vue';
import SelectExpertise from '@/Components/Form/SelectExpertise.vue';
import SelectEmployee from '@/Components/Form/SelectEmployee.vue';
import { useAbility } from '@casl/vue';

const { t } = useI18n();
const { can } = useAbility();
const { setTitle } = useHead();

onMounted(() => {
    setTitle(t('base.employee', 2));
});

const filterShow = ref(false);
const params = ref({
    limit: 25,
    page : 1,
    q : "",
    name : null,
    code : null,
    status : null,
    dept : null,
    pst : null,
    superior : null
});

const resetFilter = () => {
    params.value.name = null;
    params.value.code = null;
    params.value.status = null;
    params.value.dept = null;
    params.value.pst = null;
    params.value.superior = null;
    refetch();
};

const fetchData = async ({
    queryKey
}) => {
    const [_key, queryParams] = queryKey;
    const response = await axios.get("/employee", {
        params: queryParams,
    });
    // params.value.page = response.data.page;
    return response.data;
};

const {
    data,
    isLoading,
    isError,
    error,
    refetch
} = useQuery({
    queryKey: ['customerList', params.value],
    queryFn: fetchData,
    keepPreviousData: true,
});

const doSearch = _.debounce(() => {
    params.value.page = 1;
    refetch();
}, 1000);

const sortChange = () => {
    refetch();
}

const changePage = (newPage) => {
    params.value.page = newPage;
    refetch(); 
};

const onDelete = (id) => {
    ElMessageBox.confirm(t("message.delete_confirm"), t('message.delete_confirm_title'), {
        confirmButtonText: t("common.ok"),
        cancelButtonText: t("common.cancel"),
        type: 'warning',
    }).then(() => {
        axios.delete(`/employee/${id}/delete`).then(() => {
            fetchData();
            ElMessage({
                type: 'success',
                message: t('message.delete_success'),
            });
        }).catch(error => {
            ElMessage({
                type: 'error',
                message: t('message.delete_cancel'),
            });
        });
    }).catch(() => {
        ElMessage({
            type: 'info',
            message: t('message.delete_cancel')
        });
    });
};
</script>