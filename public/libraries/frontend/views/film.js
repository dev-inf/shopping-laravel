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
            
            detail: function(){
                var playerElement = $('.dataPlayer');
                var id = playerElement.data('id');
                var link = playerElement.data('link');
                var banner = playerElement.data('banner');
                $.ajax({
                    url: base_url + "/film/get-subtitle-film",
                    data: 'id='+id,
                    type: 'post',
                    success: function(rs){
                        rs = JSON.parse(rs);
                        var subtitle = Array();
                        if(typeof rs.subtitle !== 'undefined'){
                            $.each(rs.subtitle, function(i,v){
                                subtitle.push({
                                    file: 'http://116.118.112.25:8080/'+v['subtitle_file'],
                                    label: v['language'],
                                    kind: "captions",
                                    "default": v['default'] 
                                });
                            });
                        }

                        jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ==";
                        jwplayer("player").setup({
                            volume: "100",
                            menu: "true",
                            aspectratio: '16:9',
                            allowscriptaccess: "always",
                            wmode: "opaque",
                            width: '100%',
                            skin: base_url + "/public/scripts/plugins/jwplayer/skins/six.xml",
                            back: "false",
                            image: banner,
                            file: link,
                            tracks: subtitle,
                            logo: {
                                file: base_url + "/public/images/logo.png",
                                link: '/'
                            },
                            primary: 'html5',
                            advertising: {
                                client: "vast",
                                'skipoffset':5, 
                                tag: "http://ad3.liverail.com/?LR_PUBLISHER_ID=1331&LR_CAMPAIGN_ID=229&LR_SCHEMA=vast2"
                            }
                        })
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
