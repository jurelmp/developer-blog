/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

import './bootstrap';
import 'angular';

const blog = angular.module('blogApp', []);
blog.constant('Headers', {
    config: {
        headers: {
            'Authorization': 'Bearer ' + $('meta[name=api-token]').attr('content')
        }
    }
});
blog.config(Config);
blog.controller('PostController', PostController);
blog.factory('PostService', PostService);

function Config($interpolateProvider, $httpProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
}

function PostService($http, $log, Headers) {
    function get() {
        return $http.get('/api/posts', Headers.config)
            .then(
                function success(response) {
                    return response.data;
                });
    }

    function show(id) {
        return $http.get('/api/posts/' + id, Headers.config)
            .then(
                function success(response) {
                    return response.data;
                }
            );
    }

    function save(data) {
        Headers.config.headers['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';
        return $http.post('/api/posts', data, Headers.config)
            .then(
                function success(response) {
                    return response.data;
                }
            );
    }

    function update(data) {
        Headers.config.headers['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';
        return $http.put('/api/posts/' + data.id, data, Headers.config)
            .then(
                function success(response) {
                    return response.data;
                }
            );
    }

    function destroy(id) {

    }

    return {
        get: get,
        show: show,
        save: save,
        update: update,
        destroy: destroy
    };
}

function PostController(PostService, $log) {
    let vm = this;
    vm.post = {};
    vm.posts = [];
    PostService.get().then(function (data) {
        vm.posts = data.posts;
    });
    vm.save = function (post) {
        PostService.save($.param(post)).then(function (data) {
            if (data.status === 'success') {
                vm.posts.push(data.post);
                vm.post = {};
                angular.element('#postForm').modal('hide');
            }
        });
    };
    vm.show = function (id) {
        PostService.show(id).then(function (data) {
            if (data.status === 'success') {
                vm.post = data.post;
                angular.element('#postForm').modal('show');
            }
        });
    };
    vm.update = function (post) {
        PostService.update(post).then(function (data) {
            if (data.status === 'success') {
                vm.post = data.post;
            }
        });
    }
}

export default blog;
