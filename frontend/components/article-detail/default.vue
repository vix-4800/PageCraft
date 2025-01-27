<template>
    <div v-if="article"></div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';

defineProps({
    article: {
        type: Object as () => Article,
        required: true,
    },
});
</script>
