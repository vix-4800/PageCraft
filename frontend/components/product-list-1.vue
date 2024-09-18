<template>
    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-12 text-4xl font-extrabold text-gray-800">
            Coffee store
        </h2>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <nuxt-link
                to="/products/ads"
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>

                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee1.webp"
                            alt="Product 1"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>

                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Espresso Elegante
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $10
                        <strike class="ml-2 font-medium text-gray-400">
                            $15
                        </strike>
                    </h4>

                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </nuxt-link>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5
                            0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0
                            2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0
                            45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5
                            14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0
                            1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>

                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee8.webp"
                            alt="Product 2"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>

                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Mocha Madness
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $12
                        <strike class="ml-2 font-medium text-gray-400">
                            $17
                        </strike>
                    </h4>

                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee3.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Caramel Cream Delight
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $14
                        <strike class="ml-2 font-medium text-gray-400">
                            $19
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee4.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Hazelnut Heaven Blend
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $12
                        <strike class="ml-2 font-medium text-gray-400">
                            $17
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee5.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Vanilla Velvet Brew
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $15
                        <strike class="ml-2 font-medium text-gray-400">
                            $20
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee6.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Double Shot Symphony
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $14
                        <strike class="ml-2 font-medium text-gray-400">
                            $19
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee7.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Irish Cream Dream
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $11
                        <strike class="ml-2 font-medium text-gray-400">
                            $16
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee8.webp"
                            alt="Product 3"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Coconut Bliss Coffee
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $13
                        <strike class="ml-2 font-medium text-gray-400">
                            $18
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>

            <div
                class="bg-gray-200 rounded-xl cursor-pointer hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-6">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>
                    <div
                        class="w-2/3 h-[220px] overflow-hidden mx-auto aspect-w-16 aspect-h-8"
                    >
                        <img
                            src="https://readymadeui.com/images/coffee1.webp"
                            alt="Product 1"
                            class="object-contain w-full h-full"
                        />
                    </div>
                </div>
                <div class="p-6 text-center bg-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        Espresso Elegante
                    </h3>
                    <h4 class="mt-6 text-lg font-bold text-gray-800">
                        $10
                        <strike class="ml-2 font-medium text-gray-400">
                            $15
                        </strike>
                    </h4>
                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-6 text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        Add to cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup></script>
