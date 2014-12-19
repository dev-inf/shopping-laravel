$(document).ready(function(){
    
    $('.tooltipElement').tooltip();
    
    if($("#css3aw-main-menu-containe").length > 0){
	    $("#css3aw-main-menu-container").mCustomScrollbar({
	        advanced:{
	            updateOnContentResize: true
	        },
	        scrollButtons:{
	            enable:true
	        },
	        theme:"dark-thin",
	        autoHideScrollbar: true,
	        scrollInertia: 450
	    });
	}

	tinymce.init({
		selector:'textarea',
		relative_urls: false,
		plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime code media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
	   ],
	   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
	   image_advtab: true ,
	   
	   external_filemanager_path:"/public/filemanager/filemanager/",
	   filemanager_title:"Responsive Filemanager" ,
	   external_plugins: { "filemanager" : "/public/filemanager/filemanager/plugin.min.js"}
	});

	$('.select2').select2({
		allowClear: true
	});

	$('#nickname').select2({
		tags:[],
		tokenSeparators: [","]
	});
    
    $('.datetimepicker').datetimepicker({
        pickTime: false
    });
	
	$(document).on("click", ".check-all", function(){
		var checkbox = $(this).parents("table.dataTable").find("tbody tr td:first-child").find("input[type=checkbox]");
		checkbox.prop("checked", $(this).prop("checked"));
	});

	$(document).on("click", "#filter-form .dropdown-menu label, #filter-form .dropdown-menu checkbox, #filter-form .dropdown-menu input", function(e){
		e.stopPropagation();
	});

	$(document).on("click", "#submit-filter", function(e){
		e.preventDefault();
		var oTable = $(".dataTable").dataTable();
		oTable.fnDraw();
	});
    $('#modal-default').on('hide.bs.modal', function (e) {
		var $this = $(this);
        if($("#player").length != 0){
            jwplayer("player").stop();
        }
		$this.find('.modal-title').html('');
		$this.find('.modal-body').html('');
	});
    $(document).on("click", ".modalVideo", function(e){
		e.preventDefault();
        var type = $(this).data('type');
        var id = $(this).data('id');
		$("#modal-default").modal();
        $('#modal-default').on('shown.bs.modal', function (e) {
            var $this = $(this);
            var $invoker = $(e.relatedTarget);
            $this.find(".modal-title").html('Test view '+type);
            $this.find(".modal-body").html('<div class="divLoading"></div>');
            $.ajax({
                url: base_url + "/admin/"+type+"/watch-"+type,
                data: 'id='+id,
                type: 'post',
                success: function(rs){
                    rs = JSON.parse(rs);
                    var subtitle = Array();
                    if(typeof rs.subtitle !== 'undefined'){
                        $.each(rs.subtitle, function(i,v){
                            subtitle.push({
                                file: 'http://116.118.112.25:8080/'+v['subtitle_file'],
                                label: v['language'],
                                kind: "captions",
                                "default": v['default'] 
                            });
                        });
                    }
                    var banner = '';
                    if(typeof rs.subtitle !== 'undefined'){
                        banner = rs.banner;
                    }
                    $this.find(".modal-title").html('Test view "'+rs.title+'"');
                    $this.find(".modal-body").html('<div id="player" class="jwplayer">File '+type+' bị lỗi hoặc không tồn tại</div>');
                    jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ==";
                    
                    jwplayer("player").setup({
                        volume: "100",
                        menu: "true",
                        aspectratio: "16:9",
                        allowscriptaccess: "always",
                        wmode: "opaque",
                        width: "100%",
                        skin: "six",
                        file: rs.file,
                        tracks: subtitle,
                        image: banner,
                        logo: {
                            file: base_url + "/public/images/logo.png",
                            link: "/"
                        },
                        primary: 'html5'
                    });
                }
            });
        });
	});

});
function createTable(id){
	var table = $("#" + id);
	var bFilter = table.data("bfilter") || false;
	var pageLength = table.data("pagelength") || 10;
	var pagingType = table.data("pagingtype") || "full_numbers";
	var processing = table.data("processing") || true;
	var serverSide = table.data("serverside") || true;
	var aoColumns = new Array();
	var fn;
	var disableSort = [0];
	var sort_columns = new Array();
	var createdRow = new Array();
	var extend_url = table.data("extend-url") || "";
	var method = table.data("method") || "show";
	method = "/" + method;
	$(table).find("th").each(function(index, value){
		tmp_object = {};
		if($(this).data("data") != undefined && $(this).data("data") != ""){
			tmp_object.data = $(this).data("data");
		}
		if($(this).data("swidth") != undefined && $(this).data("swidth") != ""){
			tmp_object.sWidth = $(this).data("swidth");
		}
		if($(this).data("sclass") != undefined && $(this).data("sclass") != ""){
			tmp_object.sClass = $(this).data("sclass");
		}
		if($(this).data("render") != undefined && $(this).data("render") != ""){
			tmp_object.sDefaultContent = "";
			fn = window[$(this).data("render")];
			tmp_object.render = fn;
		}
		aoColumns.push(tmp_object);


		if($(this).data("enable-sort") == undefined || $(this).data("enable-sort") != false){
			tmp_object.orderable = true;
		}else{
			tmp_object.orderable = false;
		}
		

		if($(this).data("created-row") != undefined && $(this).data("created-row") != ""){
			$created_tmp = {
					data: $(this).data('created-row-col'),
					sclass : $(this).data('created-row'),
					condition : $(this).data('created-row-condition')
				};
			createdRow.push($created_tmp);

		}

		sort_columns[index] = $(this).data("sort-column") || "o." + $(this).data('data');

	});
	
	if(id.indexOf('film') != -1){
	    methodParam = id.replace('film','');
        if(methodParam == 'Movie' || methodParam == 'Drama'){
            method = method + '-' + methodParam.toLowerCase();
            id = id.replace(methodParam,'');
        }
	}

	// var oTable = table.dataTable();return oTable;
	var oTable = table.dataTable({
    "bFilter": bFilter,                
    "aaSorting": [[ 1, "desc" ]],                       
    "pageLength": pageLength,
    "pagingType": pagingType,
    "processing": processing,
    "serverSide": serverSide,
    "ajax": {
    	url: base_url + "/admin/" + id + method + extend_url,
    	data: function(d){
    		// var data = getFormData($("#filter-form"));
    		var data = $("#filter-form").serializeArray();
    		$.each(data, function(key, value){
    			d[value.name] = value.value;
    		});
    		// console.log(data);
    		// console.log("id", data.filter_id);
    		// // console.log(getFormData($("form#filter-form")));
    		// d.filter = data.filter_id;
    		// // d.filter = $("form#filter-form").serializeArray();
    		// // d = $.merge(d, $("form#filter-form").serializeArray());
    	},
    	async: false,
    },
    "columns": aoColumns,

    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
      // excute before row render;
	    	for(var $i=0; $i < createdRow.length; $i++)
  		{
    		if(aData[createdRow[$i].mdata] == createdRow[$i].condition)
    			{
	    			$(nRow).addClass(createdRow[$i].sclass);
    			}
  		}
    },
    // "fnDrawCallback": function( nRow, aData, iDataIndex ) {
    //     // excute before row render and every time when we change state(load dynamic data)
 	 //        $('.selectpicker').selectpicker();
 	 //        $('input[name^="verified"]').bootstrapSwitch({
   //         		  'onColor' : 'success',
 		//           		  'offColor' : 'danger',
 		//           		  'onSwitchChange' : function(event, state){
 		//            			  switchFunction(event, state);
 		// 	          		  }
 		//             });

	  //   },
    // "fnInitComplete": function( nRow, aData, iDataIndex ) {
    //     // excute after row render and just the first time table init completed
 	 //        $('.selectpicker').selectpicker();
 	 //        $('input[name^="verified"]').bootstrapSwitch({
   //         		  'onColor' : 'success',
 		//           		  'offColor' : 'danger',
 		//           		  'onSwitchChange' : function(event, state){
 		//            			 switchFunction(event, state);
 		// 	         		  }
 		//             });
 	 //    },
    "fnServerParams": function ( aoData ) {

    	// aoData.push({name: "sort_columns", value: sort_columns});
     //  var $data = $("form#filter-form").serializeArray();
     //  aoData = $.merge(aoData, $data);
    }       
 	});
	return oTable;
}
function renderStatus(data, type, row, meta){
    var status_off = row.status==0?"active":"";
	var status_on = row.status==1?"active":"";

	var controls = '<div class="btn-group change-status" data-table="' + meta.settings.sTableId + '" data-toggle="buttons">';

	controls+= '<label class="btn btn-default status btn-sm '+status_off+'">';      
	controls+='<input type="radio" value="0_'+row.id+'" name="status"><i class="glyphicon glyphicon-off"></i>';
	controls+='</label>';

	controls+= '<label class="btn btn-default status btn-sm '+status_on+'">';       
	controls+='<input type="radio" value="1_'+row.id+'" name="status"><i class="glyphicon glyphicon-ok"></i>';
	controls+='</label>';

	controls+='</div>';
	return controls;
}
function renderSetting(data, type, row, meta){
	var controls = '<div class="btn-group">';
	controls += '<a type="button" title="edit" href="' + base_url + "/admin/" + meta.settings.sTableId + '/modify/'+row.id+'" class="btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></a>';
	controls += '<button type="button" title="delete" data-id="'+row.id+'" data-title="'+row.title+'" data-table="' + meta.settings.sTableId + '" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-remove"></span></button>';
	controls += '</div>';
	return controls;
}
function renderFirstColumn(data, type, row, meta){
	return '<input type="checkbox" class="record" value="'+row.id+'">';
}

