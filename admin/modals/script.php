<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php /*header("Content-type: text/javascript; charset: UTF-8");*/?>
<!-- كل الشكر لأمون العظيم -->
<script type="text/javascript">
	   var
	   IsLogin     = Boolean('<?php echo (bool)IsLogin ?>'),
	   IsDirect    = Boolean('<?php echo (bool)directdownload ?>'),
       IsClose     = Boolean('<?php echo (bool)siteclose ?>'),
	   IsIeBrowser = Boolean('<?php echo (bool)IsIeBrowser() ?>'),
	   totalpages  = parseInt('<?php echo $totalpages ?>') ,
	   currentpage = parseInt('<?php echo $currentpage ?>') ,
	   rowsperpage = parseInt('<?php echo rowsperpage ?>') ,
	   
	   t_users	   = parseInt('<?php echo t_users ?>') ,
	   t_files     = parseInt('<?php echo t_files ?>') ,
	   t_folders   = parseInt('<?php echo t_folders ?>') ,
	   t_reports   = parseInt('<?php echo t_reports ?>') ,
	   t_comments  = parseInt('<?php echo t_comments ?>') ,
	   t_size      = parseInt('<?php echo t_size ?>') ,
	   t_size_str  = '<?php echo t_size ?>',
	   
	   HashCode    = '<?php echo HashCode ?>',
	   Language    = '<?php echo InterfaceLanguage ?>',
	   Disk_total  = parseInt('<?php echo $disk_total_space  ?>'),
	   Disk_free   = parseInt('<?php echo $disk_free_space  ?>'),
	   Lbl_total   = '<?php echo $lang[242] ?>',
	   lbl_free    = '<?php echo $lang[243] ?>',
	   _LblUpdat   = '<?php echo $lang[79] ?>',
	   _LblInfo    = '<?php echo $lang[105] ?>',
	   _path_      = '<?php echo siteurl ?>',
	   PassLabel   = '<?php echo $lang[37] ?>',
	   confirmMsg  = '<?php echo $lang[154] ?>',
	   _Yes        = '<?php echo $lang[104] ?>',
	   _No         = '<?php echo $lang[156] ?>',
	   Numberlbl   = '<?php echo $lang[157] ?>',
	   deleteLabel = '<?php echo $lang[32] ?>',
	   PleaseWait  = '<?php echo $lang[102] ?>',
	   Loading     = '<?php echo $lang[45] ?>',
	   datemsg     = '<?php echo $lang[84] ?>',
	   SiteUrl     = '<?php echo siteurl ?>',
	   chart_dates_labels ='<?php echo $chart_dates_labels?>',
	   chart_dates_data   ='<?php echo $chart_dates_data?>',
	   chart_uploads_labels='<?php echo $chart_uploads_labels?>',
	   chart_uploads_data   ='<?php echo $chart_uploads_data?>',
	   IsRtL            = Boolean('<?php echo (bool)IsRtL() ?>'),
	   IsGetDownload    = Boolean('<?php echo (bool)(isset($_GET['download'])) ?>'),
	   IsGetFiles       = Boolean('<?php echo (bool)(isset($_GET['files'])) ?>'),
	   IsGetUsers       = Boolean('<?php echo (bool)(isset($_GET['users'])) ?>'),
	   IsGetFolders     = Boolean('<?php echo (bool)(isset($_GET['folders'])) ?>'),
	   IsGetReports     = Boolean('<?php echo (bool)(isset($_GET['reports'])) ?>'),
	   IsGetStatistics  = Boolean('<?php echo (bool)(isset($_GET['statistics'])) ?>'),
	   IsGetSettings    = Boolean('<?php echo (bool)(isset($_GET['settings'])) ?>'),
	   IsGetPublicity   = Boolean('<?php echo (bool)(isset($_GET['publicity'])) ?>'),
	   IsGetPlans       = Boolean('<?php echo (bool)(isset($_GET['plans'])) ?>'),
	   IsGetComments    = Boolean('<?php echo (bool)(isset($_GET['comments'])) ?>'),
	   AdminGetIsEmpty  = Boolean('<?php echo (bool)(AdminGetIsEmpty) ?>'),
	   LoadJsCheckbox   = true,
      _maxVisible = 10,
	   myChart    = null;
	  
	  if(IsRtL) 
		  summernoteLang = 'ar-AR';
	  else
		  summernoteLang = 'en-US';
	
	   function loadTSize(){$("#t_size").html(t_size_str);}
	  
	  function LoadTable(num){
		if(IsGetUsers){
			 table = 'users';
		} else if(IsGetFolders) {
		     table = 'folders';
		} else if(IsGetReports) {
			 table = 'reports';
		} else if(IsGetStatistics) {
		     table = 'statistics';
	    } else if(IsGetFiles){ 
		     table = 'files';
		} else if(IsGetPlans){ 
		     table = 'plans';
		} else if(IsGetComments){
			 table = 'comments';		
		} else { return ;}
		      $('#span_select_all').hide();
	          $('#select_all').prop('checked',false);
			   $.get("ajax/action.php?"+table+"&currentpage="+num, function(data, status){
				   if(status=='success'){
					   loadTableHtml(data);
					   $('.checkbox').checkbox();
					    $('#span_select_all').show();
				   }
					});
			   
	  	};
	   
	 
		if(AdminGetIsEmpty)
		{
			
			 if(chart_dates_data!=='' && chart_dates_labels!=='' &&  (!IsIeBrowser))
			 {
				 
				 dates_data   = chart_dates_data.split(",");//.map(function(item) {return parseInt(item, 10);});
				 for (var i=0; i<dates_data.length; i++)
					 dates_data[i] = parseInt(dates_data[i], 10);
				 dates_labels = chart_dates_labels.split(","); 
				 uploads_data   = chart_uploads_data.split(",");//.map(function(item) {return parseInt(item, 10);});
				 for (var i=0; i<uploads_data.length; i++)
					 uploads_data[i] = parseInt(uploads_data[i], 10);
				 uploads_labels = chart_uploads_labels.split(","); 
				 lineChart("#ChartDates",dates_labels,dates_data,datemsg);	
				 lineChart("#ChartUploads",uploads_labels,uploads_data,datemsg); 
				 doughnutChart("#ChartSpace",[Lbl_total,lbl_free,''],[Disk_total,Disk_free,0]); 
				 
				 var numusers = new CountUp("t_users", 0, t_users );
				 numusers.start();
				 
				 var numusers = new CountUp("t_files", 0, t_files );
				 numusers.start();
				 
				 var numusers = new CountUp("t_folders", 0, t_folders );
				 numusers.start();
				 
				 var numusers = new CountUp("t_reports", 0, t_reports );
				 numusers.start();
				 	 var numusers = new CountUp("t_comments", 0, t_comments );
				 numusers.start();
				 
				 var numusers = new CountUp("t_size", 0, t_size );
				 numusers.start(loadTSize());

				 var myVar = setInterval("loadTSize()", 3000);
				/* if(isInt($("#t_size").html()))
					 clearInterval(myVar);*/
			 }
			 
		}
		else
	   {
		$("#tbody").html('<tr><td colspan="9">'+Loading+' ( <code>1</code> / <code>'+totalpages+'</code> ) ...</td></tr>'); 
	    LoadTable(currentpage);
        // init bootpag
        $('#page-selection').bootpag({
			page : currentpage,
            total: totalpages,
			 maxVisible: _maxVisible
        }).on("page", function(event, num){
              $("#tbody").html('<tr><td colspan="9">'+Loading+' ( <code>'+num+'</code> / <code>'+totalpages+'</code> ) ...</td></tr>'); 
			  LoadTable(num); 
        });
	   }
				
	



