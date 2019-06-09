var gulp = require('gulp')
var ftp = require('vinyl-ftp')
var shell = require('gulp-shell')

gulp.task('deploy-ftp', function () {

  var conn = ftp.create({
    host: 'grol55wy.beget.tech',
    user: 'grol55wy_cargo',
    password: 'y&wcKA7V',
    parallel: 10,
  })

  const path = '/wp-content/plugins/cargo-calc-samara/shortcode'

  var globs = [
    'dist/**',
  ]

  return gulp.src(
    globs,
    {
      base: '.',
      buffer: false,
    })
    .pipe(conn.newer(path)) // only upload newer files
    .pipe(conn.dest(path))

})

gulp.task('vue', function () {
  return gulp.src(['./src/*.vue'])
    .pipe(shell('vue-cli-service build --target lib --name cargo'))
})

gulp.task('vue-build-task', gulp.series('vue', 'deploy-ftp'))

gulp.task('watch', function () {
  gulp.watch(['./src/*.*', './src/components/!*.*'], gulp.series('vue-build-task'))
})
