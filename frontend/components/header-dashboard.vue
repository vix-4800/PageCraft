<template>
    <header
        id="page-header"
        x-data="{ userDropdownOpen: false, mobileNavOpen: false }"
        class="flex items-center flex-none z-1 bg-gradient-to-br from-gray-900 to-gray-700"
    >
        <div class="container px-4 mx-auto lg:px-8 xl:max-w-7xl">
            <div class="flex justify-between py-6">
                <div class="flex items-center">
                    <nuxt-link
                        to="/"
                        class="inline-flex items-center gap-1 font-bold tracking-wide text-md group text-slate-700 hover:text-indigo-600 active:text-slate-700 sm:text-lg"
                    >
                        <img
                            src="@img/logo.png"
                            alt=""
                            width="40px"
                            height="40px"
                        />
                        <span class="text-2xl font-bold text-white">
                            {{ appName }}
                        </span>
                    </nuxt-link>
                </div>

                <div class="flex items-center gap-1 lg:gap-5">
                    <nav class="flex items-center gap-2">
                        <a
                            href="javascript:void(0)"
                            class="group flex items-center justify-between rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100 sm:gap-2"
                        >
                            <svg
                                class="inline-block w-5 h-5 hi-mini hi-flag text-slate-300 group-hover:text-indigo-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-4.392l1.657-.348a6.449 6.449 0 014.271.572 7.948 7.948 0 005.965.524l2.078-.64A.75.75 0 0018 12.25v-8.5a.75.75 0 00-.904-.734l-2.38.501a7.25 7.25 0 01-4.186-.363l-.502-.2a8.75 8.75 0 00-5.053-.439l-1.475.31V2.75z"
                                />
                            </svg>
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                            >
                                3
                            </span>
                        </a>
                    </nav>

                    <div class="relative inline-block">
                        <button
                            id="tk-dropdown-layouts-user"
                            type="button"
                            class="group flex items-center justify-between rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-white hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100 sm:gap-2"
                            aria-haspopup="true"
                            x-bind:aria-expanded="userDropdownOpen"
                            x-on:click="userDropdownOpen = true"
                        >
                            <span class="sm:hidden">JD</span>
                            <span class="hidden sm:inline-block">
                                {{ userName }}
                            </span>
                            <svg
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                class="inline-block w-5 h-5 hi-solid hi-chevron-down text-slate-400"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                        <!-- END Dropdown Toggle Button -->

                        <!-- Dropdown -->
                        <div
                            x-cloak
                            x-show="userDropdownOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            x-on:click.outside="userDropdownOpen = false"
                            role="menu"
                            aria-labelledby="tk-dropdown-layouts-user"
                            class="absolute w-48 mt-2 rounded shadow-xl end-0 shadow-slate-200 ltr:origin-top-right rtl:origin-top-left"
                        >
                            <div
                                class="bg-white divide-y rounded divide-slate-100 ring-1 ring-slate-900/5"
                            >
                                <div class="p-2 space-y-1">
                                    <a
                                        role="menuitem"
                                        href="javascript:void(0)"
                                        class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded group text-slate-900 hover:bg-slate-100 hover:text-slate-700"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                            class="inline-block w-5 h-5 hi-mini hi-beaker text-slate-300 group-hover:text-indigo-500"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8.5 3.528v4.644c0 .729-.29 1.428-.805 1.944l-1.217 1.216a8.75 8.75 0 013.55.621l.502.201a7.25 7.25 0 004.178.365l-2.403-2.403a2.75 2.75 0 01-.805-1.944V3.528a40.205 40.205 0 00-3 0zm4.5.084l.19.015a.75.75 0 10.12-1.495 41.364 41.364 0 00-6.62 0 .75.75 0 00.12 1.495L7 3.612v4.56c0 .331-.132.649-.366.883L2.6 13.09c-1.496 1.496-.817 4.15 1.403 4.475C5.961 17.852 7.963 18 10 18s4.039-.148 5.997-.436c2.22-.325 2.9-2.979 1.403-4.475l-4.034-4.034A1.25 1.25 0 0113 8.172v-4.56z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span>Lab</span>
                                    </a>
                                    <a
                                        role="menuitem"
                                        href="javascript:void(0)"
                                        class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded group text-slate-900 hover:bg-slate-100 hover:text-slate-700"
                                    >
                                        <svg
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="inline-block w-5 h-5 hi-solid hi-inbox text-slate-300 group-hover:text-indigo-500"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span>Inbox</span>
                                    </a>
                                </div>
                                <div class="p-2 space-y-1">
                                    <a
                                        role="menuitem"
                                        href="javascript:void(0)"
                                        class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded group text-slate-900 hover:bg-slate-100 hover:text-slate-700"
                                    >
                                        <svg
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="inline-block w-5 h-5 hi-solid hi-user-circle text-slate-300 group-hover:text-indigo-500"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span>Account</span>
                                    </a>
                                </div>
                                <div class="p-2 space-y-1">
                                    <form onsubmit="return false;">
                                        <button
                                            type="submit"
                                            role="menuitem"
                                            class="flex items-center w-full gap-2 px-3 py-2 text-sm font-medium rounded group text-slate-900 hover:bg-slate-100 hover:text-slate-700"
                                        >
                                            <svg
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="inline-block w-5 h-5 hi-solid hi-lock-closed text-slate-300 group-hover:text-indigo-500"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:hidden">
                        <button
                            type="button"
                            class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100"
                            x-on:click="mobileNavOpen = !mobileNavOpen"
                        >
                            <svg
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                class="inline-block w-5 h-5 hi-solid hi-menu"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <nav
                x-cloak
                x-show="mobileNavOpen"
                class="flex flex-col py-4 lg:hidden"
            >
                <a
                    href="javascript:void(0)"
                    class="group flex items-center justify-between gap-2 rounded-md border border-transparent bg-indigo-100 px-2.5 py-2 text-sm font-semibold text-indigo-500 active:border-indigo-200"
                >
                    <svg
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                        class="flex-none inline-block w-5 h-5 hi-solid hi-home"
                    >
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                        />
                    </svg>
                    <span class="grow">Dashboard</span>
                </a>
                <hr class="h-5 border-0" />
                <div class="space-y-1.5">
                    <a
                        href="javascript:void(0)"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <svg
                            class="flex-none inline-block w-5 h-5 hi-mini hi-cursor-arrow-rays text-slate-300 group-hover:text-indigo-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="grow">Sales</span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            250
                        </span>
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <svg
                            class="flex-none inline-block w-5 h-5 hi-mini hi-chart-bar text-slate-300 group-hover:text-indigo-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="M15.5 2A1.5 1.5 0 0014 3.5v13a1.5 1.5 0 001.5 1.5h1a1.5 1.5 0 001.5-1.5v-13A1.5 1.5 0 0016.5 2h-1zM9.5 6A1.5 1.5 0 008 7.5v9A1.5 1.5 0 009.5 18h1a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0010.5 6h-1zM3.5 10A1.5 1.5 0 002 11.5v5A1.5 1.5 0 003.5 18h1A1.5 1.5 0 006 16.5v-5A1.5 1.5 0 004.5 10h-1z"
                            />
                        </svg>
                        <span class="grow">Analytics</span>
                    </a>
                </div>
                <hr class="h-5 border-0" />
                <div class="space-y-1.5">
                    <a
                        href="javascript:void(0)"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <svg
                            class="flex-none inline-block w-5 h-5 hi-mini hi-user-group text-slate-300 group-hover:text-indigo-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z"
                            />
                        </svg>
                        <span class="grow">Users</span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            563
                        </span>
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <svg
                            class="flex-none inline-block w-5 h-5 hi-mini hi-briefcase text-slate-300 group-hover:text-indigo-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M6 3.75A2.75 2.75 0 018.75 1h2.5A2.75 2.75 0 0114 3.75v.443c.572.055 1.14.122 1.706.2C17.053 4.582 18 5.75 18 7.07v3.469c0 1.126-.694 2.191-1.83 2.54-1.952.599-4.024.921-6.17.921s-4.219-.322-6.17-.921C2.694 12.73 2 11.665 2 10.539V7.07c0-1.321.947-2.489 2.294-2.676A41.047 41.047 0 016 4.193V3.75zm6.5 0v.325a41.622 41.622 0 00-5 0V3.75c0-.69.56-1.25 1.25-1.25h2.5c.69 0 1.25.56 1.25 1.25zM10 10a1 1 0 00-1 1v.01a1 1 0 001 1h.01a1 1 0 001-1V11a1 1 0 00-1-1H10z"
                                clip-rule="evenodd"
                            />
                            <path
                                d="M3 15.055v-.684c.126.053.255.1.39.142 2.092.642 4.313.987 6.61.987 2.297 0 4.518-.345 6.61-.987.135-.041.264-.089.39-.142v.684c0 1.347-.985 2.53-2.363 2.686a41.454 41.454 0 01-9.274 0C3.985 17.585 3 16.402 3 15.055z"
                            />
                        </svg>
                        <span class="grow">Projects</span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            1.2k
                        </span>
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <svg
                            class="flex-none inline-block w-5 h-5 hi-mini hi-document-text text-slate-300 group-hover:text-indigo-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="grow">Invoices</span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            7.5k
                        </span>
                    </a>
                </div>
            </nav>
        </div>
    </header>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;

const authStore = useAuthStore();
const userName: string = authStore.user?.name || 'User';
</script>