$(window).load(function () {
	
	$(".se-pre-con").fadeOut("slow",function() {
		$("#button-selection").hide(); 
		$("#result-selection").hide(); 
		$(".se-pre-con").remove();
		$( "#button-selection" ).hide();
		$("#navbar").css("visibility", "visible");
		$("#menu").css("visibility", "visible");
		$("#container").css("visibility", "visible");
		
	});	
	
});

function isInt(value) {
  var x;
  return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
}

 function copyright()
{
	var _Copyright_ = 'onexite';
	if ( $( "#author" ).length )
		_author = $('#author').html(); 
	else
		_author = _Copyright_ ; 
	
	if( _author.indexOf(_Copyright_) == -1 ){
		bootbox.alert({ size: "small",title: "تنبيه",message:'لا يمكن تغيير حقوق المبرمج ، سيستمر هذا التنبيه في الظهور' , buttons: {ok: {label: _Yes}} });
		$('#author').html(_Copyright_); 
  }
}

function CommentStatus(id) {
	  $("#Status_"+id).html('..');
	  $.get("ajax/action.php?commentstatus=" + id , function(data, status) { if (status == 'success') $("#Status_"+id).html(data.icon);});
		
}

function EditUserModal(id,editS) { 
 if (typeof(editS)==='undefined') editS = true;
 (editS) ? $("#BtnUpdateUser").show() : $("#BtnUpdateUser").hide();
 $('#level').prop('disabled', !editS) ;
 $('#status').prop('disabled', !editS) ;
 $('#username').prop('disabled', !editS) ;
 $('#email').prop('disabled', !editS) ;
 $('#password').prop('disabled', !editS) ;
 $('#user_id').prop('disabled', !editS) ;

 $('.selectpicker').prop('disabled', !editS);
 $('.selectpicker').selectpicker('refresh');

 $("#EditUserModal_title").html( (editS) ? _LblUpdat : _LblInfo)
/*
$("#edituser_form").removeClass().addClass('modal-form');
$("#EditUserModal .modal-loader").fadeIn();*/
$("#BtnUpdateUser").attr("disabled", true);
$('#EditUserModal').modal('show');	
$("#EditUserResults").html("<code> "+PleaseWait+"</code>"); 
$.get("ajax/action.php?userinfo="+id, function(data, status){
if(status=='success') {
	
$("#EditUserResults").html(""); 	

(data.level=='1') ? $('#level').prop('checked', true) : $('#level').prop('checked', false);
(data.status=='2') ? $('#status').prop('checked', true) : $('#status').prop('checked', false); 
(!data.user_id)	? $("#BtnUpdateUser").attr("disabled", true) : $("#BtnUpdateUser").attr("disabled", false);

$('#username').val(data.username);	
$('#email').val(data.email);	
$('#user_id').val(data.user_id);	
$('.settings').checkbox('update');	
/*$("#EditUserModal .modal-loader").fadeOut("fast",function() {$("#edituser_form").removeClass();});*/	
} 
});
}



