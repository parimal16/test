@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="width:50%; float: left;">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div style="width:50%; float: left;">
                <div class="card-header">User Details</div>
                <table id="userDetails"></table>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
jQuery( document ).ready(function( $ ) {
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'http://techflake-test.local/user-list',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action' }
            ]
        });
    });
    $(document).on("click","a[name='user-id']", function () {
        var token = "{{ Session::token() }}";
        var myKeyVals = { _token : token, id : this.id };
        $.ajax({
            url: "{{route('user.details')}}",
            method: 'post',
            data: myKeyVals,
            success: function(userDetailsRes){
                userDetails = '<tr><td>User Name:</td><td>'+userDetailsRes.data.name+'</td></tr>' +
                    '<tr><td>User Email: </td><td>'+userDetailsRes.data.email+'</td></tr>';
                console.log(userDetails);
                $("#userDetails").html(userDetails);
            }
        });
    });
});
</script>
@endpush
@endsection
