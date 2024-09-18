<template>
    <div>
        <HeaderDashboard />

        <div>
            <div
                id="page-container"
                class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
            >
                <div
                    id="page-content"
                    class="flex flex-col flex-auto max-w-full"
                >
                    <div class="container p-4 mx-auto lg:p-8 xl:max-w-7xl">
                        <div class="grid grid-cols-1 md:gap-20 lg:grid-cols-12">
                            <DashboardNav />

                            <main class="lg:col-span-9">
                                <slot></slot>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FooterDashboard />
    </div>
</template>
