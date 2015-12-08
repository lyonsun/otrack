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
                React.createElement('i', { className: "fa fa-" + this.state.icon + " fa-5x" })
              ),
              React.createElement(
                'div',
                { className: 'col-xs-9 text-right box-right' },
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