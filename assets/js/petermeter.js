jQuery(document).ready(function($){

    loadEvents();
    $("#ToggleAddEvent").click(function () {
        $("#EventAdd").fadeToggle("slow", "linear");
    });

    $('#submitAddEvent').click(function () {
        //Hide the elements
        $("#successAddEvent").hide();
        $("#warningAddEvent").hide();

        var comment = $('#eventComment').val();
        var eventDate = $('#eventDate').val();
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
    $.ajax({
        type: "POST",
        url: "index.php?option=com_jumi&fileid=3&format=raw",
        data: {'action': 'addAttendee','event_id': event_id},
        success: function(data){
            var parsed = $.parseJSON(data);
            if(parsed['success'])
            {
                $('#mydiv .myclass')
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

}
