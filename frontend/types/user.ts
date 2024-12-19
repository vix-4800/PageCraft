export interface User {
    id: number;
    name: string;
    email: string;
    phone: string;
    is_email_verified: boolean;
    email_verified_at: Date;
    registered_at: Date;
    role: string;
}
