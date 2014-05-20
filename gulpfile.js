var gulp     = require('gulp'),
     plugins = require('gulp-load-plugins')({camelize: true}),
     lr         = require('tiny-lr'),
     server  = lr();

// Lets us type "gulp" on the command line and run all of our tasks
gulp.task('default', ['images', 'jshint', 'vendor', 'scripts', 'styles', 'watch']);

gulp.task('watch', function() {

  server.listen(35729, function(err) {
    if (err) {
        return console.log(err);
    }

    // Watch files and run tasks
    gulp.watch('sass/**/*.scss', ['styles']);
    gulp.watch('js/**/*js', ['jshint', 'vendor', 'scripts']);
    gulp.watch('images/**/*', ['images']);
  });

});

// Hint all user-developed JS
gulp.task('jshint', function() {
  return gulp.src(['js/*.js', '!js/app.min.js', '!js/vendor.min.js'])
    .pipe(plugins.jshint())
    .pipe(plugins.jshint.reporter('default'))
    .pipe(plugins.notify({ message: 'JS Hinting task complete' }));
});

// Combine, minify all vendor JS
gulp.task('vendor', function() {
  return gulp.src(['js/vendor/*.js'])
    .pipe(plugins.concat('vendor.min.js'))
    .pipe(plugins.uglify())
    .pipe(gulp.dest('js/'))
    .pipe(plugins.notify({ message: 'Vendor JS task complete' }));
});

// JS concat, strip debugging and minify
gulp.task('scripts', function() {
  return gulp.src(['js/*.js', '!js/app.min.js', '!js/vendor.min.js', '!js/vendor{,/**}'])
    .pipe(plugins.concat('app.min.js'))
    .pipe(plugins.stripDebug())
    .pipe(plugins.uglify())
    .pipe(gulp.dest('js/'))
    .pipe(plugins.notify({ message: 'Scripts task complete' }));
});

var paths = {
  styles: {
    src:  'sass/*.scss',
    dest: 'css'
  }
};

gulp.task('styles', function () {
  return gulp.src(paths.styles.src)
    .pipe(plugins.compass({
      config_file: 'config.rb',
      css: 'css',
      sass: 'sass'
    }))
    //.pipe(plugins.minifyCSS())
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(plugins.notify({ message: 'Styles task complete' }));
});

// minify new images
gulp.task('images', function() {
  var imgSrc = 'images/**/*',
        imgDst = 'images';

  return gulp.src(imgSrc)
    .pipe(plugins.changed(imgDst))
    .pipe(plugins.imagemin())
    .pipe(gulp.dest(imgDst))
    .pipe(plugins.notify({ message: 'Images task complete' }));
});
