require.config({
    urlArgs : "token=" + new Date().getTime(),
    waitSeconds: 60,
    paths: {
        jquery: '../jquery/jquery-2.0.3.min',
        underscore: '../underscore',
        backbone: '../backbone',
        text: '../text'
        //templates: 'templates'
    }
});

require(['general','app'
    // Some plugins have to be loaded in order due to their non AMD compliance
    // Because these scripts are not "modules" they do not pass any values to the definition function below
    ], function(general,App){
        // The "app" dependency is passed in as "App"
        // Again, the other dependencies passed in are not "AMD" therefore don't pass a parameter to this function
        App.initialize();
    });