function EditPlanModal(id) { 

/*$("#editplan_form").removeClass().addClass('modal-form');
$("#EditPlanModal .modal-loader").fadeIn();*/
$("#BtnUpdatePlan").attr("disabled", true);

$('#plan_userspacemax').attr("disabled", false);
$('#plan_days_older').attr("disabled", false);
$('#plan_price').attr("disabled", false);

$('#plan_price').val("");
$('#plan_days_older').val("");
$('#plan_userspacemax').val("");


$('#EditPlanModal').modal('show');	
$("#EditUserResults").html("<code> "+PleaseWait+"</code>"); 
$.get("ajax/action.php?planinfo="+id, function(data, status){
if(status=='success') {
	
$("#EditPlanResults").html(""); 	

(data.directdownload=='1') ? $('#plan_directdownload').prop('checked', true) : $('#plan_directdownload').prop('checked', false);
(data.statistics=='1') ? $('#plan_statistics').prop('checked', true) : $('#plan_statistics').prop('checked', false); 
(data.thumbnail=='1') ? $('#plan_thumbnail').prop('checked', true) : $('#plan_thumbnail').prop('checked', false);
(data.display_ads=='1') ? $('#plan_display_ads').prop('checked', true) : $('#plan_display_ads').prop('checked', false); 
(data.multiple=='1') ? $('#plan_multiple').prop('checked', true) : $('#plan_multiple').prop('checked', false); 
(data.enable_userfolder=='1') ? $('#plan_enable_userfolder').prop('checked', true) : $('#plan_enable_userfolder').prop('checked', false);
$('.settings').checkbox('update');	
(!data)? $("#BtnUpdatePlan").attr("disabled", true) : $("#BtnUpdatePlan").attr("disabled", false);

$('#plan_maxsize').val(data.maxsize.replace(/[^0-9]/g, ''));	
$('#plan_extensions').tagsinput('removeAll');
$('#plan_extensions').tagsinput('add', data.extensions);
$('#plan_text').val(data.name);
$('#plan_id').val(id);
$('#plan_Interval').val(data.Interval);	
$('#plan_maxUploads').val(data.maxUploads);	
	
$('#plan_speed').val(data.speed.replace(/[^0-9]/g, ''));

if(id!=='free' && id!=='register')	
	$('#plan_price').val(data.price);
else
	$('#plan_price').attr("disabled", true);

if(id!=='free')	
	$('#plan_userspacemax').val(data.userspacemax.replace(/[^0-9]/g, ''));
else
	$('#plan_userspacemax').attr("disabled", true);

if(id=='free')
	$('#plan_days_older').val(data.days_older);	
else
	$('#plan_days_older').attr("disabled", true);

/*$("#EditPlanModal .modal-loader").fadeOut("fast",function() {$("#editplan_form").removeClass();});*/	
	
} 
});
}		

