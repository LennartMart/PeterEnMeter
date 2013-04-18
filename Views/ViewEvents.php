<script src="components/com_jumi/files/PeterEnMeter/assets/js/petermeter.js">
</script>
<h2>Overzicht Peter en Meter</h2>
<p>
    <button class="btn btn-large btn-primary" id="ToggleAddEvent">Nieuw Event</button>
</p>
<div id="EventAdd" style="display: none;">
    <form class="form-horizontal" method="post" id="formAddEvent">
        <div class="control-group">
            <label class="control-label" for="eventDate">Datum</label>
            <div class="controls">
                <input type="date" id="eventDate" name="bday">
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
            <button type="button" class="btn" id="submitAddEvent">Voeg Toe</button>

        </div>
        </div>
        <div>
            <span class="label label-success" style="display: none;">Toevoegen van event is gelukt!</span>
            <span class="label label-important" style="display: none;"></span>
        </div>
    </form>
    <div class="alert alert-warning" id="warningAddEvent" style="display: none;">Helaas, toevoegen mislukt!. Contacteer Lennart voor meer info.</div>
    <div class="alert alert-success" id="successAddEvent" style="display: none;">Event succesvol toegevoegd!</div>
</div>
<div id="ViewEvents"></div>
