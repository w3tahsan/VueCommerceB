@extends('admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('delete.checked') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3>All Categories</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input all">
                                        Check All
                                    <i class="input-frame"></i></label>
                                </div>
                            </th>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $index=>$category)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="check[]" class="form-check-input item" value="{{ $category->id }}">
                                    <i class="input-frame"></i></label>
                                </div>
                            </td>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $category->category_name}}</td>
                            <td><img src="{{ asset('uploads/category')}}/{{ $category->category_image }}" alt=""></td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('category.delete', $category->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="mt-2">
                        <button type="submit" id="del" disabled class="btn btn-danger">Delete Checked</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="category_image" class="form-control">
                        @error('category_image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(':checkbox.all').change(function() {
        $(':checkbox.item').prop('checked', this.checked);
        toggleDeleteButton();
    });

    $(':checkbox.item').change(function() {
        toggleDeleteButton();
    });

    function toggleDeleteButton() {
        if ($(':checkbox.item:checked').length > 0) {
            $('#del').removeAttr('disabled');
        } else {
            $('#del').attr('disabled', 'disabled');
        }
    }

</script>
@endsection