function EditFolderInfoModal(id) 
{ 
/*$("#editfolder_form").removeClass().addClass('modal-form');
$("#EditFolderModal .modal-loader").fadeIn();*/
$('#EditFolderModal').modal('show');	
$("#BtnUpdateFolder").attr("disabled", true);
$("#EditFolderResults").html('<code>'+PleaseWait+'</code>'); 
$.get("ajax/action.php?folderinfo="+id, function(data, status){
	if(status=='success') {
		$("#EditFolderResults").html(''); 
		$('#folder_id').val(id);
		$('#folder_name').val(data._folderName);
		$('#folder_user').val(data._username);		
		$('#folder_password').val(data._password);	
		
		$('#folder_ispublic').attr('checked', data._public);
		if(!data._folderName)	
			$("#BtnUpdateFolder").attr("disabled", true);
		else
			$("#BtnUpdateFolder").attr("disabled", false);
		/*$("#EditFolderModal .modal-loader").fadeOut("fast",function() {$("#editfolder_form").removeClass();});	//$("#EditFolderModal .modal-loader").remove();*/
		$('.settings').checkbox('update');	
		
			} 
			});
}

	
	function ShowIpInfos(ip)
	{
		$('#IpInfosModal').modal('show');	
		$('#ip_ip').html('--');
		$('#ip_city').html('--');		
		$('#ip_country').html('--');	
		$('#ip_isp').html('--');	
		$('#ip_lat').html('--');	
		$('#ip_lon').html('--');	
		$("#IpInfosResults").html('<code>'+PleaseWait+'</code>'); 
		   $.get("http://ip-api.com/json/" + ip  , function(data, status) {
        if (status == 'success') 
		{
			$("#IpInfosResults").html("");
			if( data.status!=='fail')	
			{
			$('#ip_city').html(data.city);		
		    $('#ip_country').html(data.country);	
		    $('#ip_isp').html(data.isp);	
		    $('#ip_lat').html(data.lat);	
		    $('#ip_lon').html(data.lon);	
			}	
			
			$('#ip_ip').html(ip);
		   
			
		}
			
    });
	}	
	
