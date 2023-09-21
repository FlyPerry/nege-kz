// Karma configuration
// Generated on Mon Jun 03 2013 11:36:13 GMT+0600 (ALMT)


// base path, that will be used to resolve files and exclude
basePath = '';


// list of files / patterns to load in the browser
files = [
  JASMINE,
  JASMINE_ADAPTER,
  'www/js/lib/angular.min.js',
  'www/js/lib/angular-resource.min.js',
  'www/js/lib/angular-sanitize.min.js',
  'www/js/lib/angular-mocks.js',
  'www/js/lib/angular/ui-bootstrap-tpls-0.2.0.min.js',
  'www/js/manage.js',
  'www/js/lib/cms/**/*.js',
  'www/js/client/**/*.js',
  'www/js/admin/**/*.js',

  'test/unit/**/*.spec.js'
];


// list of files to exclude
exclude = [
  
];


// test results reporter to use
// possible values: 'dots', 'progress', 'junit'
reporters = ['progress'];


// web server port
port = 9876;


// cli runner port
runnerPort = 9100;


// enable / disable colors in the output (reporters and logs)
colors = true;


// level of logging
// possible values: LOG_DISABLE || LOG_ERROR || LOG_WARN || LOG_INFO || LOG_DEBUG
logLevel = LOG_INFO;


// enable / disable watching file and executing tests whenever any file changes
autoWatch = false;


// Start these browsers, currently available:
// - Chrome
// - ChromeCanary
// - Firefox
// - Opera
// - Safari (only Mac)
// - PhantomJS
// - IE (only Windows)
browsers = ['Chrome'];


// If browser does not capture in given timeout [ms], kill it
captureTimeout = 60000;


// Continuous Integration mode
// if true, it capture browsers, run tests and exit
singleRun = false;

plugins=[
    'karma-ng-scenario'
];