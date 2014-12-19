/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: View Video
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
                "click .browse-video,.browse-file": "openBrowseVideoModal",
                "click .export":  "doExport",
                "click .updateTitle":  "doUpdateTitle",
            },
            
            doUpdateTitle: function(e){
                $("#modal-default").modal();
                $('#modal-default').on('shown.bs.modal', function (e) {
                    var $this = $(this);
                    var $invoker = $(e.relatedTarget);
                    $this.find(".modal-title").html('Update Title, ID, View, Duration, Status of Video');
                    $this.find(".modal-body").html('<div class="divLoading"></div>');
                    $.ajax({
                        url: base_url + "/admin/video/update-title-video",
                        type: 'post',
                        success: function(rs){
//                            rs = JSON.parse(rs);
                            $this.find("#modal-default").modal('hide');
                            location.reload(true);
                        }
                    })
                })
            },
            
            removeRecord: function(e){
                deleteRecord(e);
            },

            openBrowseVideoModal: function(e){                
                $(".file-modal").modal();
            },
            
            getShow: function(){
                $(".file-modal").on("hide.bs.modal", function(){
                    var file = $("#file-excel").val();
                    if(file != ""){
                        var from = 2;
                        var offset = 10;
                        var flag = true;
                        while(flag){
                            $.ajax({
                                url: base_url + '/admin/video/import',
                                type: 'get',
                                data: {
                                    file: file,
                                    from: from,
                                    offset: offset
                                },
                                async: false,
                                success: function(rs){
                                    rs = JSON.parse(rs);
                                    if(rs.status == 'stop'){
                                        flag = false;
                                    }else{
                                        from += offset;
                                    }
                                }
                            });
                        }
                    }
                });
                createTable("video");
            },
            
            doExport: function(e){
                e.preventDefault();
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/video/export');
                form.attr("method", 'post');
                // var input = $("<input>").attr("type", "hidden").attr("name", "selected_columns").val('g.id,g.name as gender,total_member');
                // form.append($(input));
                form.submit();
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});
function renderPosterVideo(data, type, row, meta){
    var result = '';
    if(data){
        result = '<img src="http://i1.ytimg.com/vi/'+data+'/mqdefault.jpg" height="50"/>';
    }
    return result;
}