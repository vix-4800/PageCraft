// @ts-check
import withNuxt from './.nuxt/eslint.config.mjs';

export default withNuxt({
    rules: {
        'vue/no-unused-vars': 'error',
        'vue/no-unused-components': 'error',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'vue/html-self-closing': [
            'warn',
            {
                html: { normal: 'never', void: 'always' },
                svg: 'always',
                math: 'always',
            },
        ],
        'vue/max-attributes-per-line': [
            'warn',
            {
                singleline: {
                    max: 4,
                },
                multiline: {
                    max: 1,
                },
            },
        ],
        'vue/multi-word-component-names': 'off',
    },
});
