/*
 * Author: Hà Phan Minh
 * Created: 2014-06-10
 * Description: View Movie
 */
define([
    'jquery',
    'underscore',
    'backbone',
    //'text!templates/form/form_add_admin.html'
    ], function($, _, Backbone,loginTemplate){
        // var $html_loadding = '<div class="caculation-report"><img style="margin-left:170px" src="'+$template_admincp_url+'img/standard/loaders/loading64.gif"/></div>';
        var view = Backbone.View.extend({
            el: $("#wrapper"),
            initialize: function(){

            },
            events: {
                "click .remove": "removeRecord",
                "click .choose-image": "openBrowseLinkModal",
                "click .export":  "doExport",
                "click .change-property": "changeProperty"
            },
            
            removeRecord: function(e){
                deleteRecord(e);
            },

            openBrowseLinkModal: function(e){
                var $this = $(e.currentTarget);
                var type = $this.data("type");
                var src = $(".file-modal").data("sample-url");
                src = src.replace("<<id>>", type);
                $(".file-modal iframe").attr("src", src);
                $(".file-modal").modal();
            },

            changeProperty: function(e){
                var $this = $(e.currentTarget);
                var id = $this.data("id");
                var type = $this.data("type");
                var value = $this.find("input[type='checkbox']").prop("checked") ? 0 : 1;
                $.ajax({
                    url: base_url + "/admin/film/update-film",
                    data: {
                        id: id,
                        type: type,
                        value: value
                    },
                    type: 'post',
                    async: false,
                    statusCode: {
                        302: function(resp){
                            bootbox.alert(resp.responseJSON.message);
                        }
                    },
                    success: function(rs){

                    }
                });
                console.log(value);
            },
            
            getShowMovie: function(){
                createTable("filmMovie");
            },

            getShowDrama: function(){
                createTable("filmDrama");
            },

            getModify: function(){   
                view.modify();
            },
            
            postModify: function(){
                view.modify();				
            },
            
            doExport: function(e){
                e.preventDefault();
                $this = $(e.currentTarget);
                var ids = $this.attr('ids');
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/film/export');
                form.attr("method", 'post');
                var input = $("<input>").attr("type", "hidden").attr("name", "sectionFilm").val(ids);
                form.append($(input));
                form.submit();
            },
            
            modify: function()
            {
                $(".file-modal").on("hide.bs.modal", function(){
                    if($("#banner").val() != ''){
                        $("#banner-img").attr("src", $("#banner").val());
                    }
                    if($("#poster").val() != ''){
                        $("#poster-img").attr("src", $("#poster").val());
                    }
                });
                $("#tags").select2({
                    tags: true,
                    tokenSeparators: [","],
                    minimumInputLength: 3,
                    multiple: true,
                    createSearchChoice: function(term, data) {
                        if ($(data).filter(function() {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                            return {
                                id: term,
                                text: term
                            };
                         }
                    },
                    initSelection: function(element, callback) {
                        var arrDataElement = $(element).val().split(',');
                        var dataCallback = Array();
                        $.each(arrDataElement, function(key, value){
                            dataCallback.push({id: value, text: value });
                        })
                        callback(dataCallback);
                    },
                    ajax: {
                        url: base_url + "/admin/tags/get-all-tags",
                        dataType: 'json',
                        quietMillis: 100,
                        data: function (term, page) {
                            return {
                                q: term //search term
                            };
                        },
                        results: function (data, page) {
                            return {results: data, more: false};
                        }
                    }
                });
                var arrPosition = [];
                arrPosition.push({
                        cata_id: 1,
                        id:'producer'
                    },{
                        cata_id: 2,
                        id: 'director'
                    },{
                        cata_id: 3,
                        id: 'cast'
                    });
                $.each(arrPosition, function(index, value){
                    $("#"+value.id).select2({
                        tags: true,
                        tokenSeparators: [","],
                        minimumInputLength: 3,
                        multiple: true,
                        createSearchChoice: function(term, data) {
                            if ($(data).filter(function() {
                                return this.text.localeCompare(term) === 0;
                            }).length === 0) {
                                return {
                                    id: term,
                                    text: term
                                };
                             }
                        },
                        initSelection: function(element, callback) {
                            var arrDataElement = $(element).val().split(',');
                            var dataCallback = Array();
                            $.each(arrDataElement, function(key, value){
                                dataCallback.push({id: value, text: value });
                            })
                            callback(dataCallback);
                        },
                        ajax: {
                            url: base_url + "/admin/position/get-all-position?cata_id="+value.cata_id,
                            dataType: 'json',
                            quietMillis: 100,
                            data: function (term, page) {
                                return {
                                    q: term //search term
                                };
                            },
                            results: function (data, page) {
                                return {results: data, more: false};
                            }
                        }
                    });
                });
                var en_title = $('#en_title');
                var release_date = $('#release_date');
                var imdb_rating = $('#imdb_rating');
                var imdb_vote = $('#imdb_vote');
                var imdb_link = $('#imdb_link');
                var producer = $('#producer');
                var director = $('#director');
                var cast = $('#cast');
                var idIMDB = $('#idIMDB');
                $("#getDetailImdb").click(function(){
                    var dataIdIMDB = idIMDB.val();
                    $("#modal-default").modal();
                    $('#modal-default').on('shown.bs.modal', function (e) {
                        if(dataIdIMDB.length == 0){
                            $(".modal-title").html('Search Detail Film');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + "/admin/film/search-data-movie",
                                data: $("#formFilm").serialize(),
                                type: 'post',
                                success: function(rs){
                                    rs = JSON.parse(rs);
                                    var $html = '<table class="table table-hover">'+
                                        '<thead>'+
                                            '<tr>'+
                                              '<th>#</th>'+
                                              '<th>Title</th>'+
                                              '<th>Year</th>'+
                                              '<th>Catalogue</th>'+
                                              '<th></th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>';
                                    var i = 1;
                                    if(rs){
                                        $.each(rs, function(key, value){
                                            $html += '<tr>'+
                                                '<td>'+i+'</td>'+
                                                '<td>'+value['title']+'</td>'+
                                                '<td>'+value['year']+'</td>'+
                                                '<td>'+value['catalogue']+'</td>'+
                                                '<td><input type="radio" name="idImdb" value="'+value['id']+'" class="getDetailFilm"/></td>'+
                                            '</tr>';
                                            i++;
                                        });
                                    }else{
                                        $html += '<tr>'+
                                                '<td colspan="5">Not data</td>'+
                                            '</tr>';
                                    }
                                    $html += '</tbody>'+
                                    '</table>';
                                    $(".modal-body").html($html);
                                    $('.getDetailFilm').click(function(){
                                        var idM = $(this).val();
                                        $(".modal-title").html('Get Detail Information');
                                        $(".modal-body").html('<div class="divLoading"></div>');
                                        $.ajax({
                                            url: base_url + "/admin/film/get-detail-film",
                                            data: 'id='+idM,
                                            type: 'post',
                                            success: function(rs){
                                                rs = JSON.parse(rs);
                                                if(typeof rs['title'] !== "undefined"){
                                                    en_title.val(rs['title']);
                                                }
                                                if(typeof rs['year'] !== "undefined"){
                                                    release_date.val(rs['year']);
                                                }
                                                if(typeof rs['rating'] !== "undefined"){
                                                    imdb_rating.val(rs['rating']);
                                                }
                                                if(typeof rs['votes'] !== "undefined"){
                                                    imdb_vote.val(rs['votes']);
                                                }
                                                if(typeof rs['imdb_link'] !== "undefined"){
                                                    imdb_link.val(rs['imdb_link']);
                                                }
                                                if(typeof rs['imdb_id'] !== "undefined"){
                                                    idIMDB.val(rs['imdb_id']);
                                                }
                                                if(typeof rs['producer'] !== "undefined"){
                                                    var arrProducer = Array();
                                                    $.each(rs['producer'], function(key, value){
                                                        arrProducer.push(value.name);
                                                    });
                                                    producer.select2('val', arrProducer);
                                                }
                                                if(typeof rs['director'] !== "undefined"){
                                                    var arrDirector = Array();
                                                    $.each(rs['director'], function(key, value){
                                                        arrDirector.push(value.name);
                                                    });
                                                    director.select2('val', arrDirector);
                                                }
                                                if(typeof rs['cast'] !== "undefined"){
                                                    var arrCast = Array();
                                                    $.each(rs['cast'], function(key, value){
                                                        arrCast.push(value.name);
                                                    });
                                                    cast.select2('val', arrCast);
                                                }
                                                $("#modal-default").modal('hide');
                                            }
                                        });
                                    });
                                }
                            });
                        }else{
                            $(".modal-title").html('Get Detail Information');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + "/admin/film/get-detail-film",
                                data: 'id='+dataIdIMDB,
                                type: 'post',
                                success: function(rs){
                                    rs = JSON.parse(rs);
                                    if(typeof rs['title'] !== "undefined"){
                                        en_title.val(rs['title']);
                                    }
                                    if(typeof rs['year'] !== "undefined"){
                                        release_date.val(rs['year']);
                                    }
                                    if(typeof rs['rating'] !== "undefined"){
                                        imdb_rating.val(rs['rating']);
                                    }
                                    if(typeof rs['votes'] !== "undefined"){
                                        imdb_vote.val(rs['votes']);
                                    }
                                    if(typeof rs['imdb_link'] !== "undefined"){
                                        imdb_link.val(rs['imdb_link']);
                                    }
                                    if(typeof rs['imdb_id'] !== "undefined"){
                                        idIMDB.val(rs['imdb_id']);
                                    }
                                    if(typeof rs['producer'] !== "undefined"){
                                        var arrProducer = Array();
                                        $.each(rs['producer'], function(key, value){
                                            arrProducer.push(value.name);
                                        });
                                        producer.select2('val', arrProducer);
                                    }
                                    if(typeof rs['director'] !== "undefined"){
                                        var arrDirector = Array();
                                        $.each(rs['director'], function(key, value){
                                            arrDirector.push(value.name);
                                        });
                                        director.select2('val', arrDirector);
                                    }
                                    if(typeof rs['cast'] !== "undefined"){
                                        var arrCast = Array();
                                        $.each(rs['cast'], function(key, value){
                                            arrCast.push(value.name);
                                        });
                                        cast.select2('val', arrCast);
                                    }
                                    $("#modal-default").modal('hide');
                                }
                            });
                        }
                    });
                });
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});
function renderSetting(data, type, row, meta){
    var controls = '<div class="btn-group">';
    controls += '<a type="button" title="Edit" href="' + base_url + "/admin/" + meta.settings.sTableId + '/modify/'+row.id+'" class="btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></a>';
    controls += '<a type="button" title="Add Ep" href="' + base_url + '/admin/filmEp/show/'+row.id+'" class="btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-plus"></span></a>';
    controls += '<button type="button" title="Delete" data-id="'+row.id+'" data-title="'+row.title+'" data-table="' + meta.settings.sTableId + '" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-remove"></span></button>';
    controls += '</div>';
    return controls;
}

function renderImage(data, type, row, meta){
    var result = '';
    if(data){
        result = '<img src="'+data+'" height="50"/>';
    }
    return result;
}

function renderTitle(data, type, row, meta){
    var arrResult = data.split('|');
    var result = '';
    
    if(arrResult.length == 2){
        if(arrResult[0].length == 0){
            result = arrResult[1];
        }else{
            result = arrResult[0]+"<p class='help-block'>"+arrResult[1]+"</p>";
        }
    }else{
        result = arrResult[0];
    }
    return result;
}

function renderPublish(data, type, row, meta){
    var checked = row.status == 1 ? 'checked' : '';
    var active = row.status == 1 ? 'active' : '';
    var html = '<div class="btn-group change-property" data-toggle="buttons" data-type="status" data-id="' + row.id + '">' + 
                    '<label class="btn btn-default btn-sm ' + active + '">' + 
                        '<input name="status" type="checkbox" value="1" ' + checked + '><i class="glyphicon glyphicon-ok"></i>' + 
                    '</label>' + 
                '</div>';
    return html;
}

function renderComingsoon(data, type, row, meta){
    var checked = row.coming == 1 ? 'checked' : '';
    var active = row.coming == 1 ? 'active' : '';
    var html = '<div class="btn-group change-property" data-toggle="buttons" data-type="coming" data-id="' + row.id + '">' + 
                    '<label class="btn btn-default btn-sm ' + active + '">' + 
                        '<input name="coming" type="checkbox" value="1" ' + checked + '><i class="glyphicon glyphicon-ok"></i>' + 
                    '</label>' + 
                '</div>';
    return html;
}

function renderDepute(data, type, row, meta){
    var checked = row.depute == 1 ? 'checked' : '';
    var active = row.depute == 1 ? 'active' : '';
    var html = '<div class="btn-group change-property" data-toggle="buttons" data-type="depute" data-id="' + row.id + '">' + 
                    '<label class="btn btn-default btn-sm ' + active + '">' + 
                        '<input name="depute" type="checkbox" value="1" ' + checked + '><i class="glyphicon glyphicon-ok"></i>' + 
                    '</label>' + 
                '</div>';
    return html;
}