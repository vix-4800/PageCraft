<template>
    <div>
        <page-title title="Terms of Service" />

        <ol class="space-y-4 list-decimal">
            <li>
                <h2 class="text-2xl font-bold">Acceptance</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        By using the system, you agree to the terms and
                        conditions and responsibility for the content of the
                        store.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Account Registration</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        The administrator is obliged to ensure the accuracy of
                        the data and the security of the account.
                    </li>
                    <li class="text-lg">
                        Users cannot create fake accounts for fraud.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Content Ownership</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        The administrator retains the rights to product images
                        and descriptions.
                    </li>
                    <li class="text-lg">
                        The [{{ appName }}] system does not claim user content.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Limitations</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        It is prohibited to use the system to sell prohibited
                        goods.
                    </li>
                    <li class="text-lg">
                        We are not responsible for failures in the operation of
                        payment gateways or delivery.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Termination</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        The administrator can delete their instance of the
                        system at any time.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Changes</h2>
                <ul class="list-disc">
                    <li class="text-lg">The terms may be updated.</li>
                    <li class="text-lg">
                        Users will be notified via email or control panel.
                    </li>
                </ul>
            </li>
            <li>
                <h2 class="text-2xl font-bold">Governing Law</h2>
                <ul class="list-disc">
                    <li class="text-lg">
                        Subject to the laws of the country where the instance of
                        the system is located.
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
