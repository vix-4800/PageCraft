import ConfirmPassword from '~/components/modals/confirm-password.vue';

export const withPasswordConfirmation = async (
    apiFunction: () => Promise<void>,
    title: string,
    subtitle: string,
    onConfirmMessage: string
) => {
    const { $notify } = useNuxtApp();

    if (typeof apiFunction !== 'function') {
        console.error('Invalid success function passed to modal.');
        return;
    }

    try {
        await apiFunction();

        $notify(onConfirmMessage, 'success');
    } catch (err) {
        if (err?.statusCode === 423) {
            const modal = useModal();

            modal.open(ConfirmPassword, {
                title,
                message: subtitle,
                successNotificationMessage: onConfirmMessage,
                successFunction: apiFunction,
            });
        }
    }
};
