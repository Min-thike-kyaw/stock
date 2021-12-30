@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content_header')

    <div class="d-flex justify-content-between">
        <h1>Units</h1>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
            Create a new Unit
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
                <th scope="col">Total Stocks</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($units as $num => $unit)
                <tr>
                    <td>{{++$num}}</td>
                    <td>{{$unit->name}}</td>
                    <td>{{$unit->stocks->count()}}</td>
                    <td>
                        <button data-toggle="modal" data-target="#edit{{$unit->id}}" class="btn btn-warning">Edit</button>
                        <a type="submit" onclick="del({{$unit->id}})"  class="btn btn-danger del-btn">Delete</a>
                        <form id="delete-form{{$unit->id}}" action="{{route('unit.destroy', $unit->id)}}" class="d-flex" method="POST">
                            @csrf
                            @method('delete')

                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit{{$unit->id}}" tabindex="-1" aria-labelledby="edit{{$unit->id}}Label" aria-hidden="true">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('unit.update',$unit->id)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit {{$unit->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$unit->name}}">
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
    <!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{route('unit.store')}}" method="POST">
    @csrf
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Unit</h5>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control">
            </div>
        </div>
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
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
function del(id) {
    if(confirm('Are you sure to delete')) {
        form = $("#delete-form"+id);
        form.submit();
        alert('file is deleted');
    } else {
        alert('your file is safe')
    }
}

</script>
@stop