$('#FileInfosModal').on('hide.bs.modal', function (e) { if(IsDirect) $('#player').trigger('pause');})

	
function FileInfoModal(id)
{
	$('#showfile_'+id).click();
	DisablingButton(id,rowsperpage);
}
	
	
function ShowFileInfoModal(id,cryptid,fileNum) { 
var FileInfo= $('#showfile_'+fileNum).data() ;

if (typeof(FileInfo)!=='undefined')
    FilesTotal = FileInfo["numrows"];
if (typeof(FilesTotal)==='undefined') FilesTotal = 1;

    $("#next").removeAttr('disabled');	
    $('#FileId').val(fileNum);
	$('#thumbnail').hide();
	$('#media').hide();
	$('#FileInfosModal').modal('show');	
	$('#fileInfo_filename').html('--');
	$('#fileInfo_username').html('--');		
	$('#fileInfo_date').html('--');	
	$('#fileInfo_downcount').html('--');	
	$('#fileInfo_size').html('--');	
	$('#fileInfo_delete').html('--');
	$('#fileInfo_urldownload').html('--');
	$('#fileInfo_reportcount').html('--');
	$('#fileInfo_updateurl').html('--');
	$('#fileInfo_folder').html('--');
	$('#fileInfo_ip').html('--');
	$("#FileInfosResults").html('<code>'+PleaseWait+'</code>'); 
	$.get("ajax/action.php?fileinfo="+id, function(data, status){
	if(status=='success') {
		
		$("#FileInfosResults").html("<code>"+fileNum+" / "+FilesTotal+"</code>"); 
		$('#fileInfo_username').html(data._username);		
		$('#fileInfo_date').html(data._date);	
		$('#fileInfo_downcount').html(data._download);	
		$('#fileInfo_size').html(data._size);	
		$('#fileInfo_folder').html(data._folder);
		$('#fileInfo_ip').html('<a href="javascript:void(0)" onclick="ShowIpInfos('+"'"+data._ip+"'"+')">'+data._ip+'</a>');
		$('#fileInfo_delete').html('<i class="glyphicon glyphicon-remove text-muted"></i> '+data._delete);	
		$('#fileInfo_reportcount').html(data._report);
		$('#fileInfo_updateurl').html('<i class="glyphicon glyphicon-cloud-upload text-muted"></i> <a href="javascript:void(0)" onclick="updateFile('+"'"+data._file+"'"+');" ><?php echo $lang[79] ?></a>');
		$('#fileInfo_urldownload').html('<i class="glyphicon glyphicon-download-alt text-muted"></i> <a href="../?download='+cryptid+'" target="_blank"><?php echo $lang[184] ?></a>');	
		
		if(IsDirect)
			$('#fileInfo_filename').html('<a href="'+_path_ +data._url+'"  target="_blank" >'+data._filename+'</a>');
		else
			$('#fileInfo_filename').html(data._filename);
		
		if(data._thumbnail !=='')
		{
			$('#thumbnail').show();
			$('#fileInfo_thumbnail').attr("src", _path_ + data._thumbnail);	
		}
		
		
		if(data._media && IsDirect)
		{
			
			var strSRC =  _path_ +data._url;
			$('#media').show();
			$("#player").html('<source src="'+strSRC+'"></source>');	
			$('#player').load();
		}
			
			
} 
});

}
$('#page_name').on('change', function () {
	 page_name = $('#page_name').val();
	 
	 $('#publicity_content').summernote("code","");  
	 $('#publicity_title').val("");
	 $("#PublicityResults").html("<code> "+PleaseWait+"</code>"); 
	 
	 $.get("ajax/action.php?getpublicity="+page_name, function(data, status){
		 if(status=='success')
		 {
			 $("#PublicityResults").html(""); 
			 $('#publicity_content').summernote("code",data.content);  
			 $('#publicity_title').val(data.title);
			 $('#publicity_content').summernote('enable');
			 $("#publicity_title").removeAttr('disabled');
			 
		 }
		
	});
	});

	$(document).ready(function(e){
		
	options = {
			lang:summernoteLang,
			height: 150,  
			toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table']],
			['insert', ['link']],
			['view', ['codeview']]
			]};	
		
	if(IsGetPublicity)
	{
	   $('.editor').summernote(options);
	   $("#publicity_title").attr('disabled','disabled');
	   $('#publicity_content').summernote('disable');
	}
		
	if(IsGetSettings)
	{
		
	$('.settings').checkbox('update');
	$('.editor').summernote(options);
	$('#CodeColor').colorselector({callback: function (value, color, title) {
		

		if (typeof(color)!=='undefined') {
		$("#CodeColorValue").val(color); 
		$(".ribbon.orange").css('background',color);
		$("body").append('<style>.ribbon.orange:before {border-top: 27px solid ' + color + '}.ribbon.orange:after { border-bottom: 27px solid '+ color +';}</style>');
	if(IsRtL)
	{
		$(".panel").css('border-right','3px solid '+color);
		$(".main").css('border-right','3px solid '+color);
		$(".form-control").css('border-right','3px solid '+color);
		$(".note-editor").css('border-right','3px solid '+color);
		$(".ribbon.orange").css('border-right','5px solid '+color);
		$(".navbar-header").css('border-right','3px solid '+color);
	}
	else 
	{
		$(".panel").css('border-left','3px solid '+color); 	 
		$(".main").css('border-left','3px solid '+color); 	
		$(".form-control").css('border-left','3px solid '+color);
		$(".note-editor").css('border-left','3px solid '+color);
		$(".ribbon.orange").css('border-left','5px solid '+color);
		$(".navbar-header").css('border-left','3px solid '+color);
		
	}
			 
		}}});	
		
	$('#PanelColor').colorselector({callback: function (value, color, title) {if (typeof(color)!=='undefined') {$('#confg').css('background-color', color);$("#PanelColorValue").val(color);$(".label-info").css('background-color', color);$("#btn").css('background-color', color)}}});	
	$('#BodyColor').colorselector({callback: function (value, color, title) {if (typeof(color)!=='undefined') {$("#BodyColorValue").val(color);$("body").css('background', color);}}});
	
	$('#CodeColor').colorselector('setColor', $("#CodeColorValue").val());
	$('#PanelColor').colorselector('setColor', $("#PanelColorValue").val());
	$('#BodyColor').colorselector('setColor', $("#BodyColorValue").val());
		
	
	if(IsClose)
		$('#closemsg').summernote('enable');
	else
		$('#closemsg').summernote('disable');
			
	$('#siteclose').change(function() {
    if(!this.checked)
		$('#closemsg').summernote('disable');
	else
		$('#closemsg').summernote('enable');
	});
		
	}
	
	$('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
	
});


