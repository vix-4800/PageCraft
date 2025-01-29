export interface PerformanceMetric {
    cpu_usage: number;
    ram_usage: number;
    ram_total: number;
    network_incoming: number;
    network_outgoing: number;
    is_database_up: boolean;
    collected_at: Date;
}