function renderParams(data, type, row, meta){
    var result = '<span class="glyphicon '; 
    if(data == 0){
        result += 'glyphicon-remove text-danger';
    }else{
        result += 'glyphicon-ok text-success';
    }
    result += '"></span>';
    return result;
}

function renderModalVideo(data, type, row, meta){
    var result = '';
    if(data){
        var arrData = data.split('|');
        // [0] id
        // [1] status
        // [2] type
        if(arrData[1] == 1){
            result = '<a href="javascript:void(0)" class="btn btn-danger modalVideo" data-id="'+arrData[0]+'" data-type="'+arrData[2]+'">View</a>';
        }
    }
    
    return result;
}

function changeStatus(e, url){
	var $this = $(e.currentTarget);
	var data = {};
	var status_id = $this.find("input:radio").val();
	var table = $this.parents("div.change-status").data("table");
	var url = url || base_url + "/admin/" + table + "/change-status";
	status_id = status_id.split("_");
	data.status = status_id[0];
	data.id = status_id[1];
	data.table = table;
	$.ajax({
		url: url,
		async: false,
		data: data,
		type: 'get',
		statusCode: {
			302: function(resp){
				bootbox.alert(resp.responseJSON.message);
			}
		},
		success: function(rs){
			rs = JSON.parse(rs);
			if(rs.status == "00"){

			}else{
				alert("Error " + rs.status + ": " +rs.message);
			}
			var oTable = $("#" + table).dataTable();
			oTable.fnStandingRedraw();
		}
	});
}

