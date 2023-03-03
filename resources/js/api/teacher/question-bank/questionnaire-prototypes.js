import api from '../../index';

export default {
  index(params) {
    return api({
      method: 'get',
      url: '/teacher/api/question-bank/questionnaire-prototypes',
      params,
    });
  },
  show(id, params) {
    return api({
      method: 'get',
      url: `/teacher/api/question-bank/questionnaire-prototypes/${id}`,
      params,
    });
  },
};
