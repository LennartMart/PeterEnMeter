jQuery(document).ready(function($){

    loadEvents();
    $("#ToggleAddEvent").click(function () {
        $("#EventAdd").fadeToggle("slow", "linear");
    });

    $('#submitAddEvent').click(function () {

        var eventDay = $('#eventDay').val();
        var eventMonth = $('#eventMonth').val();
        var eventYear = $('#eventYear').val();
        if(!validateInput(eventDay, eventMonth, eventYear))
        {
            return false;
        }
        var eventDate = eventYear + "-" + eventMonth + "-" + eventDay;
        //Hide the elements
        $("#successAddEvent").hide();
        $("#warningAddEvent").hide();

        var comment = $('#eventComment').val();

        //ContentHeader = text/html, Jumi override this...
        $.ajax({
            type: "POST",
            url: "index.php?option=com_jumi&fileid=3&format=raw",
            data: {'action': 'addEvent','event_date': eventDate, 'comment': comment},
            success: function(data){
                var parsed = $.parseJSON(data);
                if(parsed['success'])
                {
                    $("#successAddEvent").show();
                    loadEvents();
                }
                else
                {
                    $("#warningAddEvent").show();
                }
            },
            error: function (jqXHR, exception) {
                $("#warningAddEvent").show();

            }
        });

        //Clean up the input
        $('#eventComment').val('');
        $('#eventDate').val('');

    });



})
function validateInput(eventDay, eventMonth, eventYear)
{
    if (eventDay==null || eventDay=="" || eventMonth==null || eventMonth=="" || eventYear==null || eventYear=="")
    {
        alert("Vul datum in");
        return false;
    }
    return true;
}

function loadEvents()
{
    jQuery.ajax({
        url: 'http://localhost/JOOMLA/index.php?option=com_jumi&fileid=4&action=viewEvents&format=raw',
        type: 'get',
        dataType: 'html',

        success:function(data)
        {
            jQuery("#ViewEvents").html(data);
        },
        error: function (jqXHR, exception) {
            alert('Uncaught Error.\n' + jqXHR.responseText);

        }

    })
}

function addAttendee(event_id)
{
    jQuery.ajax({
        type: "POST",
        url: "index.php?option=com_jumi&fileid=3&format=raw",
        data: {'action': 'addAttendee','event_id': event_id},
        success: function(data){
            var parsed = jQuery.parseJSON(data);
            if(parsed['success'])
            {
                newItem = jQuery("<li id='"+parsed["attendee_id"]+"'>" + parsed["attendee_name"]+"</li>").hide();
                jQuery('#' + event_id + ' #attendeeList').prepend(newItem);
                newItem.fadeIn();
                jQuery('#' + event_id + ' #btnsAttendee #btnAanwezig').attr("disabled", "disabled");
                jQuery('#' + event_id + ' #btnsAttendee #btnAfwezig').removeAttr("disabled");
                updateProgressbar(event_id);
            }
            else
            {
               alert("Sorry, je kon niet toegevoegd worden. Ben je al niet aanwezig? Zoniet, contacteer Lennart!");
            }
        },
        error: function (jqXHR, exception) {
            alert("Sorry, je kon niet toegevoegd worden. Contacteer Lennart!");

        }
    });

}
function deleteAttendee(event_id)
{
    jQuery.ajax({
        type: "POST",
        url: "index.php?option=com_jumi&fileid=3&format=raw",
        data: {'action': 'deleteAttendee','event_id': event_id},
        success: function(data){
            var parsed = jQuery.parseJSON(data);
            if(parsed['success'])
            {
                jQuery('#' + event_id + ' #attendeeList #'+ parsed["attendee_id"]).fadeOut( function() { jQuery(this).remove(); updateProgressbar(event_id); });
                jQuery('#' + event_id + ' #btnsAttendee #btnAfwezig').attr("disabled", "disabled");
                jQuery('#' + event_id + ' #btnsAttendee #btnAanwezig').removeAttr("disabled");

            }
            else
            {
                alert("Sorry, verwijderen mislukt. Al verwijderd? Zoniet, contacteer Lennart!");
            }
        },
        error: function (jqXHR, exception) {
            alert("Sorry, je kon niet verwijderd worden. Contacteer Lennart!");

        }
    });

}

function updateProgressbar(event_id)
{
    var amount = jQuery("#"+event_id+" #attendeeList li").size();
    jQuery("#"+event_id+ " #requiredAttendees").text(amount+ " van de vereiste 8");
    var percent = (amount / 8) *100;
    jQuery("#"+event_id+ " .bar").width(percent+'%');

}