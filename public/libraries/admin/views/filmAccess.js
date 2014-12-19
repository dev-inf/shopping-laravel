/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: View Film Access
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
              createTable("filmAccess");
            },
            
            doExport: function(e){
                var form = $("#filter-form");
                form.attr("action", base_url + '/admin/filmAccess/export');
                form.attr("method", 'post');
                var input = $("<input>").attr("type", "hidden").attr("name", "selected_columns").val('r.id,username,email,phone,r.name AS role_name');
                form.append($(input));
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