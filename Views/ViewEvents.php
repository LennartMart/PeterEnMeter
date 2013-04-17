<script type="text/javascript">
    jQuery(document).ready(function($){

        loadEvents();
        $("#ToggleAddEvent").click(function () {
            $("#EventAdd").toggle();
        });

        $('#submitAddEvent').click(function () {
            var comment = $('#eventComment').val();
            var eventDate = $('#eventDate').val();
            var n =eventDate.replace("T"," ");
            eventDate = n + ":00";
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "index.php?option=com_jumi&fileid=3&format=raw",
                data: {'action': 'addEvent','event_date': eventDate, 'comment': comment},
                success: function(data){

                    if(data['success'])
                    {
                        alert(data);
                    }
                    else
                    {

                    }
                }
            });
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
    }</script>
<h2>Overzicht Peter en Meter</h2>
<p>
    <button class="btn btn-large btn-primary" id="ToggleAddEvent">Nieuw Event</button>
</p>
<div id="EventAdd" style="display: none;">
    <form class="form-horizontal" method="post">
        <div class="control-group">
            <label class="control-label" for="eventDate">Datum</label>
            <div class="controls">
            <input type="datetime-local" id="eventDate" name="event Date">
        </div>
            </div>
            <div class="control-group">

                <label class="control-label" for="eventComment">Commentaar</label>
                <div class="controls">
            <textarea name="comment" id="eventComment" placeholder='optioneel' /></textarea>
                    </div>
        </div>
        <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn" id="submitAddEvent">Voeg Toe</button>

        </div>
        </div>
        <div>
            <span class="label label-success" style="display: none;">Toevoegen van event is gelukt!</span>
            <span class="label label-important" style="display: none;"></span>
        </div>
    </form>
</div>
<div id="ViewEvents"></div>
