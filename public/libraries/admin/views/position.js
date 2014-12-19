/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: View Position
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
                "click .export":  "doExport"
            },
            
            removeRecord: function(e){
                deleteRecord(e);
            },
            
            getShow: function(){
              createTable("position");
            },
            
            getModify: function(){   
                view.modify();
            },
            
            postModify: function(){
                view.modify();              
            },
            
            doExport: function(e){
                e.preventDefault();
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/position/export');
                form.attr("method", 'post');
                // var input = $("<input>").attr("type", "hidden").attr("name", "selected_columns").val('g.id,g.name as gender,total_member');
                // form.append($(input));
                form.submit();
            },
            
            modify: function(){
                var posterImg = $('#poster-img');
                var image  = $('#image');
                var fullname = $('#fullname');
                var date_of_birth = $('#date_of_birth');
                var date_of_death = $('#date_of_death');
                var body_height = $('#body_height');
                var nickname = $('#nickname');
                var country = $('#country');
                var idIMDB = $('#idIMDB');              
                $("#getDetailImdb").click(function(){
                    var dataIDIMDB = idIMDB.val();
                    $("#modal-default").modal();
                    $('#modal-default').on('shown.bs.modal', function (e) {
                        if(dataIDIMDB.length != 0){
                            $(".modal-title").html('Get Detail Information');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + "/admin/position/get-detail-position",
                                data: 'id='+dataIDIMDB,
                                type: 'post',
                                success: function(rs){
                                    rs = JSON.parse(rs);
                                    if(typeof rs['avatar'] !== "undefined"){
                                        posterImg.removeAttr('data-src');
                                        posterImg.attr('src',rs['avatar']);
                                        image.val(rs['avatar']);
                                    }
                                    if(typeof rs['fullname'] !== "undefined"){
                                        fullname.val(rs['fullname']);
                                    }
                                    if(typeof rs['date_of_birth'] !== "undefined"){
                                        date_of_birth.val(rs['date_of_birth']);
                                    }
                                    if(typeof rs['date_of_death'] !== "undefined"){
                                        date_of_death.val(rs['date_of_death']);
                                    }
                                    if(typeof rs['body_height'] !== "undefined"){
                                        body_height.val(rs['body_height']);
                                    }
                                    if(typeof rs['nickname'] !== "undefined"){
                                        var arrNick = Array();
                                        $.each(rs['nickname'], function(key, value){
                                            arrNick.push(value);
                                        });
                                        nickname.select2('val', arrNick);
                                    }
                                    if(typeof rs['country'] !== "undefined"){
                                        country.val(rs['country']);
                                    }
                                    if(typeof rs['idIMDB'] !== "undefined"){
                                        idIMDB.val(rs['idIMDB']);
                                    }
                                    if(typeof rs['en_description'] !== "undefined"){
                                        tinymce.get('en_description').setContent(rs['en_description']);
                                    }
                                    $("#modal-default").modal('hide');
                                }
                            });
                        }else{
                            $(".modal-title").html('Search Detail Position');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + "/admin/position/search-data-position",
                                data: $("#formPosition").serialize(),
                                type: 'post',
                                success: function(rs){
                                    rs = JSON.parse(rs);
                                    var $html = '<table class="table table-hover">'+
                                        '<thead>'+
                                            '<tr>'+
                                              '<th>#</th>'+
                                              '<th>Fullname</th>'+
                                              '<th>Movie</th>'+
                                              '<th></th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>';
                                    var i = 1;
                                    if(rs){
                                        $.each(rs, function(key, value){
                                            $html += '<tr>'+
                                                '<td>'+i+'</td>'+
                                                '<td>'+value['fullname']+'</td>'+
                                                '<td>'+value['movie']+'</td>'+
                                                '<td><input type="radio" name="idImdb" value="'+value['id']+'" class="getDetailPosition"/></td>'+
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
                                    $('.getDetailPosition').click(function(){
                                        var idM = $(this).val();
                                        $(".modal-title").html('Get Detail Information');
                                        $(".modal-body").html('<div class="divLoading"></div>');
                                        $.ajax({
                                            url: base_url + "/admin/position/get-detail-position",
                                            data: 'id='+idM,
                                            type: 'post',
                                            success: function(rs){
                                                rs = JSON.parse(rs);
                                                if(typeof rs['avatar'] !== "undefined"){
                                                    posterImg.removeAttr('data-src');
                                                    posterImg.attr('src',rs['avatar']);
                                                    image.val(rs['avatar']);
                                                }
                                                if(typeof rs['fullname'] !== "undefined"){
                                                    fullname.val(rs['fullname']);
                                                }
                                                if(typeof rs['date_of_birth'] !== "undefined"){
                                                    date_of_birth.val(rs['date_of_birth']);
                                                }
                                                if(typeof rs['date_of_death'] !== "undefined"){
                                                    date_of_death.val(rs['date_of_death']);
                                                }
                                                if(typeof rs['body_height'] !== "undefined"){
                                                    body_height.val(rs['body_height']);
                                                }
                                                if(typeof rs['nickname'] !== "undefined"){
                                                    var arrNick = Array();
                                                    $.each(rs['nickname'], function(key, value){
                                                        arrNick.push(value);
                                                    });
                                                    nickname.select2('val', arrNick);
                                                }
                                                if(typeof rs['country'] !== "undefined"){
                                                    country.val(rs['country']);
                                                }
                                                if(typeof rs['idIMDB'] !== "undefined"){
                                                    idIMDB.val(rs['idIMDB']);
                                                }
                                                if(typeof rs['en_description'] !== "undefined"){
                                                    tinymce.get('en_description').setContent(rs['en_description']);
                                                }
                                                $("#modal-default").modal('hide');
                                            }
                                        });
                                    });
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
function renderImage(data, type, row, meta){
    var result = '';
    if(data){
        result = '<img src="'+data+'" height="50"/>';
    }
    return result;
}