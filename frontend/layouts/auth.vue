<template>
    <main
        class="w-full h-screen bg-gradient-to-br from-gray-900 to-gray-700 page-transition layout-transition"
    >
        <div class="flex flex-col justify-center h-screen max-w-2xl mx-auto">
            <div
                class="flex flex-col gap-4 p-6 text-gray-300 border border-gray-600 rounded-lg shadow-2xl background-blur-md"
            >
                <slot></slot>
            </div>
        </div>
    </main>
</template>
