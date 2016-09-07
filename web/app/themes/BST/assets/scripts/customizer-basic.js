(function($, api) {

  // Site title
  api('blogname', function(value) {
    value.bind(function(to) {
      $('.master-title a').text(to);
    });
  });
  
})( jQuery, wp.customize );