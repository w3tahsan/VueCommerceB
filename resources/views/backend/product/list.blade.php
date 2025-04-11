@extends('admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>SKUE</th>
                        <th>Product</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($products as $index=>$product)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td><img src="{{ asset('uploads/product') }}/{{ $product->preview }}" alt=""></td>
                            <td>
                                <a href="{{ route('inventory', $product->id) }}" class="btn btn-info">Inventory</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">No Product Found</td>
                        </tr>
                    @endforelse
                    
                </table>
            </div>
        </div>
    </div>
</div>
@endsection