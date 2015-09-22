<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   
    <title>Translation Manager for Laravel</title>
    
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
   <link href="http://code.jquery.com/ui/1.11.4/themes/sunny/jquery-ui.css" rel="stylesheet">
   
   <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->   
   
   <style type="text/css">

         html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote,
         pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s,
         samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul,
         li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td,
         article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup,
         menu, nav, output, ruby, section, summary, time, mark, audio, video {
          border: 0 none;
          margin: 0;
          padding: 0;
         }
         body {
         	font-family: Arial,Helvetica,sans-sefif;
         	padding-top: 70px; 
         }
         h1 {
            font-family: Open Sans Condensed;
            font-size: 2em;
            text-align: center;
         }
         ul {
           list-style: outside;
           list-style-type: none; 
         }
         ul.list {
            list-style: disc;
         }
         .locale-select-option {
            width: 5em;
         }
         #bgtm-content {
            overflow: hidden;
         }
         table th {
            color: #666666;
         } 
         
.toast-container {
   width: 280px;
   z-index: 9999;
}


* html .toast-container {
   position: absolute;
}

.toast-item {
   height: auto;
   background: #333;
    opacity: 0.9;
   border-radius: 10px;
   -moz-border-radius: 10px;
   -webkit-border-radius: 10px;
   color: #eee;
   padding-top: 20px;
   padding-bottom: 20px;
   padding-left: 6px;
   padding-right: 6px;
   font-family: lucida Grande;
   font-size: 14px;
   border: 2px solid #999;
   display: block;
   position: relative;
   margin: 0 0 12px 0;
}

.toast-item p {
    text-align: left;
    margin-left: 50px;
}

.toast-item-close {
    background:url(../images/close.gif);
    width:22px;
    height:22px;
    position: absolute;
    top:7px;
    right:7px;
}

.toast-item-image {
    width:32px;
    height: 32px;
    position: absolute;
    top: 50%;
    margin-top: -16px;
    left: 10px;
}

.toast-item-image-notice {
    background:url(../images/notice.png);
}

.toast-item-image-success {
    background:url(../images/success.png);
}

.toast-item-image-warning {
    background:url(../images/warning.png);
}

.toast-item-image-error {
    background:url(../images/error.png);
}


/**
 * toast types
 *
 * pattern: toast-type-[value]
 * where 'value' is the real value of the plugin option 'type'
 *
 */
.toast-type-notice {
    color: white;
}

.toast-type-success {
    color: white;
}

.toast-type-warning {
    color: white;
    border-color: #FCBD57;
}

.toast-type-error {
    color: white;
    border-color: #B32B2B;
}

/**
 * positions
 *
 * pattern: toast-position-[value]
 * where 'value' is the real value of the plugin option 'position'
 *
 */
.toast-position-top-left {
    position: fixed;
    left: 20px;
    top: 20px;
}

.toast-position-top-center {
    position: fixed;
    top: 20px;
    left: 50%;
    margin-left: -140px;
}

.toast-position-top-right {
    position: fixed;
    top: 20px;
    right: 20px;
}

.toast-position-middle-left {
    position: fixed;
    left: 20px;
    top: 50%;
    margin-top: -40px;
}

.toast-position-middle-center {
    position: fixed;
    left: 50%;
    margin-left: -140px;
    margin-top: -40px;
    top: 50%;
}

