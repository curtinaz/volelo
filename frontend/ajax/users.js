import { get } from './ajax_base.js';

function searchPlayer(username, successFunction, errorFunction) {
  get(`/api/users?search=${username}`, {},
  successFunction,
  errorFunction,
  false,
);
}

export { searchPlayer };