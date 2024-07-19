<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="usermanagement.authority"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Button trigger modal -->
                <button style="display: none;" type="button" id="modal-btn" class="btn btn-primary" data-toggle="modal" data-target="#addDesignation">
                    Add
                </button>
                <button style="display: none;" type="button" id="modal-btn-access" class="btn btn-primary" data-toggle="modal" data-target="#addAccess">
                    Add
                </button>
                <div class="col-md-8">
                    <div class="card ">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="card-title">Authority</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="#" id="proceed_1" class="btn btn-sm btn-primary" hidden>Reload</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" style="overflow: scroll; ">
                                <div class="col-md-12">
                                    <table class="table align-items-center mb-0" id="list">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Name</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Access List</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">
                                
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="card-title">Links</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="#" id="proceed" class="btn btn-sm btn-primary" hidden>Reload</a>
                                    
                                    <button type="button" class="btn btn-secondary btn-sm add_btn" data="link">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session()->has('success'))
                            <div class="row justify-content-center session">
                                <div class="alert alert-success col-md-12 text-center">
                                {{ session()->get('success') }}
                                </div>
                            </div>
                            @endif
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0" id="table_url">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">
                                
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
              <div class="modal fade" id="addDesignation" tabindex="-1" role="dialog" aria-labelledby="addDesignation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title sidebar-icon font-weight-bold" id="header-modal">---</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="{{ route('superadmin.authority') }}">
                        @csrf
                        <input type="text" class="form-control" id="type" name="type" style="display: none"/>
                        <label for="name">Link Name</label>
                        <input type="text" class="form-control border text-center" id="name" name="name" />
                     
                      <br><br><br><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="addAccess" tabindex="-1" role="dialog" aria-labelledby="addAccess" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title sidebar-icon font-weight-bold">Add Access</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control text-dark" id="user_id" name="user_id" style="display: none;">
                        <label for="access">Access List</label>
                        <select id="link" name="link" class="form-control ps-2 text-dark border text-secondary text-xs font-weight-bolder">
                            <option class="text-secondary text-xs font-weight-bolder" value="">Select Link Name</option>
                            @foreach ($data as $item)
                                <option class="text-secondary text-xs font-weight-bolder" value="{{$item->id}}">{{$item->linkName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" id="add-access" class="btn btn-primary">Add</button>
                      <button type="button" id="remove-access" class="btn btn-danger">Remove</button>
                    </div>
                  </div>
                </div>
              </div>


        </div>
        <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
    <script type="text/javascript">
        $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // -----------------------------
            $('#proceed').click(function(){
                var table = $('#table_url').DataTable();
                table.destroy();
                $('#table_url').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 30,
                lengthMenu: [20, 40, 60, 80, 100],
                dom: 'rti',
                ajax: {
                    "url": "{{ route('superadmin.authority') }}",
                    "data":  {type: 'url'},
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' , className: "text-center text-secondary text-xs font-weight-bold"},
                    { data: 'linkName', name: 'linkName' , className: "text-center text-secondary text-xs font-weight-bold"},
                ],
                order: [[0, 'desc']]
            });
            });
            // -----------------------------------
            $('#proceed_1').click(function(){
                var table = $('#list').DataTable();
                table.destroy();
                $('#list').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [20, 40, 60, 80, 100],
                ajax: {
                    "url": "{{ route('superadmin.authority') }}",
                    "data":  {type: 'employee'},
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center text-secondary text-xs font-weight-bold" },
                    { data: 'name', name: 'name' , className: "text-center text-secondary text-xs font-weight-bold"},
                    { data: 'access', name: 'access', className: "text-center text-secondary text-xs font-weight-bold"},
                    {data: 'action', name: 'action', orderable: false, className: "text-center text-secondary text-xs font-weight-bold"},
                ],
                order: [[0, 'desc']]
            });
            });
            // -------------------------------
            $('.add_btn').click(function(){
                $('#header-modal').html('Add '+$(this).attr('data'));
                $('#type').val('link');
                $('#modal-btn').click();
            })
            // ------------------------------
            $('#proceed').click();
            $('#proceed_1').click();
            $('#add-access').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '{{route("superadmin.authority")}}',
                    data: {
                        type: 'add_access',
                        id: $('#user_id').val(),
                        linkName_id: $('#link').val(),
                    },
                    success: function (data) {
                        $('#modal-btn-access').click();
                        $('#proceed').click();
                        $('#proceed_1').click();
                    }
                });
            })
            $('#remove-access').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '{{route("superadmin.authority")}}',
                    data: {
                        type: 'remove_access',
                        id: $('#user_id').val(),
                        linkName_id: $('#link').val(),
                    },
                    success: function (data) {
                        $('#modal-btn-access').click();
                        $('#proceed').click();
                        $('#proceed_1').click();
                    }
                });
            })
        });
        // --------------------------------------------------------------------------------------------------
        function edit(id){
            $('#modal-btn-access').click();
            $('#user_id').val(id);
        }
        </script>
    @endpush
</x-layout>
