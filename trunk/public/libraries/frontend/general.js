$(function() {
	$.fn.waitUntilExists    = function (handler, shouldRunHandlerOnce, isChild) {
		var found       = 'found';
		var $this       = $(this.selector);
		var $elements   = $this.not(function () { return $(this).data(found); }).each(handler).data(found, true);

		if (!isChild)
		{
			(window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
				window.setInterval(function () { $this.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 100)
			;
		}
		else if (shouldRunHandlerOnce && $elements.length)
		{
			window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
		}

		return $this;
	}
	
	/* Swipe Menu */
	var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		menuRight = document.getElementById( 'cbp-spmenu-s2' ),
		showLeft = document.getElementById( 'showLeft' ),
		showRight = document.getElementById( 'showRight' ),
		body = document.body;
	if(showLeft){
		showLeft.onclick = function() {
			classie.toggle( this, 'active' );
			var defineWidth = findBootstrapEnvironment();
			if(defineWidth == 'xs' || defineWidth == 'sm'){
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				classie.removeClass( menuRight, 'cbp-spmenu-open' );
				if(classie.hasClass( body, 'cbp-spmenu-push-toright' )){
					if(classie.hasClass( body, 'cbp-spmenu-push-toleft' )){
						classie.remove( body, 'cbp-spmenu-push-toleft' );
					}
				}
			}else{
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
			}
		};
	}
	
	if(showRight){
		showRight.onclick = function() {
			classie.toggle( this, 'active' );
			var defineWidth = findBootstrapEnvironment();
			if(defineWidth == 'xs' || defineWidth == 'sm'){
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				classie.removeClass( menuLeft, 'cbp-spmenu-open' );
				classie.toggle( body, 'cbp-spmenu-push-toleft' );
				if(classie.hasClass( body, 'cbp-spmenu-push-toleft' )){
					if(classie.hasClass( body, 'cbp-spmenu-push-toright' )){
						classie.remove( body, 'cbp-spmenu-push-toright' );
					}
				}
			}else{
				classie.toggle( menuRight, 'cbp-spmenu-open' );
			}
		};
		
		/* Portfolio */
		$('#posterList').mixItUp({
			callbacks: {
				onMixEnd: function(state){
					var dataFilter = state.activeFilter;
					var dataSort = state.activeSort;
					if(dataFilter == ".mix"){
						dataFilter = "all";
					}
					var stringShowFilter = $(".filter[data-filter='"+dataFilter+"']").html().toUpperCase();
					stringShowFilter = stringShowFilter.replace(/(<([^>]+)>)/ig,"");
					var dataStringShowFilter = stringShowFilter.split(' ');
					var totalFilm = dataStringShowFilter[0];
					dataStringShowFilter.splice(0,1);
					stringShowFilter = dataStringShowFilter.join(' ');
					$("#showFilter").html("\"<i>"+$.trim(stringShowFilter)+" ("+totalFilm+" phim)</i>\"");
					
					if(dataSort == "default:asc"){
						$("#showSort").html("");
					}else{
						var stringShowSort = $(".sort[data-sort='"+dataSort+"']").html().toUpperCase();
						stringShowSort = stringShowSort.replace(/(<([^>]+)>)/ig,"");
						$("#showSort").html(" <i>\""+$.trim(stringShowSort)+"</i>\"");
					}
				}   
			}
		});
	}
	
	/* Menu */
	var menu_ul = $('.menu > li > ul'),
		   menu_a  = $('.menu > li > a');
	menu_ul.hide();
	menu_a.click(function(e) {
		e.preventDefault();
		if(!$(this).hasClass('active')) {
			menu_a.removeClass('active');
			menu_ul.filter(':visible').slideUp('normal');
			$(this).addClass('active').next().stop(true,true).slideDown('normal');
		} else {
			$(this).removeClass('active');
			$(this).next().stop(true,true).slideUp('normal');
		}
	});
	
	/* Video */
	var mediaBody = $('.media-body').html();
	var addMoreInfo = '<div class="infoFilm">' + mediaBody + '</div>';
	$('.mejs-poster').append(addMoreInfo).show();
	
	/* Readmore */
	$('#desFilm').readmore();
	
	/* Turn On/Off Light */
	$('.wrapper').allofthelights({
		'callback_turn_off': function() {
			$('#player').css("z-index","999");
		}
	});
	
	/* Scroll Fixed */
	$('.fb-like').scrollToFixed({ marginTop: 50});
	
	/* Slider */
	$("#owl-slider").owlCarousel({
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		lazyLoad : true
	});
	
	/* Lazy Load Image */
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});
	
	/* Modal */
	$('#myModalTrailer').on('show.bs.modal', function (e) {
		var $this = $(this);
		var $invoker = $(e.relatedTarget);
		var code = $invoker[0].id;
		var title = $invoker[0].dataset.title;
		var href = $invoker[0].baseURI;
		var body = '<div class="row">' +
		'<div id="video"></div>' +
		'<div class="fb-like" data-href="' + href + '" data-layout="standard" data-action="like" data-show-faces="true" data-share="true" style="margin-left: 20px;"></div>' +
		'<div class="fb-comments" data-href="' + href + '" data-numposts="5" data-colorscheme="light" data-width="900"></div>' +
		'</div>';
		$this.find('#myModalLabel').html(title);
		$this.find('.modal-body').html(body);
		
		if(typeof FB != "undefined"){
			FB.XFBML.parse();
		}
		jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ==";
		jwplayer("video").setup({
			volume: "100",
			menu: "true",
			aspectratio: '16:9',
			allowscriptaccess: "always",
			wmode: "opaque",
			width: '100%',
			skin: 'six',
			file: 'https://www.youtube.com/watch?v=' + code,
			logo: {
				file: base_url + "/public/images/logo.png",
				link: '/',
			}
		});
	});
	
	$('#myModal').on('hide.bs.modal', function (e) {
		var $this = $(this);
		$this.find('#myModalLabel').html('');
		$this.find('.modal-body').html('');
		setHistoryPush();
	});
	
	/* Notification */
	var dataNotification = [];
	dataNotification.push({
		type : 'success', 
		icon : 'glyphicon-gift',
		event : 'Happy Birthday',
		text : 'Hôm nay là sinh nhật của đạo diễn',
		mainText: 'Shane Black',
		link : 'cast.html'
	});
	dataNotification.push({
		type : 'success', 
		icon : 'glyphicon-heart',
		event : 'Sự Kiện',
		text : 'Ngày 01/01/2014 có chương trình khuyến mãi',
		mainText: 'Coi phim nhận quà',
		link : '#'
	});
	
	var timeDelay = 1000;
	$.each(dataNotification, function( index, value ) {
		setTimeout(function() {
			$.bootstrapGrowl('<strong><span class="glyphicon '+value.icon+'"></span> '+value.event+'!</strong> '+value.text+' \"<a href="'+value.link+'" class="alert-link">'+value.mainText+'</a>\"', {
				ele: 'body', // which element to append to
				type: value.type, // (null, 'info', 'error', 'success')
				offset: {from: 'top', amount: 55}, // 'top', or 'bottom'
				align: 'right', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				delay: 0, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 10 // spacing between consecutively stacked growls.
			});
		}, timeDelay);
		timeDelay += 2000;
	});
	
	/* Push More */
	$(".pushMore").click(function(){
		var $this = $(this);
		var $badgeAccess = $this.parent().find('.badgeAccess');
		var $keyAccess = $badgeAccess.attr('data-access');
		if($keyAccess == 1){
			var $textBadge = $badgeAccess.html();
			var arrText = $textBadge.split(' ');
			var currentNum = parseFloat(arrText[0].replace(",", ""));
			$badgeAccess.html($.number( ++currentNum, ',' )+' '+arrText[1]);
			$badgeAccess.attr('data-access',0);
			$this.parent().find('.help-block').html('<i class="glyphicon glyphicon-info-sign"></i> Đã yêu cầu!');
		}
		return false;
	});
	
	/* Date Picker */
	$('#inputDateShow, #inputDateShowFrom, #inputDateShowTo').datetimepicker({
		pickTime: false
	});
	
	/* Select2 */
	$(".selectFilter").select2({
		closeOnSelect:false
	});
	$("#inputQuickSearch").select2({
		cacheDataSource: [],
		placeholder: 'Tìm kiếm nhanh',
		minimumInputLength: 3,
		query: function(query) {
            self = this;
            var key = query.term;
            var cachedData = self.cacheDataSource[key];

            if(cachedData) {
                query.callback({results: cachedData.result});
                return;
            } else {
                $.ajax({
					url: 'php/listQuickMovie.php',
					data: { q : query.term },
					dataType: 'jsonp',
					jsonp: 'callback',
					type: 'GET',
					success: function(data) {
						self.cacheDataSource[key] = data;
						query.callback({results: data.result});
					}
                })
            }
        },
		formatResult: formatResultQuick,
		formatSelection: formatSelection,
		escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
	}).on("select2-open", function() {
		if (!$('.addedDiv',$('#select2-drop')).is('*')){
			$('#select2-drop').waitUntilExists(function(){$('#select2-drop').append('<div class="addedDiv text-right"><a href="pro_search.html" class="btn btn-primary">Tìm kiếm nâng cao</a></div>')});
			$('.addedDiv').click(function(){
				var addressValue = $(this).find('a').attr("href");
				window.location = addressValue;
			});
		}
    }).on("select2-selecting", function(e) {
		window.location = e.object.link;
	});
    
//    if($("#player").length !== 0){
//        var playerElement = $('.dataPlayer');
//        var id = playerElement.data('id');
//        var link = playerElement.data('link');
//        var banner = playerElement.data('banner');
//        $.ajax({
//            url: base_url + "/film/get-subtitle-film",
//            data: 'id='+id,
//            type: 'post',
//            success: function(rs){
//                rs = JSON.parse(rs);
//                var subtitle = Array();
//                if(typeof rs.subtitle !== 'undefined'){
//                    $.each(rs.subtitle, function(i,v){
//                        subtitle.push({
//                            file: 'http://116.118.112.25:8080/'+v['subtitle_file'],
//                            label: v['language'],
//                            kind: "captions",
//                            "default": v['default'] 
//                        });
//                    });
//                }
//
//                jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ==";
//                jwplayer("player").setup({
//                    volume: "100",
//                    menu: "true",
//                    aspectratio: '16:9',
//                    allowscriptaccess: "always",
//                    wmode: "opaque",
//                    width: '100%',
//                    skin: base_url + "/public/scripts/plugins/jwplayer/skins/six.xml",
//                    back: "false",
//                    image: banner,
//                    file: link,
//                    tracks: subtitle,
//                    logo: {
//                        file: base_url + "/public/images/logo.png",
//                        link: '/'
//                    },
//                    primary: 'html5',
//                    advertising: {
//                        client: "vast",
//                        'skipoffset':5, 
//                        tag: "http://ad3.liverail.com/?LR_PUBLISHER_ID=1331&LR_CAMPAIGN_ID=229&LR_SCHEMA=vast2"
//                    }
//                });
//            }
//        });
//    }

	if($(".login").length != 0){
		$(".login").on("click", function(e){
			e.preventDefault();
			var email = $("#email").val();
			var password = $("#password").val();
			$.ajax({
				url: base_url + "/auth/customer/login",
				type: 'post',
				data: {
					email: email,
					password: password
				},
				async: false,
				statusCode: {
					400: function(obj){
						resp = obj.responseJSON;
						$("#login .error").html(resp.message);
					}
				},
				success: function(rs){
					rs = JSON.parse(rs);
					if(rs.success){
						$("#login").remove();
					}
				}
			});
			// e.stopPropagation();
		});
	}
});

