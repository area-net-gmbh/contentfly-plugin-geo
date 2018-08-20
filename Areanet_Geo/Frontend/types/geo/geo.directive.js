(function() {
  'use strict';

  angular
    .module('app')
    .directive('pimGeo', pimGeo);
  
  function pimGeo(localStorageService, $http, $timeout,$rootScope){
    return {
      restrict: 'E',
      scope: {
        key: '=', config: '=', value: '=', isValid: '=', object: '=', isSubmit: '=', onChangeCallback: '&'
      },
      templateUrl: function(){
        return '/plugins/Areanet_Geo/types/geo/geo.html?v=400'
      },
      link: function(scope, element, attrs){

        //Properties
        var map     = null;
        var marker  = null;
        var timeout = null;

        //Startup
        init();

        //////////////////////////////

        function centerMap(lat, lng){
          if(!marker){
            marker = L.marker([lat, lng]).addTo(map);
          }else{
            marker.setLatLng([lat, lng]);
          }

          map.setView(new L.LatLng(lat, lng), 15, { animation: true });
        }

        function init(){
          map = L.map('leaflet-map').setView([51.165691, 10.451526], 8);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
          }).addTo(map);

          $timeout(function(){
            map.invalidateSize();
          }, 500);

          scope.location = scope.object.street + ',' + scope.object.zipcode + ' ' + scope.object.city;

          scope.$watch('object', function(){

            if(scope.object.lat && scope.object.lat){
              centerMap(scope.object.lat, scope.object.lng);
            }

            clearTimeout(timeout);
            timeout = window.setTimeout(startGeocoding, 1000);
          }, true);
        }


        function geocode(location){
          var data = {
            query: location
          };

          $http({
            method: 'POST',
            url: '/geoplugin/geocode',
            data: data
          }).then(function(data){
            scope.object.lat = data.data.lat;
            scope.object.lng = data.data.lng;

            scope.onChangeCallback({key: 'lat', value: scope.object.lat});
            scope.onChangeCallback({key: 'lng', value: scope.object.lng});

            scope.location = location;

            centerMap(data.data.lat, data.data.lng)
          }).catch(function(error){
            console.log(error);
          });

        }

        function startGeocoding(){
          if(!scope.object.street || !scope.object.zipcode || !scope.object.city){
            return;
          }

          var location = scope.object.street + ',' + scope.object.zipcode + ' ' + scope.object.city;
          if(scope.location != location){
            geocode(location);
          }

        }




      }
    }
  }

})();
