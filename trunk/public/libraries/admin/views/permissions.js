/*
 * Author: Võ Lê Thanh Tùng
 * Created: 2014-07-10
 * Description: View Permissions of Film
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
                "click .btn-get-action": "openGrantAccessModal",
                "click .btn-save": "saveAccess",
                "click .remove": "removeRecord"
            },

            openGrantAccessModal: function(e){
                var $this = $(e.currentTarget);
                var parent_id = $this.data("id");
                var name = $this.data("name");
                var role_id = $("#role-id").val();
                $.ajax({
                    url: base_url + "/admin/permissions/roles/get-resources-by-parent",
                    type: "get",
                    data: {
                        parent_id: parent_id,
                        role_id: role_id
                    },
                    async: false,
                    success: function(rs){
                        if(rs.success){
                            var modal = $("#grant-access-modal");
                            modal.find(".modal-title").html(name);
                            var html = "";
                            var resource_name = "";
                            var checked = '';
                            $.each(rs.resources, function(index, value){
                                if(value.checked == 'on'){
                                    checked = 'checked';
                                }else{
                                    checked = '';
                                }
                                html += "<div class='col-xs-12 col-md-4'><input class='resource-checkbox' type='checkbox' value='" + value.id + "' name='resources[]' " + checked + "> " + value.action + "</div>";
                            });
                            modal.find(".modal-body .row").html(html);
                            $("#grant-access-modal").modal();
                        }
                        
                    }
                });
            },

            saveAccess: function(e){
                var $this = $(e.currentTarget);
                var resources_on = new Array();
                var resources_off = new Array();
                $(".resource-checkbox").each(function(){
                    if($(this).prop("checked")){
                        resources_on.push($(this).val());
                    }else{
                        resources_off.push($(this).val());
                    }
                });
                $.ajax({
                    url: location.href,
                    data: {resources_on: resources_on, resources_off: resources_off},
                    type: "get",
                    async: false,
                    success: function(rs){
                        $("#grant-access-modal").modal("hide");
                    }
                });
                console.log(resources);
            },

            removeRecord: function(e){
                deleteRecord(e, base_url + "/admin/permissions/delete");
            },
            
            grantAccessForRole: function(){

            },

            showResources: function(){
                createTable("permissions");
            },
            
            render: function(){
                console.log($app.action);
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});

function renderResourceSetting(data, type, row, meta){
    var controls = '<div class="btn-group">';
    controls += '<a type="button" title="edit" href="' + base_url + "/admin/" + meta.settings.sTableId + '/resources/modify/'+row.id+'" class="btn btn-warning btn-sm edit"><span class="glyphicon glyphicon-pencil"></span></a>';
    controls += '<button type="button" title="delete" data-id="'+row.id+'" data-title="'+row.name+'" data-table="resources" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-remove"></span></button>';
    controls += '</div>';
    return controls;
}