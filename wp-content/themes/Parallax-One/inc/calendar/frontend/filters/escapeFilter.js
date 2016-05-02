(function () {
    var module = angular.module('4water.filters', []);

    module.filter('escape', function() {
      return window.encodeURIComponent;
    });
})();
