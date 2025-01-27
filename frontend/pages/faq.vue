<template>
    <div>
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">
            Frequently asked questions
        </h2>

        <u-accordion
            :items="questions"
            size="xl"
            variant="ghost"
            color="white"
            open-icon="material-symbols:expand-more-rounded"
            close-icon="material-symbols:expand-less-rounded"
        />
    </div>
</template>

<script lang="ts" setup>
const questions = ref([
    {
        label: 'Are there any special discounts or promotions available during the event.',
        defaultOpen: true,
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
    {
        label: 'What are the dates and locations for the product launch events?',
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
    {
        label: 'Can I bring a guest with me to the product launch event?',
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
    {
        label: 'How can I register for the event?',
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
    {
        label: 'Is there parking available at the venue?',
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
    {
        label: 'How can I contact the event organizers?',
        content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor auctor arcu, at fermentum dui. Maecenas ongue facilisis sapien, a semper orci facilisis in.',
    },
]);
</script>
