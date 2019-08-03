/* global cy, Cypress */

const vuetifyGetMenuEntriesList = () => {
  return cy.get('.menuable__content__active')
}

const vuetifyGetMenuEntry = (value, index = false) => {
  const $entries = vuetifyGetMenuEntriesList().find('.v-list__tile__title')
  if (index) {
    return $entries[value]
  } else {
    return $entries.filter((i, el) => {
      console.log(cy.$$(el).text())
      return cy.$$(el).text() === value
    }).first()
  }
}

const vuetifySelectInputEntry = (value, index = false) => {
  return vuetifyGetMenuEntry(value, index).click()
}

Cypress.Commands.add('vuetifySelectInputEntry', vuetifySelectInputEntry)
