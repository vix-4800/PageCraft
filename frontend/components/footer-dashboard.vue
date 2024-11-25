<template>
    <footer
        id="page-footer"
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
            </div>
        </div>
    </footer>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;
</script>
