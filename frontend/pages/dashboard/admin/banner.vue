<template>
    <div>
        <dashboard-page-name title="Banner" />

        <u-form v-if="banner" :state="banner" class="space-y-4">
            <u-form-group label="Text" name="text">
                <u-input v-model="banner.text" color="blue" size="md" />
            </u-form-group>

            <u-form-group label="Link" name="link">
                <u-input v-model="banner.link" color="blue" size="md" />
            </u-form-group>

            <u-form-group label="Is Banner Active" name="is_active">
                <u-toggle
                    v-model="banner.is_active"
                    color="blue"
                    size="lg"
                    on-icon="material-symbols:check"
                    off-icon="material-symbols:close"
                />
            </u-form-group>

            <u-button
                type="submit"
                color="blue"
                icon="material-symbols:save"
                size="md"
                label="Save"
                @click="save"
            />
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import type { Banner } from '~/types/banner';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const loading = ref(false);
const banner = ref<Banner>();
const { $notify } = useNuxtApp();

onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: Banner }>(`v1/banners`);

    banner.value = data;
    loading.value = false;
});

const save = async () => {
    loading.value = true;

    await apiFetch('v1/banners', {
        method: 'PUT',
        body: banner.value,
    });

    loading.value = false;

    $notify('Banner updated successfully', 'success');
};
</script>
