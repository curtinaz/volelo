import { get, post, _delete, _get } from './ajax_base.js';

function login(email, password, successFunction, errorFunction) {
  post('/api/Users/login',
    {
      email: email,
      password: password
    },
    successFunction,
    errorFunction
  );
}

function isRecipientRefused(successFunction, errorFunction) {
  get('/api/Users/is-refused', { },
    successFunction,
    errorFunction,
    true
  );
}

function deleteUser(successFunction, errorFunction) {
  _delete('/api/Users', successFunction, errorFunction);
}

function changePassword(oldPassword, newPassword, successFunction, errorFunction) {
  post('/api/Users/change-password',
    {
      oldPassword: oldPassword,
      newPassword: newPassword
    },
    successFunction,
    errorFunction,
    true);
}

function getUser(successFunction, errorFunction) {
  get('/api/Users', {}, successFunction, errorFunction, true);
}

function addAdditionalInfo(form, successFunction, errorFunction) {
  post('/api/Users/additional-info', form, successFunction, errorFunction, true);
}

function addUser(
  form,
  successFunction,
  errorFunction) {
  post('/api/Users',
    form,
    successFunction,
    errorFunction
  );
}

function passwordRecovery(email, successFunction, errorFunction) {
  post('/api/Users/forgot-password',
    {
      email: email
    },
    successFunction,
    errorFunction
  );
}

function checkCodeIsValid(code, successFunction, errorFunction) {
  post('/api/Users/is-code-valid',
    {
      code: code
    },
    successFunction,
    errorFunction
  );
}

function changePasswordWithCode(code, newPassword, invalidateOtherTokens, successFunction, errorFunction) {
  post('/api/Users/change-password-with-code',
    {
      code: code,
      newPassword: newPassword,
      invalidateOtherTokens: invalidateOtherTokens,
    },
    successFunction,
    errorFunction
  );
}

function getProducerFees(successFunction, errorFunction) {
  get('/api/Users/fees', {}, successFunction, errorFunction, true);
}

export {
  login,
  addUser,
  getUser,
  addAdditionalInfo,
  deleteUser,
  changePassword,
  passwordRecovery,
  checkCodeIsValid,
  changePasswordWithCode,
  isRecipientRefused,
  getProducerFees
}