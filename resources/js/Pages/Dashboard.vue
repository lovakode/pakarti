<template>
    <div class="content">
        <div class="content-header">
            <div class="mt-auto mb-0">
                <div class="text-lg font-semibold">{{ $t('base.dashboard',2) }}</div>
            </div>
            <div class="mt-auto mb-0">
                
            </div>
        </div>

        
        <el-row :gutter="20">
            <el-col :md="24">
                <employee-dept-chart class="mb-5"/>
            </el-col>
            <el-col :md="24">
                <employee-status-chart class="mb-5"/>
            </el-col>
            <el-col :md="24">
                <department-tree class="mb-5"/>
            </el-col>
        </el-row>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useHead } from '@/Composable/useBase.js';
import EmployeeJoinChart from '@/Components/Chart/EmployeeJoinChart.vue';
import EmployeeDeptChart from '@/Components/Chart/EmployeeDeptChart.vue';
import EmployeeStatusChart from '@/Components/Chart/EmployeeStatusChart.vue';
import DepartmentTree from '@/Components/DepartmentTree.vue';

const { t } = useI18n();
const { setTitle } = useHead(); 

onMounted(() => {
    setTitle(t('base.dashboard'));
});
</script>
