module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            'custom-css': {
                expand: true,
                src: 'app/Resources/public/sass/main.css*',
                dest: 'web/assets/css/',
                flatten: true,
                filter: 'isFile'
            },
            'custom-js': {
                expand: true,
                src: 'app/Resources/public/js/main.js',
                dest: 'web/assets/js/',
                flatten: true,
                filter: 'isFile'
            }
        },
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.min.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootswatch/flatly/bootstrap.min.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.min.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'web/assets/css/main.css'
                ],
                dest: 'web/assets/css/bundled.css'
            },
            js : {
                src : [
                    'web/assets/js/jquery.js',
                    'web/assets/js/bootstrap.js',
                    'web/assets/js/main.js'
                ],
                dest: 'web/assets/js/bundled.js'
            }
        },
        cssmin : {
            bundled:{
                src: 'web/assets/css/bundled.css',
                dest: 'web/assets/css/bundled.min.css'
            }
        },
        uglify : {
            js: {
                files: {
                    'web/assets/js/bundled.min.js': ['web/assets/js/bundled.js']
                }
            }
        },
        watch: {
            'custom-css': {
                files: 'app/Resources/public/sass/main.css*',
                tasks: ['generate-css'],
                options: {
                    spawn: false
                }
            },
            'custom-js': {
                files: 'app/Resources/public/js/main.js',
                tasks: ['generate-js'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['copy', 'bowercopy', 'concat', 'cssmin', 'uglify']);
    grunt.registerTask('generate-css', ['copy:custom-css', 'concat:css', 'cssmin']);
    grunt.registerTask('generate-js', ['copy:custom-js', 'concat:js', 'uglify']);
};