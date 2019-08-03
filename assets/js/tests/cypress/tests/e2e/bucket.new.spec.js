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

const getContextCodeInput = () => {
  return cy.getElementByTestId('contextCodeFlex').find('input')
}

const getContextTypeInput = () => {
  return cy.getElementByTestId('contextTypeFlex').find('input')
}

const getContextNumInput = () => {
  return cy.getElementByTestId('contextNumFlex').find('input')
}

const checkAutoCompleteValues = (values = {
  siteCode: '',
  siteName: '',
  areaCode: '',
  areaName: '',
  contextCode: '',
  contextType: '',
  contextNum: ''
}) => {
  getSiteCodeInput().should('have.value', values.siteCode)
  getSiteNameInput().should('have.value', values.siteName)
  getAreaCodeInput().should('have.value', values.areaCode)
  getAreaNameInput().should('have.value', values.areaName)
  getContextCodeInput().should('have.value', values.contextCode)
  getContextTypeInput().should('have.value', values.contextType)
  getContextNumInput().should('have.value', values.contextNum)
}

describe('Bucket new form', () => {
  beforeEach(() => {
    cy.fixture('context/23456.json').as('context23456')
    cy.fixture('context/23456.buckets.json').as('context23456buckets')
    cy.fixture('context/23456.site.json').as('context23456site')
    cy.server()
    cy.route('data/context/23456', '@context23456')
    cy.route('data/context/23456/site', '@context23456site')
    cy.route('data/context/23456/bucket**', '@context23456buckets')
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
      cy.visit('/#/data/bucket/create')
      getAreaCodeInput().should('not.have.class', 'v-input--is-readonly')
      checkAutoCompleteValues()
      getContextCodeInput().type('TG')
      cy.wait(500)
      cy.vuetifySelectInputEntry('TG.301')
      checkAutoCompleteValues({
        siteCode: 'TG',
        siteName: 'Taşlıgeçit Höyük',
        areaCode: 'D',
        areaName: 'D',
        contextCode: 'TG.301',
        contextType: 'bench',
        contextNum: '301'
      })
    })
    it('With parent area', () => {
      cy.visit('/#/data/context/23456/bucket/create')
      getAreaCodeInput().should('not.have.class', 'v-input--is-readonly')
      cy.wait(500)
      checkAutoCompleteValues({
        siteCode: 'TG',
        siteName: 'Taşlıgeçit Höyük',
        areaCode: 'D',
        areaName: 'D',
        contextCode: 'TG.301',
        contextType: 'bench',
        contextNum: '301'
      })
    })
  })
})