.toast-position-middle-right {
    position: fixed;
    right: 20px;
    margin-left: -140px;
    margin-top: -40px;
    top: 50%;
}
         
         
         
   </style>

   @section('css')
   @show
      
   </head>
   <body>
      <nav class="navbar navbar-default navbar-fixed-top">
         <div id="bgtr-nav" class="container">
           <div class="navbar-header">
             <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
             </button>
             <a href="#" class="navbar-brand">Translation Manager for Laravel</a>
           </div>
           <div class="navbar-collapse collapse" id="navbar">
             <ul class="nav navbar-nav">
               <li class="{!! ($activePage == 'dashboard' ? 'active' : '')  !!}"><a href="{{ route('transedit.dashboard') }}" data-url="{{ route('transedit.dashboard') }}" data-target="#bgtm-content" data-toggle="tabajax">Dashboard</a></li>
               <li class="{!! ($activePage == 'language' ? 'active' : '')  !!}"><a href="{{ route('transedit.language') }}" data-url="{{ route('transedit.language') }}" data-target="#bgtm-content" data-toggle="tabajax">Add/Delete Languages</a></li>
               <li class="{!! ($activePage == 'online' ? 'active' : '')  !!}"><a href="{{ route('transedit.online') }}" data-url="{{ route('transedit.online') }}" data-target="#bgtm-content" data-toggle="tabajax">Online Translations</a></li>
               <li class="dropdown">
                 <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <span class="caret"></span></a>
                 <ul class="dropdown-menu">
                   <li><a href="#">Action</a></li>
                   <li><a href="#">Another action</a></li>
                   <li><a href="#">Something else here</a></li>
                   <li class="divider" role="separator"></li>
                   <li class="dropdown-header">Nav header</li>
                   <li><a href="#">Separated link</a></li>
                   <li><a href="#">One more separated link</a></li>
                 </ul>
               </li>
             </ul>
             <ul class="nav navbar-nav navbar-right">
               <li><a href="../navbar/" data-target="#bgtm-content" data-toggle="tabajax">Contact</a></li>
             </ul>
           </div><!--/.nav-collapse -->
         </div>
       </nav>      

       <div class="container">
          <div id="bgtm-content">
            @section('content')
            @show
         </div>
      </div>
   
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      
      <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      
      <script type="text/javascript">
         @include('translationeditor::jquery_toastmessage'); 
      
      </script>
      
      <script type="text/javascript">
      	 
         var bgtmManager = bgtmManager || {
               defaultFiles: {!! json_encode($default_files) !!},
               saveRoute: '{!! route("transedit.savechange") !!}',
               formToken: '{{ Session::token() }}', 

               sendRequest: function(url, requestType, data, successFunction, successParams, errorFunction, errorParams) {
            	  // Chrome and IE can't handle defaults for params
              	   requestType = requestType || 'GET';
                   data = data || null;
                   successFunction = successFunction || null;
                   successParams = successParams || null;
                   errorFunction = errorFunction || null;
                   errorParams = errorParams || null;
                   
                   
  			      jQuery.ajax({
  				      type: requestType,
                      data: data,
  				      url: url,
  				      error: function(data){
  				        alert("There was a problem  data:" + data.responseText);
  				      },
  				      success: function(data){
                       if (successParams == null) {
                          successFunction(data);
                       } else {
                          successFunction(data, successParams);
                       }
                     

  				      }
  				    });
        	   },

               dataFill: function(data, dataTarget) {
                   jQuery(dataTarget).empty();
                   jQuery(dataTarget).html(data); 
                  switch (dataTarget) {
                     case '#dashboard':
                        jQuery('.default-page').off('click').on('click', bgtmManager.getPageContents);
                        break;
                     case '#usersettings': 
                        break;
                     case '#table-body':
                    	 bgtmManager.bindGridButtons(); 
                         bgtmManager.adjustTable();
                      
                         break;
                  }

               },

               showToast: function(data) {
            	   var jsonData = JSON.parse(data);
            	   //var jsonData = data;
                   var toastType = 'success';
                  if (!jsonData.success) {
                      toastType = 'error';
                  }
                  
              	  jQuery().toastmessage('showToast', {
           			  text: jsonData.message,
           			  type:	toastType,		// notice, warning, error, success
           			  sticky: false,
           			  position : 'middle-center'
               	  });
               },
               
               getSelectedPage: function() {
                  return jQuery('[name="file-select"]').val();
               },
               
               bindGridButtons: function() {
            	  jQuery('#add-default-str').off('click').on('click', bgtmManager.addString); 
                  jQuery('button.save-string').off('click').on('click', bgtmManager.saveLanguageString);
                  jQuery('button.online-translate').off('click').on('click', bgtmManager.getOnlineTranslation);
               },

        	   saveLanguageString: function(ev) {
        	      ev.preventDefault();
  				  var target = jQuery(ev.target);
  	              
  				  var dataInput = target.attr('data-input');
                  if (dataInput.substring(0, 1) == '-') {
                    jQuery().toastmessage('showToast', {
                          text: 'Please choose a locale before saving',
                          type:  'error',    // notice, warning, error, success
                          sticky: false,
                          position : 'middle-center'
                       });              
                      return;        
                  }
              
                  var oldStr = target.attr('data-original-value');
                  
                  var str = jQuery('[name="' + dataInput + '"]').val(); 
                  if (str == '') {
                      jQuery().toastmessage('showToast', {
                            text: 'Please enter a value before saving',
                            type:  'error',    // notice, warning, error, success
                            sticky: false,
                            position : 'middle-center'
                         });              
                        return;        
                    }

                  
                  var selectedPage = bgtmManager.getSelectedPage();
                  
                  var data = { page: selectedPage, fieldname: dataInput, oldStr: oldStr, str: str, _token: bgtmManager.formToken};
                  var successParam = { datatarget: target };
                  
			      bgtmManager.sendRequest(bgtmManager.saveRoute, 'POST', data, bgtmManager.showToast, successParam); 
        	   },

               getOnlineTranslation: function(ev) {


                   alert('getOnlineTranslation');
               },
               
               
               adjustTable: function() {
                  var firstRow = jQuery('#table-body > tr:first');
                  // get the width of the row, and then the width of the alias column
                  // and use them to adjust the width's of the other columns
                  var rowWidth = jQuery(firstRow).width();
                  var aliasWidth = jQuery(firstRow).children().eq(1).width();
                  if (aliasWidth > 250) {
                      aliasWidth = 250;
                  }
                  var halfWidth = (rowWidth - aliasWidth) / 2;
                  jQuery(firstRow).children().eq(1).width(halfWidth);
                  jQuery(firstRow).children().eq(2).width(halfWidth);
               },

               createNewFolderForm: function(e) {
                  jQuery("#new-lang-div" ).dialog({
                    title: "Add New File",
                    modal: true,
                       autoOpen: true,
                       closeText: "Save",
                       buttons: [{
                             text: "Save",
                             icons: {
                               primary: "ui-icon-check"
                             },
                          click: function() {
                           bgtmManager.sendNewFileData();
                               jQuery( this ).dialog( "close" );
                             }
                         }
                       ]
                   });                  
               },
               
        	   createNewFileForm: function(e) {
                  jQuery("#dialog-div" ).dialog({
                	  title: "Add New Language Folder",
                	  modal: true,
                      autoOpen: true,
                      closeText: "Save",
                   	  buttons: [{
           	              text: "Save",
           	              icons: {
           	                primary: "ui-icon-check"
           	              },
          	              click: function() {
          	            	bgtmManager.sendNewFolderData();
           	                jQuery( this ).dialog( "close" );
           	              }
                        }
                      ]
                  });
                   
        	   },

               sendNewFileData: function(e) {
      

                   

               },

            	 
        	   getPageContents: function(e) {
        		   var dataTarget = '#table-body';   
        		   var dataUrl = "{!! route('transedit.page', array('||locale1||', '||locale2||', '||page||')) !!}";

        		   var selectedPage = jQuery('[name="file-select"]').val();
        		   var language1 = jQuery('[name="language1-select"]').val();
                   if (language1 == '') {
                       alert('You must select a Base Language')
                       return;
                   }
               
                   var language2 = jQuery('[name="language2-select"]').val();
                   if (language2 == '') {
                	   language2 = 'none';
                   }
                   dataUrl = dataUrl.replace('||locale1||', language1);
                   dataUrl = dataUrl.replace('||locale2||', language2);
                   dataUrl = dataUrl.replace('||page||', selectedPage);

        		   bgtmManager.sendRequest(dataUrl, "GET", null, bgtmManager.dataFill, dataTarget);  
        	   },
             
        	   switchDashboard: function(e) {
                  e.preventDefault();
  				   // First remove the active class on all the tabajax items and data div's
 			      jQuery('a[data-toggle="tabajax"]').parent().removeClass('active');
  				   // put the active class on the selected menu item and data div
       	          var tab = jQuery(e.target);
       	          jQuery(tab).parent().addClass('active');
  				  
          	      var dataUrl = tab.attr('data-url');
 			      var dataTarget = tab.attr('data-target');

 			      bgtmManager.sendRequest(dataUrl, "GET", null, bgtmManager.dataFill, dataTarget);  
        	   }     	 
         };
      	 
     
      	jQuery(document).ready(function() {
       	   jQuery('a[data-toggle="tabajax"]').off('click').on('click', bgtmManager.switchDashboard);
       	   
           jQuery('#btn-create-file').off('click').on('click', bgtmManager.createNewFileForm);
           jQuery('#add-lang-folder').off('click').on('click', bgtmManager.createNewFolderForm);
           

           jQuery('[name="language1-select"]').off('change').on('change', bgtmManager.getPageContents);
           jQuery('[name="language2-select"]').off('change').on('change', bgtmManager.getPageContents);
           jQuery('[name="file-select"]').off('change').on('change', bgtmManager.getPageContents);
           //bgtmManager.bindGridButtons();

           bgtmManager.getPageContents();
           
//           bgtmManager.adjustTable();
           
      	});

      </script>
      
      
      <div id="new-lang-div" style="display: none">
         <span>Add New Language Folder</span>
         <select name="language-select" style="width: 40%" >
            @foreach($all_languages as $index => $lang)
               <option value="{!! $index !!}">{!! $index . ' - ' . $lang['name'] !!}</option>
            @endforeach         
         </select>
      </div>
      <div id="dialog-div" style="display: none">
         <span>New File Name</span>
         <input name="newfile" type="text" />.php
      </div>      
            
   </body>
</html>