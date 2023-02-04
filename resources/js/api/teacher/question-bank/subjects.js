import api from '../../index';

export default {
  index() {
    return api({
      method: 'get',
      url: '/teacher/api/question-bank/subjects',
    });
  },
};
