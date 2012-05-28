<h3>F&auml;cher f&uuml;r {$semester->getSemester()}. Semester {$semester->getSchuljahr()}</h3>
<form action="?page=private.doUploadFaecher" method="post" enctype="multipart/form-data">
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
	<input type="hidden" value="{$semester->getIdentNumber()}" name="zeitraumnummer" />
	<input type="submit" value="Hochladen" name="upload" />
      </td>
    </tr>
  </table>
</form>
