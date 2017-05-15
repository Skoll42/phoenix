module.exports = function(grunt) {

    function scss_path_to_css(path) {
        path = path.replace(/\/scss\//, "/css/");
        path = path.replace(/\.scss$/, ".css");
        return path;
    }


    // Project configuration.
    grunt.initConfig({
        sass: {
            options: {
                sourcemap: 'file'
            },
            compressed: {
                options: {
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: 'public/wp-content/themes/common/',
                    src: ['**/*.scss', '!**/_*.scss'],
                    dest: 'public/wp-content/themes/common/',
                    ext: '.css',
                    extDot: 'last',
                    rename: function(dest, src) {
                        return scss_path_to_css(dest + src);
                    }
                }]
            },
            expanded: {
                options: {
                    style: 'expanded'
                },
                files: [{
                    expand: true,
                    cwd: 'public/wp-content/themes/common/',
                    src: ['**/*.scss', '!**/_*.scss'],
                    dest: 'public/wp-content/themes/common/',
                    ext: '.css',
                    extDot: 'last',
                    rename: function(dest, src) {
                        return scss_path_to_css(dest + src);
                    }
                }]
            },
            compressed_sickfront: {
                options: {
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: 'public/wp-content/plugins/sickfront/',
                    src: ['**/*.scss', '!**/_*.scss'],
                    dest: 'public/wp-content/plugins/sickfront/',
                    ext: '.css',
                    extDot: 'last',
                    rename: function(dest, src) {
                        return scss_path_to_css(dest + src);
                    }
                }]
            },
            expanded_sickfront: {
                options: {
                    style: 'expanded'
                },
                files: [{
                    expand: true,
                    cwd: 'public/wp-content/plugins/sickfront/',
                    src: ['**/*.scss', '!**/_*.scss'],
                    dest: 'public/wp-content/plugins/sickfront/',
                    ext: '.css',
                    extDot: 'last',
                    rename: function(dest, src) {
                        return scss_path_to_css(dest + src);
                    }
                }]
            }
        },
        cssmin: {
            minify: {
                expand: true,
                report: 'gzip',
                cwd: 'public/wp-content/themes/common/css/',
                src: ['**/*.css', '!**/*.min.css'],
                dest: 'public/wp-content/themes/common/css/',
                ext: '.min.css',
                extDot: 'last'
            }
        },
        uglify: {
            dist: {
                expand: true,
                report: 'gzip',
                cwd: 'public/wp-content/themes/common/',
                src: ['**/*.js', '!**/*.min.js'],
                dest: 'public/wp-content/themes/common/',
                ext: '.min.js',
                extDot: 'last'
            }
        },
        watch: {
            css: {
                files: [
                    'public/wp-content/themes/common/**/*.scss',
                    'public/wp-content/plugins/sickfront/**/*.scss'
                ],
                tasks: ['sass:expanded'],
                options: {
                    spawn: false,
                    interrupt: true,
                    debounceDelay: 250
                }
            }
        },
        clean: {
            css_min: [],//["public/wp-content/themes/common/**/*.min.css"],
            js_min: []//["public/wp-content/themes/common/**/*.min.js"]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');

    // Default task(s).
    grunt.registerTask('default', ['sass:expanded', 'sass:expanded_sickfront', 'clean:css_min', 'clean:js_min', 'watch']);
    grunt.registerTask('local', ['sass:expanded', 'sass:expanded_sickfront', 'clean:css_min', 'clean:js_min']);
    grunt.registerTask('prod', ['sass:compressed', 'sass:compressed_sickfront', 'cssmin', 'uglify']);
};