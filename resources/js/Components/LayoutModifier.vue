<template>
    <component
        :is="tag"
        :type="tag === 'button' ? 'button' : false"
        :href="tag === 'a' ? '#' : false"
        @click.prevent="executeAction">
        <slot></slot>
    </component>
</template>
  
<script setup>
import { useAppBaseStore } from '@/Stores/base';
import { defineProps }from 'vue';


const props = defineProps({
    tag: {
        type: String,
        default: 'button',
        description: 'The HTML tag of the component (button, a)'
    },
    size: {
        type: String,
        description: 'Button size (sm, lg)'
    },
    variant: {
        type: String,
        default: 'primary',
        description: 'Button variant (primary, alt-primary, outline-primary, secondary, alt-secondar' +
                'y, outline-secondary, light, alt-light, outline-light, dark, alt-dark, outline' +
                '-dark, danger, alt-danger, outline-danger, info, alt-info, outline-info, succe' +
                'ss, alt-success, outline-success, warning, alt-warning, outline-warning, dual)'
    },
    action: {
        type: String,
        description: 'Specify the layout modifier mode to apply on click'
    }
});

const appBase = useAppBaseStore();

const layoutAPI = {
    sidebarOpen: () => appBase.sidebar('open'),
    sidebarClose: () => appBase.sidebar('close'),
    sidebarToggle: () => appBase.sidebar('toggle'),
    sidebarMiniOn: () => appBase.sidebarMini('on'),
    sidebarMiniOff: () => appBase.sidebarMini('off'),
    sidebarMiniToggle: () => appBase.sidebarMini('toggle'),
};

const executeAction = () => {
    if (props.action && layoutAPI[props.action]) {
        layoutAPI[props.action]();
    }
};

</script>