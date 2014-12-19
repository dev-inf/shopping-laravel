/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: View Catalogue of Video
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
              createTable("catalogueVideo");
            },
            
            doExport: function(e){
                e.preventDefault();
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/catalogueVideo/export');
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