var files = {
    exclusions: [
        '**/.DS_Store',
        '**/.gitignore',
        '**/Thumbs.db',
        '.idea',
        '.git',
        'node_modules',
        '.ftppass',
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
        },
        'ftp-deploy': {
            public: {
                auth: auth,
                src: 'public',
                dest: 'public',
                exclusions: [files.exclusions]
            },
            application: {
                auth: auth,
                src: 'application',
                dest: 'application',
                exclusions: [files.exclusions]
            },
            vendor: {
                auth: auth,
                src: 'vendor',
                dest: 'vendor',
                exclusions: [files.exclusions]
            }
        },
        watch: {
            scripts: {
                files: ['assets/js/**/*'],
                tasks: ['uglify']
            },
            scss: {
                files: ['assets/scss/**/*'],
                tasks: ['sass']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-ftp-deploy');

    grunt.registerTask('default', ['sass', 'uglify', 'watch']);
    grunt.registerTask('publish', ['ftp-deploy:public', 'ftp-deploy:application']);
    grunt.registerTask('publish-vendor', ['ftp-deploy:vendor']);

};