var app = angular.module('demo', ['angular-progress-arc']);


app.controller('DemoCtrl', function ($scope) {
  
  // Init progress value
  $scope.progress = 0.0;
  
  // Color hex values
  var orange = "#e67e22";
  var red = "#e74c3c";
  var green = "#2ecc71";

  // Breakpoints for colors
  var breakToWarning = 0.60;
  var breakToDanger = 0.90;
  
  // Color change
  $scope.$watch('progress', function(){
   
    if ($scope.progress >= breakToDanger) {
      $scope.barColor = red;
    } else if ($scope.progress < breakToDanger && $scope.progress > breakToWarning) {
      $scope.barColor = orange;
    } else if ($scope.progress < breakToWarning) {
      $scope.barColor = green;
    }
  });
  
});