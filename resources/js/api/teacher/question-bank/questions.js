import api from '../../index';

export default {
  index(params) {
    return api({
      method: 'get',
      url: '/teacher/api/question-bank/question-prototypes',
      params,
    });
  },
};
