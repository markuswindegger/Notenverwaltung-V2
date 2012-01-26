
<!-- Error/Info message -->

{if $mess_type == "info"}

<div class="info_message">
 <span class="info_message_title">Fehler</span>
{elseif $mess_type == "warning"}

<div class="warning_message">
 <span class="warning_message_title">Warnung</span>
{elseif $mess_type == "error"}

<div class="error_message">
 <span class="error_message_title">Fehler</span>
{else}
<div class="error_message">
 <span class="error_message_title">Error</span>
{/if}
  <p class="message_text">
  {$message}
  </p>
</div>

<!-- Error/Info message end -->
