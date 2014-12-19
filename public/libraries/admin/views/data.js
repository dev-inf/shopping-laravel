/*
 * Author: Hà Phan Minh
 * Created: 2014-06-20
 * Description: Data
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
                
            },
			
			updateDataFilm: function(){
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        $('#modal-default').modal();
                        $('#modal-default').on('shown.bs.modal', function (e) {
                            $(".modal-title").html('Search Data Film');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + '/admin/data/update-data-film',
                                async: false,
                                type: 'post',
                                success: function(){
                                    $(".modal-body").html(showAlert('success', 'Update data film done!'));
                                }
                            });
                        });
                    }
                });
			},
			
			updateFilm: function(){
			
			},
			
			updatePosition: function(){
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        $('#modal-default').modal();
                        $('#modal-default').on('shown.bs.modal', function (e) {
                            $(".modal-title").html('Search Data Position');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + '/admin/data/update-position',
                                async: false,
                                type: 'post',
                                success: function(){
                                    $(".modal-body").html(showAlert('success', 'Update position done!'));
                                }
                            });
                        });
                    }
                });
			},
            
            clearAllCache: function(){
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        $('#modal-default').modal();
                        $('#modal-default').on('shown.bs.modal', function (e) {
                            $(".modal-title").html('Clear all cache');
                            $(".modal-body").html('<div class="divLoading"></div>');
                            $.ajax({
                                url: base_url + '/admin/data/clear-all-cache',
                                async: false,
                                type: 'post',
                                success: function(){
                                    $(".modal-body").html(showAlert('success', 'Clear all cache done!'));
                                }
                            });
                        });
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