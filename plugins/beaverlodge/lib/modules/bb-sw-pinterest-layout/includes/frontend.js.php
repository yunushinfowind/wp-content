(function($) {

	$(function() {

        var items = $('.masonry li'),
            itemsByTags = {};

        //Loop through tags
        items.each(function(i){
            var elem = $(this),
            tags = elem.data('tags').split(',');

            //Add data attribute for quicksand
            elem.attr('data-id',i);

            $.each(tags,function(key,value){
                //Remove whitespace
                value = $.trim(value);

                if(!(value in itemsByTags)){
                    //Add empty value
                    itemsByTags[value] = [];
                }

                //Add image to array
                itemsByTags[value].push(elem);
            });
        });

        //Create "All Items" option
        createList('All Items',items);

        $.each(itemsByTags, function(k, v){
            createList(k, v);
        });

        //Click Handler
        $('.masonry-navbar a').live('click', function(e){
            var link = $(this);

            //Add active class
            link.addClass('active').siblings().removeClass('active');

            $('.masonry').quicksand(link.data('list').find('li'));
            e.preventDefault();
        });

        $('.masonry-navbar a:first').click();

        //Create the lists
        function createList(text,items){
            //Create empty ul
            var ul = $('<ul>',{'class':'hidden'});

            $.each(items, function(){
                $(this).clone().appendTo(ul)
            });

            //Add gallery div
            ul.appendTo('.masonry');

            //Create menu item
            var a = $('<a>',{
                html:text,
                href:'#',
                data:{list:ul}
            }).appendTo('.masonry-navbar');
        }

            $( '.masonry-navbar a' ).filter( function(){
                if ( ! $.trim( $( this ).html() ) ) {
                    $( this ).addClass( 'hidden' );
            }

    } );
	});

})(jQuery);