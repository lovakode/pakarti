<template>
    <div>
        <div class="flex items-center align-middle justify-between mb-2 py-2 " :class="headerClass">
            <div class="font-semibold my-auto">{{ $t('employee.family_member', 2)}}</div>
            <el-button type="primary" 
            :disabled="isLoading" @click.prevent="openModal">
                <icon icon="mingcute:add-line" class="me-2"/>
                {{ `${ $t('common.add') } ${ $t('employee.family_member') }` }}
            </el-button>
        </div>
        <el-skeleton :loading="isLoading" animated>
            <template #template>
                <skeleton-table :rows="5"/>
            </template>
            <template #default v-if="data">
                <el-table class="min-w-full" 
                    :data="data" @sort-change="sortChange">
                    <el-table-column :label="$t('common.name')" sortable>
                        <template #default="scope">
                            {{ scope.row.name ?? '-'}}<br/>
                            {{ scope.row.relationship ?? '-' }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('employee.birth_date')" sortable>
                        <template #default="scope">
                            {{ scope.row.birth_place ?? '-'}}<br/>
                            {{ scope.row.birth_date ? formatDate(scope.row.birth_date) : '-' }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('employee.religion')" sortable>
                        <template #default="scope">
                            {{ scope.row.religion ? $t(`employee.${scope.row.religion}`):  '-'}}<br/>
                        </template>
                    </el-table-column>
                    <el-table-column prop="phone" :label="$t('common.phone')" sortable/>
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
        class="!sm:w-full !w-1/3 rounded-lg"
        :close-on-click-modal="false"
        :close-on-press-escape="false">
            <el-form label-position="top" ref="formRef" :model="form" :rules="formRules" @submit.prevent="onSubmit">
                <el-form-item :label="$t('common.name')" prop="name">
                    <el-input v-model="form.name"/>
                </el-form-item>
                <el-row :gutter="20">
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
                        <el-form-item :label="$t('employee.relationship')" prop="relationship">
                            <el-select v-model="form.relationship" class="w-full" :placeholder="$t('common.select')">
                                <el-option value="wife" :label="$t('employee.wife')"/>
                                <el-option value="husband" :label="$t('employee.husband')"/>
                                <el-option value="mother" :label="$t('employee.mother')"/>
                                <el-option value="father" :label="$t('employee.father')"/>
                                <el-option value="child" :label="$t('employee.child')"/>
                                <el-option value="sibling" :label="$t('employee.sibling')"/>
                                <el-option value="relative" :label="$t('employee.relative')"/>
                                <el-option value="friend" :label="$t('employee.friend')"/>
                                <el-option value="colleague" :label="$t('employee.colleague')"/>
                                <el-option value="other" :label="$t('employee.other')"/>
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
                </el-row>
                <el-form-item :label="$t('common.phone')">
                    <el-input v-model="form.phone" />
                </el-form-item>

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

const { formatDate } = useFormatter();
const { t } = useI18n();

const params = ref({
    q : "",
    employeeId : props.employee
});

const fetchData = async ({
    queryKey
}) => {
    const [_key, queryParams] = queryKey;
    const response = await axios.get(`/family`, {
        params: queryParams,
    });
    return response.data;
};

const {
    data,
    isLoading,
    isError,
    error,
    refetch
} = useQuery({
    queryKey: ['showEmployeeFamilies', params.value], // Query key unik
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
    name : null,
    employee_id : props.employee,
    birth_date : null,
    birth_place : null,
    relationship : null,
    phone : null,
    religion : null,
});
const formRules = ref({
    name: [
        { required: true, message: t('validation.required', { attribute: t('common.name') }), trigger: 'blur' },
    ]
});
const formLoading = ref(false);

const openModal = () => {
    formTitle.value = `${ t('common.add') } ${ t('employee.family') }`;
    formShow.value = true;
    form.value.id = null;
    form.value.name = null;
    form.value.birth_date = null;
    form.value.birth_place = null;
    form.value.relationship = null;
    form.value.religion = null;
    form.value.phone = null;
}

const onEdit = (data) => {
    formTitle.value = `${ t('common.edit') } ${ t('employee.family') }`;
    formShow.value = true;
    form.value.id = data.id;
    form.value.name = data.name;
    form.value.birth_date = data.birth_date;
    form.value.birth_place = data.birth_place;
    form.value.relationship = data.relationship;
    form.value.religion = data.religion;
    form.value.phone = data.phone;
}

const onResetForm = () => {
    formShow.value = false;
    form.value.id = null;
    form.value.name = null;
    form.value.name = null;
    form.value.birth_date = null;
    form.value.birth_place = null;
    form.value.relationship = null;
    form.value.religion = null;
    form.value.phone = null;
}

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
                const url = form.value.id ? `/family/${form.value.id}/update` : '/family/store';
                const method = 'post';
                await axios({
                    method,
                    url,
                    data: form.value
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
        axios.delete(`/family/${id}/delete`).then(() => {
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