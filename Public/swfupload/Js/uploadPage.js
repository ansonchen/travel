alert($J('#fsUploadProgress1').data('path')+','+$J('#fsUploadProgress1').data('aid')+','+$J('#fsUploadProgress1').data('pid'))
$J(window).load(function(){
	upload1 = new SWFUpload({
		// Backend Settings
		upload_url: "__URL__/upload/path/"+$J('#fsUploadProgress1').data('path')+"/id/"+$J('#fsUploadProgress1').data('aid'),
		//file_post_name : "Filedata",
		post_params: {
						"PHPSESSID" : $J('#fsUploadProgress1').data('pid'),
						"path":$J('#fsUploadProgress1').data('path'),
						"aid":$J('#fsUploadProgress1').data('aid')
						},
		// File Upload Settings
		file_size_limit : "1024mb",	// 100MB 
		file_types : "*.*",// 
		file_types_description : "所有文件",
		file_upload_limit : 10,
		file_queue_limit : 0,

		// Event Handler Settings (all my handlers are in the Handler.js file)
		swfupload_preload_handler : preLoad,
		swfupload_load_failed_handler : loadFailed,
		file_dialog_start_handler : fileDialogStart,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "__PUBLIC__/swfupload/Image/XPButtonUploadTextCn_61x22.png",
		button_placeholder_id : "spanButtonPlaceholder1",
		button_width: 63,
		button_height: 22,
		
		// Flash Settings
		flash_url : "__PUBLIC__/swfupload/Flash/swfupload.swf",
		flash9_url : "__PUBLIC__/swfupload/Flash/swfupload_fp9.swf",
	

		custom_settings : {
			progressTarget : "fsUploadProgress1",
			cancelButtonId : "btnCancel1"
		},
		
		// Debug Settings
		debug: false
	});

 })