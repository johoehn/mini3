module.exports = function (grunt) {

    grunt.initConfig({
        sass: {
            dist: {
                options: {
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
                        'node_modules/jquery/dist/jquery.js',
                        'node_modules/bootstrap/dist/js/bootstrap.js',
                        'assets/js/script.js',
                    ]
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', ['sass', 'uglify']);
};