function request(parameter,ResultsID,formID) {
	var results  = $("#"+ResultsID);
	$.ajax({
           type: "POST",
           url: 'ajax/action.php?'+parameter,
           dataType: "json",
		   data: $("#"+formID).serialize(),
          beforeSend: function() {
			  if(formID=='settings_form')
				  $("html, body").animate({ scrollTop: 0 }, "slow");
			  results.html("<div class='alert alert-info'><i class='glyphicon glyphicon-hourglass'></i> "+PleaseWait+"</div>");	
			  },
           success: function (data) {
               if(data['success_msg']) {
				
				 if(formID=='search_form')
				 {
					 //loadSidenav();
					 
					  results.html("");
					 
					  $('#SearchModal').modal('hide');
					  $('#page-selection').bootpag({page : 1,total: data.success_totalpages ,maxVisible: _maxVisible}); 
			          $("#tbody").html(data.success_msg);
					  setInterval(redirect('?files'),1000); 
					  $("#Titleheader").html('<?php echo $lang[48] ?> / <a style="font-size: 14px;" href="?clearfilter"><?php echo $lang[81] ?></a>');
					  
					  
				 } 
				  else if(formID=='settings_form')
				 {
					 //loadSidenav();					 
					  results.html("");		 
					  $('#SettingsModal').modal('hide');
					  setInterval(redirect('./'),2000); 
					  
					  
				 } 		
				 else if(formID=='edituser_form')
				 {
					results.html("");  
					$('#EditUserModal').modal('hide');
					  setInterval(redirect('?users'),1000); 
				 }
				  else if(formID=='editplan_form')
				 {
					results.html("");  
					$('#EditPlanModal').modal('hide');
					  setInterval(redirect('?plans'),1000); 
				 }
				  else if(formID=='editfolder_form')
				 {
					results.html("");  
					$('#EditFolderModal').modal('hide');
					  setInterval(redirect('?folders'),1000); 
				 }
				  else if(formID=='publicity_form')
				 {
					results.html("");
					setInterval(redirect('?publicity'),1000); 
				 }
				 
				$("#"+formID).trigger("reset");
			   } else if(data['error_msg']) {
				results.html(data.error_msg);
			   } else {
				results.html("<div class='alert alert-danger'><?php echo $lang[103] ?></div>");
			   }			   
           }
		   
    });
	
}




