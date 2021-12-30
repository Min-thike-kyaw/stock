@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="d-flex justify-content-between">
        <h1>Dashboard</h1>

    </div>
@stop



@section('content')
    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Unit</th>
                <th scope="col">Quantity</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($stock_history->stockDetails as $num => $detail)
                <tr>
                    <td>{{++$num}}</td>
                    <td>{{$stock_history->stock->name}}</td>
                    <td>{{$detail->unit->name ?? ""}}</td>
                    <td>{{$detail->qty }}</td>
                    <td>
                        <button data-toggle="modal" data-target="#edit{{$detail->id}}" class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger " onclick="del({{$detail->id}})">Delete</button>
                        <form id="delete-form{{$detail->id}}" action="{{route('detail.destroy', $detail->id)}}" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="edit{{$detail->id}}" tabindex="-1" aria-labelledby="edit{{$detail->id}}Label" aria-hidden="true">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('detail.update',$detail->id)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit {{$detail->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">{{$detail->name}}</label>
                                    <input type="number" name="qty" class="form-control" value="{{$detail->qty}}">
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



@stop
@section('js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


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