function setHistoryPush() {
	window.history.pushState(null, null, './');
}

function initialize() {
	if(document.getElementById("map_canvas") !== null){
		var latlng = new google.maps.LatLng(45.738028,21.224535);
		var settings = {
			zoom: 15,
			center: latlng,
			mapTypeControl: false,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: false,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("map_canvas"), settings);
		var contentString = '<div id="content">'+
			'<div id="siteNotice">'+
			'</div>'+
			'<h2 id="firstHeading" class="firstHeading">Hà Phan Minh</h2>'+
			'<div id="bodyContent">'+
			'<p>This is a pop up. You can put here your text.</p>'+
			'</div>'+
			'</div>';
		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		
		var companyImage = new google.maps.MarkerImage('images/marker.png',
			new google.maps.Size(70,85),<!-- Width and height of the marker -->
			new google.maps.Point(0,0),
			new google.maps.Point(35,50)<!-- Position of the marker -->
		);

		var companyShadow = new google.maps.MarkerImage('images/marker-shadow.png',
			new google.maps.Size(108,56),<!-- Width and height of the shadow marker -->
			new google.maps.Point(0,0),
			new google.maps.Point(30, 20));<!-- Position of the shadow marker -->

		var companyPos = new google.maps.LatLng(45.738028,21.224535);

		var companyMarker = new google.maps.Marker({
			position: companyPos,
			map: map,
			icon: companyImage,
			shadow: companyShadow,
			title:"2012 Media",
			zIndex: 3});	
		
		google.maps.event.addListener(companyMarker, 'click', function() {
			infowindow.open(map,companyMarker);
		});
	}
}

