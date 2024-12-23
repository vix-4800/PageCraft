export const apiFetch = async <T>(url: string, options: $FetchOptions = {}) => {
    const runtimeConfig = useRuntimeConfig();
    const apiUrl: string = runtimeConfig.public.apiUrl;
    const apiBaseUrl: string = runtimeConfig.public.apiBaseUrl;

    const defaultHeaders: Record<string, string> = {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    };

    const csrfCookieName = 'XSRF-TOKEN';
    const csrfHeaderName = 'X-XSRF-TOKEN';

    // Fetch the CSRF token cookie
    let csrfCookie = useCookie(csrfCookieName);
    if (!csrfCookie.value) {
        await $fetch('/sanctum/csrf-cookie', {
            baseURL: apiBaseUrl,
            credentials: 'include',
        });
    }

    // If the cookie exists, add it to the headers
    csrfCookie = useCookie(csrfCookieName);
    if (csrfCookie.value) {
        defaultHeaders[csrfHeaderName] = csrfCookie.value;
    }

    const authRoutes: string[] = [
        'sanctum/csrf-cookie',
        'login',
        'register',
        'reset-password',
        'forgot-password',
        'logout',
    ];

    return await $fetch<T>(`/${url}`, {
        baseURL: authRoutes.includes(url) ? apiBaseUrl : apiUrl,
        credentials: 'include',
        ...options,
        headers: {
            ...defaultHeaders,
            ...options.headers,
        },
    });
};
