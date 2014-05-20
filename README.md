Startpress
==========

The best possible starting theme for Wordpress. Ever.

Support for; Custom taxonomies, custom post types, removal of default junk, support for AJAX requests, SASS/Compass styling, Semantic.gs Grid System.

Clone into your wp-content/themes directory, edit style.css and change the name, then you're all set to go. This theme is perfect is you're building a site using a grid system (and if you're not), support for AJAX requests as well as a simplistic AJAX JSON API you can use to make simplistic requests within your theme.

This is the same code-base I use for client projects as well as projects I build on Wordpress at my day job.

## Dependencies

Javascript and CSS is generated using Gulp.js. Make sure you have Node.js installed first, navigate to the theme folder and run, "npm install" without the quotes. This will install Gulp.js and all required dependencies to generate CSS, JS, JS Hinting, and Images.

## Generating CSS & JS

As mentioned previously, CSS and JS is generated using Gulp.js. Provided you have everything setup correctly, you merely have to write: "gulp" without the quotes to start the task runner. This will also spin up a LiveReload server and also watch your folders for changes and generate new CSS, JS and compress Images.
