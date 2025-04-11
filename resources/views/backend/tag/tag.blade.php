@extends('admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Tag List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Tag</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($tags as $index=>$tag)                        
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $tag->tag_name }}</td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Tag</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="tag-main">
                        <div class="mb-0 d-flex justify-content-between">
                            <label class="form-label">Tag Name</label>
                            <i id="click" class="fa-solid fa-plus cursor-pointer"></i>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="tag_name[]" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let tag_main = document.querySelector('.tag-main');
    let click = document.querySelector('#click');
    click.onclick = function(){
        let div = document.createElement('div');
        div.classList.add('mb-3')
        let input = document.createElement('input');
        input.classList.add('form-control')
        input.setAttribute('type', 'text')
        input.setAttribute('name', 'tag_name[]')
        div.appendChild(input)
        tag_main.appendChild(div)
        
        
    }

    
</script>
@endsection