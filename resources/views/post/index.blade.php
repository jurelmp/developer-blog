@extends('layouts.app')

@section('content')
    <div class="container" ng-controller="PostController as postCtrl">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button class="pull-right btn btn-primary" data-toggle="modal" data-target="#postForm">New Post</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" ng-repeat="post in postCtrl.posts | orderBy:'-created_at'">
                    <div class="panel-heading">
                        <a style="font-weight: bold;" ng-click="postCtrl.show(post.id)"><% post.title %></a>
                        <span class="pull-right"><% post.created_at %></span>
                    </div>

                    <div class="panel-body">
                        <% post.text %>
                    </div>
                    <div class="panel-footer">
                        <span>Posted By: <% post.user.email %></span>
                        <span class="pull-right"><% post.comments.length %> comments.</span>
                    </div>
                </div>
            </div>
        </div>

        {{--Modal--}}
        <div id="postForm" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <span>Post Form</span>
                        </h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input ng-model="postCtrl.post.title" type="text" class="form-control" id="title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea ng-model="postCtrl.post.text" class="form-control" title="content" id="content" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" ng-click="postCtrl.save(postCtrl.post)">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection