import api from '../../index';

export default {
  index(params) {
    return api({
      method: 'get',
      url: '/teacher/api/question-bank/question-prototype-versions',
      params,
    });
  },
  get(id, params) {
    return api({
      method: 'get',
      url: `/teacher/api/question-bank/question-prototype-versions/${id}`,
      params,
    });
  },
};
