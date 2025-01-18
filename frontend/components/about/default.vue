<template>
    <section id="team" class="font-sans">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-800">Meet our team</h2>
            <p class="mt-4 text-sm leading-relaxed text-gray-800">
                Meet our team of professionals to serve you.
            </p>
        </div>

        <div
            class="grid gap-6 mt-12 lg:grid-cols-4 md:grid-cols-3 max-md:justify-center"
        >
            <div
                v-for="member in teamMembers"
                :key="member.id"
                class="overflow-hidden border rounded-lg"
            >
                <nuxt-img
                    :src="member.image"
                    class="object-cover w-full h-56"
                />

                <div class="p-4">
                    <h4 class="text-base font-bold text-gray-800">
                        {{ member.name }}
                    </h4>
                    <p class="mt-1 text-xs text-gray-800">{{ member.role }}</p>

                    <div class="mt-4 space-x-4">
                        <u-button
                            icon="mdi:facebook"
                            color="blue"
                            :to="member.facebook"
                            target="_blank"
                            :ui="{ rounded: 'rounded-full' }"
                        />

                        <u-button
                            icon="mdi:twitter"
                            color="blue"
                            :to="member.twitter"
                            target="_blank"
                            :ui="{ rounded: 'rounded-full' }"
                        />

                        <u-button
                            icon="mdi:instagram"
                            color="blue"
                            :to="member.instagram"
                            target="_blank"
                            :ui="{ rounded: 'rounded-full' }"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="my-12 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800">
                What our happy client say
            </h2>
            <p class="mt-6 text-sm leading-relaxed text-gray-500">
                Veniam proident aute magna anim excepteur et ex consectetur
                velit ullamco veniam minim aute sit. Elit occaecat officia et
                laboris Lorem minim. Officia do aliqua adipisicing ullamco in
            </p>
        </div>

        <div
            class="grid gap-6 mx-auto mt-16 md:grid-cols-2 lg:grid-cols-3 max-lg:gap-12 max-md:justify-center max-lg:max-w-3xl max-md:max-w-lg"
        >
            <div v-for="review in reviews" :key="review.id">
                <div class="flex flex-col items-center">
                    <nuxt-img
                        :src="review.user.image"
                        class="w-24 h-24 border-2 border-purple-600 rounded-full"
                    />
                    <div class="mt-6">
                        <h4 class="text-sm font-bold text-gray-800">
                            {{ review.user.name }}
                        </h4>
                    </div>
                </div>

                <div class="flex justify-center space-x-1 mt-2.5">
                    <u-icon
                        v-for="i in review.rating"
                        :key="i"
                        name="mdi:star"
                        size="20"
                        class="text-yellow-400"
                    />

                    <u-icon
                        v-for="i in 5 - review.rating"
                        :key="i"
                        name="mdi:star"
                        size="20"
                        class="text-gray-400"
                    />
                </div>

                <div class="mt-4">
                    <p class="text-sm leading-relaxed text-gray-800">
                        {{ review.text }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section
        id="stats"
        class="min-h-[250px] flex flex-col items-center justify-center font-sans"
    >
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">
            Application Metrics
        </h2>

        <div class="grid gap-6 lg:grid-cols-4 sm:grid-cols-2 max-lg:gap-12">
            <div v-for="stat in stats" :key="stat.label" class="text-center">
                <h3 class="text-4xl font-extrabold text-gray-800">
                    {{ stat.value
                    }}<span class="text-blue-600">{{ stat.suffix }}</span>
                </h3>
                <p class="mt-4 text-base font-bold">{{ stat.label }}</p>
                <p class="mt-2 text-sm text-gray-500">
                    {{ stat.description }}
                </p>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
const teamMembers = [
    {
        id: 1,
        name: 'John Doe',
        role: 'CEO',
        image: 'https://readymadeui.com/team-1.webp',
        facebook: 'https://www.facebook.com/johndoe',
        twitter: 'https://twitter.com/johndoe',
        instagram: 'https://www.instagram.com/johndoe',
    },
];

const reviews = [
    {
        id: 1,
        user: {
            name: 'John Doe',
            image: 'https://readymadeui.com/team-2.webp',
        },
        rating: 3,
        text: 'The service was amazing. I never had to wait that long for my food. The staff was friendly and attentive, and the delivery was impressively prompt.',
    },
];

const stats = [
    {
        value: 5.4,
        suffix: 'M+',
        label: 'Total Users',
        description: 'The total number of registered users on the platform.',
    },
    {
        value: 80,
        suffix: 'K',
        label: 'Revenue',
        description: 'The total revenue generated by the application.',
    },
    {
        value: 100,
        suffix: 'K',
        label: 'Engagement',
        description:
            "The level of user engagement with the application's content and features.",
    },
    {
        value: 99.9,
        suffix: '%',
        label: 'Server Uptime',
        description:
            'The percentage of time the server has been operational and available.',
    },
];
</script>
