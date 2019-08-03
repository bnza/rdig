/// <reference types="cypress" />
/* eslint-env mocha */
/* global cy */

let getStore

const getSiteNameInput = () => {
  return cy.getElementByTestId('siteNameFlex').find('input')
}

const getYearInput = () => {
  return cy.getElementByTestId('yearFlex').find('input')
}

const getAreaNameInput = () => {
  return cy.getElementByTestId('areaNameFlex').find('input')
}

const getContextCodeInput = () => {
  return cy.getElementByTestId('contextCodeFlex').find('input')
}

const getBucketCodeInput = () => {
  return cy.getElementByTestId('bucketCodeFlex').find('input')
}

const checkAutoCompleteValues = (values = {
  siteName: '',
  year: '',
  areaName: '',
  contextCode: '',
  bucketCode: ''
}) => {
  getSiteNameInput().should('have.value', values.siteName)
  getYearInput().should('have.value', values.year)
  getAreaNameInput().should('have.value', values.areaName)
  getContextCodeInput().should('have.value', values.contextCode)
  getBucketCodeInput().should('have.value', values.bucketCode)
}

describe('Object new form', () => {
  beforeEach(() => {
    cy.fixture('bucket/28932.json').as('bucket28932')
    cy.fixture('bucket/28932.objects.json').as('bucket28932objects')
    cy.fixture('bucket/28932.site.json').as('bucket28932site')
    cy.server()
    cy.route('data/bucket/28932', '@bucket28932')
    cy.route('data/bucket/28932/site', '@bucket28932site')
    cy.route('data/bucket/28932/objects**', '@bucket28932objects')
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
    it('Without parent context', () => {
      cy.visit('/#/data/object/create')
      getBucketCodeInput().should('not.have.class', 'v-input--is-readonly')
      checkAutoCompleteValues()
      getBucketCodeInput().type('TG')
      cy.wait(1000)
      cy.vuetifySelectInputEntry('TG.09.0002')
      checkAutoCompleteValues({
        siteName: 'Taşlıgeçit Höyük',
        year: '2009',
        areaName: 'A',
        contextCode: 'F.1',
        bucketCode: 'TG.09.0002'
      })
    })
    it('With parent area', () => {
      cy.visit('/#/data/bucket/28932/object/create')
      getBucketCodeInput().should('not.have.class', 'v-input--is-readonly')
      cy.wait(500)
      checkAutoCompleteValues({
        siteName: 'Taşlıgeçit Höyük',
        year: '2009',
        areaName: 'A',
        contextCode: 'F.1',
        bucketCode: 'TG.09.0002'
      })
    })
  })

})
