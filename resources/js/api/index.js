import axios from 'axios';
import { camelizeKeys, decamelizeKeys } from 'humps';

const api = axios.create();

api.interceptors.response.use(
  response => {
    if (response.data && response.headers['content-type'].match('application/json')) {
      response.data = camelizeKeys(response.data);
    }

    return response;
  },
);

api.interceptors.request.use(config => {
  const newConfig = { ...config };
  if (newConfig.headers['Content-Type'] === 'multipart/form-data') {
    return newConfig;
  }
  if (config.params) {
    newConfig.params = decamelizeKeys(config.params);
  }
  if (config.data) {
    newConfig.data = decamelizeKeys(config.data);
  }

  return newConfig;
});

export default api;
