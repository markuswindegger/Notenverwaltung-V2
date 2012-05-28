<div class="post">
  <h2 class="title"><a href="#">Semesterliste</a></h2>
  <div class="entry">
    {if isset($fehlermsg)}
    <p style="color: red;text-align: center">
      {$fehlermsg}
    </p>
    {/if}
    <table border='0' align="center">
      <tr>
	<th>Semester</th>
	<th>Schuljahr</th>
	<th>Freigabe</th>
	<th>Sperrung</th>
	<th>L&ouml;schen</th>
	<th>Bearbeiten</th>
      </tr>
      {foreach $semesterliste as $semester}
      <tr class='{cycle values="odd,even"}'>
      	<td align="center">{$semester->getSemester()}</td>
	<td>{$semester->getSchuljahr()|escape:html}</td>
	<td>{$semester->getFreidatum()->format('d.m.Y')}</td>
	<td>{$semester->getSperrdatum()->format('d.m.Y')}</td>
	<td align="center">
	  <a href="?page=private.semesterliste&id={$semester->getIdentNumber()}">
	    <img src="./images/delete.png" alt="L&ouml;schen" />
	  </a>
	</td>
	<td align="center">
	  <a href="?page=private.modify_semester&id={$semester->getIdentNumber()}">
	    <img src="./images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
      </tr>
      {foreachelse}
      <tr>
	<td colspan="4" align="center">
	  Keine Semester vorhanden!!
	</td>
      </tr>
      {/foreach}
    </table>
  </div>
</div>

<div class="post">
  <h3 class="title"><a href="#">Semester hinzuf&uuml;gen</a></h3>
  <div class="entry">
    <form action="?page=private.insertSemester" method="post">
      <table align="center" border="0" width="100%">
	<tr>
	  <td>
	    Semester:
	  </td>
	  <td>
	    <select name="semester">
	      <option value="1">1</option>
	      <option value="2">2</option>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Schuljahr:
	  </td>
	  <td>
	    <input type="text" name="schuljahr" />
	  </td>
	</tr>
	<tr>
	  <td>
	    Freigabedatum:
	  </td>
	  <td>
	    <input type="text" name="freidatum" onchange="setSperre()" />
	  </td>
	</tr>
	<tr>
	  <td>
	    Sperrdatumdatum:
	  </td>
	  <td>
	    <input type="text" name="sperrdatum" />
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="submit" name="senden" value="Hinzuf&uuml;gen" onclick="freigeben()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
