/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    meta: {
      banner: '/*! G LAB Portal\n' +
        '* http://glabstudios.com/\n' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> GLAB\n' +
        '* All rights reserved. */'
    },
    lint: {
      files: ['grunt.js', '../global/js/global.js', 'src/script.js']
    },
    concat: {
      bootstrap: {
        src: ['<banner:meta.banner>', '../bootstrap/js/bootstrap*.js'],
        dest: 'src/bootstrap.js'
      }
    },
    min: {
      bootstrap: {
        src: ['<banner:meta.banner>', '<config:concat.bootstrap.dest>'],
        dest: 'dist/bootstrap.min.js'
      },
      init: {
        src: ['<banner:meta.banner>', 'src/init.js'],
        dest: 'dist/init.min.js'
      },
      portal: {
        src: ['<banner:meta.banner>', 'src/analytics.js', 'global/js/global.js', 'src/script.js'],
        dest: 'dist/script.min.js'
      }
    },
    watch: {
      files: '<config:lint.files>',
      tasks: 'lint qunit'
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        boss: true,
        eqnull: true,
        browser: true
      },
      globals: {
        jQuery: false
      }
    },
    uglify: {}
  });

  // Default task.
  grunt.registerTask('default', 'lint qunit concat min');

};
