import http, { FractalResponseData } from '@/api/http';

export interface Activity {
    event: string;
    timestamp: Date;
}

export const rawDataToActivity = ({ attributes: data }: FractalResponseData): Activity => ({
    event: data.event,
    timestamp: new Date(data.timestamp),
});

export default async (): Promise<Activity> => {
    return new Promise((resolve, reject) => {
        http.get('/api/client/account/activity/latest')
            .then(({ data }) => resolve(rawDataToActivity(data)))
            .catch(reject);
    });
};
