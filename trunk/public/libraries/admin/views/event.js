/*
 * Author: Hà Phan Minh
 * Created: 2014-08-04
 * Description: View Event
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
                "click .remove": "removeRecord"
            },
            
            removeRecord: function(e){
                deleteRecord(e);
            },
            
            getShow: function(){
                createTable("events");
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});