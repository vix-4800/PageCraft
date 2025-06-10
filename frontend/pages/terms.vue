<template>
    <div>
        <page-title title="Пользовательское соглашение" />

        <ol class="space-y-4 list-decimal">
            <li>
                <h2 class="text-2xl font-bold">Принятие условий</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Используя систему, вы соглашаетесь с условиями и несёте
                        ответственность за контент магазина.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Регистрация аккаунта</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Администратор обязан обеспечивать достоверность данных и
                        безопасность аккаунта.
                    </li>
                    <li class="text-lg">
                        Пользователям запрещено создавать фейковые аккаунты с
                        целью мошенничества.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">
                    Право собственности на контент
                </h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Администратор сохраняет права на изображения и описания
                        товаров.
                    </li>
                    <li class="text-lg">
                        Система [{{ appName }}] не претендует на
                        пользовательский контент.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Ограничения</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Запрещено использовать систему для продажи запрещённых
                        товаров.
                    </li>
                    <li class="text-lg">
                        Мы не несем ответственности за сбои в работе платёжных
                        систем или служб доставки.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Удаление</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Администратор может удалить свою инстанцию системы в
                        любое время.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Изменения</h2>
                <ul class="list-disc">
                    <li class="text-lg">Условия могут обновляться.</li>
                    <li class="text-lg">
                        Пользователи будут уведомлены по электронной почте или в
                        личном кабинете.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Применимое право</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Применяется законодательство страны, в которой размещена
                        инстанция системы.
                    </li>
                </ul>
            </li>
        </ol>
    </div>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;
</script>
