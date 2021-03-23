<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 3/22/21
 * Time: 6:07 PM
 */
// function for hooking js into the footer
function hook_javascript() {
?>
<script>

    jQuery( "#title" ).autocomplete({

        minLength: 3,//start search after 3 characters are typed

        source: function (request, response) {

            jQuery.ajax({
                dataType:'json',
                url: '/lists/getlistwp.php?term=' + jQuery('#title').val(),
                data: request,
                success: response,
                error: function(jqXHR, textStatus, errorThrown) {
                    //just leave these here - we are behind a session firewall so displaying errors here may only be viewed by team members
                    //  alert(jqXHR.status);
                    //  alert(textStatus);
                    alert(errorThrown);
                    //alert($('#title').val());

                    response([ ]);
                }

            });
        },

        response: function(event, ui) {

            if (ui.content.length == 0)
                jQuery("#match-message-title").text("List may not exist (check spelling)");
            else jQuery("#match-message-title").empty();

        },
        select: function(event,ui){
            var title = ui.item.value,
                id = ui.item.id,
                price = ui.item.retailprice,
                pagelink = ui.item.pagelink,
                description = ui.item.description,
                malslink = "http://ww4.aitsafe.com/cf/add.cfm?userid=5555555&product=" + title + "&price=" + price + "&return=" + pagelink + "&units=1&qty=1",
                rowcounts = ui.item.rowcounts,
                jsondata = JSON.parse(rowcounts);

            jQuery('#title').val(title);
            jQuery('#list_id').val(id);
            jQuery('#retailprice').text("Price: $" + price);
            jQuery('#description').text(description);
            //rows display box and labels
            jQuery('#totallabel').text("Total rows");
            jQuery('#emailslabel').text("Emails");
            jQuery('#phoneslabel').text("Phones");
            jQuery('#addresslabel').text("Addresses");
            jQuery('#morelabel').text("More");

            //rows display content
            jQuery('#totalrows').text(jsondata['totalrows']);
            jQuery('#totalemails').text(jsondata['totalemails']);
            jQuery('#totalphones').text(jsondata['totalphones']);
            jQuery('#totaladdress').text(jsondata['totaladdress']);
            jQuery('#totalmore').text(jsondata['totalmore']);

            jQuery('#pagelink').text("Go to page >");
            jQuery("#pagelink").attr("href", pagelink);
            jQuery("#pagelink").css({"background-color":"#ffffff", "border":"2px solid #3BB3DB", "padding":"6px", "color":"#3BB3DB","font-size":"1.3", "font-weight":"bold", "float":"left"});
            jQuery('#malslink').text("Buy now");
            jQuery("#malslink").attr("href", malslink);
            jQuery("#malslink").css({"background-color":"orange", "border":"1px solid #000", "border-radius":"4px", "padding":"7px", "color":"#000","font-size":"1.3", "font-weight":"bold", "float":"right"});
            jQuery("#list-widget-block").css({"display":"block"});

        }//end select: function...
    });//end $( "#title").autocomplete({....

</script>
    <?php
} //end function hook_javascript() {...

add_action('wp_footer', 'hook_javascript');