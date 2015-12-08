

ReactDOM.render(React.createElement(
  "div",
  null,
  React.createElement(Box, { source: "home/customers" }),
  React.createElement(Box, { source: "home/orders" }),
  React.createElement(Box, { source: "home/products" }),
  React.createElement(Box, { source: "home/pending_orders" })
), document.getElementById('boxes'));