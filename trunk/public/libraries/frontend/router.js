// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    ], function($, _, Backbone){
        var AppRouter = Backbone.Router.extend({
            routes: {
                
                '': 'home',
                
                'film': 'film',
                'film/*path': 'film',

                '*actions': 'defaultAction'
            },
            
            home: function(){
                require(['views/home'], function(view){
                    view.render();
                });
            },
            
            film: function(){
                require(['views/film'], function(view){
                    view.render();
                });
            },

            defaultAction: function(actions){
                // We have no matching route, lets display the home page
                console.log(actions);
            }
        });
        var initialize = function(){
            if(base_url.indexOf("http://localhost") != -1){
                root = "/khophim/";
            }else{
                root = "/";
            }
            var app_router = new AppRouter;
            Backbone.history.start({
                pushState: true,
                root: root
            }); 
            var url = location.href;
        };
        return {
            initialize: initialize
        };
    });