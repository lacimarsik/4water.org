angular.module('4water.services', []);
angular.module('4water.filters', []);
angular.module('4water.controllers', []);
angular.module('4water.directives', ['4water.services']);
angular.module('4water', ['4water.controllers', '4water.services', '4water.filters', '4water.directives']);