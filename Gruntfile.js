'use strict';
module.exports = function(grunt) {
    var pkg = grunt.file.readJSON('package.json');

    var stringReplace = {
        download_link: {
            src: ['config/app.php'],             // source files array (supports minimatch)
            dest: 'config/app.php',             // destination directory or file
            replacements: [
                {
                    from: '{github-download-version}',                   // string replacement
                    to:'v' + pkg.version
                }
            ]
        },
        localization: {
            src: ['build/includes/scripts.php'],             // source files array (supports minimatch)
            dest: 'build/includes/scripts.php',             // destination directory or file
            replacements: [
                {
                    from: /'isProduction'\s*(.*)/,
                    to: '\'isProduction\' => true,'
                },
            ]
        }
    };

    grunt.initConfig({
        // Clean up build directory
        clean: {
            main: ['build/']
        },

        // Copy the plugin into the build directory
        copy: {
            main: {
                src: [
                    '**',
                    '!node_modules/**',
                    '!build/**',
                    '!bin/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!package-lock.json',
                    '!phpcs.ruleset.xml',
                    '!phpunit.xml.dist',
                    '!webpack.config.js',
                    '!tmp/**',
                    '!views/assets/src/**',
                    '!src/**',
                    '!debug.log',
                    '!phpunit.xml',
                    '!export.sh',
                    '!.gitignore',
                    '!.env',
                    '!.gitmodules',
                    '!codeception.yml',
                    '!npm-debug.log',
                    '!plugin-deploy.sh',
                    '!readme.md',
                    '!composer.json',
                    '!composer.lock',
                    '!prev.json',
                    '!secret.json',
                    '!assets/src/**',
                    '!assets/less/**',
                    '!tests/**',
                    '!**/Gruntfile.js',
                    '!**/package.json',
                    '!**/README.md',
                    '!**/customs.json',
                    '!nbproject',
                    '!phpcs.xml.dist',
                    '!phpcs-report.txt',
                    '!less-watch-compiler.config.json',
                    '!**/*~'
                ],
                dest: 'build/'
            }
        },

        //Compress build directory into <name>.zip and <name>-<version>.zip
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './build/frontrom-v' + pkg.version + '.zip'
                },
                expand: true,
                cwd: 'build/',
                src: ['**/*'],
                dest: 'frontrom'
            }
        },

        replace: stringReplace,

        run: {
            options: {},

            reset: {
                cmd: 'npm',
                args: ['run', 'build']
            },

            makepot:{
                cmd: 'npm',
                args: ['run', 'makepot']
            },

            removeDev:{
                cmd: 'composer',
                args: ['install', '--no-dev']
            },

            dumpautoload:{
                cmd: 'composer',
                args: ['dumpautoload', '-o']
            },

            composerInstall:{
                cmd: 'composer',
                args: ['install']
            },
        }
    });


    // Load NPM tasks to be used here
    grunt.loadNpmTasks( 'grunt-contrib-less' );
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    grunt.loadNpmTasks( 'grunt-contrib-jshint' );
    grunt.loadNpmTasks( 'grunt-wp-i18n' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-contrib-clean' );
    grunt.loadNpmTasks( 'grunt-text-replace' );
    grunt.loadNpmTasks( 'grunt-contrib-copy' );
    grunt.loadNpmTasks( 'grunt-contrib-compress' );
    grunt.loadNpmTasks( 'grunt-run' );


    grunt.registerTask( 'release', [
        'clean',
        'run:reset',
        //'run:makepot',
        'run:removeDev',
        'run:dumpautoload',
        'copy',
        'replace',
        'compress',
        'run:composerInstall',
        'run:dumpautoload',
    ])
};