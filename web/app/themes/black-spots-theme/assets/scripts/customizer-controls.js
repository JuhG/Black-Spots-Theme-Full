// bsColorScheme is a global object

(function($, api) {
    api.controlConstructor.select = api.Control.extend( {
        ready: function() {
            if ( 'color-scheme' === this.id ) {
                this.setting.bind( 'change', function( value ) {
                    var reset = api.instance('color-scheme-reset').get();

                    $.each( bsColorScheme[ value ].colors, function( name, values ) {
                        api.control( name ).container.find( '.color-picker-hex' )
                            .data( 'data-default-color', values.color )
                            .wpColorPicker( 'defaultColor', values.color );
                        if ( reset ) api.instance( name ).set( values.color );
                    });

                } );
            }
        }
    } );

})( jQuery, wp.customize );
