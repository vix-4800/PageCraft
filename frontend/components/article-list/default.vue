<template>
    <div>
        <div v-if="loading"></div>
        <div v-if="!loading"></div>
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';

defineProps({
    articles: {
        type: Array as () => Article[],
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>