function findBootstrapEnvironment() {
	var envs = ['xs', 'sm', 'md', 'lg'];

	$el = $('<div>');
	$el.appendTo($('body'));

	for (var i = envs.length - 1; i >= 0; i--) {
		var env = envs[i];

		$el.addClass('hidden-'+env);
		if ($el.is(':hidden')) {
			$el.remove();
			return env
		}
	};
}

function formatResult(item) {
	$html = '<div class="media">'+
		'<a class="pull-left" href="'+item.link+'"><img class="media-object" src="'+item.img+'" alt="..." width="100"></a>'+
		'<div class="media-body">'+
			'<h4 class="media-heading"><a href="'+item.link+'">'+item.title+'</a></h4>'+
			'<p><b>Nhà sản xuất:</b>'+createLink(item.directorName, item.directorLink)+
			'<p><b>Ngày công chiếu:</b> '+item.releaseDate+'</p>'+
			'<p><b>Điểm IMDB:</b> '+item.IMDBPoint+'</p>'+
			'<p><b>Đạo diễn:</b>'+createLink(item.directorName, item.directorLink)+
			'<p><b>Diễn viên:</b>'+createLink(item.castName, item.castLink)+
		'</div>'+
	'</div>';
	return $html;
}

function formatResultQuick(item) {
	if(item.text) {
		// return `text` for optgroup
		return item.text;
	}
	$html = '<div class="media">'+
		'<a class="pull-left" href="'+item.link+'"><img class="media-object" src="'+item.img+'" alt="..." width="100"></a>'+
		'<div class="media-body">'+
			'<h4 class="media-heading"><a href="'+item.link+'">'+item.title+'</a></h4>'+item.info+
		'</div>'+
	'</div>';
	return $html;
}

function formatSelection(item) {
	return '<b>' + item.title + '</b>';
}

function createLink($itemName, $itemLink){
	var arrName = $itemName.split(",");
	var arrLink = $itemLink.split(",");
	var countArr = arrName.length;
	var i = 1;
	var separate = '';
	var $html = '';
	$.each(arrName, function(index, value){
		if(i < countArr){
			separate = ',';
		} else {
			separate = '</p>';
		}
		$html += ' <a href="'+arrLink[index]+'">'+value+'</a>'+separate;
		i++;
	});
	return $html;
}