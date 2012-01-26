<div class="post">
  <h2 class="title"><a href="#">Lehrer eintragen</a></h2>
  <div class="entry">
    {if isset($fehlermsg)}
    <p style="color: red;text-align: center">
      {$fehlermsg}
    </p>
    {/if}
    <form action="?page=private.doUploadLehrer" method="post" enctype="multipart/form-data">
      <table align="center" border="0" width="100%">	
	<tr>
	  <td width="30%">
	    Datei:
	  </td>
	  <td width="*">
	    <input name="datei" type="file" maxlength="100000" accept="text/*" />
	  </td>
	</tr>
	<tr>
	  <td width="30%">
	    Trennzeichen:
	  </td>
	  <td width="*">
	    <input name="trennzeichen" type="text" />
	  </td>
	</tr>
	<tr>
	  <td width="*" align="center" colspan="2">
	    <input type="submit" value="Hochladen" name="upload" />
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
