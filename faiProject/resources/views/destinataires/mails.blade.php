@extends('layouts.app')

@section('content')
@include('layouts.headers.destinataires.header', [
        'title' => __("The addressees page"),
        'description' => __("This is the addressees page. You can see all available addressees you made sort by base."),
        'class' => 'col-lg-11'
    ])    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <div class="table-responsive overflow-hidden">
                            <table id="list_table" class="table table-bordered table-striped w-100">
                                <thead>
                                <tr>
                                    <th>List</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="btn-group my-3" role="group">
                            <a class="btn btn-primary text-light" href="/destinataire/create">Create an addressee</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script>
    $(document).ready(function(){ 
        var url = window.location.pathname.split("/");
        var baseName = url[2];
        $('#list_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("destinataire.mails") }}',
                type: 'POST',
                data: {
                    list: baseName
                },
            },
            columns: [
                {
                    "data": 'email',
                    "name": "destinataires.email",
                },
                
               
            ]
            
        });
    });
</script>
@endsection
