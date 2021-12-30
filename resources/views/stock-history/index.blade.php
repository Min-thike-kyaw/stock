@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

        <h1>Dashboard</h1>

@stop

@section('content')
    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($stock_histories as $num => $history)
                <tr>
                    <td>{{++$num}}</td>
                    <td>{{$history->stock->name ?? ""}}</td>
                    <td>{{$history->date}}</td>
                    <td>
                        <a href="{{route('history.detail',$history->id)}}" class="btn btn-success">Detail</a>
                        <button class="btn btn-danger" onclick="del({{$history->id}})">Delete</button>
                        <form id="delete-form{{$history->id}}" action="{{route('history.destroy', $history->id)}}" method="POST">
                            @csrf
                            @method('delete')

                    </form>
                    </td>

                </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    <!-- Button trigger modal -->


  <!-- Modal -->

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
