<template>
    <div>
        <page-title
            title="Политика конфиденциальности"
            subtitle="Ваша конфиденциальность — наш приоритет"
        />

        <ol class="space-y-4 list-decimal">
            <li>
                <h2 class="text-2xl font-bold">Сбор данных</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Мы собираем: имя, e-mail, телефон, адрес доставки,
                        платёжные данные (через защищённые платёжные системы).
                    </li>
                    <li class="text-lg">
                        Автоматически: IP-адрес, тип устройства, cookie для
                        корзины и авторизации.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Использование данных</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Оформление заказов, связь с клиентами, улучшение
                        функциональности магазина.
                    </li>
                    <li class="text-lg">
                        Администратор имеет доступ к данным пользователей для
                        управления заказами.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Защита данных</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Все данные шифруются (SSL, AES-256).
                    </li>
                    <li class="text-lg">
                        Доступ к платёжным данным есть только у платёжных систем
                        (Stripe, PayPal и др.).
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Права пользователей</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Пользователь может запросить доступ, изменение или
                        удаление своих данных через администратора магазина.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Третьи лица</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Данные передаются только службам доставки (например,
                        СДЭК) и платёжным системам.
                    </li>
                </ul>
            </li>
        </ol>
    </div>
</template>

<script lang="ts" setup></script>
