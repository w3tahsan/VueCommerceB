@extends('admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('checked.action') }}" method="POST">
            @csrf
        <div class="card mt-3">
            <div class="card-header">
                <h3>Trashed Categories</h3>
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
                    @foreach ($trashed as $index=>$category)
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
                            <a href="{{ route('category.restore', $category->id) }}" class="btn btn-success">Restore</a>
                            <a href="{{ route('category.pdelete', $category->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="mt-2">
                    <button name="btun" value="1" type="submit" disabled class="btn btn-success del">Restore Checked</button>
                    <button name="btun" value="2" type="submit" disabled class="btn btn-danger del">Delete Checked</button>
                </div>
            </div>
        </div>
        </form>
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
            $('.del').removeAttr('disabled');
        } else {
            $('.del').attr('disabled', 'disabled');
        }
    }

</script>
@endsection