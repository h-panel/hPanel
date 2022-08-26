import http from '@/api/http';

export default (uuid: string): Promise<void> => {
    return new Promise((resolve, reject) => {
        http.post(`/api/client/servers/${uuid}/delete`)
            .then(() => resolve())
            .catch(reject);
    });
};