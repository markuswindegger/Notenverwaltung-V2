<div class="post">
  <h2 class="title"><a href="#">Sch&uuml;lerliste aus Poppcorn</a></h2>
  <div class="entry">
    {if isset($fehlermsg) && $fehlermsg != NULL}
    <p style="color: red" align="center">
      {$fehlermsg}
    </p>
    {/if}
    {if isset($message) && $message != NULL}
    <p align="center">
      {$message}
    </p>
    {/if}
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Semester aussuchen:
	  </td>
	  <td>
	    <select name="zeitraumnummer" onchange="schuelerrequest()">
	      <option value="-1" selected="selected">Bitte Semester ausw&auml;hlen</option>
	      {foreach $semesterliste as $semester}
	      <option value="{$semester->getIdentNumber()}">{$semester->getSemester()}. Semester {$semester->getSchuljahr()}</option>
	      {/foreach}
	    </select>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="button" name="Zeige" value="Weiter" onclick="schuelerrequest()"/>
	  </td>
	</tr>
      </table>
      <p class="error" style="color: red">	
      </p>
    </form>
    <div class="schueler">
    </div>
  </div>
</div>
