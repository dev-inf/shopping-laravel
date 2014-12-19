/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: View Film Ep
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
                "click .modify-ep-btn, a.edit": "openModifyEpModal",
                "click .browse-link": "openBrowseLinkModal",
                "click #submit-btn": "modifyEp"
            },
            
            removeRecord: function(e){
                deleteRecord(e);
            },

            openModifyEpModal: function(e){
                e.preventDefault();
                var $this = $(e.currentTarget);
                var url = $("#remote-url").val();
                if($this.hasClass("edit")){
                    url_array = url.split("?");
                    url = $this.attr("href") + "?" + url_array[1];
                }
                console.log(url);
                $("#modify-ep-modal").modal({
                    remote: url
                });
            },

            openBrowseLinkModal: function(e){
                var $this = $(e.currentTarget);
                var type = $this.data("type");
                var src = $(".file-modal").data("sample-url");
                src = src.replace("<<id>>", type);
                $(".file-modal iframe").attr("src", src);
                // if(type == "ep"){
                //     src = src.replace("<<id>>", "ep_link");
                //     $(".file-modal iframe").attr("src", src);
                // }
                // if(type == "subtitle"){
                //     src = src.replace("<<id>>", "subtitle_url");
                //     $(".file-modal iframe").attr("src", src);
                // }
                $("#modify-ep-modal").data("is-destroy", "false");
                $("#modify-ep-modal").modal("hide");
            },

            modifyEp: function(e){
                e.preventDefault();
                var $this = $(e.currentTarget);
                var url = $("#modify-ep-form").attr("action");
                var data = $("#modify-ep-form").serialize();
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    async: false,
                    success: function(rs){
                        rs = JSON.parse(rs);
                        if(!rs.success){

                        }else{
                            $("#modify-ep-modal").modal("hide");
                        }
                    }
                });
            },
            
            getShow: function(){
                createTable("filmEp");
                $("#modify-ep-modal").on("show.bs.modal", function(){
                    $(this).data("is-destroy", "true");
                });

                $("#modify-ep-modal").on("hidden.bs.modal", function(){
                    if($(this).data("is-destroy") == "true"){
                        $(".file-modal").removeData("bs.modal");
                        $(this).removeData("bs.modal");
                    }else{
                        $(".file-modal").modal();
                    }   
                });

                $(".file-modal").on("hidden.bs.modal", function(){
                    $("#modify-ep-modal").modal("show");
                });
            },
            
            getModify: function(){
                $("#sectionFilm").change(function(){
                    var $this = $(this);
                    var id = $this.val();
                    var filmElement = $("#film");
                    if(id != 0){
                        $.ajax({
                            url: base_url + "/admin/film/get-data-film-by-section",
                            data: 'id='+id,
                            type: 'post',
                            success: function(rs){
                                rs = JSON.parse(rs);
                                var arrFilm = Array();
                                if(rs.length > 0){
                                    filmElement.parent().find('p').addClass('hidden');
                                    $.each(rs, function(key, value){
                                        arrFilm.push({
                                            id:value['id'], 
                                            text:value['en_title']
                                        });
                                    });
                                    filmElement.select2({
                                        data:arrFilm
                                    });
                                }else{
                                    filmElement.parent().find('p').removeClass('hidden').html('Data empty');
                                    filmElement.select2('destroy');
                                    filmElement.prop('disabled', false);
                                }
                            }
                        });
                    }else{
                        filmElement.parent().find('p').removeClass('hidden');
                        filmElement.select2('destroy');
                        filmElement.prop('disabled', false);
                    }
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