function confirm_request(parameter,ResultsID,formID) {
	var results  = $("#"+ResultsID);
	 bootbox.confirm({
    message: confirmMsg+" - <strong> "+Numberlbl+" : "+TotalItems()+" </strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
		if (Confirmed){   
	$.ajax({
           type: "POST",
           url: 'ajax/action.php?'+parameter,
           dataType: "json",
		   data: $("#"+formID).serialize(),
          beforeSend: function() {
			  $("#result-selection").show(); 
			  results.html("<i class='glyphicon glyphicon-hourglass'></i> "+PleaseWait+"");	
			  },
           success: function (data) {
               if(data['success_msg']) {
				
					results.html(""); 
					 HideTR = data.success_msg;
					 for (var i=0; i< HideTR.length ; i++ ) 
					   $( "#file_"+HideTR[i] ).hide();
				    $('#page-selection').bootpag({ total: data.success_totalpages ,maxVisible: _maxVisible}); 
					$("#button_1").html(deleteLabel);
					$("#button-selection").hide(); 
					$("#result-selection").hide(); 
					if(HideTR.length==rowsperpage)
						LoadTable(1);
					//$("#button_1").hide();

				$("#"+formID).trigger("reset");
			   } else if(data['error_msg']) {
				results.html(data.error_msg);
			   } else {
				results.html("<code><?php echo $lang[103] ?></code>");
			   }			   
           }
		   
    });
	
}

}
});
}	







	
function Logout(){ 
$("#LogoutResults").html("<div class='alert alert-info'><i class='glyphicon glyphicon-hourglass'></i> "+PleaseWait+"</div>");
$.get("../ajax/action.php?logout=1", function(data, status){
	 if(status=='success'){
		 $('#LogoutModal').modal('hide'); 
		  setInterval(redirect('./'),1000); 
		 } 
		 
    });
};

function deleteFile(id,deleteid,_page , title ){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+title+"</strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
		if (Confirmed){   
		$("#tbody").html('<tr><td colspan="9">'+Loading+' ...</td></tr>');
		$.get("ajax/action.php?delete="+deleteid+"&delete_file_id="+id, function(data, status){
			if(status=='success')
				{
					$('#FileInfosModal').modal('hide');	
					$('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
					LoadTable(_page); 
					return data.success_totalpages;
				}
		});
		}
       
    }
});
};



function deleteComment(id,_page,title){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+title+"</strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
   if (Confirmed)
   {   
$("#tbody").html('<tr><td colspan="8">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?delete_comment_id="+id, function(data, status){
	 if(status=='success')
	   {
		 
		 $('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
		 LoadTable(_page); 
		 return data.success_totalpages;
				}
		});
    }
       
    }
});
};

function deleteUser(id,_page,title){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+title+"</strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
   if (Confirmed)
   {   
$("#tbody").html('<tr><td colspan="8">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?delete_user_id="+id, function(data, status){
	 if(status=='success')
	   {
		 
		 $('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
		 LoadTable(_page); 
		 return data.success_totalpages;
				}
		});
    }
       
    }
});
};

function deleteReport(id,_page,title){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+title+"</strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
   if (Confirmed)
   {   
$("#tbody").html('<tr><td colspan="7">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?delete_report_id="+id, function(data, status){
	 if(status=='success')
	   {
		 
		 $('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
		 LoadTable(_page); 
		 return data.success_totalpages;
		}
		});
    }
       
    }
});
};

function deleteStat(id,_page,title){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+title+"</strong> ؟",
    buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
   if (Confirmed)
   {   
$("#tbody").html('<tr><td colspan="3">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?delete_stat_id="+id, function(data, status){
	 if(status=='success')
	   {
		 
		 $('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
		 LoadTable(_page); 
		 return data.success_totalpages;
		}
		});
    }
       
    }
});
};

function acceptReport(id,_page){ 
$('#Status_'+id).html(''+Loading+' ...'); 
 $.get("ajax/action.php?accept_report_id="+id, function(data, status){
	 if(status=='success')
	   $('#Status_'+id).html('<i class="glyphicon glyphicon-question-sign"></i>'); 	
	 });	 
};

function orderTable(orderBy,Table){ 
$("#tbody").html('<tr><td colspan="8">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?"+Table+"&order="+orderBy, function(data, status){
	 if(status=='success')
	 {
		$("#Titleheader").html('<?php TitleHeader(); ?></a>');
		LoadTable(1); 
	 }
		 
	  // $('#Status_'+id).html('<i class="glyphicon glyphicon-question-sign"></i>'); 	
	 });	 
};


function UploadOnComplete(IsError,msg )
{
	        if (typeof(IsError)==='undefined') IsError = false;
			if (typeof(msg)==='undefined') msg = '';
			
	        $('#uploadIcon').html('<i class="icon-upload-cloud uploadIcon"></i>');
            $('#dragLabel').show();
			$('#uploadLabel').show(); 
            $("#dropzone").attr('class', 'upload-drop-zone');	
			if(IsError)
				$("#msgBox").append('<div class="alert alert-info">'+msg+'</div>');
}


