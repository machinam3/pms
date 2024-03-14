@extends('layouts.app')
@section('page-title', 'Users')

@push('page-css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" />

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="userList">
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Users List</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal"><i
                                            class="ri-add-line align-bottom me-1"></i> Add User</button>
                                    <button type="button" class="btn btn-info"><i
                                            class="ri-file-download-line align-bottom me-1"></i> Import</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form>
                            <div class="row g-3">
                                <div class="col-xl-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                            placeholder="Search for user, email, phone, status or something...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xl-6">
                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <div class="">
                                                <input type="text" class="form-control" id="datepicker-range"
                                                    data-provider="flatpickr" data-date-format="d M, Y"
                                                    data-range-date="true" placeholder="Select date">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-sm-4">
                                            <div>
                                                <select class="form-control" data-plugin="choices" data-choices
                                                    data-choices-search-false name="choices-single-default" id="idStatus">
                                                    <option value="">Status</option>
                                                    <option value="all" selected>All</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Block">Block</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-sm-4">
                                            <div>
                                                <button type="button" class="btn btn-primary w-100"
                                                    onclick="SearchData();"> <i
                                                        class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table nowrap align-middle" style="width:100%" id="user-Table">
                            <thead class="table-light text-muted">
                                <tr>
                                    {{-- <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        value="option">
                                                </div>
                                            </th> --}}
                                    <th>#</th>
                                    <th>Full Names</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Joining Date</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                {{-- @foreach ($users as $user)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                                            value="option1">
                                                    </div>
                                                </th>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">{{ $user->id }}</a></td>
                                                <td class="user_name">{{ $user->name }}</td>
                                                <td class="email">{{ $user->email }}</td>
                                                <td class="phone">{{ $user->role->name }}</td>
                                                <td class="date">{{ $user->created_at }}</td>
                                                <td class="status"><span
                                                        class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Edit">
                                                            <a href="#showModal" data-bs-toggle="modal"
                                                                class="text-primary d-inline-block edit-item-btn">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="#deleteRecordModal">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                            </tbody>
                        </table>
                        <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light p-3">
                                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                            id="close-modal"></button>
                                    </div>
                                    <form class="tablelist-form" autocomplete="off" action="{{ route('users.store') }}"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" id="id-field" />

                                            <div class="mb-3" id="modal-id" style="display: none;">
                                                <label for="id-field1" class="form-label">ID</label>
                                                <input type="text" id="id-field1" class="form-control"
                                                    placeholder="ID" readonly />
                                            </div>

                                            <div class="mb-3">
                                                <label for="username-field" class="form-label">Full Names</label>
                                                <input type="text" id="name-field" class="form-control"
                                                    placeholder="Enter name" name="name" value="{{ old('name') }}"
                                                    required />
                                                <div class="invalid-feedback">Please enter a full name.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email-field" class="form-label">Email</label>
                                                <input type="email" id="email-field" class="form-control"
                                                    placeholder="Enter email" name="{{ old('email') }}" required />
                                                <div class="invalid-feedback">Please enter an email.</div>
                                            </div>

                                            <div>
                                                <label for="role-field" class="form-label">Role</label>
                                                <select class="form-control" data-choices data-choices-search-false
                                                    name="role-field" id="role-field" name="role" required>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" @selected(old('role'))>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="status-field" class="form-label">Status</label>
                                                <select class="form-control" data-choices data-choices-search-false
                                                    name="status-field" id="status-field" required>
                                                    <option value="">Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Block">Block</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="add-btn">Add
                                                    User</button>
                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" id="deleteRecord-close"
                                            data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mt-2 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                colors="primary:#f7b84b,secondary:#f06548"
                                                style="width:100px;height:100px"></lord-icon>
                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                <h4>Are you sure ?</h4>
                                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record
                                                    ?</p>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                            <button type="button" class="btn w-sm btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes,
                                                Delete It!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end modal -->
                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- container-fluid -->

@endsection

@push('page-scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    <!-- PDFMake JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- JSZip JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        // new DataTable("#buttons-datatables", {
        //         dom: "Bfrtip",
        //         buttons: ["copy", "csv", "excel", "print", "pdf"],
        //     }),
        $(document).ready(function() {
            $("#user-Table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.search') }}",
                columns: [{
                        data: "id",
                        name: "users.id"
                    },
                    {
                        data: "name",
                        name: "users.name"
                    },
                    {
                        data: "email",
                        name: "users.email"
                    },
                    {
                        data: "role_name",
                        name: "roles.name"
                    },
                    {
                        data: "joining_date",
                        name: "users.created_at"
                    },
                    // {
                    //     data: "status",
                    //     name: "status"
                    // },
                    {
                        data: 'id', // Assuming you have the 'id' sent from the server
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Customize these buttons as needed
                            return `
                        <a href="/users/${data}/edit" class="btn btn-primary btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${data})">Delete</button>
                    `;
                        }
                    }
                ],
                order: [
                    [0, "asc"]
                ], // Default ordering (optional)
            });

            //     function fetchData() {
            //         $.ajax({
            //             type: 'GET',
            //             url: '/users/search', // Adjust the URL to your route
            //             data: {
            //                 'search_query': $('.search').val(),
            //                 'date_range': $('#datepicker-range').val(),
            //                 'status': $('#idStatus').val()
            //             },
            //             success: function(data) {
            //                 $('#userTable tbody').html(data);
            //             }
            //         });
            //     }

            //     // Trigger fetchData on input change
            //     $('.search, #idStatus').on('input change', fetchData);
            //     $('#datepicker-range').on('change', fetchData);
            //     // Trigger fetchData on filter button click
            //     $('button[onclick="SearchData();"]').on('click', fetchData);
        });
    </script>
    {{-- <script src="{{ asset('assets/theme/js/pages/user-list.init.js') }}"></script> --}}
@endpush
