<template>
    <div>
        <div class="flex items-center align-middle justify-between mb-2 py-2 " :class="headerClass">
            <div class="font-semibold my-auto">{{ $t('employee.certification', 2)}}</div>
            <el-button type="primary" 
            :disabled="isLoading" @click.prevent="openModal">
                <icon icon="mingcute:add-line" class="me-2"/>
                {{ `${ $t('common.add') } ${ $t('employee.certification') }` }}
            </el-button>
        </div>
        <el-skeleton :loading="isLoading" animated>
            <template #template>
                <skeleton-table :rows="5"/>
            </template>
            <template #default v-if="data">
                <el-table class="min-w-full" v-if="data"
                    :data="data" @sort-change="sortChange">
                    <el-table-column prop="name" :label="$t('common.name')" sortable>
                        <template #default="scope">
                            {{ scope.row.name ?? '-' }}<br/>
                            {{ scope.row.institution ?? '-' }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="result" :label="$t('employee.result')" sortable>
                        <template #default="scope">
                            {{ scope.row.result ?? '-'}}
                        </template>
                    </el-table-column>
                    <el-table-column prop="level" :label="$t('employee.level')" sortable/>
                    <el-table-column :label="$t('employee.issued_date')" sortable>
                        <template #default="scope">
                            {{ scope.row.issued_date ? formatDate(scope.row.issued_date) : '-' }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('employee.valid_date')" sortable>
                        <template #default="scope">
                            {{ scope.row.valid_date ? formatDate(scope.row.valid_date) : '-' }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('common.action')" align="center" width="150">
                        <template #default="scope">
                            <el-dropdown popper-class="dropdown-action" trigger="click" >
                                <el-button type="primary">
                                    {{ $t('common.action') }}
                                </el-button>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item class="flex justify-between" @click.prevent="onEdit(scope.row)">
                                            <Icon icon="mingcute:edit-line" class="me-2"/>
                                            {{  $t('common.edit') }}
                                        </el-dropdown-item>
                                        <el-dropdown-item class="flex justify-between" @click.prevent="onDelete(scope.row.id)">
                                            <Icon icon="mingcute:delete-2-line" class="me-2"/>
                                            {{ $t('common.delete') }}
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </el-skeleton>

        <el-dialog
        id="modalForm"
        v-model="formShow"
        :title="formTitle" 
        class="!sm:w-full !md:w-[700px] rounded-lg"
        :close-on-click-modal="false"
        :close-on-press-escape="false">
            <el-form label-position="top" ref="formRef" :model="form" :rules="formRules" @submit.prevent="onSubmit">
                <el-row :gutter="20">
                    <el-col :md="12">
                        <el-form-item :label="$t('common.name')" prop="name">
                            <el-input v-model="form.name" clearable/>
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item :label="$t('employee.institution')" prop="institution">
                            <el-input v-model="form.institution" clearable/>
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item :label="$t('employee.level')" prop="level">
                            <el-input v-model="form.level" />
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item :label="$t('employee.issued_date')" prop="issued_date">
                            <el-date-picker v-model="form.issued_date" class="!w-full"
                            format="DD-MM-YYYY"
                            value-format="YYYY-MM-DD" />
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item :label="$t('employee.valid_date')" prop="valid_date">
                            <el-date-picker v-model="form.valid_date" class="!w-full"
                            format="DD-MM-YYYY"
                            value-format="YYYY-MM-DD" />
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item :label="$t('employee.document')">
                           <input-file v-model="form.file" />
                        </el-form-item>
                    </el-col>
                </el-row>

                <div class="text-end">
                    <el-button @click.prevent="onResetForm">
                        {{ $t('common.cancel') }}
                    </el-button>
                    <el-button type="primary" native-type="submit">
                        {{ $t('common.save') }}
                    </el-button>
                </div>
            </el-form>
        </el-dialog>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { ElMessageBox, ElMessage, ElLoading } from 'element-plus';
import { Icon } from '@iconify/vue';
import _ from 'lodash';
import { useI18n } from 'vue-i18n';
import SkeletonTable from '@/Components/SkeletonTable.vue';
import { useQuery } from '@tanstack/vue-query';
import { useFormatter } from '@/Composable/useFormatter';
import InputFile from '@/Components/Form/InputFile.vue';

const props = defineProps({
    employee : {
        type : [String, Number],
        default : null,
    },
    headerClass : {
        type : String,
        default : ""
    }
});
const { formatDate, objectToFormData } = useFormatter();
const { t } = useI18n();

const params = ref({
    q : "",
    employeeId : props.employee
});

const fetchData = async ({
    queryKey
}) => {
    const [_key, queryParams] = queryKey;
    const response = await axios.get(`/certification`, {
        params: queryParams,
    });
    params.value.page = response.data.page;
    return response.data;
};

const {
    data,
    isLoading,
    isError,
    error,
    refetch
} = useQuery({
    queryKey: [`showEmployeeCertification-${props.employee}`, params.value], // Query key unik
    queryFn: fetchData,
    keepPreviousData: true,
});

const doSearch = _.debounce(() => {
    params.value.page = 1;
    refetch();
}, 2000);

const sortChange = () => {
    refetch();
}


const formRef = ref(null);
const formShow = ref(false);
const formTitle = ref('');
const form = ref({
    id : null,
    employee_id : props.employee,
    name : null,
    institution : null,
    level : null,
    issued_date : null,
    valid_date : null,
    file : null,
});


const formRules = ref({
    name: [
        { required: true, message: t('validation.required', { attribute: t('common.name') }), trigger: 'blur' },
    ],
    institution: [
        { required: true, message: t('validation.required', { attribute: t('employee.institution') }), trigger: 'blur' },
    ],
    level: [
        { required: true, message: t('validation.required', { attribute: t('employee.level') }), trigger: 'blur' },
    ],
    issued_date: [
        { required: true, message: t('validation.required', { attribute: t('employee.issued_date') }), trigger: 'blur' },
    ],
    valid_date: [
        { required: true, message: t('validation.required', { attribute: t('employee.valid_date') }), trigger: 'blur' },
    ],
});
const formLoading = ref(false);
const openModal = () => {
    formTitle.value = `${t('common.add')} ${t('employee.certification')}`;
    formShow.value = true;
    form.value.id = null;
    form.value.institution = null;
    form.value.name = null;
    form.value.level = null;
    form.value.issued_date = null;
    form.value.valid_date = null;
    form.value.file = null;
};

const onEdit = (data) => {
    formTitle.value = `${t('common.edit')} ${t('employee.certification')}`;
    formShow.value = true;
    form.value.id = data.id;
    form.value.institution = data.institution;
    form.value.name = data.name;
    form.value.level = data.level;
    form.value.issued_date = data.issued_date;
    form.value.valid_date = data.valid_date;
    form.value.file = data.file_name;
};

const onResetForm = () => {
    formShow.value = false;
    form.value.id = null;
    form.value.institution = null;
    form.value.name = null;
    form.value.level = null;
    form.value.issued_date = null;
    form.value.valid_date = null;
    form.value.file = null;
};

const onSubmit = async () => {
    if (!formRef.value) return;
    formRef.value.validate(async (valid) => {
        if (valid) {
            const loading = ElLoading.service({
                customClass: 'rounded-md',
                target: document.querySelector('#modalForm')
            });
            try {
                formLoading.value = true;
                const url = form.value.id ? `/certification/${form.value.id}/update` : '/certification/store';
                const method = 'post';
                await axios({
                    method,
                    url,
                    data: objectToFormData(form.value),
                    headers: {
                        "Content-Type": "multipart/form-data"
                    },
                });
                formShow.value = false;
                refetch();
                onResetForm();
                ElMessage({
                    message: t('message.success_save'),
                    type: 'success',
                });
            } catch (error) {
                formLoading.value = false;
                ElMessage({
                    message: t('message.error_server'),
                    type: 'error',
                });
            }
            loading.close();
        } else {
            ElMessage({
                message: t('message.error_input'),
                type: 'error',
            });
        }
    });
};

const onDelete = (id) => {
    ElMessageBox.confirm(t("message.delete_confirm"), t('message.delete_confirm_title'), {
        confirmButtonText: t("common.ok"),
        cancelButtonText: t("common.cancel"),
        type: 'warning',
    }).then(() => {
        axios.delete(`/certification/${id}/delete`).then(() => {
            refetch();
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