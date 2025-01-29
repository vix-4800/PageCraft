export interface SystemReport {
    cpu_usage: number;
    ram_usage: number;
    ram_total: number;
    network_incoming: number;
    network_outgoing: number;
    is_database_up: boolean;
    is_cache_up: boolean;
    uptime: string;
    collected_at: Date;
}
