import ConfirmPassword from '~/components/modals/confirm-password.vue';

export const withPasswordConfirmation = async (
    apiFunction: () => Promise<void>,
    title: string,
    subtitle: string,
    force: boolean = false,
    onConfirmMessage?: string
) => {
    const modal = useModal();
    const { $notify } = useNuxtApp();

    if (typeof apiFunction !== 'function') {
        console.error('Invalid success function passed to modal.');
        return;
    }

    try {
        if (force) {
            openModal();
        } else {
            await apiFunction();
        }

        if (onConfirmMessage) $notify(onConfirmMessage, 'success');
    } catch (err) {
        if (err?.statusCode === 423) {
            openModal();
        }
    }

    function openModal() {
        modal.open(ConfirmPassword, {
            title,
            message: subtitle,
            successNotificationMessage: onConfirmMessage,
            successFunction: apiFunction,
        });
    }
};
