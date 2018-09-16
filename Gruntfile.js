var files = {
    exclusions: [
        '**/.DS_Store',
        '**/.gitignore',
        '**/Thumbs.db',
        '.idea',
        '.git',
        'node_modules',
        'Gruntfile.js',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        '.grunt',
        '.sass-cache',
        'assets',
        'vendor',
    ]
};
var auth = {
    host: 'host.com',
    port: 21,
    authKey: 'live'
};


module.exports = function (grunt) {

    grunt.initConfig({
        sass: {
            dist: {
                options: {                       // Target options
                    style: 'compressed'
                },
                files: {
                    'public/css/style.css': 'assets/scss/index.scss'
                }
            }
        },
        uglify: {
            my_target: {
                files: {
                    'public/js/application.js': [
                        //'node_modules/jquery/dist/jquery.js',
                        'assets/js/script.js',
                    ]
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', ['sass', 'uglify', 'watch']);
};