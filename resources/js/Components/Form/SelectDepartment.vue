<template>
    <el-tree-select
    node-key="id"
    class="w-full"
    v-model="value"
    check-strictly
    :data="data"
    :render-after-expand="false"
    @change="selectChange"
    :props="defaultProps"
    :loading="isLoading"></el-tree-select>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { useQuery } from '@tanstack/vue-query';

const emit = defineEmits(['update:modelValue'])
// Define props
const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    }
});

const defaultProps =  {
  children: 'children',
  label: 'name',
  disabled: 'disabled',
};

// Define data
const dataList = ref([]);
const value = ref(props.modelValue);
// const isLoading = ref(false);

// Watch for changes to modelValue
watch(() => props.modelValue, (newValue) => {
    value.value = newValue;
});

const fetchData = async ({
    queryKey
}) => {
    const [_key, queryParams] = queryKey;
    const response = await axios.get("/settings/department", {
        params: {
            tree : true
        },
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
    queryKey: ['selectDepartment'], // Query key unik
    queryFn: fetchData,
    keepPreviousData: true,
});
// // Fetch data on mounted
// const fetchData = async () => {
//     try {
//         isLoading.value = true;
//         const response = await axios.get("/settings/department",{
//             params : {
//                 tree : true
//             }
//         });
//         if (response.status === 200) {
//             dataList.value = response.data;
//         }
//         isLoading.value = false;
//     } catch (error) {
//     }
// };

// onMounted(() => {
//     fetchData();
// });

// Emit value change
const selectChange = (newValue) => {
    value.value = newValue;
    emit('update:modelValue', newValue);
};
</script>