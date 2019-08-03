/* global Cypress */

const vuexCommitSetUser = (store, username, roles = ['ROLE_USER'], allowedSites = []) => {
  store.commit('account/SET_USER', {'username': username, 'roles': roles, 'allowedSites': allowedSites})
}

Cypress.Commands.add('vuexCommitSetUser', vuexCommitSetUser)
