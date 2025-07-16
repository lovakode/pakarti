<template>
    <el-dialog
        v-model="visible"
        width="600px"
        :before-close="handleClose"
        :close-on-click-modal="false"
        class="export-modal"
        body-class="p-0"
    >
        <template #title>
            <div class="flex items-center gap-2">
                <Icon icon="mingcute:download-line" class="w-5 h-5" style="color: var(--el-color-primary)"/>
                <span>{{ $t('common.export') }} {{ $t('base.employee', 2) }}</span>
            </div>
        </template>

        <el-form ref="formRef" :model="form" @submit.prevent="handleExport">
                <!-- Format Selection -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div 
                        v-for="format in formats" 
                        :key="format.value"
                        class="format-card"
                        :class="{ 'active': form.format === format.value }"
                        @click="form.format = format.value"
                    >
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 mr-3">
                            <Icon :icon="format.icon" class="w-5 h-5" :class="format.iconColor"/>
                        </div>
                        <div class="format-name flex-1">{{ format.name }}</div>
                        <div class="format-check">
                            <Icon 
                                v-if="form.format === format.value" 
                                icon="mingcute:check-circle-fill" 
                                class="w-5 h-5"
                                style="color: var(--el-color-primary)"
                            />
                        </div>
                    </div>
                </div>

                <!-- Export Options -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <el-checkbox v-model="form.useCurrentFilters" class="w-full">
                        <div class="flex items-center gap-3">
                            <Icon icon="mingcute:filter-line" class="w-5 h-5" style="color: var(--el-color-primary)"/>
                            <div>
                                <div class="font-medium text-gray-900">{{ $t('common.use_current_filters') }}</div>
                                <div class="text-sm text-gray-600">Apply current table filters to export</div>
                            </div>
                        </div>
                    </el-checkbox>
                </div>

                <!-- Columns Selection -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <Icon icon="mingcute:layout-grid-line" class="w-5 h-5" style="color: var(--el-color-primary)"/>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $t('common.columns_to_export') }}</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <el-button size="small" text type="primary" @click="selectAllColumns">
                                <Icon icon="mingcute:check-2-line" class="mr-1"/>
                                {{ $t('common.select_all') }}
                            </el-button>
                            <el-button size="small" text @click="clearAllColumns">
                                <Icon icon="mingcute:close-line" class="mr-1"/>
                                {{ $t('common.clear_all') }}
                            </el-button>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <el-tag type="primary" effect="plain">
                            {{ form.columns.length }} of {{ availableColumns.length }} columns selected
                        </el-tag>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div 
                            v-for="column in availableColumns" 
                            :key="column.value"
                            class="column-card"
                            :class="{ 'selected': form.columns.includes(column.value) }"
                            @click="toggleColumn(column.value)"
                        >
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 mr-3">
                                <Icon :icon="column.icon" class="w-4 h-4 text-gray-500"/>
                            </div>
                            <div class="column-name flex-1">{{ column.label }}</div>
                        </div>
                    </div>
                </div>

                <!-- Status Alert -->
                <div class="pt-4 border-t border-gray-200">
                    <el-alert
                        v-if="form.columns.length === 0"
                        title="Please select at least one column to export"
                        type="warning"
                        :closable="false"
                        show-icon
                    />
                    <el-alert
                        v-else
                        :title="`Ready to export ${form.columns.length} columns in ${form.format.toUpperCase()} format`"
                        type="success"
                        :closable="false"
                        show-icon
                    />
                </div>
            </el-form>

        <template #footer>
            <div class="flex justify-end gap-3">
                <el-button @click="handleClose" size="large">
                    {{ $t('common.cancel') }}
                </el-button>
                <el-button 
                    type="primary" 
                    size="large"
                    :loading="loading"
                    @click="handleExport"
                    :disabled="form.columns.length === 0"
                >
                    <Icon icon="mingcute:download-line" class="mr-2"/>
                    {{ $t('common.export') }}
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import { Icon } from '@iconify/vue';
import { useI18n } from 'vue-i18n';
import { ElMessage } from 'element-plus';
import axios from 'axios';

const { t } = useI18n();

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    currentFilters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['update:modelValue', 'exported']);

const visible = ref(props.modelValue);
const loading = ref(false);
const formRef = ref();

const form = reactive({
    format: 'excel',
    useCurrentFilters: true,
    columns: [
        'code', 'name', 'email', 'phone', 'gender', 'birth_date', 
        'department', 'job_position', 'grade', 'status', 'join_date'
    ]
});

const formats = ref([
    {
        value: 'excel',
        name: 'Excel (.xlsx)',
        description: 'Best for data analysis and calculations',
        icon: 'file-icons:microsoft-excel',
        iconColor: 'text-green-600'
    },
    {
        value: 'pdf',
        name: 'PDF',
        description: 'Perfect for reports and printing',
        icon: 'vscode-icons:file-type-pdf2',
        iconColor: 'text-red-600'
    }
]);

