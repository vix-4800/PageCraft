<template>
    <u-app :locale="locales[locale]">
        <nuxt-layout>
            <nuxt-page />
        </nuxt-layout>
    </u-app>
</template>

<script setup lang="ts">
import * as locales from '@nuxt/ui/locale';

const { locale } = useI18n();

const lang = computed(() => locales[locale.value].code);
const dir = computed(() => locales[locale.value].dir);

useHead({
    htmlAttrs: {
        lang,
        dir,
    },
});
</script>
