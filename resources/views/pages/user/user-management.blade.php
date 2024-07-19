<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="usermanagement.index"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <form action="{{route('usermanagement.upload.template')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <label class="custom-file-upload btn btn-success btn-sm">
                    <input type="file" id="file" name="file" onchange="$('#submit').click()" style="display:none;"/>
                    <i class="fa fa-cloud-upload"></i> Mass Registration
                </label>
                <a href="{{route('usermanagement.download.template')}}" class="btn btn-sm btn-secondary" >Template</a>
                <button type="submit" id="submit" style="display: none">Submit</button>
            </form>
            <div class="table-responsive">
                <button id="proceed" style="display: none">Refresh</button>
                <table class="table align-items-center mb-0" id="itrtable">
                    <thead>
                        <tr>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                ID</th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Name</th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Email</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Phone</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Location</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Company</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#proceed').click(function(){
                var table = $('#itrtable').DataTable();
                    table.destroy();
                    $('#itrtable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('usermanagement.index') }}',
                    columns: [
                        { data: 'id', name: 'id', className: 'text-center text-secondary text-xs font-weight-bold'},
                        { data: 'name', name: 'name', className: 'text-center text-secondary text-xs font-weight-bold' },
                        { data: 'email', name: 'email', className: 'text-center text-secondary text-xs font-weight-bold' },
                        { data: 'phone', name: 'phone', className: 'text-center text-secondary text-xs font-weight-bold' },
                        { data: 'location', name: 'location', className: 'text-center text-secondary text-xs font-weight-bold' },
                        { data: 'company', name: 'company', className: 'text-center text-secondary text-xs font-weight-bold' },
                        { data: 'action', width: 80, name: 'action', orderable: false, searchable: false }
                    ]
                });
            });
            $("#proceed").click();
        });
        
        function res(id){
            $.ajax({
                type: 'post',
                url: '{{route("usermanagement.upload.reset")}}',
                data: {
                    type: 'reset',
                    id: id,
                },
                success: function (data) {
                    $('#proceed').click();
                    navigator.clipboard.writeText("GVista User Reset Account Request\nUsername: "+data+"\nPassword: gmc@2024\n\n");
                    
                    }
                });
            }
            function dis(id){
                $.ajax({
                    type: 'post',
                    url: '{{route("usermanagement.upload.reset")}}',
                    data: {
                        type: 'disable',
                        id: id,
                    },
                    success: function (data) {
                        $('#proceed').click();
                        }
                    });
                }
                function en(id){
                $.ajax({
                    type: 'post',
                    url: '{{route("usermanagement.upload.reset")}}',
                    data: {
                        type: 'enable',
                        id: id,
                    },
                    success: function (data) {
                        $('#proceed').click();
                        }
                    });
                }
    </script>
    @endpush
</x-layout>
