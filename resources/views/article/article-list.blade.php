@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('error_msg'))
                    <div class="alert alert-error error text-center" role="alert">
                        {{ session()->get('error_msg') }}
                    </div>
                @endif
                @if (session()->has('success_msg'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session()->get('success_msg') }}
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <a href="{{ route('article.create') }}" class="btn btn-primary float-right"> Add article</a>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Article Name</th>
                                <th scope="col">Article Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($article_list) && !$article_list->isEmpty() &&
                            $article_list->count()) {
                            foreach ($article_list as $key => $value) { ?>
                            <tr>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->category->name }}</td>
                                <td>
                                    <a href="{{ route('article.edit', ['article' => $value->id]) }}">edit</a>
                                </td>
                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    {{ $article_list->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
