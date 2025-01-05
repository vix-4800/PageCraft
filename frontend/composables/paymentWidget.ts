export const openPaymentWidget = async () => {
    const { $notify } = useNuxtApp();

    const cartStore = useCartStore();

    const payments = new cp.CloudPayments({
        language: 'en-US',
        email: '',
        applePaySupport: false,
        googlePaySupport: false,
        yandexPaySupport: true,
        tinkoffPaySupport: true,
        tinkoffInstallmentSupport: true,
        sbpSupport: true,
    });

    payments
        .pay('charge', {
            publicId: 'test_api_00000000000000000000002',
            description: 'Order Payment',
            amount: cartStore.cost.total,
            currency: 'USD',
            invoiceId: '123',
            accountId: '123',
            email: cartStore.details.email,
            skin: 'mini',
            requireEmail: true,
            payer: {
                firstName: cartStore.details.name,
                phone: cartStore.details.phone,
            },
        })
        .then(function (widgetResult: { status: string; type: string }) {
            if (widgetResult.status === 'success') {
                cartStore.createOrder();
                cartStore.clearCart();

                $notify('Order Placed Successfully', 'success');
            } else {
                $notify('Payment Cancelled', 'warning');
            }
        })
        .catch(function (widgetResult: { status: string; type: string }) {
            $notify('Payment Failed', 'error');
            console.error(widgetResult);
        });
};
