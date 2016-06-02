<html>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>        
    </head>
    <body>
        <div class="ui-widget">
            <form action=/cities/map>
                <label for="city">Cities: </label>
                <input id="city">
                <input type="submit" value="Submit">                    
            </form>
        </div>        
    </body>
</html>

<script>
    $(function() {
        $( "#city" ).autocomplete({
            source: '/cities/map/search',
            _renderItem: function( ul, item ) {
              return $( "<li>" )
                .attr( "data-value", item.id )
                .append( item.name )
                .appendTo( ul );
            }            
        });
        
    });
</script>