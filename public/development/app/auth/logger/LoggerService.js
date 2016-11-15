angular
    .module('authApp')
        .service('loginService', function($http, $sessionStorage, $window, $q) {

            function login(login, password) {
                var info = {login: login, password: password};
                var defer=$q.defer();

                $http.post("/login", info)
                    .success(function (answ) {
                        defer.resolve(answ);
                    }).error(function(err) {
                        defer.reject(err);
                    });
                console.log(defer.promise);
                return defer.promise;
            }

            function cahngeSessionInfo() {
                $sessionStorage.$reset({
                    name: sessionStorage.getItem('fio'),
                    post: sessionStorage.getItem('post'),
                });
            }

            function getPost() {
                return $sessionStorage.post;
            }

            function redirection(post) {
                if (post == 'Врач') {
                    $window.location.href =  "/doctor#/inpatients";
                }
                if (post  == 'Медсестра') {
                    $window.location.href =  "/emergency#/received_patients";
                }
            }

            return {
                login: login,
                redirection: redirection,
                getPost: getPost,
                cahngeSessionInfo: cahngeSessionInfo
            };

        });