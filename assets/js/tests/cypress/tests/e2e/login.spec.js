/// <reference types="cypress" />
/* eslint-env mocha */
/* global cy, Cypress */

describe('Login/Logout', () => {
  beforeEach(() => cy.visit('http://rdig.local'))

  const getStore = () => cy.window().its('app.$store')

  it('User could be login/logout', () => {
    getStore()
      .its('state.account.user')
      .should('be.null')
  })
})
