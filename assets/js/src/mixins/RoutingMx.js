export const routingMxOpenTable = function (key, routeName) {
  routeName = routeName || 'data_table_read'
  let prefix = routeName.split('_')[0]
  this.$router.push({
    name: routeName,
    params: {
      prefix: prefix,
      table: key,
      action: 'read'
    }
  })
}