const availableColumns = ref([
    { value: 'code', label: t('common.code'), icon: 'mingcute:hashtag-line' },
    { value: 'name', label: t('common.name'), icon: 'mingcute:user-2-line' },
    { value: 'email', label: t('common.email'), icon: 'mingcute:mail-line' },
    { value: 'phone', label: t('common.phone'), icon: 'mingcute:phone-line' },
    { value: 'gender', label: t('employee.gender'), icon: 'mingcute:group-line' },
    { value: 'birth_date', label: t('employee.birth_date'), icon: 'mingcute:calendar-line' },
    { value: 'department', label: t('base.department'), icon: 'mingcute:building-line' },
    { value: 'job_position', label: t('base.job_position'), icon: 'mingcute:briefcase-line' },
    { value: 'grade', label: t('base.grade'), icon: 'mingcute:medal-line' },
    { value: 'status', label: t('common.status'), icon: 'mingcute:check-circle-line' },
    { value: 'join_date', label: t('employee.join_date'), icon: 'mingcute:calendar-add-line' },
    { value: 'exit_date', label: t('employee.exit_date'), icon: 'mingcute:exit-door-line' },
    { value: 'ptkp', label: t('employee.ptkp'), icon: 'mingcute:textbox-fill' },
    { value: 'address', label: t('common.address'), icon: 'mingcute:location-line' },
    { value: 'emergency_contact', label: t('employee.emergency_contact'), icon: 'mingcute:phone-call-line' }
]);

watch(() => props.modelValue, (newValue) => {
    visible.value = newValue;
});

watch(visible, (newValue) => {
    emit('update:modelValue', newValue);
});

const handleClose = () => {
    visible.value = false;
};

const selectAllColumns = () => {
    form.columns = availableColumns.value.map(col => col.value);
};

const clearAllColumns = () => {
    form.columns = [];
};

const toggleColumn = (columnValue) => {
    const index = form.columns.indexOf(columnValue);
    if (index > -1) {
        form.columns.splice(index, 1);
    } else {
        form.columns.push(columnValue);
    }
};

const validateForm = () => {
    if (form.columns.length === 0) {
        ElMessage.warning('Please select at least one column to export');
        return false;
    }
    return true;
};

const downloadFile = (response, extension) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    
    const timestamp = new Date().toISOString().split('T')[0];
    link.setAttribute('download', `employee_export_${timestamp}.${extension}`);
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    window.URL.revokeObjectURL(url);
};

const handleExport = async () => {
    if (!validateForm()) return;

    loading.value = true;
    
    try {
        const params = {};
        
        if (form.useCurrentFilters) {
            Object.assign(params, props.currentFilters);
        }
        
        params.columns = form.columns.join(',');
        
        const endpoint = form.format === 'excel' ? '/employee/export/excel' : '/employee/export/pdf';
        const extension = form.format === 'excel' ? 'xlsx' : 'pdf';
        
        const response = await axios.get(endpoint, {
            params,
            responseType: 'blob'
        });
        
        downloadFile(response, extension);
        
        ElMessage.success('Export completed successfully');
        emit('exported');
        handleClose();
        
    } catch (error) {
        console.error('Export error:', error);
        ElMessage.error('Export failed. Please try again.');
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
/* Modal Custom Styles */
.export-modal :deep(.el-dialog) {
    @apply rounded-2xl border-0 shadow-2xl;
}

.export-modal :deep(.el-dialog__header) {
    @apply px-6 py-4 border-b border-gray-100;
}

.export-modal :deep(.el-dialog__body) {
    @apply p-0;
}

.export-modal :deep(.el-dialog__footer) {
    @apply px-6 py-4 border-t border-gray-100 bg-gray-50;
}

/* Format Selection */
.format-card {
    @apply flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all duration-200 hover:shadow-md;
}

.format-card:hover {
    border-color: var(--el-color-primary);
    background-color: var(--el-color-primary-light-9);
}

.format-card.active {
    @apply shadow-md;
    border-color: var(--el-color-primary);
    background-color: var(--el-color-primary-light-9);
}

.format-name {
    @apply font-semibold text-gray-900;
}

.format-check {
    @apply ml-auto;
}

/* Column Selection */
.column-card {
    @apply flex items-center p-2 rounded-xl border-2 border-gray-200 cursor-pointer transition-all duration-200 hover:shadow-md;
}

.column-card:hover {
    border-color: var(--el-color-primary);
    background-color: var(--el-color-primary-light-9);
}

.column-card.selected {
    @apply shadow-md;
    border-color: var(--el-color-primary);
    background-color: var(--el-color-primary-light-9);
}

.column-card.selected .w-4 {
    color: var(--el-color-primary);
}

.column-name {
    @apply text-sm font-medium text-gray-900;
}

/* Responsive */
@media (max-width: 768px) {
    .format-card {
        @apply p-3;
    }
    
    .column-card {
        @apply p-2;
    }
}
</style>