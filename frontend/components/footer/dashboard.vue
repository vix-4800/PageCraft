<template>
    <footer
        class="flex items-center grow-0 bg-linear-to-br from-gray-900 to-gray-700"
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
                    v-if="!versionStore.fetched"
                    name="svg-spinners:180-ring"
                    size="20"
                />
                <div v-else>
                    <span class="font-medium">
                        {{ versionStore.current.name }}
                    </span>

                    <u-tooltip
                        v-if="newVersion"
                        :text="`Version ${versionStore.latest.name} is available`"
                    >
                        <nuxt-link
                            class="font-medium text-yellow-400"
                            to="/dashboard/admin/update"
                        >
                            (new version)
                        </nuxt-link>
                    </u-tooltip>
                </div>
            </div>
        </div>
    </footer>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;

const versionStore = useVersionStore();

onMounted(async () => {
    await versionStore.fetch();
});
</script>
