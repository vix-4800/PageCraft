<template>
    <div>
        <section id="team">
            <page-title
                title="Познакомьтесь с нашей командой"
                subtitle="Знакомьтесь с командой профессионалов, которые будут работать для вас"
            />

            <team-basic :team-members="teamMembers" />
        </section>

        <section id="clients" class="my-12 text-center">
            <page-title
                title="Отзывы наших довольных клиентов"
                subtitle="Veniam proident aute magna anim excepteur et ex consectetur velit ullamco veniam minim aute sit. Elit occaecat officia et laboris Lorem minim. Officia do aliqua adipisicing ullamco in"
            />

            <clients-basic :reviews="reviews" />
        </section>

        <section
            id="metrics"
            class="min-h-[250px] flex flex-col items-center justify-center"
        >
            <page-title title="Метрики приложения" />

            <metrics-basic :stats="stats" />
        </section>

        <section id="integrations" class="my-10">
            <page-title
                title="Интеграции"
                subtitle="Интеграции — это процесс объединения различных программных систем или компонентов для их совместной и бесшовной работы. Это включает подключение разных приложений."
            />

            <integrations-basic :integrations="integrations" />
        </section>
    </div>
</template>

<script lang="ts" setup>
const teamMembers = [
    {
        id: 1,
        name: 'Джон Доу',
        role: 'Генеральный директор',
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
            name: 'Джон Доу',
            image: 'https://readymadeui.com/team-2.webp',
        },
        rating: 3,
        text: 'Сервис был потрясающим. Мне никогда не приходилось так долго ждать свою еду. Персонал был дружелюбным и внимательным, а доставка — на удивление быстрой.',
    },
];

const stats = [
    {
        value: 5.4,
        suffix: 'М+',
        label: 'Всего пользователей',
        description:
            'Общее количество зарегистрированных пользователей на платформе.',
    },
    {
        value: 80,
        suffix: 'K',
        label: 'Доход',
        description: 'Общий доход, полученный приложением.',
    },
    {
        value: 100,
        suffix: 'K',
        label: 'Вовлечённость',
        description:
            'Уровень вовлечённости пользователей во взаимодействие с контентом и функциями приложения.',
    },
    {
        value: 99.9,
        suffix: '%',
        label: 'Аптайм сервера',
        description:
            'Процент времени, в течение которого сервер был работоспособен и доступен.',
    },
];

const integrations = [
    {
        link: 'https://stripe.com',
        description:
            'Stripe — это платформа для обработки платежей, позволяющая бизнесу принимать онлайн-платежи.',
        icon: 'logos:stripe',
    },
    {
        link: 'https://google.com/analytics',
        description:
            'Google Analytics — это сервис веб-аналитики, предоставляющий данные о трафике сайта и поведении пользователей.',
        icon: 'logos:google-analytics',
    },
    {
        link: 'https://mailchimp.com',
        description:
            'Mailchimp — это маркетинговая платформа, позволяющая бизнесу отправлять email-рассылки своей аудитории.',
        icon: 'logos:mailchimp-freddie',
    },
    {
        link: 'https://slack.com',
        description:
            'Slack — это платформа для коммуникаций, позволяющая командам эффективно сотрудничать и общаться.',
        icon: 'logos:slack',
    },
];
</script>
