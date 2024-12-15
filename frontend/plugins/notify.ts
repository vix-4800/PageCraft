import { Notyf } from 'notyf';

export default defineNuxtPlugin({
    name: 'notify',
    setup() {
        const notyf = new Notyf({
            duration: 3500,
            position: {
                x: 'right',
                y: 'top',
            },
            ripple: false,
            dismissible: true,
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'warning',
                    },
                },
                {
                    type: 'info',
                    background: '#3d778e',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'info',
                    },
                },
            ],
        });

        return {
            provide: {
                notify: (msg: string, type: string = 'success') =>
                    notyf.open({
                        type: type,
                        message: msg,
                    }),
            },
        };
    },
});
