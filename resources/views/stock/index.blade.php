@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="d-flex justify-content-between">
        <h1>Stocks</h1>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newStock">
            Create a new Stock
        </button>
    </div>
@stop

@section('content')
    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Units</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $num => $stock)
                <tr>
                    <th scope="row">{{++$num}}</th>
                    <td>{{$stock->name}}</td>

                    <td>
                        @foreach ($stock->units as $unit)
                            <span class="badge badge-info">{{$unit->name}}</span>
                        @endforeach
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$stock->id}}">
                            Add into stock
                        </button>
                        <button data-toggle="modal" data-target="#edit{{$stock->id}}" class="btn btn-warning">Edit</button>
                        <button class="btn btn-danger" onclick="del({{$stock->id}})">Delete</button>
                        <form id="delete-form{{$stock->id}}" action="{{route('stock.destroy', $stock->id)}}" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
                <!-- Add into stock modal Modal -->
                <div class="modal fade" id="exampleModal{{$stock->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('history.store',$stock->id)}}" method="POST">
                        @csrf
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add into {{$stock->name}}</h5>
                            </div>
                            <div class="modal-body">
                                @foreach ($stock->units as $unit)
                                    <div class="form-group">
                                        <label for="{{$unit->name}}">{{$unit->name}}</label>
                                        <input type="number" class="form-control" name="{{$unit->name}}" value="0">
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit{{$stock->id}}" tabindex="-1" aria-labelledby="edit{{$stock->id}}Label" aria-hidden="true">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('stock.update',$stock->id)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit {{$stock->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$stock->name}}">
                                </div>
                                <div class="form-group">
                                    <select class="js-example-basic-multiple form-control"  name="unit_id[]" multiple="multiple">
                                        @foreach (\App\Unit::all() as $unit)
                                            <option class="form-control" value="{{$unit->id}}" {{in_array($unit->id, $stock->units->pluck('id')->toArray()) ? "selected" : "" }}>{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
                @endforeach

            </tbody>
          </table>
    </div>

<!-- New Stock Modal -->
<div class="modal fade" id="newStock" tabindex="-1" aria-labelledby="newStockLabel" aria-hidden="true">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('stock.store')}}" method="POST">
        @csrf
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="newStockLabel">Create a new stock</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
            </div>

                <select class="js-example-basic-multiple" name="unit_id[]" multiple="multiple">
                    @foreach (\App\Unit::all() as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach
                  </select>

            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
        </div>
    </form>
</div>

@stop

@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script> --}}

<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
function del(id){
    var form = $('#delete-form'+ id)
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            form.submit()
            swal("Poof! Your imaginary file has been deleted!", {
            icon: "success",
            });
        } else {
            swal("Your imaginary file is safe!");
        }
        });
}
</script>
@stop
