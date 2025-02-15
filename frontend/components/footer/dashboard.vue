<template>
    <footer
        class="flex items-center grow-0 bg-gradient-to-br from-gray-900 to-gray-700"
    >
        <div class="container px-4 mx-auto lg:px-8 xl:max-w-7xl">
            <div
                class="flex flex-col gap-2 py-6 text-sm font-medium text-center text-white md:flex-row md:justify-between md:gap-0 md:text-start"
            >
                <div>
                    ©
                    <span class="font-semibold">
                        {{ appName }}
                    </span>
                </div>

                <u-icon
                    v-if="loadingVersion"
                    name="svg-spinners:180-ring"
                    size="20"
                />
                <div v-else>
                    <span class="font-medium">
                        {{ version.name }}
                    </span>

                    <nuxt-link
                        v-if="newVersion"
                        class="font-medium text-yellow-400"
                        to="/dashboard/admin/update"
                    >
                        (new version)
                    </nuxt-link>
                </div>
            </div>
        </div>
    </footer>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;

const version = ref('');
const loadingVersion = ref(true);
const newVersion = ref(false);
onMounted(async () => {
    const { data } = await apiFetch('v1/versions');

    version.value = data;
    loadingVersion.value = false;
    newVersion.value = true; // TODO
});
</script>
