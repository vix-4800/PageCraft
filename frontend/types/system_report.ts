export interface SystemReport {
    is_database_up: boolean;
    is_cache_up: boolean;
    uptime: string;
    collected_at: Date;
}
