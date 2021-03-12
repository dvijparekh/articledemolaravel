@extends('layouts.app')

@section('head')
    <style>
        .error {
            color: red;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form
                    action="{{ isset($article_data) ? route('article.update', ['article' => $article_data->id]) : route('article.store') }}"
                    id="article-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($article_data))
                        @method('put')
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php if (old('name') != null) {
                                $name_value = old('name');
                                } else {
                                $name_value = isset($article_data->name) ? $article_data->name : '';
                                } ?>
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Type name"
                                    value="{{ $name_value }}">
                                @error('name')
                                    <label id="name-error" class="error" for="name">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <?php if (old('category') != null) {
                                $category_value = old('category');
                                } else {
                                $category_value = isset($article_data->category->name) ? $article_data->category->name : '';
                                } ?>
                                <select name="category" class="form-control" id="category">
                                    <option value="">Select</option>
                                    @if (isset($category_list) && is_object($category_list) && !$category_list->isEmpty())
                                        @foreach ($category_list as $value)
                                            <option value="{{ $value->name }}"
                                                {{ $value->name == $category_value ? 'SELECTED' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category')
                                    <label id="category-error" class="error" for="category">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="image">Image</label>
                            <?php
                            $image = isset($article_data->image) && !empty($article_data->image) ? $article_data->image :
                            '';
                            $image_path = isset($article_data->image_path) && !empty($article_data->image_path) ?
                            $article_data->image_path : '';
                            $is_image_present = false;
                            $image_value = '';
                            if (Storage::url($image_path . $image) == '/storage/') {
                            $is_image_present = true;
                            } else {
                            $image_value = Storage::url($image_path . $image);
                            }
                            ?>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                style="height: 100px;">
                            @error('image')
                                <label id="image-error" class="error" for="image">{{ $message }}</label>
                            @enderror
                        </div>
                        @if ($image_value != '')
                            <div class="col-md-6">

                                <img src="{{ $image_value }}" alt="{{ $article_data->name }}">

                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <?php if (old('description') != null) {
                                $description_value = old('description');
                                } else {
                                $description_value = isset($article_data->description) ? $article_data->description : '';
                                } ?>
                                <textarea name="description" id="" cols="30" rows="10"
                                    class="form-control">{{ $description_value }}</textarea>
                                @error('description')
                                    <label id="description-error" class="error" for="description">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>
        $('#article-form').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 60
                },
                category: {
                    required: true
                },
                description: {
                    required: true,
                    maxlength: 60
                },
                <?php
                if ($is_image_present) {
                    ?>
                    image: {
                        required: true
                    }
                    <?php
                } ?>

            }
        });

    </script>
@endsection
