/*
 * Author: Hà Phan Minh
 * Created: 2014-07-25
 * Description: View Ribbon
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
                createTable("ribbon");
            },
            
            getModify: function(){   
                $('#colorpickerField1, #colorpickerField2').ColorPicker({
                    onSubmit: function(hsb, hex, rgb, el) {
                        $(el).parent().parent().find('input').val(hex);
                        $(el).ColorPickerHide();
                    },
                    onBeforeShow: function () {
                        $(this).ColorPickerSetColor(this.value);
                    }
                })
                .bind('keyup', function(){
                    $(this).ColorPickerSetColor(this.value);
                });
                
                $("#testView").click(function(){
                    var name = $('#name').val();
                    var eleChange = $(".ribbon .base");
                    if(name.length != 0){
                        eleChange.html('<span>'+name+'</span>');
                    }
                    var from = $('#from').val();
                    var to = $('#to').val();
                    if(from.length != 0 && to.length != 0){
                        eleChange.css("background", "#"+from);
                        eleChange.css("background", "-moz-linear-gradient(top, #"+from+" 0%, #"+to+" 100%)");
                        eleChange.css("background", "-webkit-gradient(linear, left top, left bottom, color-stop(0%,#"+from+"), color-stop(100%,#"+to+"))");
                        eleChange.css("background", "-webkit-linear-gradient(top, #"+from+" 0%, #"+to+" 100%)");
                        eleChange.css("background", "-o-linear-gradient(top, #"+from+" 0%, #"+to+" 100%)");
                        eleChange.css("background", "-ms-linear-gradient(top, #"+from+" 0%, #"+to+" 100%)");
                        eleChange.css("background", "linear-gradient(top, #"+from+" 0%, #"+to+" 100%)");
                        eleChange.css("filter", "progid:DXImageTransform.Microsoft.gradient( startColorstr='#'"+from+", endColorstr='#'"+to+",GradientType=0 )");
                        
                        $(".ribbon .left_corner").css("background", "#"+to);
                        $(".ribbon .right_corner").css("background", "#"+to);
                    }
                })
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});