<template>
    <u-input-menu
        v-model="selected"
        :options="pages"
        placeholder="Search Pages"
        size="lg"
        class="hidden md:block lg:w-96 md:w-64"
        :ui="{ color: { white: { outline: 'focus:ring-indigo-500' } } }"
        searchable
    >
        <template #option-empty="{ query }">
            Page <q>{{ query }}</q> not found
        </template>
    </u-input-menu>
</template>

<script lang="ts" setup>
defineProps({
    pages: {
        type: Object as () => { label: string; href: string }[],
        required: true,
    },
});

const selected = ref();

watch(
    () => selected.value,
    (page) => {
        if (page) {
            navigateTo(page.href);
            selected.value = null;
        }
    }
);
</script>
