interface Log {
    date: Date;
}

export interface ApplicationLog extends Log {
    level: string;
    message: string;
}

export interface QueueLog extends Log {
    name: string;
    execution_time: string;
    status: QueueLogStatus;
}

export enum QueueLogStatus {
    RUNNING = 'RUNNING',
    DONE = 'DONE',
    FAILED = 'FAILED',
}