function updateFile(filename){ 

$("#dropzone").css('position','relative');
$("#dropzone").css('zIndex',1);
$('#UploadFileModal').modal('show');
$("#msgBox").html('');
$("#UploadModalTitle").html('<?php echo $lang[79] ?>  - <span class="text-color">'+filename+'</span>');
$("#UpdateFileName").val(filename);
if(IsIeBrowser)
{
bootbox.prompt({ size: "small",title: "-", callback: function(result){  }});
bootbox.hideAll();
}
	

var btn = document.getElementById('uploadBtn'),
      progressBar = document.getElementById('progressBar'),
      progressOuter = document.getElementById('progressOuter'),
      msgBox = document.getElementById('msgBox');
	  
  if (typeof(ss)!=='undefined')  
  var uploader = new ss.SimpleUpload({
        button: btn,
        url: 'ajax/action.php?updatefile='+filename,
		sessionProgressUrl: SiteUrl + '/includes/sessionprogress.php',
        name: 'uploadfile',
        multipart: true,
        hoverClass: 'hover',
        focusClass: 'focus',
        responseType: 'json',
        startXHR: function() {},
        dropzone: 'dropzone', // ID of element to be the drop zone
        dragClass: 'upload-drop-zone drop',
        onSubmit: function() {
			this.setData({ code : HashCode, passwordfile : $("#File_Password").val() , ispublic : $("#isPublic").prop( "checked" ) ? 1 : 0 });
			progressOuter.style.display = 'block'; // make progress bar visible
            this.setProgressBar( progressBar );
            msgBox.innerHTML = ''; // empty the message box
            $('#dragLabel').hide();
			$('#uploadLabel').hide();
		    $('#uploadIcon').html('<i class="icon-spin6 animate-spin uploadIcon"></i>');
          },
		  onProgress: function( pct )
		  {
			  /*progressBar.innerHTML =pct+'%';*/
		  },
        onComplete: function( filename, response ) {
			UploadOnComplete();
       
            progressOuter.style.display = 'none'; // hide progress bar when upload is completed
            if ( !response ) {
				 UploadOnComplete(true,'<?php echo $lang[15]?>');	
                return;
            }
            if ( response.success === true ) {
                msgBox.innerHTML = '<div class="alert alert-info" style="white-space: normal;"><strong>' + escapeTags( filename ) + '</strong>' + ' <span class="hidden-xs pull-<?php directionDiv(); ?>"><?php echo $lang[16]?>.</span></div>';
            } else {
                if ( response.msg )  {
					UploadOnComplete(true,escapeTags(response.msg));

                } else {
         
					UploadOnComplete(true,'<?php echo $lang[17]?>');
                }
            }
          },
        onError: function( filename, type, status, statusText, response, uploadBtn, size ) {
			UploadOnComplete(true,'<?php echo $lang[15]?>');
            progressOuter.style.display = 'none';
          }
	});
	

/*
 $.get("ajax/action.php?updatefile="+filename, function(data, status){
	 if(status=='success') 
	 });	*/ 
};

function deleteFolder(folder_id,folder,_page){ 
bootbox.confirm({
    message: confirmMsg+" - <strong>"+folder+"</strong> ؟",
	buttons: {confirm: {label: _Yes},cancel: {label: _No}},callback: function (Confirmed) {  
   if (Confirmed)
   {   
$("#tbody").html('<tr><td colspan="7">'+Loading+' ...</td></tr>');
 $.get("ajax/action.php?delete_folder="+folder+"&folder_id="+folder_id, function(data, status){
	 if(status=='success')
	   {
		 
		 $('#page-selection').bootpag({page : _page,total: data.success_totalpages ,maxVisible: _maxVisible}); 
		 LoadTable(_page); 
		 return data.success_totalpages;
		}
		});
  } //end if (Confirmed)
       
    } //function (Confirmed)
});
};
	



	function AjaxConfirm(title)	
{	
bootbox.confirm({
    message: title,
    buttons: {
        confirm: {
            label: _Yes
        },
        cancel: {
            label: _No
        }
    },
    callback: function (result) {
		return result
		
    }
});
}

 </script>