function deleteRecord(e, dataUrl){
	bootbox.confirm('Are you sure?', function(ok){
		if(ok){
			var $this = $(e.currentTarget);
			var data = new Array();
			var table = $this.data("table");
            console.log(table);
      var controller = '';
      if(table.indexOf('film') != -1 && (table != 'filmEp')){
          controller = 'film';
      }else{
          controller = table;
      }
      var ajax_url = dataUrl || base_url + "/admin/" + controller + "/delete";
			var ids = new Array();
			if($this.data("type") == "multi"){
				$("input.record:checked").each(function(){
					ids.push($(this).val());
				});
			}else{
				ids.push($this.data('id'));
			}

			data = {
				table: table,
				ids: ids
			};

			$.ajax({
				url: ajax_url,
				type: 'get',
				data: data,
				async: false,
				statusCode: {
					302: function(resp){
						bootbox.alert(resp.responseJSON.message);
					}
				},
				success: function(rs){
					rs = JSON.parse(rs);
					if(rs.status == "00"){

					}else{
						alert("Error " + rs.status + ": " +rs.message);
					}
					if(table == 'resources' || table == 'roles'){
						table = 'permissions';
					}
					var oTable = $("#" + table).dataTable();
					oTable.fnDraw(false);
				}
			});
		}
	});

}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function showAlert($type, $message){
	var $title = '';
	switch ($type) {
	    case 'success': $title = 'Successful!';
	    case 'info': $title = 'Information!';
	    case 'warning': $title = 'Warning!';
	    case 'danger': $title = 'Danger!';
	    default: $title = 'Yep!';
	}
	var $html = '<div class="alert alert-'+$type+'"><strong>'+$title+'</strong> '+$message+'</div>';
	return $html;
}