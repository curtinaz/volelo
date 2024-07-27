import { get, post } from './ajax_base.js';

function searchPlayer(username, successFunction, errorFunction) {
  get(`/api/users?search=${username}`, {},
    successFunction,
    errorFunction,
    false,
  );
}

function balanceTeam(players, successFunction, errorFunction) {
  post(`/api/users/balancer`, players,
    successFunction,
    errorFunction,
    false,
  );
}

function updateElo(match, successFunction, errorFunction) {
  post(`/api/users/eloUpdate`, match,
    successFunction,
    errorFunction,
    false,
  );
}

function getRanking(perPage = 10, page = 1, successFunction, errorFunction) {
  get(`/api/users/ranking?perPage=${perPage}&page=${page}`, {},
    successFunction,
    errorFunction,
    false,
  );
};

function newUser(username){
  post(``)
}

export { searchPlayer, balanceTeam, updateElo, getRanking };