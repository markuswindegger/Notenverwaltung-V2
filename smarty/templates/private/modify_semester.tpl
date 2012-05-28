<div class="post">
  <h3 class="title"><a href="#">Semester Bearbeiten</a></h3>
  <div class="entry">
    {if isset($fehlermsg)}
    <p style="color: red;text-align: center">
      {$fehlermsg}
    </p>
    {/if}
    <form action="?page=private.insertSemester" method="post">
      <table align="center" border="0" width="100%">
	<tr>
	  <td>
	    Semester:
	  </td>
	  <td>
	    <select name="semester">
	      <option value="1"
              {if $semester->getSemester() == 1}
		selected="selected"
              {/if}
              >1</option>
	      <option value="2"
	      {if $semester->getSemester() == 1}
		selected="selected"
	      {/if}	
              >2</option>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Schuljahr:
	  </td>
	  <td>
	    <input type="text" name="schuljahr" value="{$semester->getSchuljahr()}"/>
	  </td>
	</tr>
	<tr>
	  <td>
	    Freigabedatum:
	  </td>
	  <td>
	    <input type="text" name="freidatum" onchange="setSperre()" value='{$semester->getFreidatum()->format("d.m.Y")}'/>
	  </td>
	</tr>
	<tr>
	  <td>
	    Sperrdatumdatum:
	  </td>
	  <td>
	    <input type="text" name="sperrdatum" value='{$semester->getSperrdatum()->format("d.m.Y")}'/>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="hidden" name="id" value="{$semester->getIdentNumber()}" />
	    <input type="submit" name="senden" value="&Auml;ndern" onclick="freigeben()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
