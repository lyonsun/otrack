
// Boxes component
// -----------------------------------

var Boxes = React.createClass({
  displayName: 'Boxes',

  render: function () {
    return React.createElement(
      'div',
      null,
      this.props.children
    );
  }
});

// Box component
// -----------------------------------

var Box = React.createClass({
  displayName: 'Box',

  getInitialState: function () {
    return {
      link: '#',
      color: 'default',
      icon: '',
      number: 0,
      text: '--'
    };
  },

  componentDidMount: function () {
    $.get(this.props.source, (function (result) {
      var boxData = $.parseJSON(result);
      if (this.isMounted()) {
        this.setState({
          link: boxData.link,
          color: boxData.color,
          icon: boxData.icon,
          number: boxData.number,
          text: boxData.text
        });
      }
    }).bind(this));
  },

  render: function () {
    var boxRightStyle = {
      fontSize: 25 + 'px',
      fontWeight: 'bold'
    };

    return React.createElement(
      'div',
      { className: 'col-md-3 col-sm-6' },
      React.createElement(
        'a',
        { href: this.state.link },
        React.createElement(
          'div',
          { className: "panel panel-" + this.state.color },
          React.createElement(
            'div',
            { className: 'panel-heading' },
            React.createElement(
              'div',
              { className: 'row' },
              React.createElement(
                'div',
                { className: 'col-xs-3' },
                React.createElement('i', { className: "fa fa-" + this.state.icon + " fa-3x" })
              ),
              React.createElement(
                'div',
                { className: 'col-xs-9 text-right', style: boxRightStyle },
                React.createElement(
                  'div',
                  null,
                  this.state.text
                ),
                React.createElement(
                  'div',
                  null,
                  this.state.number
                )
              )
            )
          )
        )
      )
    );
  }
});

// List component
// -----------------------------------

var List = React.createClass({
  displayName: 'List',

  getInitialState: function () {
    return {
      title: '--',
      nomatch_text: '--',
      products: [],
      count: 0
    };
  },

  componentDidMount: function () {
    $.get(this.props.source, (function (result) {
      var listData = $.parseJSON(result);
      if (this.isMounted()) {
        this.setState({
          title: listData.title,
          nomatch_text: listData.nomatch_text,
          products: listData.products,
          count: listData.products.length
        });
      }
    }).bind(this));
  },

  render: function () {
    if (this.state.count <= 0) {
      list = React.createElement(
        'div',
        { className: 'panel-body' },
        this.state.nomatch_text
      );
    } else {
      list = React.createElement(
        'div',
        { className: 'list-group' },
        this.state.products.map(function (product) {
          if (product.stock <= 1) {
            status = 'progress-bar-danger';
          } else if (product.stock <= 5) {
            status = 'progress-bar-warning';
          } else {
            status = 'progress-bar-success';
          }

          return React.createElement(
            'a',
            { key: product.id, href: "products/view/" + product.id, className: 'list-group-item' },
            React.createElement(
              'span',
              { className: "badge " + status },
              product.stock
            ),
            product.name
          );
        })
      );
    }
    return React.createElement(
      'div',
      { className: 'panel panel-default' },
      React.createElement(
        'div',
        { className: 'panel-heading' },
        React.createElement(
          'h3',
          { className: 'panel-title' },
          this.state.title
        )
      ),
      list
    );
  }
});