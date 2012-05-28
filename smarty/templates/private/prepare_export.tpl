<div class="post">
  <h2 class="title"><a href="#">Export von Klassen</a></h2>
  <div id="ajaxspace" class="entry">
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Semester aussuchen:
	  </td>
	  <td>
	    <select name="zeitraumnummer">
	      <option value="-1" selected="selected">Bitte Semester ausw&auml;hlen</option>
	      {foreach $semesterliste as $semester}
	      <option value="{$semester->getIdentNumber()}">{$semester->getSemester()}. Semester {$semester->getSchuljahr()}</option>
	      {/foreach}
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Klasse aussuchen:
	  </td>
	  <td>
	    <select name="klassennummer">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	      {foreach $klassenliste as $klasse}
	      <option value="{$klasse->getIdentNumber()}">{$klasse->getStufe()}. {$klasse->getFachrichtung()} {$klasse->getZug()}</option>
	      {/foreach}
	    </select>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="button" name="Zeige" value="Export" onclick="schuelerrequest()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
