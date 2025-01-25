export interface Notification {
    id: string;
    read_at: Date | null;
    data: {
        message: string;
        type: string;
        details: any;
    };
    created_at: Date;
}
