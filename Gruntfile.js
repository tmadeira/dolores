'use strict';

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    browserify: {
      options: {
        debug: true,
        transform: ['reactify', 'debowerify']
      },

      scfn: {
        src: ['src/js/scfn/main.js'],
        dest: 'build/scfn/script.js'
      }
    },

    closureCompiler: {
      options: {
        compilerFile: 'node_modules/google-closure-compiler/compiler.jar',
        compilerOpts: {
          compilation_level: 'SIMPLE_OPTIMIZATIONS',
          language_in: 'ECMASCRIPT6',
          language_out: 'ECMASCRIPT5'
        }
      },

      scfn: {
        src: 'build/scfn/script.js',
        dest: 'build/scfn/script.gcc.js'
      }
    },

    compass: {
      default: {
        options: {
          specify: 'src/css/**/*.scss',
          sassDir: 'src/css',
          cssDir: 'build',
          fontsDir: 'static/fonts',
          imagesDir: 'static/images',
          importPath: [
            'bower_components/breakpoint-sass/stylesheets',
            'bower_components/fontawesome/scss'
          ]
        }
      }
    },

    copy: {
      devtheme: {
        cwd: 'build/',
        dest: '/var/www/dolores/wp-content/themes/dolores/',
        expand: true,
        src: '**',
        timestamp: true
      },

      composer: {
        cwd: 'vendor/',
        dest: 'build/vendor/',
        expand: true,
        src: '**',
        timestamp: true
      },

      php: {
        cwd: 'src/php/',
        dest: 'build/',
        expand: true,
        src: '**',
        timestamp: true
      },

      static: {
        dest: 'build/',
        expand: true,
        src: 'static/**',
        timestamp: true
      }
    },

    cssmin: {
      options: {
        roundingPrecision: -1
      },

      default: {
        files: {
          'build/scfn/style.min.css': ['build/scfn/style.css']
        }
      }
    },

    concurrent: {
      options: {
        debounceDelay: 250,
        forever: false,
        logConcurrentOutput: true,
        spawn: false
      },

      watch: {
        tasks: ['watch:build', 'watch:css', 'watch:js', 'watch:composer', 'watch:php', 'watch:static']
      }
    },

    eslint: {
      options: {
        envs: ['browser', 'node'],
        rules: {
          'no-alert': 0,
          'no-debugger': 0
        }
      },

      dev: {
        options: {
          force: true
        },

        files: {
          src: ['src/**/*.js']
        }
      },

      prod: {
        options: {
          force: false
        },

        files: {
          src: ['src/**/*.js']
        }
      }
    },

    uglify: {
      default: {
        files: {
          'build/scfn/script.min.js': 'build/scfn/script.gcc.js'
        }
      }
    },

    watch: {
      options: {
        atBegin: true,
        spawn: false
      },

      build: {
        files: 'build/**/*',
        tasks: ['copy:devtheme']
      },

      composer: {
        files: 'vendor/**/*',
        tasks: ['copy:composer']
      },

      css: {
        files: 'src/css/**/*.scss',
        tasks: ['compass']
      },

      js: {
        files: 'src/js/**/*.js',
        tasks: ['eslint:dev', 'browserify:scfn']
      },

      php: {
        files: 'src/php/**/*',
        tasks: ['copy:php']
      },

      static: {
        files: 'static/**/*',
        tasks: ['copy:static']
      }
    }
  });

  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-closure-tools');
  grunt.loadNpmTasks('grunt-concurrent');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-eslint');

  grunt.registerTask(
    'dev',
    [
      'concurrent:watch'
    ]
  );

  grunt.registerTask(
    'prod',
    [
      // JS
      'eslint:prod',
      'browserify',
      'closureCompiler',
      'uglify',

      // CSS
      'compass',
      'cssmin',

      // PHP
      'copy:composer',
      'copy:php',

      // Static
      'copy:static',
    ]
  );

  grunt.registerTask('default', ['dev']);
};
