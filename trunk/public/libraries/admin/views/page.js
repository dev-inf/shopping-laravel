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
                "click .browse-image": "openBrowseImageModal",
                "click .remove": "removeRecord",
                "click .status": "changeStatus"
            },

            changeStatus: function(e){
                changeStatus(e);
            },

            removeRecord: function(e){
                deleteRecord(e);
            },

            openBrowseImageModal: function(e){
                $(".file-modal").modal();
            },

            getShow: function(){
                createTable('pages');
            },
            
            getModify: function(){
                view.modify();
            },

            postModify: function(){
                view.modify();
            },
            
            modify: function(){
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});