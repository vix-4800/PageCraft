import type { FeedbackQuestion } from './feedback_question';
import type { Order } from './order';

export interface Notification {
    id: string;
    read_at: Date | null;
    data: {
        message: string;
        type: string;
        details: Order | FeedbackQuestion;
    };
    created_at: Date;
}
