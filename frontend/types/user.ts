export interface User {
    id: number;
    name: string;
    avatar: string;
    email: string;
    phone: string;
    is_email_verified: boolean;
    email_verified_at: Date;
    registered_at: Date;
    role: string;
    two_factor: {
        enabled: boolean;
        secret: string;
    };
}

export enum UserRole {
    CUSTOMER = 'customer',
    ADMIN = 'admin',
}
