<template>
    <div>
        <DashboardHeader />

        <div
            class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
        >
            <div class="flex flex-col flex-auto max-w-full">
                <div class="container p-4 mx-auto lg:p-8 xl:max-w-7xl">
                    <div class="grid grid-cols-1 md:gap-20 lg:grid-cols-12">
                        <DashboardSidebar />

                        <main class="lg:col-span-9">
                            <div
                                class="p-6 overflow-hidden bg-white border rounded-xl border-slate-200"
                            >
                                <slot></slot>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <DashboardFooter />
    </div>
</template>
