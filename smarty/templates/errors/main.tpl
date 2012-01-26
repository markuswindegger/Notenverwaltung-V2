<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-style-type" content="text/css" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    
    <link rel="shortcut icon" href="{$URL}/media/favicon.ico" />

    {foreach from=$metas item=meta}
     {$meta}
    {/foreach}

    <title>DiNoBUS - SAD</title>
    
    <link rel="stylesheet" type="text/css" href="{$URL}/css/layout.css" 
          media="screen, projection, tv" />
    <link rel="stylesheet" type="text/css" href="{$URL}/css/fatal_error.css" 
          media="screen, projection, tv" />
    
    <!--[if lte IE 7.0]>
    <link rel="stylesheet" type="text/css" href="css/ie.css" 
          media="screen, projection, tv" />
    <![endif]-->
    <!--[if IE 8.0]>
    <style type="text/css">
      form.fields fieldset {literal}{margin-top: -10px;}{/literal}
    </style>
    <![endif]-->
    
    {foreach from=$stylesheets item=style}
    <link rel="stylesheet" type="text/css" href="{$URL}/css/{$style}" />
    {/foreach}

    {foreach from=$js_scripts item=script}
    <script type="text/javascript" scr="{$URL}/js/{$script}"></script>
    {/foreach}

    {foreach from=$js_code item=code}
    <script type="text/javascript">
      {$code}
    </script>
    {/foreach}

  </head>
  <body {if $onLoadFunction} onLoad="{$onLoadFunction}"{/if}>
    
    <div id="header">
      <div class="inner-container clearfix">
	<h1 id="logo">
	  <a class="home" href="{$URL}" title="Di.No.BUS">
	    Di.No.BUS
	    <span class="ir">
            </span>
	  </a>
	</h1>
	
      </div>
      <!-- .inner-container -->
    </div>
    <!-- #header -->
    <div id="top_nav">
      <div class="inner-container clearfix">
	
      </div>
      <!-- .inner-container -->
    </div>
    <!-- #nav -->
    
    <div id="container">
      <div class="inner-container">
        
        <div class="box altbox-red">
	  <div class="boxin">
	    <div class="header">
	      <h3>Errore</h3>
	    </div>
	    <div class="content" style="padding: 1em">
	      
              {$message}
              
	    </div>
	  </div>
	</div>
				

      </div> <!-- #inner-container -->
     <div id="footer">
          <p>
            © {$smarty.now|date_format:"%Y"} 
            SAD Trasporto locale / SAD Nahverkehr AG - 
            P.I. 01276500210
          </p>
        </div>

    </div> <!-- #container -->

  </body>
</html>
    
