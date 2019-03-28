/**
 * Camelize a string, cutting the string by multiple separators like
 * hyphens, underscores and spaces.
 *
 * @param {string} string Text to camelize
 * @return string Camelized text
 */
export function camelize (string) {
  return string.replace(/^([A-Z])|[\s-_]+(\w)/g, function (match, p1, p2, offset) {
    if (p2) return p2.toUpperCase()
    return p1.toLowerCase()
  })
}

/**
 * Decamelizes a string with/without a custom separator (underscore by default).
 *
 * @param string String in camelcase
 * @param separator Separator for the new decamelized string.
 */
function decamelize (string, separator) {
  separator = typeof separator === 'undefined' ? '_' : separator

  return string
    .replace(/([a-z\d])([A-Z])/g, '$1' + separator + '$2')
    .replace(/([A-Z]+)([A-Z][a-z\d]+)/g, '$1' + separator + '$2')
    .toLowerCase()
}

export function capitalize (string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
}

export function pascalize (string) {
  return capitalize(camelize(string))
}

export function kebabize (string) {
  return decamelize(string, '-')
}

export function debounce (func, wait, immediate) {
  let timeout
  return function () {
    const context = this
    const args = arguments
    const later = function() {
      timeout = null
      if (!immediate) func.apply(context, args)
    }
    let callNow = immediate && !timeout
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
    if (callNow) func.apply(context, args)
  }
}

export const requiredAutocompleteObject = (value) => {
  return typeof value === 'object' && value.id
}

export default {
  camelize: camelize,
  decamelize: decamelize,
  capitalize: capitalize,
  pascalize: pascalize,
  kebabize: kebabize
}
