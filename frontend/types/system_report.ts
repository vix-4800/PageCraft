export interface SystemReport {
    is_database_up: boolean;
    is_cache_up: boolean;
    is_config_cached: boolean;
    uptime: string;
}
