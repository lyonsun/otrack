

ReactDOM.render(React.createElement(
  Boxes,
  null,
  React.createElement(Box, { source: "home/customers" }),
  React.createElement(Box, { source: "home/orders" }),
  React.createElement(Box, { source: "home/products" }),
  React.createElement(Box, { source: "home/pending_orders" })
), document.getElementById('boxes'));

ReactDOM.render(React.createElement(List, { source: "home/products_list" }), document.getElementById('products-list'));