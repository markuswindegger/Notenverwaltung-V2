<option value="-1">
  Bitte Klasse ausw&auml;hlen...
</option>
{foreach $klassenliste as $klasse}
<option value="{$klasse->getIdentNumber()}">
  {$klasse->getStufe()|escape:html}.   {$klasse->getFachrichtung()|escape:html}   {$klasse->getZug()|escape:html}
</option>
{/foreach}
