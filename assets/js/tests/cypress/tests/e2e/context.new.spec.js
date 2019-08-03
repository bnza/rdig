/// <reference types="cypress" />
/* eslint-env mocha */
/* global cy */

let getStore

const getSiteCodeInput = () => {
  return cy.getElementByTestId('siteCodeFlex').find('input')
}

const getSiteNameInput = () => {
  return cy.getElementByTestId('siteNameFlex').find('input')
}

const getAreaCodeInput = () => {
  return cy.getElementByTestId('areaCodeFlex').find('input')
}

const getAreaNameInput = () => {
  return cy.getElementByTestId('areaNameFlex').find('input')
}

const checkAutoCompleteValues = (values = {
  siteCode: '',
  siteName: '',
  areaCode: '',
  areaName: ''
}) => {
  getSiteCodeInput().should('have.value', values.siteCode)
  getSiteNameInput().should('have.value', values.siteName)
  getAreaCodeInput().should('have.value', values.areaCode)
  getAreaNameInput().should('have.value', values.areaName)
}

describe('Context new form', () => {
  beforeEach(() => {
    cy.fixture('area/842.json').as('area842')
    cy.fixture('area/842.contexts.json').as('area842contexts')
    cy.fixture('area/842.site.json').as('area842site')
    cy.server()
    cy.route('data/area/842', '@area842')
    cy.route('data/area/842/site', '@area842site')
    cy.route('data/area/842/context**', '@area842contexts')
  })
  beforeEach(() => cy.visit('/'))
  beforeEach(() => {
    getStore = () => cy.window().its('app.$store')
  })

  describe('Admin user', () => {
    beforeEach(() => {
      getStore().then((store) => {
        cy.vuexCommitSetUser(store, 'theUser', ['ROLE_ADMIN'])
      })
    })
    it('Without parent area', () => {
      cy.visit('/#/data/context/create')
      getAreaCodeInput().should('not.have.class', 'v-input--is-readonly')
      checkAutoCompleteValues()
      getAreaCodeInput().type('TG')
      cy.wait(500)
      cy.vuetifySelectInputEntry('TG.A')
      checkAutoCompleteValues({
        siteCode: 'TG',
        siteName: 'Taşlıgeçit Höyük',
        areaCode: 'TG.A',
        areaName: 'A'
      })
    })
    it.skip('With parent area', () => {
      cy.visit('http://rdig.local/#/data/area/842/context/create')
      getAreaCodeInput().should('not.have.class', 'v-input--is-readonly')
      cy.wait(500)
      checkAutoCompleteValues({
        siteCode: 'TG',
        siteName: 'Taşlıgeçit Höyük',
        areaCode: 'TG.A',
        areaName: 'A'
      })
    })
  })
})
