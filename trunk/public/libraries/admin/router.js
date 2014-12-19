// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    ], function($, _, Backbone){
        var AppRouter = Backbone.Router.extend({
            routes: {
                
                '/admin': 'home',
            	
                'pages': 'pages',
                'pages/*path': 'pages',
                /* Created | 2014-06-05 | Hà Phan Minh | View Gender */
                'gender': 'gender',
                'gender/*path': 'gender',
                
                'users': 'users',
                'users/*path': 'users',
                
                /* Created | 2014-06-04 | Hà Phan Minh | View Section of Film */
                'sectionFilm': 'sectionFilm',
                'sectionFilm/*path': 'sectionFilm',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Film */
                'catalogueFilm': 'catalogueFilm',
                'catalogueFilm/*path': 'catalogueFilm',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Film */
                'film': 'film',
                'film/*path': 'film',
                'filmMovie': 'film',
                'filmMovie/*path': 'film',
                'filmDrama': 'film',
                'filmDrama/*path': 'film',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Film Access */
                'filmAccess': 'filmAccess',
                'filmAccess/*path': 'filmAccess',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Film Ep */
                'filmEp': 'filmEp',
                'filmEp/*path': 'filmEp',
                
                /* Created | 2014-06-19 | Hà Phan Minh | View Film Quality */
                'filmQuality': 'filmQuality',
                'filmQuality/*path': 'filmQuality',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Film Subtitle */
                'filmSubtitle': 'filmSubtitle',
                'filmSubtitle/*path': 'filmSubtitle',

                /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Position */
                'cataloguePosition': 'cataloguePosition',
                'cataloguePosition/*path': 'cataloguePosition',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Position */
                'position': 'position',
                'position/*path': 'position',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Video */
                'catalogueVideo': 'catalogueVideo',
                'catalogueVideo/*path': 'catalogueVideo',
                
                /* Created | 2014-06-05 | Hà Phan Minh | View Video */
                'video': 'video',
                'video/*path': 'video',

                /* Created | 2014-06-06 | Hà Phan Minh | View Language */
                'language': 'language',
                'language/*path': 'language',

				/* Created | 2014-06-20 | Hà Phan Minh | Data */
                'data': 'data',
                'data/*path': 'data',
				
                'medias': 'medias',
                'medias/*path': 'medias',

                'permissions': 'permissions',
                'permissions/*path': 'permissions',
                
                /* Created | 2014-07-18 | Hà Phan Minh | View Configuration */
                'configuration': 'configuration',
                'configuration/*path': 'configuration',
                
                /* Created | 2014-07-18 | Hà Phan Minh | View Log */
                'log': 'log',
                'log/*path': 'log',
                
                /* Created | 2014-07-21 | Hà Phan Minh | View Tags */
                'tags': 'tags',
                'tags/*path': 'tags',
                
                /* Created | 2014-07-25 | Hà Phan Minh | View Ribbon */
                'ribbon': 'ribbon',
                'ribbon/*path': 'ribbon',
                
                /* Created | 2014-08-04 | Hà Phan Minh | View Event */
                'events': 'event',
                'events/*path': 'event',
                
                /* Created | 2014-08-04 | Hà Phan Minh | View Commercial */
                'commercial': 'commercial',
                'commercial/*path': 'commercial',

                '*actions': 'defaultAction'
            },
            
            home: function(){
                require(['views/home'], function(view){
                    view.render();
                });
            },
            
            pages: function(){
            	require(['views/page'], function (page) {
            		page.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Gender*/
            gender: function(){
                require(['views/gender'], function(view){
                    view.render();
                });
            },

            users: function(){
                require(['views/users'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-04 | Hà Phan Minh | View Section of Film */
            sectionFilm: function(){
                require(['views/sectionFilm'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Film */
            catalogueFilm: function(){
                require(['views/catalogueFilm'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Film */
            film: function(){
                require(['views/film'], function(view){
                    view.render();
                });
            },
            
            filmMovie: function(){
                require(['views/film'], function(view){
                    view.render();
                });
            },
            
            filmDrama: function(){
                require(['views/film'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Film Access */
            filmAccess: function(){
                require(['views/filmAccess'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Film Ep */
            filmEp: function(){
                require(['views/filmEp'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-19 | Hà Phan Minh | View Film Quality */
            filmQuality: function(){
                require(['views/filmQuality'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Film Subtitle */
            filmSubtitle: function(){
                require(['views/filmSubtitle'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Position */
            cataloguePosition: function(){
                require(['views/cataloguePosition'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Position */
            position: function(){
                require(['views/position'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Catalogue of Video */
            catalogueVideo: function(){
                require(['views/catalogueVideo'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-06-05 | Hà Phan Minh | View Video */
            video: function(){
                require(['views/video'], function(view){
                    view.render();
                });
            },

            /* Created | 2014-06-06 | Hà Phan Minh | View Video */
            language: function(){
                require(['views/language'], function(view){
                    view.render();
                });
            },

            medias: function(){
                require(['views/medias'], function(view){
                    view.render();
                });
            },

            permissions: function(){
                require(['views/permissions'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-07-18 | Hà Phan Minh | View Configuration */
            configuration: function(){
                require(['views/configuration'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-07-18 | Hà Phan Minh | View Log */
            log: function(){
                require(['views/log'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-07-18 | Hà Phan Minh | View Tags */
            tags: function(){
                require(['views/tags'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-07-25 | Hà Phan Minh | View Ribbon */
            ribbon: function(){
                require(['views/ribbon'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-08-04 | Hà Phan Minh | View Event */
            event: function(){
                require(['views/event'], function(view){
                    view.render();
                });
            },
            
            /* Created | 2014-08-04 | Hà Phan Minh | View Commercial */
            commercial: function(){
                require(['views/commercial'], function(view){
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
                root: root + 'admin/'
            }); 
            var url = location.href;
            $(document).ready(function(){
                $("#updateDataFilm").on("click", function(e){
                    e.stopPropagation();
                    require(['views/data'], function(view) {
                        view.updateDataFilm();
                    });
                });
                $('#updateFilm').click(function(e) {
                    e.stopPropagation();
                    require(['views/data'], function(view) {
                        view.updateFilm();
                    });
                });
                
                $('#updatePosition').click(function(e) {
                    e.stopPropagation();
                    require(['views/data'], function(view) {
                        view.updatePosition();
                    });
                });
                
                $('#clearAllCache').click(function(e) {
                    e.stopPropagation();
                    require(['views/data'], function(view) {
                        view.clearAllCache();
                    });
                });
            });
        };
        return {
            initialize: initialize
        };
    });