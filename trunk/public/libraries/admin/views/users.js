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
               "click .status": "changeStatus",
               "click .remove": "removeRecord",
               "click .export":  "doExport"
            },

            changeStatus: function(e){
              changeStatus(e);
            },

            removeRecord: function(e){
                deleteRecord(e);
            },

            doExport: function(e){
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/users/export');
                form.attr("method", 'post');
                var input = $("<input>").attr("type", "hidden").attr("name", "selected_columns").val('u.id,username,fullname,email,g.name AS gender,phone,r.name AS role,status');
                form.append($(input));
                form.submit();
            },
            
            getShow: function(){
                createTable("users");
            },
            
            getModify: function(){   
                view.modify();
            },
            
            postModify: function(){
                view.modify();				
            },

            modify: function(){
                $(".file-modal").on("hide.bs.modal", function(){
                    if($("#image").val() != ""){
                        $(".media-object.avatar").attr("src", $("#image").val());
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